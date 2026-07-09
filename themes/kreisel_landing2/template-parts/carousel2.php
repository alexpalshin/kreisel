<?php
if (isset($args)):

$carousel               = $args['section'];
$title                  = $carousel['title'];
$slides                 = $carousel['card_item'];
$carousel_id            = "Carousel".rand(111,999);

?>

    <div class="component-container bg-orientation-left ctype-sfcontentelements_carousel">
        <div class="container content-container ">
            <header>
                <h2 class="ce-headline-center">
	                <?php echo $title ?>
                </h2>
            </header>
            <div id="<?php echo $carousel_id ?>" class="carousel carousel--centered">
            <?php
            $i = 0;
            foreach ($slides as $slide):
                ?>
                <div class="carousel__item">
                    <figure>
                        <picture>
	                        <?php
	                        if (!empty($slide['image']['sizes'])) { ?>
                                <img src="<?php echo $slide['image']['sizes']['large']; ?>" class="card-img-top" alt="<?php echo $slide['image']['alt']; ?>">
	                        <?php } else {
		                        echo $slide['image'];
	                        } ?>
                        </picture>
                    </figure>
                </div>
		    <?php $i++; endforeach; ?>
            </div>
        </div>
    </div>

<?php endif; ?>