<?php
if (isset($args)):

$carousel               = $args['section'];
$title                  = $carousel['title'];
$background             = $carousel['section_background']['background'];
$slides                 = $carousel['card_item'];
$carousel_id            = "Carousel".rand(111,999);

$bg_class = krl_get_bg_class('solid',$background);
?>

<div class="component-container productslider <?php echo $bg_class['bg_color'] ?>">
	<div class="container container-inner">
		<h2 class="text-center"><?php echo $title ?></h2>
		<div class="row">
			<div id="<?php echo $carousel_id ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
				<div class="carousel-indicators">
                    <?php
                    $i = 0;
                    foreach ($slides as $slide):
                    ?>
					    <button type="button" data-bs-target="#<?php echo $carousel_id ?>" data-bs-slide-to="<?php echo $i; ?>" <?php if ($i == 0) echo "class=\"active\""; ?> <?php if ($i == 0) echo "aria-current=\"true\""; ?> aria-label="Slide <?php echo $i+1; ?>"></button>
                    <?php $i++; endforeach; ?>
				</div>
				<div class="carousel-inner" role="listbox">

					<?php
					$i = 0;
					foreach ($slides as $slide):
					?>
					<div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
						<div class="col-20">
							<div class="card product-card">
								<!--<div class="card_bookmark"> <a class="link-bookmark" href="#">
										<div class="card_icon-round">
											<svg height="19" viewBox="0 0 20 19" width="20" xmlns="http://www.w3.org/2000/svg" aria-label="Symbol einen Stern der Bewertung darstellt" class="svg-icon">
												<path d="M10,15.3l6.2,3.7l-1.6-7L20,7.2l-7.2-0.6L10,0L7.2,6.6L0,7.2L5.5,12l-1.6,7L10,15.3z"></path>
											</svg>
										</div>
									</a> </div>-->
								<div class="card-mediacontainer">
									<figure>
                                        <?php
                                        if (!empty($slide['image']['sizes'])) { ?>
                                            <img src="<?php echo $slide['image']['sizes']['large']; ?>" class="card-img-top" alt="<?php echo $slide['image']['alt']; ?>">
                                        <?php } else {
                                            echo $slide['image'];
                                        } ?>
                                    </figure>
								</div>
								<h4 class="card-title"><?php echo $slide['title']; ?></h4>
                                <div class="p card-text"><?php echo $slide['text']; ?></div>
								<div class="card-linkwrapper">
                                    <a class="produktlink" href="<?php echo $slide['link_url']; ?>"><?php echo $slide['link_text']; ?></a>
                                </div>
							</div>
						</div>
					</div>
                    <?php $i++; endforeach; ?>

				</div>
				<a class="carousel-control-prev w-aut" href="#<?php echo $carousel_id ?>" role="button" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> </a> <a class="carousel-control-next w-aut" href="#<?php echo $carousel_id ?>" role="button" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> </a>
            </div>
		</div>
	</div>
</div>

<?php endif; ?>