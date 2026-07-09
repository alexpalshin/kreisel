<?php
/*
Template Name: References
 */

get_header();

(isset($_GET['q'])) ? $q = $_GET['q'] : $q = '';
(isset($_GET['project_location'])) ? $project_location = $_GET['project_location'] : $project_location = '';
(isset($_GET['project_type'])) ? $project_type = $_GET['project_type'] : $project_type = '';
(isset($_GET['construction_type'])) ? $construction_type = $_GET['construction_type'] : $construction_type = '';
?>

<figure class="reference-page">
    <!--CAROUSEL-->

    <?php
    $carousel = get_field('carousel');
    ?>
    <div class="key-visual">
	    <?php if ( !empty($carousel) && is_array($carousel) ): ?>

            <div class="key-visual-inner-content slick">
			    <?php
			    $i = 0;
			    foreach ($carousel as $item):
				    $i++;
				    $background_img                 = $item['background_img'];
				    $text_city_search               = $item['text_city_search'];
				    $text_product_type_search       = $item['text_product_type_search'];
				    $text_project_type_search       = $item['text_project_type_search'];
				    $text_construction_type_search  = $item['text_construction_type_search'];
				    $button_text                    = $item['button_text'];
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
                        <?php
                        echo get_template_part(
	                        'template-parts/ref_search',
	                        null,
	                        array(
		                        'q'                             => $q,
		                        'text_city_search'              => $text_city_search,
		                        'text_product_type_search'      => $text_product_type_search,
		                        'text_project_type_search'      => $text_project_type_search,
		                        'text_construction_type_search' => $text_construction_type_search,
                                'button_text'                   => $button_text,
                                'project_location'              => $project_location,
                                'project_type'                  => $project_type,
                                'construction_type'             => $construction_type,
	                        )
                        );
                        ?>
                    </div>
			    <?php endforeach; ?>
            </div>

	    <?php else: ?>
        <div class="key-visual-container">
            <picture>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg" alt="key-visual">
            </picture>
        </div>
        <?php endif; ?>

    </div>

    <div class="maincontent">
        <div class="component-container bg-white">
            <div class="pluginlist container bg-white">
                <?php
                if ( empty($q) && empty($project_location) && empty($project_type) && empty($construction_type) ): // If no search input, output TOP REFERENCE

                    $top_reference = get_field('top_reference', 'option');
                    if (!empty($top_reference)):

                        $top_reference_id = $top_reference->ID;
                        $post = $top_reference;
                        setup_postdata($post);
                        $section['reduced_width'] = false;
                        $section['image'] = get_the_post_thumbnail_url();
                        $section['text']['top_line'] = 'TOP Объект';
                        $section['text']['header'] = get_the_title();
                        $section['text']['text'] = get_the_content();
                        $section['link']['link_url'] = get_the_permalink();
                        $section['link']['link_text'] = 'Перейти к объекту';

                        echo get_template_part(
                            'template-parts/top_teaser',
                            null,
                            array(
                                'section' => $section,
                            )
                        );

                        wp_reset_postdata();

                    endif;

                endif;

                ?>

                <div class="teaser-container px-2">
                    <div class="row">
                    <?php

                        $args = array(
                            'posts_per_page'    => -1,
                            'post_type'         => 'refs',
                            'post_status'       => 'publish',
                            'paged' => 1
                        );

                        $tax_query = array();

                        if (!empty($project_location) || !empty($project_type) || !empty($construction_type)) {
                            $tax_query[] = ['relation' => 'AND'];
                        }

                        if (!empty($project_location)) {
                            $tax_query[] = [
                                'taxonomy' => 'project_location',
                                'field' => 'term_id',
                                'terms' => $project_location,
                            ];
                            $args['tax_query'] = $tax_query;
                        }

                        if (!empty($project_type)) {
                            $tax_query[] = [
                                'taxonomy' => 'project_type',
                                'field' => 'term_id',
                                'terms' => $project_type,
                            ];
                            $args['tax_query'] = $tax_query;
                        }

                        if (!empty($construction_type)) {
                            $tax_query[] = [
                                'taxonomy' => 'construction_type',
                                'field' => 'term_id',
                                'terms' => $construction_type,
                            ];
                            $args['tax_query'] = $tax_query;
                        }

                        if (!empty($q)) {
                            $args['s'] = $q;
                        }

                        if (!empty($top_reference_id)) {
                            $args['post__not_in'] = array($top_reference_id);
                        }

                        $loop = new WP_Query( $args );

                        if ($loop->have_posts() == false) echo "<h2>По вашему запросу ничего не найдено</h2>";

                        $i = 0;
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <div class="col-md-6 col-lg-4 teaser">
                                <div class="card">
                                    <div class="teaser-mediacontainer">
                                        <img src="<?php echo get_the_post_thumbnail_url() ?>"  alt="<?php the_title(); ?>">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php the_title(); ?></h4>
                                        <div class="p card-text"><?php the_content(); ?></div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>">Читать дальше</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
    </div>

</figure>

<?php get_footer();?>
