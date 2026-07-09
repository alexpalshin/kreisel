<?php
get_header();

$object_type            = get_field('object_type');
$square                 = get_field('square');
$construction_year      = get_field('construction_year');
$work_type              = get_field('work_type');
$situation              = get_field('situation');
$linked_products        = get_field('linked_products');
$pdf_version            = get_field('pdf_version');
$products_description   = get_field('products_description');
?>

<?php if (have_posts()) : while(have_posts()) : the_post(); ?>

<figure class="single-reference">
    <div class="maincontent">
        <div class="component-container bg-white">
            <div class="plugindetail reference container bg-white" style="min-height: 500px">
                <h1 class="reference-title"><?php the_title(); ?></h1>
                <div class="reference-imagecontainer">
                    <div class="reference-image" >
                        <img src="<?php echo get_the_post_thumbnail_url() ?>" width="945" height="709" alt="<?php the_title(); ?>"/>
                    </div>
                </div>
                <div class="reference-info-container">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if (!empty($object_type)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-home">
                                            <symbol viewBox="0 0 24 24" id="icon-home">
                                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Тип объекта</p>
                                    <p><strong><?php echo $object_type ?></strong></p>
                                </div>
                            </div>
                            <?php endif; ?>
	                        <?php if (!empty($square)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-fullscreen">
                                            <symbol viewBox="0 0 24 24" id="icon-fullscreen">
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Площадь</p>
                                    <p><strong><?php echo $square ?></strong></p>
                                </div>
                            </div>
	                        <?php endif; ?>
	                        <?php if (!empty($construction_year)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-event">
                                            <symbol viewBox="0 0 24 24" id="icon-event">
                                                <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"></path>
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Год выполнения</p>
                                    <p><strong><?php echo $construction_year ?></strong></p>
                                </div>
                            </div>
	                        <?php endif; ?>
                        </div>
                        <div class="col-md-6">
	                        <?php if (!empty($work_type)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-account-balance">
                                            <symbol viewBox="0 0 24 24" id="icon-account-balance">
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Род работ</p>
                                    <p><strong><?php echo $work_type ?></strong></p>
                                </div>
                            </div>
	                        <?php endif; ?>
	                        <?php if (!empty($situation)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-location">
                                            <symbol viewBox="0 0 24 24" id="icon-location">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Расположение</p>
                                    <p><strong><?php echo $situation ?></strong></p>
                                </div>
                            </div>
	                        <?php endif; ?>
	                        <?php if (!empty($situation)): ?>
                            <div class="infobox">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-info-solid">
                                            <symbol viewBox="0 0 192 512" id="icon-info-solid">
                                                <path d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </div>
                                <div class="info-text">
                                    <p>Информация</p>
                                    <div class="p">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--PRODUKT SLIDER-->
	    <?php

	    $slides = array();
	    $i = 0;
	    if (is_array($linked_products)):
		    foreach($linked_products as $product):

			    $slides[$i]['title'] = $product->post_title;
			    $slides[$i]['link_url'] = get_permalink($product->ID);
			    $slides[$i]['image'] = get_the_post_thumbnail($product->ID);
			    $slides[$i]['text'] = $product->post_content;
			    $slides[$i]['link_text'] = 'Подробнее';

			    $i++;
		    endforeach;

		    $section = array(
			    'title'     => 'Используемые продукты',
			    'card_item' => $slides,
			    'section_background' => array(
				    'background' => 'white',
			    )
		    );

		    echo get_template_part(
			    'template-parts/carousel',
			    null,
			    array(
				    'section' => $section,
			    )
		    );

	    endif;
	    ?>

        <?php if (!empty($products_description)): ?>
        <div class="component-container bg-white">
            <div class="container container-inner">
                <?php echo $products_description ?>
            </div>
        </div>
        <?php endif; ?>

        <!--
        <div class="component-container bg-white">
            <div class="container container-inner">
                <h2 class="text-center">Referenz als PDF</h2>
                <div class="downloads">
                    <div class="downloads-entry col-12">
                        <div class="downloads-title">OR Franziskanerkloster in Zeitz – Innensanierung mit Dämmputz und Trasskalkputz<span class="downloads-subtitle">Referenzobjekt</span></div>
                        <div class="downloads-file-info">
                            <div class="downloads-file-extension">pdf</div>
                            <div class="downloads-file-size">5 MB</div>
                        </div>
                        <div class="downloads-link"> <a href="#">
                                <svg class="svg-icon-download-link">
                                    <use xlink:href="#icon-rss">
                                        <svg viewBox="0 0 24 24" id="icon-rss" width="100%" height="100%">
                                            <circle cx="6.18" cy="17.82" r="2.18"></circle>
                                            <path d="M4 4.44v2.83c7.03 0 12.73 5.7 12.73 12.73h2.83c0-8.59-6.97-15.56-15.56-15.56zm0 5.66v2.83c3.9 0 7.07 3.17 7.07 7.07h2.83c0-5.47-4.43-9.9-9.9-9.9z"></path>
                                        </svg>
                                    </use>
                                </svg>
                                <span>Abonnieren</span> </a> </div>
                        <div class="downloads-link"> <a href="">
                                <svg class="svg-icon-download-link">
                                    <use xlink:href="#icon-grade">
                                        <svg viewBox="0 0 20 19" id="icon-grade" width="100%" height="100%">
                                            <path d="M10 15.3l6.2 3.7-1.6-7L20 7.2l-7.2-.6L10 0 7.2 6.6 0 7.2 5.5 12l-1.6 7 6.1-3.7z"></path>
                                        </svg>
                                    </use>
                                </svg>
                                <span class="bookmarker-text-add">Zur Merkliste hinzufügen</span> <span class="bookmarker-text-remove">Von der Merkliste entfernen</span> </a> </div>
                        <div class="downloads-link"> <a href="">
                                <svg class="svg-icon-download-link">
                                    <use xlink:href="#icon-download">
                                        <svg viewBox="0 0 24 24" id="icon-download" width="100%" height="100%">
                                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path>
                                        </svg>
                                    </use>
                                </svg>
                                Herunterladen</a> </div>
                    </div>
                </div>
            </div>
        </div>
        -->

        <?php
        $current_tax = get_the_terms($post->ID, 'project_type');
        $current_id = get_the_ID();

        $args = array(
	        'posts_per_page'    => 3,
	        'post_type'         => 'refs',
	        'post_status'       => 'publish',
	        'post__not_in'      => array($current_id),
	        'taxonomy'          => 'project_type',
	        'field'             => 'term_id',
            'terms'             => $current_tax[0]->term_id,
        );

        $related_objects = get_posts($args);
        ?>


        <div class="component-container bg-gray">
            <div class="container container-inner">
                <h2 class="text-center">Похожие объекты</h2>
                <div class="teaser-container teaser33">
                    <div class="row">
                        <?php
                        foreach ($related_objects as $post):
                            setup_postdata($post);
                        ?>
                        <div class="col-md-4 teaser">
                            <div class="card">
                                <div class="teaser-mediacontainer"> <img src="<?php echo get_the_post_thumbnail_url() ?>"  alt="<?php the_title() ?>"></div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php the_title() ?></h4>
                                    <div class="p card-text"><?php the_content() ?></div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php the_permalink(); ?>">Читать далее</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="component-container-footer"><a class="btn btn-blue" href="<?php echo site_url() ?>/obyekty">Все объекты</a></div>
            </div>
        </div>
    </div>
</figure>

<?php endwhile; endif;?>

<?php get_footer();?>
