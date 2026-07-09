<?php
if (isset($args)):
	$section        = $args['section'];
	$quote_image    = $section['quote_image'];
	$quote_text     = $section['quote_text'];
	$quote_source   = $section['quote_source'];
	?>

    <div class="component-container bg-lightgray quote-container quote-horizontal mt-4">
        <div class="quote-image-container col-md-4">
            <div class="quote-image">
				<?php
				if ( !empty($quote_image) ) {
					echo wp_get_attachment_image($quote_image, 'full');
				}
				?>
            </div>
        </div>
        <div class="quote-content-container col-md-8">
            <div class="quote-content job-posting">
				<?php echo $quote_text; ?>
            </div>
            <div class="quote-source">
				<?php echo $quote_source; ?>
            </div>
        </div>
    </div>

<?php endif; ?>