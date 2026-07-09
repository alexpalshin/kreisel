<?php
function export_dealers_csv() {
    if ( is_user_logged_in() && isset($_GET['export_dealers']) && $_GET['export_dealers'] == 'csv' ) {
        $post_type = 'dealers';
        $dealers = get_posts([
            'post_type' => 'dealers',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);
        $date = date('d-m-Y');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $post_type . '-'.$date.'.csv"');

        $output = fopen('php://output', 'w');

        // Добавляем BOM (Byte Order Mark) для UTF-8
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, array('id','company', 'city', 'address', 'phone', 'email', 'website'));

        if (is_array($dealers))
            foreach ($dealers as $post) {
                $company_address = get_post_meta($post->ID, 'company_address',true );
                $company_phone = get_post_meta($post->ID, 'company_phone', true );
                $company_email = get_post_meta($post->ID, 'company_email', true );
                $company_website = get_post_meta($post->ID, 'company_website', true );

                $company_city = get_the_terms($post->ID, 'dealer_city' );
                if ($company_city && is_array($company_city)) {
                    $city = $company_city[0]->name;
                }

                fputcsv($output, array(
	                $post->ID,
                    $post->post_title,
                    $city,
                    $company_address,
                    $company_phone,
                    $company_email,
                    $company_website
                ));
            }


        fclose($output);
        exit;
    }
}
add_action('init', 'export_dealers_csv');


