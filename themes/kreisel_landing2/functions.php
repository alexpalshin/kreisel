<?php
define('LAYOUT_VER', '050123');

if (! file_exists(get_template_directory() . '/inc/wp-navwalker.php')) {
	// file does not exist... return an error.
	return new WP_Error('wp-bootstrap-navwalker-missing', __('It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
} else {
	// file exists... require it.
	require_once get_template_directory() . '/inc/wp-navwalker.php';
}


// Check if Class Exists.
if (! class_exists('WP_Bootstrap_Navwalker')) :
	/**
	 * WP_Bootstrap_Navwalker class.
	 */
	class WP_Bootstrap_Navwalker extends Walker_Nav_Menu
	{

		/**
		 * Whether the items_wrap contains schema microdata or not.
		 *
		 * @since 4.2.0
		 * @var boolean
		 */
		private $has_schema = false;

		/**
		 * Ensure the items_wrap argument contains microdata.
		 *
		 * @since 4.2.0
		 */
		public function __construct()
		{
			if (! has_filter('wp_nav_menu_args', array($this, 'add_schema_to_navbar_ul'))) {
				add_filter('wp_nav_menu_args', array($this, 'add_schema_to_navbar_ul'));
			}
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @since WP 3.0.0
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param int              $depth  Depth of menu item. Used for padding.
		 * @param WP_Nav_Menu_Args $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl(&$output, $depth = 0, $args = null)
		{
			if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat($t, $depth);
			// Default class to add to the file.
			$classes = array('dropdown-menu');
			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @since WP 4.8.0
			 *
			 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
			 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			/*
			 * The `.dropdown-menu` container needs to have a labelledby
			 * attribute which points to it's trigger link.
			 *
			 * Form a string for the labelledby attribute from the the latest
			 * link with an id that was added to the $output.
			 */
			$labelledby = '';
			// Find all links with an id in the output.
			preg_match_all('/(<a.*?id=\"|\')(.*?)\"|\'.*?>/im', $output, $matches);
			// With pointer at end of array check if we got an ID match.
			if (end($matches[2])) {
				// Build a string to use as aria-labelledby.
				$labelledby = 'aria-labelledby="' . esc_attr(end($matches[2])) . '"';
			}
			$output .= "{$n}{$indent}<ul$class_names $labelledby>{$n}";
		}

		/**
		 * Starts the element output.
		 *
		 * @since WP 3.0.0
		 * @since WP 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 *
		 * @param string           $output Used to append additional content (passed by reference).
		 * @param WP_Nav_Menu_Item $item   Menu item data object.
		 * @param int              $depth  Depth of menu item. Used for padding.
		 * @param WP_Nav_Menu_Args $args   An object of wp_nav_menu() arguments.
		 * @param int              $id     Current item ID.
		 */
		public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
		{
			if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ($depth) ? str_repeat($t, $depth) : '';

			if (false !== strpos($args->items_wrap, 'itemscope') && false === $this->has_schema) {
				$this->has_schema  = true;
				$args->link_before = '<span itemprop="name">' . $args->link_before;
				$args->link_after .= '</span>';
			}

			$classes = empty($item->classes) ? array() : (array) $item->classes;

			// Updating the CSS classes of a menu item in the WordPress Customizer preview results in all classes defined
			// in that particular input box to come in as one big class string.
			$split_on_spaces = function ($class) {
				return preg_split('/\s+/', $class);
			};
			$classes         = $this->flatten(array_map($split_on_spaces, $classes));

			/*
			 * Initialize some holder variables to store specially handled item
			 * wrappers and icons.
			 */
			$linkmod_classes = array();
			$icon_classes    = array();

			/*
			 * Get an updated $classes array without linkmod or icon classes.
			 *
			 * NOTE: linkmod and icon class arrays are passed by reference and
			 * are maybe modified before being used later in this function.
			 */
			$classes = $this->separate_linkmods_and_icons_from_classes($classes, $linkmod_classes, $icon_classes, $depth);

			// Join any icon classes plucked from $classes into a string.
			$icon_class_string = join(' ', $icon_classes);

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since WP 4.4.0
			 *
			 * @param WP_Nav_Menu_Args $args  An object of wp_nav_menu() arguments.
			 * @param WP_Nav_Menu_Item $item  Menu item data object.
			 * @param int              $depth Depth of menu item. Used for padding.
			 *
			 * @var WP_Nav_Menu_Args
			 */
			$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

			// Add .dropdown or .active classes where they are needed.
			if ($this->has_children) {
				$classes[] = 'dropdown';
			}
			if (in_array('current-menu-item', $classes, true) || in_array('current-menu-parent', $classes, true)) {
				$classes[] = 'active';
			}

			// Add some additional default classes to the item.
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'nav-item';

			// Allow filtering the classes.
			$classes = apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);

			// Form a string of classes in format: class="class_names".
			$class_names = join(' ', $classes);
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since WP 3.0.1
			 * @since WP 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string           $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Nav_Menu_Item $item    The current menu item.
			 * @param WP_Nav_Menu_Args $args    An object of wp_nav_menu() arguments.
			 * @param int              $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li ' . $id . $class_names . '>';

			// Initialize array for holding the $atts for the link item.
			$atts           = array();
			$atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
			$atts['target'] = ! empty($item->target) ? $item->target : '';
			if ('_blank' === $item->target && empty($item->xfn)) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = ! empty($item->xfn) ? $item->xfn : '';
			}

			// If the item has_children add atts to <a>.
			if ($this->has_children && 0 === $depth) {
				$atts['href']          = '#';
				$atts['data-toggle']   = 'dropdown';
				$atts['aria-expanded'] = 'false';
				$atts['class']         = 'dropdown-toggle nav-link';
				$atts['id']            = 'menu-item-dropdown-' . $item->ID;
			} else {
				if (true === $this->has_schema) {
					$atts['itemprop'] = 'url';
				}

				$atts['href'] = ! empty($item->url) ? $item->url : '#';
				// For items in dropdowns use .dropdown-item instead of .nav-link.
				if ($depth > 0) {
					$atts['class'] = 'dropdown-item';
				} else {
					$atts['class'] = 'nav-link';
				}
			}

			$atts['aria-current'] = $item->current ? 'page' : '';

			// Update atts of this item based on any custom linkmod classes.
			$atts = $this->update_atts_for_linkmod_type($atts, $linkmod_classes);

			// Allow filtering of the $atts array before using it.
			$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

			// Build a string of html containing all the atts for the item.
			$attributes = '';
			foreach ($atts as $attr => $value) {
				if (! empty($value)) {
					$value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			// Set a typeflag to easily test if this is a linkmod or not.
			$linkmod_type = $this->get_linkmod_type($linkmod_classes);

			// START appending the internal item contents to the output.
			$item_output = isset($args->before) ? $args->before : '';

			/*
			 * This is the start of the internal nav item. Depending on what
			 * kind of linkmod we have we may need different wrapper elements.
			 */
			if ('' !== $linkmod_type) {
				// Is linkmod, output the required element opener.
				$item_output .= $this->linkmod_element_open($linkmod_type, $attributes);
			} else {
				// With no link mod type set this must be a standard <a> tag.
				$item_output .= '<a' . $attributes . '>';
			}

			/*
			 * Initiate empty icon var, then if we have a string containing any
			 * icon classes form the icon markup with an <i> element. This is
			 * output inside of the item before the $title (the link text).
			 */
			$icon_html = '';
			if (! empty($icon_class_string)) {
				// Append an <i> with the icon classes to what is output before links.
				$icon_html = '<i class="' . esc_attr($icon_class_string) . '" aria-hidden="true"></i> ';
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters('the_title', $item->title, $item->ID);

			/**
			 * Filters a menu item's title.
			 *
			 * @since WP 4.4.0
			 *
			 * @param string           $title The menu item's title.
			 * @param WP_Nav_Menu_Item $item  The current menu item.
			 * @param WP_Nav_Menu_Args $args  An object of wp_nav_menu() arguments.
			 * @param int              $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

			// If the .sr-only class was set apply to the nav items text only.
			if (in_array('sr-only', $linkmod_classes, true)) {
				$title         = $this->wrap_for_screen_reader($title);
				$keys_to_unset = array_keys($linkmod_classes, 'sr-only', true);
				foreach ($keys_to_unset as $k) {
					unset($linkmod_classes[$k]);
				}
			}

			// Put the item contents into $output.
			$item_output .= isset($args->link_before) ? $args->link_before . $icon_html . $title . $args->link_after : '';

			/*
			 * This is the end of the internal nav item. We need to close the
			 * correct element depending on the type of link or link mod.
			 */
			if ('' !== $linkmod_type) {
				// Is linkmod, output the required closing element.
				$item_output .= $this->linkmod_element_close($linkmod_type);
			} else {
				// With no link mod type set this must be a standard <a> tag.
				$item_output .= '</a>';
			}

			$item_output .= isset($args->after) ? $args->after : '';

			// END appending the internal item contents to the output.
			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}

		/**
		 * Menu fallback.
		 *
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function will display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 * @return string|void String when echo is false.
		 */
		public static function fallback($args)
		{
			if (! current_user_can('edit_theme_options')) {
				return;
			}

			// Initialize var to store fallback html.
			$fallback_output = '';

			// Menu container opening tag.
			$show_container = false;
			if ($args['container']) {
				/**
				 * Filters the list of HTML tags that are valid for use as menu containers.
				 *
				 * @since WP 3.0.0
				 *
				 * @param array $tags The acceptable HTML tags for use as menu containers.
				 *                    Default is array containing 'div' and 'nav'.
				 */
				$allowed_tags = apply_filters('wp_nav_menu_container_allowedtags', array('div', 'nav'));
				if (is_string($args['container']) && in_array($args['container'], $allowed_tags, true)) {
					$show_container   = true;
					$class            = $args['container_class'] ? ' class="menu-fallback-container ' . esc_attr($args['container_class']) . '"' : ' class="menu-fallback-container"';
					$id               = $args['container_id'] ? ' id="' . esc_attr($args['container_id']) . '"' : '';
					$fallback_output .= '<' . $args['container'] . $id . $class . '>';
				}
			}

			// The fallback menu.
			$class            = $args['menu_class'] ? ' class="menu-fallback-menu ' . esc_attr($args['menu_class']) . '"' : ' class="menu-fallback-menu"';
			$id               = $args['menu_id'] ? ' id="' . esc_attr($args['menu_id']) . '"' : '';
			$fallback_output .= '<ul' . $id . $class . '>';
			$fallback_output .= '<li class="nav-item"><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="nav-link" title="' . esc_attr__('Add a menu', 'wp-bootstrap-navwalker') . '">' . esc_html__('Add a menu', 'wp-bootstrap-navwalker') . '</a></li>';
			$fallback_output .= '</ul>';

			// Menu container closing tag.
			if ($show_container) {
				$fallback_output .= '</' . $args['container'] . '>';
			}

			// if $args has 'echo' key and it's true echo, otherwise return.
			if (array_key_exists('echo', $args) && $args['echo']) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $fallback_output;
			} else {
				return $fallback_output;
			}
		}

		/**
		 * Filter to ensure the items_Wrap argument contains microdata.
		 *
		 * @since 4.2.0
		 *
		 * @param  array $args The nav instance arguments.
		 * @return array $args The altered nav instance arguments.
		 */
		public function add_schema_to_navbar_ul($args)
		{
			if (isset($args['items_wrap'])) {
				$wrap = $args['items_wrap'];
				if (strpos($wrap, 'SiteNavigationElement') === false) {
					$args['items_wrap'] = preg_replace('/(>).*>?\%3\$s/', ' itemscope itemtype="http://www.schema.org/SiteNavigationElement"$0', $wrap);
				}
			}
			return $args;
		}

		/**
		 * Find any custom linkmod or icon classes and store in their holder
		 * arrays then remove them from the main classes array.
		 *
		 * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
		 * Supported iconsets: Font Awesome 4/5, Glypicons
		 *
		 * NOTE: This accepts the linkmod and icon arrays by reference.
		 *
		 * @since 4.0.0
		 *
		 * @param array   $classes         an array of classes currently assigned to the item.
		 * @param array   $linkmod_classes an array to hold linkmod classes.
		 * @param array   $icon_classes    an array to hold icon classes.
		 * @param integer $depth           an integer holding current depth level.
		 *
		 * @return array  $classes         a maybe modified array of classnames.
		 */
		private function separate_linkmods_and_icons_from_classes($classes, &$linkmod_classes, &$icon_classes, $depth)
		{
			// Loop through $classes array to find linkmod or icon classes.
			foreach ($classes as $key => $class) {
				/*
				 * If any special classes are found, store the class in it's
				 * holder array and and unset the item from $classes.
				 */
				if (preg_match('/^disabled|^sr-only/i', $class)) {
					// Test for .disabled or .sr-only classes.
					$linkmod_classes[] = $class;
					unset($classes[$key]);
				} elseif (preg_match('/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class) && $depth > 0) {
					/*
					 * Test for .dropdown-header or .dropdown-divider and a
					 * depth greater than 0 - IE inside a dropdown.
					 */
					$linkmod_classes[] = $class;
					unset($classes[$key]);
				} elseif (preg_match('/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class)) {
					// Font Awesome.
					$icon_classes[] = $class;
					unset($classes[$key]);
				} elseif (preg_match('/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class)) {
					// Glyphicons.
					$icon_classes[] = $class;
					unset($classes[$key]);
				}
			}

			return $classes;
		}

		/**
		 * Return a string containing a linkmod type and update $atts array
		 * accordingly depending on the decided.
		 *
		 * @since 4.0.0
		 *
		 * @param array $linkmod_classes array of any link modifier classes.
		 *
		 * @return string                empty for default, a linkmod type string otherwise.
		 */
		private function get_linkmod_type($linkmod_classes = array())
		{
			$linkmod_type = '';
			// Loop through array of linkmod classes to handle their $atts.
			if (! empty($linkmod_classes)) {
				foreach ($linkmod_classes as $link_class) {
					if (! empty($link_class)) {

						// Check for special class types and set a flag for them.
						if ('dropdown-header' === $link_class) {
							$linkmod_type = 'dropdown-header';
						} elseif ('dropdown-divider' === $link_class) {
							$linkmod_type = 'dropdown-divider';
						} elseif ('dropdown-item-text' === $link_class) {
							$linkmod_type = 'dropdown-item-text';
						}
					}
				}
			}
			return $linkmod_type;
		}

		/**
		 * Update the attributes of a nav item depending on the limkmod classes.
		 *
		 * @since 4.0.0
		 *
		 * @param array $atts            array of atts for the current link in nav item.
		 * @param array $linkmod_classes an array of classes that modify link or nav item behaviors or displays.
		 *
		 * @return array                 maybe updated array of attributes for item.
		 */
		private function update_atts_for_linkmod_type($atts = array(), $linkmod_classes = array())
		{
			if (! empty($linkmod_classes)) {
				foreach ($linkmod_classes as $link_class) {
					if (! empty($link_class)) {
						/*
						 * Update $atts with a space and the extra classname
						 * so long as it's not a sr-only class.
						 */
						if ('sr-only' !== $link_class) {
							$atts['class'] .= ' ' . esc_attr($link_class);
						}
						// Check for special class types we need additional handling for.
						if ('disabled' === $link_class) {
							// Convert link to '#' and unset open targets.
							$atts['href'] = '#';
							unset($atts['target']);
						} elseif ('dropdown-header' === $link_class || 'dropdown-divider' === $link_class || 'dropdown-item-text' === $link_class) {
							// Store a type flag and unset href and target.
							unset($atts['href']);
							unset($atts['target']);
						}
					}
				}
			}
			return $atts;
		}

		/**
		 * Wraps the passed text in a screen reader only class.
		 *
		 * @since 4.0.0
		 *
		 * @param string $text the string of text to be wrapped in a screen reader class.
		 * @return string      the string wrapped in a span with the class.
		 */
		private function wrap_for_screen_reader($text = '')
		{
			if ($text) {
				$text = '<span class="sr-only">' . $text . '</span>';
			}
			return $text;
		}

		/**
		 * Returns the correct opening element and attributes for a linkmod.
		 *
		 * @since 4.0.0
		 *
		 * @param string $linkmod_type a sting containing a linkmod type flag.
		 * @param string $attributes   a string of attributes to add to the element.
		 *
		 * @return string              a string with the openign tag for the element with attribibutes added.
		 */
		private function linkmod_element_open($linkmod_type, $attributes = '')
		{
			$output = '';
			if ('dropdown-item-text' === $linkmod_type) {
				$output .= '<span class="dropdown-item-text"' . $attributes . '>';
			} elseif ('dropdown-header' === $linkmod_type) {
				/*
				 * For a header use a span with the .h6 class instead of a real
				 * header tag so that it doesn't confuse screen readers.
				 */
				$output .= '<span class="dropdown-header h6"' . $attributes . '>';
			} elseif ('dropdown-divider' === $linkmod_type) {
				// This is a divider.
				$output .= '<div class="dropdown-divider"' . $attributes . '>';
			}
			return $output;
		}

		/**
		 * Return the correct closing tag for the linkmod element.
		 *
		 * @since 4.0.0
		 *
		 * @param string $linkmod_type a string containing a special linkmod type.
		 *
		 * @return string              a string with the closing tag for this linkmod type.
		 */
		private function linkmod_element_close($linkmod_type)
		{
			$output = '';
			if ('dropdown-header' === $linkmod_type || 'dropdown-item-text' === $linkmod_type) {
				/*
				 * For a header use a span with the .h6 class instead of a real
				 * header tag so that it doesn't confuse screen readers.
				 */
				$output .= '</span>';
			} elseif ('dropdown-divider' === $linkmod_type) {
				// This is a divider.
				$output .= '</div>';
			}
			return $output;
		}

		/**
		 * Flattens a multidimensional array to a simple array.
		 *
		 * @param array $array a multidimensional array.
		 *
		 * @return array a simple array
		 */
		public function flatten($array)
		{
			$result = array();
			foreach ($array as $element) {
				if (is_array($element)) {
					array_push($result, ...$this->flatten($element));
				} else {
					$result[] = $element;
				}
			}
			return $result;
		}
	}

endif;


if (file_exists(get_template_directory() . '/inc/distical/src/Distical.inc.php')) {
	// file exists... require it.
	require_once get_template_directory() . '/inc/distical/src/Distical.inc.php';
}


/**
 * Save ACF JSON to theme folder
 */

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

define('ACF_JSON_FOLDER', 'acf-fields');

function my_acf_json_save_point($path)
{

	// update path
	$path = get_stylesheet_directory() . '/' . ACF_JSON_FOLDER;


	// return
	return $path;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths)
{

	// remove original path (optional)
	unset($paths[0]);


	// append path
	$paths[] = get_stylesheet_directory() . '/' . ACF_JSON_FOLDER;


	// return
	return $paths;
}

/**
 * Show required plugins notifications in Dashboard.
 */

add_action('admin_notices', 'krl_showAdminMessages');

function krl_showAdminMessages()
{
	$plugin_messages = array();

	include_once(ABSPATH . 'wp-admin/includes/plugin.php');

	// ACF Pro Plugin
	if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
		$plugin_messages[] = 'This theme requires you to install the ACF Pro plugin, <a href="https://www.advancedcustomfields.com/pro/">download it from here</a>.';
	}


	if (count($plugin_messages) > 0) {
		echo '<div id="message" class="error">';

		foreach ($plugin_messages as $message) {
			echo '<p><strong>' . $message . '</strong></p>';
		}

		echo '</div>';
	}
}

function load_styles()
{
	wp_register_style('style', get_template_directory_uri() . '/dist/css/main_blue.css', array(), LAYOUT_VER, 'all');
	wp_enqueue_style('style');
}
add_action('wp_enqueue_scripts', 'load_styles');


function include_theme_scripts()
{
	wp_register_script('select2', get_template_directory_uri() . '/src/js/select2.min.js', array('jquery'), LAYOUT_VER, true);
	wp_enqueue_script('select2');
	wp_enqueue_script('slick', get_template_directory_uri() . '/src/js/slick.min.js', array('jquery'), LAYOUT_VER, true);
	wp_enqueue_script('mainjs', get_template_directory_uri() . '/dist/js/main.js', array('jquery'), LAYOUT_VER, true);
	wp_register_script('customjs', get_template_directory_uri() . '/src/js/custom.js', array('jquery', 'slick', 'select2', 'mainjs'), LAYOUT_VER, true);
	$params = array(
		'ajaxurl'       => admin_url('admin-ajax.php'),
		'ajax_nonce'    => wp_create_nonce('krl-ajax-safe'),
		'themeurl'      => get_stylesheet_directory_uri()
	);
	wp_localize_script('customjs', 'localization', $params);

	wp_enqueue_script('customjs');
}
add_action('wp_enqueue_scripts', 'include_theme_scripts');


function krl_theme_setup()
{
	load_theme_textdomain('kreisel', get_stylesheet_directory_uri() . '/lang');
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	register_nav_menus(
		array(
			'top-menu' => __('Top Menu'),
			'meta-menu' => __('Meta Menu'),
			'footer-menu' => __('Footer Menu'),
			'social-menu' => __('Social Menu'),
		)
	);

	add_image_size('smallest', 300, 300, true);
	add_image_size('largest', 1200, 800, true);
}
add_action('after_setup_theme', 'krl_theme_setup');


if (function_exists('acf_add_options_page')) {

	acf_add_options_page();
}


/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function krl_widgets_init()
{
	register_sidebar(array(
		'name' => __('Main Widgets'),
		'id' => 'sidebar-main',
		'description' => __('Appears on posts and pages'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('Footer Widgets 1'),
		'id' => 'sidebar-1',
		'description' => __('Appears on footer'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('Footer Widgets 2'),
		'id' => 'sidebar-2',
		'description' => __('Appears on footer'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('Footer Widgets 3'),
		'id' => 'sidebar-3',
		'description' => __('Appears on footer'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('Footer Widgets 3'),
		'id' => 'sidebar-3',
		'description' => __('Appears on footer'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'krl_widgets_init');


/**
 * AJAX handler for processing Load More Features Articles request from Front page
 *
 */

add_action('wp_ajax_nopriv_krl_more_post_ajax', 'krl_more_post_ajax');
add_action('wp_ajax_krl_more_post_ajax', 'krl_more_post_ajax');

if (!function_exists('krl_more_post_ajax')) {
	function krl_more_post_ajax()
	{

		check_ajax_referer('krl-ajax-safe', 'security');

		$cpt     = 'species';
		$ppp     = (isset($_POST['ppp'])) ? $_POST['ppp'] : 5;
		$paged   = (isset($_POST['page_num'])) ? $_POST['page_num'] : 1;
		$offset  = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
		$search  = (isset($_POST['q'])) ? $_POST['q'] : '';


		global $post;

		$args = array(
			'post_type'         => $cpt,
			'post_status'       => 'publish',
			'posts_per_page'    => $ppp,
			'paged'             => $paged,
			'offset'            => $offset,
			'orderby'           => 'default_date',
			'order'             => 'DESC'
		);

		if (!empty($search)) {
			$args['s'] = $search;
		}

		$i = 0;

		/*
		$querystr = "
		    SELECT $wpdb->posts.* 
		    FROM $wpdb->posts,
		    WHERE $wpdb->posts.post_status = 'publish' 
		    AND $wpdb->posts.post_type = 'species'
		    AND $wpdb->posts.post_date < NOW()
		    ORDER BY $wpdb->posts.post_date DESC
 ";

		$myposts = $wpdb->get_results($querystr, OBJECT);*/

		$myposts = new WP_Query($args);

		$out = '';
		$out .= "<div class=\"row\">";

		global $post;

		foreach ($myposts as $post) : setup_postdata($post);

			$args['thumb_url'] = (has_post_thumbnail($post)) ? get_the_post_thumbnail_url($post) : krl_catch_that_image($post);
			$args['url'] = get_the_permalink();
			$args['title'] = get_the_title();
			$args['author'] = get_field('author', $post->ID);
			if (!empty($post->post_excerpt)) {
				$args['excerpt'] =  $post->post_excerpt;
			} else {
				$args['excerpt'] = get_the_content(); //the_advanced_excerpt('length=30&use_words=1&no_custom=1&ellipsis=%26hellip;&exclude_tags=img,p,strong,iframe','true');
			}
			$args['time'] = get_the_time('d.m.Y');
			$post_meta = '';


			$post_cats = get_the_terms($post, 'family');

			$cat_i = 0;
			$cats_num = count($post_cats);
			foreach ($post_cats as $post_cat) {
				$cat_i++;
				$cat_name = $post_cat->name;
				$cat_link = get_category_link($post_cat);
				if ($cat_name == 'Без рубрики') {
					continue;
				}
				$args['post_meta'] .= "<a href=\"$cat_link\">$post_cat->name</a>";
				if ($cat_i < $cats_num) $args['post_meta'] .= " &raquo; ";
			}
			$args['i'] = $i;

			ob_start();

			get_template_part('article-frame', null, $args);

			$out .= "<div class=\"col-lg-3 col-md-6\">";
			$out .= ob_get_contents();
			ob_end_clean();
			$out .= "</div>";

			$i++;

		endforeach;

		$out .= "</div>";

		wp_reset_postdata();
		wp_reset_query();


		wp_die($out);
	}
}


/**
 * AJAX search handler
 */

function krl_ajax_search()
{

	check_ajax_referer('krl-ajax-safe', 'security');

	$args = array(
		'post_status'      => 'publish',
		'order'            => 'DESC',
		'orderby'          => 'title',
		's'                => $_POST['term'],
		'posts_per_page'   => -1,
		'suppress_filters'  => false
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$thumb_url = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : krl_catch_that_image();
?>
			<a href="<?php the_permalink(); ?>">
				<div class="search-result__item">
					<div class="search-result__image" style="background-image: url('<?php echo $thumb_url; ?>')"></div>
					<h3><?php the_title(); ?></h3>
				</div>
			</a>
		<?php }
	} else { ?>
		<a><?php _e('Nothing was found'); ?></a>
<?php }
	exit;
}
add_action('wp_ajax_nopriv_krl_ajax_search', 'krl_ajax_search');
add_action('wp_ajax_krl_ajax_search', 'krl_ajax_search');


/**
 * Let's calculate total number of pages
 * @param $ppp
 * @param $cats
 * @return integer
 */

function krl_total_pages($ppp = 3, $offset = 0, $cats = '')
{
	$args = array(
		'post_type'         => 'product',
		'post_status'       => 'publish',
		'posts_per_page'    => -1,
		'suppress_filters'  => false
	);

	$totalposts = get_posts($args);

	for ($i = 1; $i <= $offset; $i++) {
		$first = array_shift($totalposts);
	}

	$postperp = $ppp;

	$pages = count($totalposts) / $postperp;

	return ceil($pages);
}

/**
 * Catches first image from post content
 * @return string
 */

function krl_catch_that_image($custom_post = '')
{
	global $post, $posts;
	if (!empty($custom_post)) $post = $custom_post;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);

	if (!empty($matches[1][0])) {
		$first_img = $matches[1][0];
	} else {
		$first_img = get_stylesheet_directory_uri() . "/images/default.jpg";
	}
	return $first_img;
}


/**
 * Add References post type
 */
add_action('init', 'krl_add_refs_cpt');
function krl_add_refs_cpt()
{
	$labels = array(
		'name'               => _x('Объекты', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Объект', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Объекты', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Объект', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Объект', 'wordpress'),
		'new_item'           => __('Новый Объект', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Объекты', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'refs'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title', 'editor', 'thumbnail'),
		'taxonomies'         => array('project_location', 'project_type', 'construction_type'),
		'show_in_rest'       => true,
	);

	register_post_type('refs', $args);
}


add_action('init', 'krl_refs_taxonomies', 0);
function krl_refs_taxonomies()
{

	//Product type

	$labels = array(
		'name' => _x('Локация объекта', 'taxonomy general name'),
		'singular_name' => _x('Локация объекта', 'taxonomy singular name'),
		'search_items' =>  __('Искать Локации'),
		'all_items' => __('Все Локации объектов'),
		'parent_item' => __('Локация объекта'),
		'parent_item_colon' => __('Локация объекта:'),
		'edit_item' => __('Изменить Локацию объекта'),
		'update_item' => __('Обновить Локацию объекта'),
		'add_new_item' => __('Добавить Локацию объекта'),
		'new_item_name' => __('Название Локации'),
		'menu_name' => __('Локации объектов'),
	);

	// Now register the taxonomy

	register_taxonomy('project_location', array('refs'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest'       => true,
		'query_var' => true,
	));



	//Project type

	$labels = array(
		'name' => _x('Тип объекта', 'taxonomy general name'),
		'singular_name' => _x('Тип объекта', 'taxonomy singular name'),
		'search_items' =>  __('Искать Тип объекта'),
		'all_items' => __('Все Типы объекта'),
		'parent_item' => __('Тип объекта'),
		'parent_item_colon' => __('Тип объекта:'),
		'edit_item' => __('Изменить Тип объекта'),
		'update_item' => __('Обновить Тип объекта'),
		'add_new_item' => __('Добавить Тип объекта'),
		'new_item_name' => __('Название Типа объекта'),
		'menu_name' => __('Тип объекта'),
	);

	// Now register the taxonomy

	register_taxonomy('project_type', array('refs'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest'       => true,
		'query_var' => true,
	));



	//Construction type

	$labels = array(
		'name' => _x('Тип конструкции', 'taxonomy general name'),
		'singular_name' => _x('Тип конструкции', 'taxonomy singular name'),
		'search_items' =>  __('Искать Тип конструкции'),
		'all_items' => __('Все Типы конструкции'),
		'parent_item' => __('Тип конструкции'),
		'parent_item_colon' => __('Тип конструкции:'),
		'edit_item' => __('Изменить Тип конструкции'),
		'update_item' => __('Обновить Тип конструкции'),
		'add_new_item' => __('Добавить Тип конструкции'),
		'new_item_name' => __('Название Типа конструкции'),
		'menu_name' => __('Тип конструкции'),
	);

	// Now register the taxonomy

	register_taxonomy('construction_type', array('refs'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest'       => true,
		'query_var' => true,
	));
}


/**
 * Add Products post type
 */
add_action('init', 'krl_add_products_cpt');
function krl_add_products_cpt()
{
	$labels = array(
		'name'               => _x('Продукты', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Продукт', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Продукты', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Продукт', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Продукт', 'wordpress'),
		'new_item'           => __('Новый Продукт', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Продукты', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'products'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title', 'editor', 'thumbnail'),
		'taxonomies'         => array('products'),
		'show_in_rest'       => true,
	);

	register_post_type('product', $args);
}

add_action('init', 'krl_produkt_taxonomies', 0);
function krl_produkt_taxonomies()
{

	//Products taxonomy

	$labels = array(
		'name' => _x('Категория продуктов', 'taxonomy general name'),
		'singular_name' => _x('Категория', 'taxonomy singular name'),
		'search_items' =>  __('Искать Категорию'),
		'all_items' => __('Все Категории'),
		'parent_item' => __('Категории'),
		'parent_item_colon' => __('Категория:'),
		'edit_item' => __('Изменить Категорию'),
		'update_item' => __('Обновить Категорию'),
		'add_new_item' => __('Добавить Категорию'),
		'new_item_name' => __('Название Категории'),
		'menu_name' => __('Категории продуктов'),
	);

	// Now register the taxonomy

	register_taxonomy('products', array('product'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'rewrite' => array(
			'hierarchical' => true,
			'slug' => 'prodcat'
		),
	));
}



/**
 * Add Instructions post type
 */
add_action('init', 'krl_add_instructions_cpt');
function krl_add_instructions_cpt()
{
	$labels = array(
		'name'               => _x('Инструкции', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Инструкция', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Инструкции', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Инструкцию', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Инструкцию', 'wordpress'),
		'new_item'           => __('Новая Инструкция', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Инструкции', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'indstructions'),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title', 'thumbnail'),
		'show_in_rest'       => true,
	);

	register_post_type('indstructions', $args);
}



/**
 * Add Jobs post type
 */
add_action('init', 'krl_add_jobs_cpt');
function krl_add_jobs_cpt()
{
	$labels = array(
		'name'               => _x('Вакансии', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Вакансия', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Вакансии', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Вакансию', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Вакансию', 'wordpress'),
		'new_item'           => __('Новая Вакансия', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Вакансии', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'jobs/position'),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title'),
		'show_in_rest'       => true,
	);

	register_post_type('jobs', $args);
}


/**
 * Add Dealers post type
 */
add_action('init', 'krl_add_dealers_cpt');
function krl_add_dealers_cpt()
{
	$labels = array(
		'name'               => _x('Дистрибьюторы', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Дистрибьютор', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Дистрибьюторы', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Дистрибьютор', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Дистрибьютора', 'wordpress'),
		'new_item'           => __('Новый Дистрибьютор', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Дистрибьюторы', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title', 'editor', 'thumbnail'),
		'taxonomies'         => array('dealer_city'),
		'show_in_rest'       => true,
	);

	register_post_type('dealers', $args);
}


add_action('init', 'krl_dealers_taxonomies', 0);
function krl_dealers_taxonomies()
{

	//Dealer city

	$labels = array(
		'name' => _x('Города', 'taxonomy general name'),
		'singular_name' => _x('Город', 'taxonomy singular name'),
		'search_items' =>  __('Искать Город'),
		'all_items' => __('Все Города'),
		'parent_item' => __('Город'),
		'parent_item_colon' => __('Город:'),
		'edit_item' => __('Изменить Город'),
		'update_item' => __('Обновить Город'),
		'add_new_item' => __('Добавить Город'),
		'new_item_name' => __('Название Города'),
		'menu_name' => __('Города'),
	);

	// Now register the taxonomy

	register_taxonomy('dealer_city', array('dealers'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest'       => true,
		'query_var' => true,
	));
}


/**
 * Add Downloads post type
 */
add_action('init', 'krl_add_downloads_cpt');
function krl_add_downloads_cpt()
{
	$labels = array(
		'name'               => _x('Загрузки', 'post type general name', 'wordpress'),
		'singular_name'      => _x('Загрузка', 'post type singular name', 'wordpress'),
		'menu_name'          => _x('Загрузки', 'admin menu', 'wordpress'),
		'name_admin_bar'     => _x('Загрузку', 'add new on admin bar', 'wordpress'),
		'add_new'            => _x('Добавить', 'bio', 'wordpress'),
		'add_new_item'       => __('Добавить Загрузку', 'wordpress'),
		'new_item'           => __('Новая Загрузка', 'wordpress'),
		'edit_item'          => __('Редактировать', 'wordpress'),
		'view_item'          => __('Просмотреть', 'wordpress'),
		'all_items'          => __('Все Загрузки', 'wordpress')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __('Description.', 'wordpress'),
		'public'             => true,
		'exclude_from_search' => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title', 'editor'),
		'taxonomies'         => array('download_category'),
		'show_in_rest'       => true,
	);

	register_post_type('downloads', $args);
}


add_action('init', 'krl_downloads_taxonomies', 0);
function krl_downloads_taxonomies()
{

	//Download category

	$labels = array(
		'name' => _x('Категории загрузок', 'taxonomy general name'),
		'singular_name' => _x('Категория', 'taxonomy singular name'),
		'search_items' =>  __('Искать Категорию'),
		'all_items' => __('Все Категории'),
		'parent_item' => __('Категория'),
		'parent_item_colon' => __('Категория:'),
		'edit_item' => __('Изменить Категорию'),
		'update_item' => __('Обновить Категорию'),
		'add_new_item' => __('Добавить Категорию'),
		'new_item_name' => __('Название Категории'),
		'menu_name' => __('Категории'),
	);

	// Now register the taxonomy

	register_taxonomy('download_category', array('downloads'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest'       => true,
		'query_var' => true,
	));
}


add_action('init', function () {

	if (isset($_GET['import_dealers'])) {

		$upload_dir   = wp_upload_dir();

		$res = fopen($upload_dir['path'] . '/dealers.csv', "r");

		if ($res) {

			$allposts = get_posts(array('post_type' => 'dealers', 'numberposts' => -1));
			foreach ($allposts as $eachpost) {
				wp_delete_post($eachpost->ID, true);
			}

			$flag = true;
			while (($single_data = fgetcsv($res, 10000, ",")) !== FALSE) {
				if ($flag) {
					$flag = false;
					continue;
				}

				//wp_die(var_dump($single_data));

				/* Taxonomies */

				$dealer_tax = array();

				$city_tax    = get_term_by('name', $single_data[8], 'dealer_city');

				if (!$city_tax) { // if not exists
					$parent = wp_insert_term(
						$single_data[8], // category name
						'dealer_city' // taxonomy
					);
					if (!is_wp_error($parent)) {
						$parent_id = $parent['term_id'];
						array_push($dealer_tax, $parent_id);
					} else {
						var_dump($parent);
					}
				} else {
					$parent_id = $city_tax->term_id;
					array_push($dealer_tax, $parent_id);
				}

				$post_id = wp_insert_post(wp_slash(array(
					'post_title'   => wp_strip_all_tags($single_data[4]),
					'post_content' => '',
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_type'    => 'dealers'
				)));

				if ($post_id != 0) {
					wp_set_object_terms($post_id, $dealer_tax, 'dealer_city');

					update_post_meta($post_id, 'company_address', $single_data[6]);
					update_post_meta($post_id, 'company_postcode', $single_data[7]);
					update_post_meta($post_id, 'company_phone', $single_data[9]);
					update_post_meta($post_id, 'company_email', $single_data[10]);
					update_post_meta($post_id, 'company_website', $single_data[11]);
					update_post_meta($post_id, 'coord_n', $single_data[16]);
					update_post_meta($post_id, 'coord_e', $single_data[17]);
				}

				echo "$single_data[4] <br>";
			}

			fclose($res);
		}

		wp_die();
	}
});


function krl_numtomonth($string)
{
	$converter = array(
		'1' => 'Январь',
		'2' => 'Февраль',
		'3' => 'Март',
		'4' => 'Апрель',
		'5' => 'Май',
		'6' => 'Июнь',
		'7' => 'Июль',
		'8' => 'Август',
		'9' => 'Сентябрь',
		'01' => 'Январь',
		'02' => 'Февраль',
		'03' => 'Март',
		'04' => 'Апрель',
		'05' => 'Май',
		'06' => 'Июнь',
		'07' => 'Июль',
		'08' => 'Август',
		'09' => 'Сентябрь',
		'10' => 'Октябрь',
		'11' => 'Ноябрь',
		'12' => 'Декабрь'
	);
	$string = strtr($string, $converter);
	return $string;
}

/* Custom CF7 validation */
add_filter('wpcf7_validate_text', 'custom_text_validation_filter', 1, 2);

function custom_text_validation_filter($result, $tag)
{
	$tag = new WPCF7_FormTag($tag);
	if ('robot-input' == $tag->name) {
		$robot = $_POST['robot-input'];
		if (mb_strlen($robot) > 0) {
			$result->invalidate($tag, "Form processing error.");
			return $result;
		}
	}

	if ('loaded' == $tag->name) {
		$loaded = $_POST['loaded'];
		if ($loaded != 'loaded') {
			$result->invalidate($tag, "Form validation error.");
			return $result;
		}
	}
	return $result;
}


/* Check if overlaying header is needed */

function krl_is_overlaying_header()
{
	global $post;
	if (is_front_page()) return true;
	//if (is_page_template('sectioned.php')) return true;
	if (!empty(get_field('banner', $post->ID))) return true;

	return false;
}


/* Return background color class */

function krl_get_bg_class($background_type = 'solid', $background_color = 'white', $bg_position = '')
{

	$bg_pos = '';
	$bg_color = '';

	if ($background_type == 'solid') {

		if ($background_color == 'white') {
			$bg_color = 'bg-white';
		} elseif ($background_color == 'gray') {
			$bg_color = 'bg-gray';
		} elseif ($background_color == 'darkgray') {
			$bg_color = 'bg-darkgray';
		} else {
			$bg_color = 'bg-white';
		}
	} else {
		if ($bg_position == "to left") {

			$bg_pos = 'bg-image-left';

			if ($background_color == 'white') {
				$bg_color = 'bg-white-left';
			} elseif ($background_color == 'gray') {
				$bg_color = 'bg-gray-left';
			} elseif ($background_color == 'darkgray') {
				$bg_color = 'bg-darkgray-left';
			}
		} elseif ($bg_position == "to right") {

			$bg_pos = 'bg-image-right';

			if ($background_color == 'white') {
				$bg_color = 'bg-white-right';
			} elseif ($background_color == 'gray') {
				$bg_color = 'bg-gray-right';
			} elseif ($background_color == 'darkgray') {
				$bg_color = 'bg-darkgray-right';
			}
		}
	}

	$result = array(
		'bg_color' => $bg_color,
		'bg_pos' => $bg_pos
	);

	return $result;
}


/**
 * Return column class
 */

function krl_get_column_class($cols)
{
	if ($cols == 2) $cols_class = 'col-12 col-md-6';
	if ($cols == 3) $cols_class = 'col-12 col-md-4';
	if ($cols == 4) $cols_class = 'col-12 col-md-3';

	return $cols_class;
}


/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.1
 */
function kama_breadcrumbs($sep = ' » ', $l10n = array(), $args = array())
{
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs($sep, $l10n, $args);
}


class Kama_Breadcrumbs
{

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => '<span itemprop="name" style="display:none;">Home</span>
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-home">
                                            <symbol viewBox="0 0 24 24" id="icon-home">
                                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                            </symbol>
                                        </use>
                                    </svg>',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => false,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs($sep, $l10n, $args)
	{
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge(apply_filters('kama_breadcrumbs_default_loc', self::$l10n), $l10n);
		$arg = (object) array_merge(apply_filters('kama_breadcrumbs_default_args', self::$args), $args);

		$arg->sep = '<span class="kb_sep">' . $arg->sep . '</span>'; // дополним

		// упростим
		$sep = &$arg->sep;
		$this->arg = &$arg;

		// микроразметка ---
		if (1) {
			$mark = &$arg->markup;

			// Разметка по умолчанию
			if (! $mark) $mark = array(
				'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
				'linkpatt'  => '<a href="%s">%s</a>',
				'sep_after' => '',
			);
			// rdf
			elseif ($mark === 'rdf.data-vocabulary.org') $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
				'linkpatt'   => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
				'sep_after'  => '</span>', // закрываем span после разделителя!
			);
			// schema.org
			elseif ($mark === 'schema.org') $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
				'linkpatt'   => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
				'sep_after'  => '',
			);

			elseif (! is_array($mark))
				die(__CLASS__ . ': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ', '<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after'] . "\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if (empty($post)) {
			if (isset($q_obj->taxonomy))
				$ptype = &$wp_post_types[get_taxonomy($q_obj->taxonomy)->object_type[0]];
		} else $ptype = &$wp_post_types[$post->post_type];

		// paged
		$arg->pg_end = '';
		if (($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')))
			$arg->pg_end = $sep . sprintf($loc->paged, (int) $paged_num);

		$pg_end = $arg->pg_end; // упростим

		// ну, с богом...
		$out = '';

		if (is_front_page()) {
			return $arg->on_front_page ? sprintf($wrappatt, ($paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home)) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif (is_home()) {
			$out = $paged_num ? (sprintf($linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title)) . $pg_end) : esc_html($q_obj->post_title);
		} elseif (is_404()) {
			$out = $loc->_404;
		} elseif (is_search()) {
			$out = sprintf($loc->search, esc_html($GLOBALS['s']));
		} elseif (is_author()) {
			$tit = sprintf($loc->author, esc_html($q_obj->display_name));
			$out = ($paged_num ? sprintf($linkpatt, get_author_posts_url($q_obj->ID, $q_obj->user_nicename) . $pg_end, $tit) : $tit);
		} elseif (is_year() || is_month() || is_day()) {
			$y_url  = get_year_link($year = get_the_time('Y'));

			if (is_year()) {
				$tit = sprintf($loc->year, $year);
				$out = ($paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit);
			}
			// month day
			else {
				$y_link = sprintf($linkpatt, $y_url, $year);
				$m_url  = get_month_link($year, get_the_time('m'));

				if (is_month()) {
					$tit = sprintf($loc->month, get_the_time('F'));
					$out = $y_link . $sep . ($paged_num ? sprintf($linkpatt, $m_url, $tit) . $pg_end : $tit);
				} elseif (is_day()) {
					$m_link = sprintf($linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
		elseif (is_singular() && $ptype->hierarchical) {
			$out = $this->_add_title($this->_page_crumbs($post), $post);
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if (is_singular()) {
				// изменим $post, чтобы определить термин родителя вложения
				if (is_attachment() && $post->post_parent) {
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies($post->post_type);
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect($taxonomies, get_taxonomies(array('hierarchical' => true, 'public' => true)));

				if ($taxonomies) {
					// сортируем по приоритету
					if (! empty($arg->priority_tax)) {
						usort($taxonomies, function ($a, $b) use ($arg) {
							$a_index = array_search($a, $arg->priority_tax);
							if ($a_index === false) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if ($b_index === false) $b_index = 9999999;

							return ($b_index === $a_index) ? 0 : ($b_index < $a_index ? 1 : -1); // меньше индекс - выше
						});
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach ($taxonomies as $taxname) {
						if ($terms = get_the_terms($post->ID, $taxname)) {
							// проверим приоритетные термины для таксы
							$prior_terms = &$arg->priority_terms[$taxname];
							if ($prior_terms && count($terms) > 2) {
								foreach ((array) $prior_terms as $term_id) {
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter($terms, array($filter_field => $term_id));

									if ($_terms) {
										$term = array_shift($_terms);
										break;
									}
								}
							} else
								$term = array_shift($terms);

							break;
						}
					}
				}

				if (isset($save_post)) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if ($term && isset($term->term_id)) {
				$term = apply_filters('kama_breadcrumbs_term', $term);

				// attachment
				if (is_attachment()) {
					if (! $post->post_parent)
						$out = sprintf($loc->attachment, esc_html($post->post_title));
					else {
						if (! $out = apply_filters('attachment_tax_crumbs', '', $term, $this)) {
							$_crumbs    = $this->_tax_crumbs($term, 'self');
							$parent_tit = sprintf($linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent));
							$_out = implode($sep, array($_crumbs, $parent_tit));
							$out = $this->_add_title($_out, $post);
						}
					}
				}
				// single
				elseif (is_single()) {
					if (! $out = apply_filters('post_tax_crumbs', '', $term, $this)) {
						$_crumbs = $this->_tax_crumbs($term, 'self');
						$out = $this->_add_title($_crumbs, $post);
					}
				}
				// не древовидная такса (метки)
				elseif (! is_taxonomy_hierarchical($term->taxonomy)) {
					// метка
					if (is_tag())
						$out = $this->_add_title('', $term, sprintf($loc->tag, esc_html($term->name)));
					// такса
					elseif (is_tax()) {
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][$term->taxonomy]->labels->name;
						$out = $this->_add_title('', $term, sprintf($loc->tax_tag, $post_label, $tax_label, esc_html($term->name)));
					}
				}
				// древовидная такса (рибрики)
				else {
					if (! $out = apply_filters('term_tax_crumbs', '', $term, $this)) {
						$_crumbs = $this->_tax_crumbs($term, 'parent');
						$out = $this->_add_title($_crumbs, $term, esc_html($term->name));
					}
				}
			}
			// влоежния от записи без терминов
			elseif (is_attachment()) {
				$parent = get_post($post->post_parent);
				$parent_link = sprintf($linkpatt, get_permalink($parent), esc_html($parent->post_title));
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if (is_post_type_hierarchical($parent->post_type)) {
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode($sep, array($parent_crumbs, $parent_link));
				}

				$out = $this->_add_title($_out, $post);
			}
			// записи без терминов
			elseif (is_singular()) {
				$out = $this->_add_title('', $post);
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype);

		if ('' === $home_after) {
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if (
				$ptype && $ptype->has_archive && ! in_array($ptype->name, array('post', 'page', 'attachment'))
				&& (is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)))
			) {
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if (is_post_type_archive() && ! $paged_num)
					$home_after = $pt_title;
				// singular, paged post_type_archive, tax
				else {
					$home_after = sprintf($linkpatt, get_post_type_archive_link($ptype->name), $pt_title);

					$home_after .= (($paged_num && ! is_tax()) ? $pg_end : $sep); // пагинация
				}
			}
		}

		$before_out = sprintf($linkpatt, home_url(), $loc->home) . ($home_after ? $sep . $home_after : ($out ? $sep : ''));

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg);

		$out = sprintf($wrappatt, $before_out . $out);

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg);
	}

	function _page_crumbs($post)
	{
		$parent = $post->post_parent;

		$crumbs = array();
		while ($parent) {
			$page = get_post($parent);
			$crumbs[] = sprintf($this->arg->linkpatt, get_permalink($page), esc_html($page->post_title));
			$parent = $page->post_parent;
		}

		return implode($this->arg->sep, array_reverse($crumbs));
	}

	function _tax_crumbs($term, $start_from = 'self')
	{
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while ($term_id) {
			$term       = get_term($term_id, $term->taxonomy);
			$termlinks[] = sprintf($this->arg->linkpatt, get_term_link($term), esc_html($term->name));
			$term_id    = $term->parent;
		}

		if ($termlinks)
			return implode($this->arg->sep, array_reverse($termlinks)) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title($add_to, $obj, $term_title = '')
	{
		$arg = &$this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if ($arg->pg_end) {
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf($arg->linkpatt, $link, $title) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif ($add_to) {
			if ($show_title)
				$add_to .= $arg->sep . sprintf($arg->title_patt, $title);
			elseif ($arg->last_sep)
				$add_to .= $arg->sep;
		}
		// sep будет потом...
		elseif ($show_title)
			$add_to = sprintf($arg->title_patt, $title);

		return $add_to;
	}
}

use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;

function krl_dealer_distance($dealer_coords = array(), $city_coords = array())
{

	// Set our Lat/Long coordinates
	$dealer = new LatLong($dealer_coords[0], $dealer_coords[1]);
	$city = new LatLong($city_coords[0], $city_coords[1]);

	// Get the distance between these two Lat/Long coordinates...
	$distanceCalculator = new DistanceCalculator($dealer, $city);

	// You can then compute the distance...
	$distance = $distanceCalculator->get();
	// you can also chain these methods together eg. $distanceCalculator->get()->asMiles();

	// We can now output the miles using the asMiles() method, you can also calculate and use asKilometres() or asNauticalMiles() as required!
	return $distance->asKilometres();
}


/**
 * Disable the emoji's
 */
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

	// Remove from TinyMCE
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}


/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join($join)
{
	global $wpdb;

	if (is_search()) {
		$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}

	return $join;
}
add_filter('posts_join', 'cf_search_join');

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where($where)
{
	global $pagenow, $wpdb;

	if (is_search()) {
		$where = preg_replace(
			"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)",
			$where
		);
	}

	return $where;
}
add_filter('posts_where', 'cf_search_where');

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct($where)
{
	global $wpdb;

	if (is_search()) {
		return "DISTINCT";
	}

	return $where;
}
add_filter('posts_distinct', 'cf_search_distinct');


function krl_check_for_new_products()
{
	$args = array(
		'post_type' => 'product', // Or your custom post type like 'products' or 'event'
		'posts_per_page' => 1, // Number of posts to show
		'tax_query' => array(
			array(
				'taxonomy' => 'products', // The slug of your taxonomy (e.g., 'category', 'genre')
				'field'    => 'slug',    // Select terms by 'slug', 'name', or 'term_id'
				'terms'    => '%d0%bd%d0%be%d0%b2%d0%b8%d0%bd%d0%ba%d0%b8', // The term slug (or ID/name depending on 'field' value)
			),
		),
	);

	$query_new = get_posts($args);

	if (count($query_new) > 0):
		return true;
	else:
		return false;
	endif;
}



/**
 * Set 11 posts per page for products if there are "new products"
 * @param $query
 *
 */
function set_posts_per_page_for_products_cpt($query)
{
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {

		if (krl_check_for_new_products() === true) :
			$query->set('posts_per_page', '11');
		else :
			$query->set('posts_per_page', '12');
		endif;
	}
}
add_action('pre_get_posts', 'set_posts_per_page_for_products_cpt');


function krl_create_bootstrap_desktop_menu($theme_location)
{
	if (($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location])) {

		$menu = get_term($locations[$theme_location], 'nav_menu');
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<ul class="navbar-nav">';

		foreach ($menu_items as $menu_item) {
			if ($menu_item->menu_item_parent == 0) {
				$level = 0;
				$subparent = 0;
				$bool = false;
				$bool2 = false;
				$menu_banners = get_field('menu_banners', 'option');

				if (in_array('products', $menu_item->classes)) {
					$menu_banner = $menu_banners['products'];
				}
				if (in_array('trends', $menu_item->classes)) {
					$menu_banner = $menu_banners['trends'];
				}
				$banner_html = '';

				if (!empty($menu_banner['title'])) {
					$banner_html .= '<div class="col-md-4 menuspalte teaser"><div class="card">';
					$banner_html .= '<div class="media-container">';
					$banner_html .= '<img src="' . $menu_banner['image']['url'] . '" title="' . $menu_banner['image']['title'] . '" alt="' . $menu_banner['image']['alt'] . '">';
					$banner_html .= '</div>';
					$banner_html .= '<div class="card-body">';
					$banner_html .= '<h5 class="card-title">' . $menu_banner['title'] . '</h5>';
					$banner_html .= '<div class="p">' . $menu_banner['subtitle'] . '</div>';
					$banner_html .= '<div class="card-button">';
					$banner_html .= '<a href="' . $menu_banner['link'] . '" class="btn btn-blue">' . $menu_banner['button_text'] . '</a>';
					$banner_html .= '</div>';
					$banner_html .= '</div></div></div>';
				}


				$parent = $menu_item->ID;

				$menu_array = array();

				foreach ($menu_items as $submenu) {
					$menu_array2 = array();
					if ($submenu->menu_item_parent == $parent) {
						$subparent = $submenu->ID;
						$bool = true;

						foreach ($menu_items as $subsubmenu) {
							if ($subsubmenu->menu_item_parent == $subparent) {
								$bool2 = true;
								$menu_array2[] = '<li class="nav-item"><a href="' . $subsubmenu->url . '">' . $subsubmenu->title . '</a></li>' . "\n";
							}
						}

						if ($bool2 == true && count($menu_array2) > 0) {
							$submenu_list = '<li class="">' . "\n";
							$submenu_list .= '<a href="' . $submenu->url . '" data-bs-toggle="dropdown" aria-expanded="false">' . $submenu->title . '</a>';
							$submenu_list .= '<ul class="menulist spalte2">' . "\n";
							$submenu_list .= implode("\n", $menu_array2);
							$submenu_list .= '</ul>' . "\n";
							$submenu_list .= '</li>' . "\n";
							$menu_array[] = $submenu_list;
						} else {
							$menu_array[] = '<li class="nav-item"><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>' . "\n";
						}
					}
				}
				if ($bool == true && count($menu_array) > 0) {
					$level = 0;
					$menu_list .= '<li class="nav-item dropdown has-megamenu">' . "\n";
					$menu_list .= '<a class="nav-link dropdown-toggle" href="' . $menu_item->url . '" data-bs-toggle="dropdown">' . $menu_item->title . '</a>' . "\n";
					$menu_list .= '<div class="dropdown-menu megamenu container" role="menu">' . "\n";
					$menu_list .= '<div class="row">' . "\n";
					$menu_list .= '<div class="col-md-8 zweispalter">' . "\n";
					$menu_list .= '<div class="row">' . "\n";
					$menu_list .= '<div class="col-md-6 menuspalte spalte1">' . "\n";
					$menu_list .= '<ul class="megamenulist ebene">' . "\n";
					$menu_list .= implode("\n", $menu_array);
					$menu_list .= '</ul>' . "\n";
					$menu_list .= '</div>' . "\n";
					$menu_list .= '</div>' . "\n";
					$menu_list .= '</div>' . "\n";
					$menu_list .= $banner_html . "\n";
					$menu_list .= '</div>' . "\n";
					$menu_list .= '</div>' . "\n";
					$menu_list .= '</li>' . "\n";
				} else {
					$menu_list .= '<li class="nav-item">' . "\n";
					$menu_list .= '<a href="' . $menu_item->url . '" class="nav-link">' . "\n";
					$menu_list .= $menu_item->title . "\n";
					$menu_list .= '</a>' . "\n";
					$menu_list .= '</li>' . "\n";
				}
			}
		}

		$menu_list .= '</div>' . "\n";
	} else {
		$menu_list = '<!-- no menu defined in location "' . $theme_location . '" -->';
	}

	echo $menu_list;
}


function krl_create_bootstrap_mobile_menu1($theme_location)
{
	if (($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location])) {

		$menu = get_term($locations[$theme_location], 'nav_menu');
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<div class="accordion accordion-flush" id="accordionmenu">'; //'<ul class="nav navbar-nav">' ."\n";

		foreach ($menu_items as $menu_item) {
			if ($menu_item->menu_item_parent == 0) {
				$level = 0;
				$subparent = 0;
				$bool = false;
				$bool2 = false;

				$parent = $menu_item->ID;

				$menu_array = array();

				foreach ($menu_items as $submenu) {
					$menu_array2 = array();
					if ($submenu->menu_item_parent == $parent) {
						$subparent = $submenu->ID;
						$bool = true;

						foreach ($menu_items as $subsubmenu) {
							if ($subsubmenu->menu_item_parent == $subparent) {
								$bool2 = true;
								$menu_array2[] = '<li class="nav-item"><a href="' . $subsubmenu->url . '">' . $subsubmenu->title . '</a></li>' . "\n";
							}
						}

						if ($bool2 == true && count($menu_array2) > 0) {
							$submenu_list = '<li class="nav-item dropdown">' . "\n";
							$submenu_list .= '<a href="' . $submenu->url . '" data-bs-toggle="dropdown" aria-expanded="false">' . $submenu->title . '</a>';
							$submenu_list .= '<ul class="dropdown-menu">' . "\n";
							$submenu_list .= implode("\n", $menu_array2);
							$submenu_list .= '</ul>' . "\n";
							$submenu_list .= '</li>' . "\n";
							$menu_array[] = $submenu_list;
						} else {
							$menu_array[] = '<li class="nav-item"><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>' . "\n";
						}
					}
				}
				if ($bool == true && count($menu_array) > 0) {
					$level = 0;
					$menu_list .= '<div class="accordion-item">' . "\n";
					$menu_list .= '<h2 class="accordion-header" id="flush-heading' . $parent . '">' . "\n";
					$menu_list .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $parent . '" aria-expanded="false" aria-controls="flush-collapse' . $parent . '">' . $menu_item->title . '</button>' . "\n";
					$menu_list .= '</h2>' . "\n";
					$menu_list .= '<div id="flush-collapse' . $parent . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $parent . '" data-bs-parent="#accordionmenu" style=""><div class="accordion-body">' . "\n";
					$menu_list .= '<ul class="nav flex-column">' . "\n";
					$menu_list .= implode("\n", $menu_array);
					$menu_list .= '</ul>' . "\n";
					$menu_list .= '</div></div>' . "\n";
					$menu_list .= '</div>' . "\n";
				} else {
					$menu_list .= '<div class="accordion-item no-collapse">' . "\n";
					$menu_list .= '<h2 class="accordion-header" id="flush-heading' . $parent . '">' . "\n";
					$menu_list .= '<a href="' . $menu_item->url . '" target="_top" class="nochildren">' . "\n";
					$menu_list .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $parent . '" aria-expanded="false" aria-controls="flush-collapse' . $parent . '">' . $menu_item->title . '</button>' . "\n";
					$menu_list .= '</a>' . "\n";
					$menu_list .= '</h2>' . "\n";
					$menu_list .= '</div>' . "\n";
				}
			}
		}

		$menu_list .= '</div>' . "\n";
	} else {
		$menu_list = '<!-- no menu defined in location "' . $theme_location . '" -->';
	}

	echo $menu_list;
}

function krl_create_bootstrap_mobile_menu2($theme_location)
{
	if (($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location])) {

		$menu = get_term($locations[$theme_location], 'nav_menu');
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<div class="accordion accordion-flush" id="accordionmenu2">'; //'<ul class="nav navbar-nav">' ."\n";

		foreach ($menu_items as $menu_item) {
			if ($menu_item->menu_item_parent == 0) {
				$level = 0;
				$subparent = 0;
				$bool = false;
				$bool2 = false;

				$parent = $menu_item->ID;

				$menu_array = array();

				foreach ($menu_items as $submenu) {
					$menu_array2 = array();
					if ($submenu->menu_item_parent == $parent) {
						$subparent = $submenu->ID;
						$bool = true;

						foreach ($menu_items as $subsubmenu) {
							if ($subsubmenu->menu_item_parent == $subparent) {
								$bool2 = true;
								$menu_array2[] = '<li class="nav-item"><a href="' . $subsubmenu->url . '">' . $subsubmenu->title . '</a></li>' . "\n";
							}
						}

						if ($bool2 == true && count($menu_array2) > 0) {
							$submenu_list = '<li class="nav-item dropdown">' . "\n";
							$submenu_list .= '<a href="' . $submenu->url . '" data-bs-toggle="dropdown" aria-expanded="false">' . $submenu->title . '</a>';
							$submenu_list .= '<ul class="dropdown-menu">' . "\n";
							$submenu_list .= implode("\n", $menu_array2);
							$submenu_list .= '</ul>' . "\n";
							$submenu_list .= '</li>' . "\n";
							$menu_array[] = $submenu_list;
						} else {
							$menu_array[] = '<li class="nav-item"><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>' . "\n";
						}
					}
				}
				if ($bool == true && count($menu_array) > 0) {
					$level = 0;
					$menu_list .= '<div class="accordion-item accordionsubmenu">' . "\n";
					$menu_list .= '<h2 class="accordion-header" id="flush-heading' . $parent . '">' . "\n";
					$menu_list .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $parent . '" aria-expanded="false" aria-controls="flush-collapse' . $parent . '">' . $menu_item->title . '</button>' . "\n";
					$menu_list .= '</h2>' . "\n";
					$menu_list .= '<div id="flush-collapse' . $parent . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $parent . '" data-bs-parent="#accordionmenu" style=""><div class="accordion-body">' . "\n";
					$menu_list .= '<ul class="nav flex-column">' . "\n";
					$menu_list .= implode("\n", $menu_array);
					$menu_list .= '</ul>' . "\n";
					$menu_list .= '</div></div>' . "\n";
					$menu_list .= '</div>' . "\n";
				} else {
					$menu_list .= '<div class="accordion-item accordionsubmenu no-collapse">' . "\n";
					$menu_list .= '<h2 class="accordion-header" id="flush-heading' . $parent . '">' . "\n";
					$menu_list .= '<a href="' . $menu_item->url . '" target="_top" class="nochildren">' . "\n";
					$menu_list .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $parent . '" aria-expanded="false" aria-controls="flush-collapse' . $parent . '">' . $menu_item->title . '</button>' . "\n";
					$menu_list .= '</a>' . "\n";
					$menu_list .= '</h2>' . "\n";
					$menu_list .= '</div>' . "\n";
				}
			}
		}

		$menu_list .= '</div>' . "\n";
	} else {
		$menu_list = '<!-- no menu defined in location "' . $theme_location . '" -->';
	}

	echo $menu_list;
}

add_filter('xmlrpc_enabled', '__return_false');
