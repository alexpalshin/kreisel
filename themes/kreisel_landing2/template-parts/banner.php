<!--BANNER-->
<?php
if (isset($args)):

$banner             = $args['section'];
$background_img     = $banner['background_img'];
$title              = $banner['title'];
$text			    = $banner['text'];
$button_text        = $banner['button_text'];
$button_url         = $banner['button_url'];
$title_position	    = $banner['title_position'];
?>
<div class="key-visual">
	<div class="key-visual-container <?php if ($title_position == true): echo "with-text-container"; else: echo "with-border-line"; endif; ?>">
		<?php
		if (!empty($background_img)) {

		    if (is_array($background_img)) { //if it's an array from ACF
		        ?>
                <picture>
                    <source media="(min-width:1200px)" srcset="<?php echo $background_img['sizes']['2048x2048']; ?>">
                    <source media="(min-width:768px)" srcset="<?php echo $background_img['sizes']['large']; ?>">
                    <source media="(min-width:320px)" srcset="<?php echo $background_img['sizes']['medium_large']; ?>">
                    <img src="<?php echo $background_img['sizes']['1536x1536']; ?>" alt="key-visual">
                </picture>
                <?php
            } else { // if it's a path
		        ?>
                <picture>
                    <img src="<?php echo $background_img; ?>" alt="key-visual">
                </picture>
                <?php
            }

		} else {
			?>
			<picture>
				<source media="(min-width:1260px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_251306.png">
				<source media="(min-width:320px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_251306-576.jpg">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_251306-576.jpg" alt="key-visual">
			</picture>
			<?php
		}
		?>
	</div>

	<?php if ($title_position == true) { ?>

		<div class="key-visual-textcontainer">
            <?php if (!empty($text) || !empty($title)): ?>
                <div class="textbox right">
                    <h1><?php echo $title ?></h1>
                    <div class="p"><?php echo $text ?></div>
                    <?php if (!empty($button_text)): ?>
                        <a href="<?php echo $button_url ?>" class="btn btn-green"><?php echo $button_text ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
		</div>

	<?php } else { ?>

		<div class="key-visual_border-headline">
			<h1><?php echo $title ?></h1>
		</div>

	<?php } ?>
</div>

<?php endif; ?>