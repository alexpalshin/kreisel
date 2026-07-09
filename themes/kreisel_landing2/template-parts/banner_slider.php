<?php
if (isset($args)):

$carousel           = $args['section'];
$title_position	    = $carousel['title_position'];
$carousel_slides    = $carousel['slide'];
?>
<div class="key-visual <?php if ($title_position == true) echo "with-text-container"; ?>">

	<?php if ( !empty($carousel) && is_array($carousel) ): ?>

		<div class="key-visual-inner-content slick">
			<?php
			$i = 0;
			foreach ($carousel_slides as $item):
				$i++;
				$background_img     = $item['background_img'];
				$title              = $item['title'];
				$text               = $item['text'];
				$button_text        = $item['button_text'];
				$button_url         = $item['button_url'];
				?>
				<div class="key-visual-slide">
					<div class="key-visual-imagecontainer">
						<picture>
							<source media="(min-width:1200px)" srcset="<?php echo $background_img['sizes']['2048x2048']; ?>">
							<source media="(min-width:768px)" srcset="<?php echo $background_img['sizes']['large']; ?>">
							<source media="(min-width:320px)" srcset="<?php echo $background_img['sizes']['medium_large']; ?>">
							<img src="<?php echo $background_img['sizes']['1536x1536']; ?>" alt="key-visual">
						</picture>
					</div>
					<?php if ($title_position == true) : ?>
				        <?php if (!empty($text) || !empty($title)): ?>
                            <div class="key-visual-textcontainer">
                                <div class="textbox right primary">
                                    <?php if ($i == 1): ?>
                                        <h1><?php echo $title ?></h1>
                                    <?php else: ?>
                                        <div class="h1"><?php echo $title ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($text)): ?>
                                        <div class="p"><?php echo $text ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($button_text)): ?>
                                        <a href="<?php echo $button_url ?>" class="btn btn-cta"><?php echo $button_text ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
					    <?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if (count($carousel) > 1): ?>
			<div class="key-visual-control slick-control-prev"><svg fill="#FFFFFF" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" class="svg-icon"><path d="M15.6,6.3l-5.3,5.3l5.3,5.3l-0.8,1l-6.3-6.3l6.3-6.3L15.6,6.3z"></path></svg></div>
			<div class="key-visual-control slick-control-next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" fill="#FFFFFF" viewBox="0 0 24 24" class="svg-icon"><path d="M8.5,16.9l5.3-5.3L8.5,6.3l0.8-1l6.3,6.3l-6.3,6.3L8.5,16.9z"></path></svg></div>
		<?php endif; ?>

		<?php if ($title_position == false) : ?>

			<div class="container">
				<div class="key-visual_border-headline"><h1><?php echo $carousel['border_headline'] ?></h1></div>
			</div>

		<?php endif; ?>

	<?php endif; ?>

</div>

<?php endif; ?>