/**
 * Plugin Name: Dealers CSV Importer
 * Description: Import dealers from CSV files with encoding support
 * Version: 1.3
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


class DealersCSVImporter {
	
	public function __construct() {
		add_action('admin_menu', array($this, 'add_admin_page'));
		add_action('admin_init', array($this, 'handle_csv_upload'));
	}
	
	/**
	 * Add admin page to WordPress dashboard
	 */
	public function add_admin_page() {
		add_submenu_page(
			'edit.php?post_type=dealers',
			'Загрузка CSV',
			'Загрузка CSV',
			'manage_options',
			'dealers-csv-import',
			array($this, 'render_admin_page')
		);
	}
	
	/**
	 * Render the admin page with file upload form
	 */
	public function render_admin_page() {
		?>
		<div class="wrap">
			<h1>Импорт Дистрибьюторов из CSV</h1>
			
			<?php if (isset($_GET['import_result'])): ?>
				<div class="notice notice-<?php echo esc_attr($_GET['success'] ? 'success' : 'error'); ?> is-dismissible">
					<p><?php echo esc_html(urldecode($_GET['import_result'])); ?></p>
				</div>
			<?php endif; ?>

            <div class="card">
                <h2>Скачать файл</h2>
                <p>Скачайте CSV файл с существующими на сайте дистрибьюторами</p>
                <a href="<?php echo home_url('?export_dealers=csv') ?>" class="button button-primary">Скачать</a>
            </div>

            <div class="card">
				<h2>Загрузка CSV файла</h2>
				<p>CSV файл должен содержать следующие колонки: <code>id, company name, city name, address, phone, email, website address</code></p>
				<p><strong>Формат:</strong> UTF-8 с кириллическим текстом</p>
				
				<form method="post" enctype="multipart/form-data">
					<?php wp_nonce_field('dealers_csv_import', 'dealers_csv_nonce'); ?>
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="csv_file">CSV файл</label>
							</th>
							<td>
								<input type="file" name="csv_file" id="csv_file" accept=".csv" required>
								<p class="description">Выберите CSV файл для импорта</p>
							</td>
						</tr>
					</table>
					<?php submit_button('Import CSV', 'primary', 'submit_csv'); ?>
				</form>
			</div>
			
			<div class="card">
				<h2>Пример формата CSV файла</h2>
				<textarea rows="5" cols="100" readonly style="width: 100%; font-family: monospace;">
'id','company', 'city', 'address', 'phone', 'email', 'website'
,"Компания ООО","Москва","ул. Ленина, 123","+7 (495) 123-45-67","company@example.com","https://company.com"
25,"ИП Иванов","Санкт-Петербург","Невский пр., 45","+7 (812) 987-65-43","ivanov@example.com","https://ivanov.ru"
                </textarea>
				<p><strong>Note:</strong> Оставьте колонку id пустой, чтобы создать нового дилера.</p>
			</div>
        </div>
		<?php
	}

	/**
	 * Handle CSV file upload and processing
	 */
	public function handle_csv_upload() {
		if (!isset($_POST['submit_csv']) || !isset($_FILES['csv_file'])) {
			return;
		}

		// Security checks
		if (!wp_verify_nonce($_POST['dealers_csv_nonce'], 'dealers_csv_import')) {
			wp_die('Security check failed');
		}

		if (!current_user_can('manage_options')) {
			wp_die('Insufficient permissions');
		}

		$file = $_FILES['csv_file'];

		// Validate file
		if ($file['error'] !== UPLOAD_ERR_OK) {
			$this->redirect_with_message('File upload failed: ' . $file['error'], false);
			return;
		}

		if ($file['type'] !== 'text/csv' && pathinfo($file['name'], PATHINFO_EXTENSION) !== 'csv') {
			$this->redirect_with_message('Please upload a valid CSV file', false);
			return;
		}

		// Process CSV file
		$result = $this->process_csv_file($file['tmp_name']);

		if (is_wp_error($result)) {
			$this->redirect_with_message('Import failed: ' . $result->get_error_message(), false);
		} else {
			$this->redirect_with_message("Import completed successfully! Processed {$result['processed']} rows. Created: {$result['created']}, Updated: {$result['updated']}, Errors: {$result['errors']}", true);
		}
	}

	/**
	 * Process the uploaded CSV file
	 */
	private function process_csv_file($file_path) {

        // Detect or use specified encoding
        $detected_encoding = $this->detect_file_encoding($file_path);

        if (is_wp_error($detected_encoding)) {
            return $detected_encoding;
        }

        // Read file content with proper encoding
        $file_content = file_get_contents($file_path);

        if ($detected_encoding !== 'UTF-8') {
            return new WP_Error('wrong_encoding', 'CSV must be in UTF-8 format');
            //$file_content = mb_convert_encoding($file_content, 'UTF-8', $detected_encoding);
        }

        // Create temporary file with UTF-8 encoding
        $temp_file = wp_tempnam();
        file_put_contents($temp_file, $file_content);

		$handle = fopen($temp_file, 'r');

		if (!$handle) {
			return new WP_Error('file_open', 'Could not open CSV file');
		}

		// Read and validate header
		$header = fgetcsv($handle);

		$header_0_without_bom = str_replace("\xEF\xBB\xBF", '', $header[0]);

		if ($header_0_without_bom !== 'id') {
			fclose($handle);
			return new WP_Error('invalid_header', 'CSV header does not match expected format');
		}

		$results = array(
			'processed' => 0,
			'created' => 0,
			'updated' => 0,
			'errors' => 0
		);

		$row_number = 1; // Start from 1 to account for header

		while (($row = fgetcsv($handle)) !== FALSE) {
			$row_number++;
			$result = $this->process_single_row($row, $row_number);

			if (is_wp_error($result)) {
				$results['errors']++;
				error_log("Dealers CSV Import Error (Row {$row_number}): " . $result->get_error_message());
			} else {
				if ($result === 'created') {
					$results['created']++;
				} else {
					$results['updated']++;
				}
			}

			$results['processed']++;
		}

		fclose($handle);
		return $results;
	}

    /**
     * Convert content to UTF-8 with multiple attempts
     */
    private function convert_to_utf8($content, $source_encoding) {
        if ($source_encoding === 'UTF-8') {
            return $content;
        }

        // List of possible source encodings to try
        $encodings_to_try = [$source_encoding];

        // Add common alternatives for Cyrillic
        if ($source_encoding === 'CP866') {
            $encodings_to_try[] = 'Windows-1251';
            $encodings_to_try[] = 'CP1251';
        } elseif ($source_encoding === 'Windows-1251' || $source_encoding === 'CP1251') {
            $encodings_to_try[] = 'CP866';
        }

        // Try each encoding
        foreach ($encodings_to_try as $encoding) {
            $converted = @mb_convert_encoding($content, 'UTF-8', $encoding);

            // Validate that the conversion produced readable Cyrillic text
            if ($this->is_valid_cyrillic_text($converted)) {
                return $converted;
            }
        }

        // If all conversions failed, return the first attempt but log warning
        $converted = @mb_convert_encoding($content, 'UTF-8', $source_encoding);
        error_log("Dealers CSV Import: Encoding conversion may have issues. Source: $source_encoding");
        return $converted;
    }

    /**
     * Validate that text contains proper Cyrillic characters
     */
    private function is_valid_cyrillic_text($text) {
        // Sample the first 500 characters for validation
        $sample = substr($text, 0, 500);

        // Check for presence of Cyrillic characters
        if (preg_match('/\p{Cyrillic}/u', $sample)) {
            return true;
        }

        // Also allow Latin text for company names that might be in English
        if (preg_match('/[a-zA-Z0-9\s\-\.,&]+/', $sample) && strlen($sample) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Detect file encoding
     */
    private function detect_file_encoding($file_path, $user_encoding = 'auto') {
        // If user specified encoding, use it
        if ($user_encoding !== 'auto') {
            $supported_encodings = array('UTF-8', 'Windows-1251', 'CP866', 'CP1251');
            if (in_array($user_encoding, $supported_encodings)) {
                return $user_encoding;
            }
        }

        // Auto-detect encoding
        $file_content = file_get_contents($file_path);

        // Check for UTF-8 BOM
        if (substr($file_content, 0, 3) === "\xEF\xBB\xBF") {
            return 'UTF-8';
        }

        // Use mb_detect_encoding with Cyrillic focus
        $detected = mb_detect_encoding($file_content, array('UTF-8', 'Windows-1251', 'CP866', 'CP1251', 'ISO-8859-5'), true);

        if ($detected) {
            return $detected;
        }

        // Fallback: try to determine by testing conversions
        return $this->fallback_encoding_detection($file_content);
    }

    /**
     * Fallback encoding detection by testing conversions
     */
    private function fallback_encoding_detection($content) {
        $encodings = ['CP866', 'Windows-1251', 'CP1251'];

        foreach ($encodings as $encoding) {
            $converted = @mb_convert_encoding($content, 'UTF-8', $encoding);
            if ($this->is_valid_cyrillic_text($converted)) {
                return $encoding;
            }
        }

        // Default to CP866 for Excel files
        return 'CP866';
    }

	/**
	 * Process a single row from CSV
	 */
	private function process_single_row($row, $row_number) {

		// Map row data to variables
		list($id, $company_name, $city_name, $address, $phone, $email, $website) = $row;

		// Validate and sanitize data
		$company_name = $this->sanitize_cyrillic_text($company_name);
		$city_name = $this->sanitize_cyrillic_text($city_name);
		$address = $this->sanitize_cyrillic_text($address);
		$phone = $this->sanitize_phone($phone);
		$email = $this->sanitize_email($email);
		$website = $this->sanitize_url($website);

		// Validate required fields
		if (empty($company_name)) {
			return new WP_Error('missing_company', 'Company name is required');
		}

		if (empty($city_name)) {
			return new WP_Error('missing_city', 'City name is required');
		}

		// Prepare post data
		$post_data = array(
			'post_title' => $company_name,
			'post_type' => 'dealers',
			'post_status' => 'publish'
		);

		// Check if we're updating an existing post
		$post_id = null;
		if (!empty($id)) {
			$post_id = intval($id);
			$existing_post = get_post($post_id);

			if (!$existing_post || $existing_post->post_type !== 'dealers') {
				return new WP_Error('invalid_id', "Post with ID {$post_id} not found or is not a dealer");
			}

			$post_data['ID'] = $post_id;
		}

		// Insert or update post
		if ($post_id) {
			$result = wp_update_post($post_data, true);
		} else {
			$result = wp_insert_post($post_data, true);
		}

		if (is_wp_error($result)) {
			return $result;
		}

		$post_id = $result;

		// Handle city taxonomy
		$this->handle_city_taxonomy($post_id, $city_name);

		// Update meta fields
		update_post_meta($post_id, 'company_address', $address);
		update_post_meta($post_id, 'company_phone', $phone);
		update_post_meta($post_id, 'company_email', $email);
		update_post_meta($post_id, 'company_website', $website);

		return $post_id ? 'updated' : 'created';
	}

	/**
	 * Handle city taxonomy assignment
	 */
	private function handle_city_taxonomy($post_id, $city_name) {
		if (!taxonomy_exists('dealer_city')) {
			return new WP_Error('missing_taxonomy', 'Dealer city taxonomy does not exist');
		}

		// Remove all existing city terms
		wp_set_object_terms($post_id, array(), 'dealer_city');

		// Add new city term
		if (!empty($city_name)) {
			$term = term_exists($city_name, 'dealer_city');

			if (!$term) {
				$term = wp_insert_term($city_name, 'dealer_city');
			}

			if (!is_wp_error($term)) {
				wp_set_object_terms($post_id, array(intval($term['term_id'])), 'dealer_city');
			}
		}
	}

	/**
	 * Sanitize Cyrillic text
	 */
	private function sanitize_cyrillic_text($text) {
		$text = trim($text);
		// Allow Cyrillic characters, basic punctuation, and spaces
		$text = preg_replace('/[^\p{Cyrillic}\p{L}\p{N}\s\-\.\,\!\?\(\)]/u', '', $text);
		return sanitize_text_field($text);
	}

	/**
	 * Sanitize phone number
	 */
	private function sanitize_phone($phone) {
		$phone = trim($phone);
		// Allow numbers, spaces, parentheses, hyphens, and plus sign
		$phone = preg_replace('/[^\d\s\-\+\(\)]/', '', $phone);
		return sanitize_text_field($phone);
	}

	/**
	 * Sanitize email
	 */
	private function sanitize_email($email) {
		$email = trim($email);
		return sanitize_email($email);
	}

	/**
	 * Sanitize URL
	 */
	private function sanitize_url($url) {
		$url = trim($url);
		if (!empty($url) && !preg_match('/^https?:\/\//', $url)) {
			$url = 'http://' . $url;
		}
		return esc_url_raw($url);
	}

	/**
	 * Redirect with result message
	 */
	private function redirect_with_message($message, $success) {
		$url = add_query_arg(array(
			'import_result' => urlencode($message),
			'success' => $success ? '1' : '0'
		), admin_url('edit.php?post_type=dealers&page=dealers-csv-import'));

		wp_redirect($url);
		exit;
	}
}

// Initialize the plugin
new DealersCSVImporter();
