<?php
/*
Template Name: Downloads
 */

get_header();

(isset($_GET['q'])) ? $q = $_GET['q'] : $q = '';
(isset($_GET['download_category'])) ? $download_category = $_GET['download_category'] : $download_category = '';
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
				    $text_download_category_search  = $item['text_download_category_search'];
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
	                        'template-parts/download_search',
	                        null,
	                        array(
		                        'q'                             => $q,
		                        'text_city_search'              => $text_city_search,
		                        'text_download_category_search' => $text_download_category_search,
                                'button_text'                   => $button_text,
                                'download_category'             => $download_category,
	                        )
                        );
                        ?>
                    </div>
			    <?php endforeach; ?>
            </div>

	    <?php else: ?>
        <div class="key-visual-container">
            <picture>
                <source media="(min-width:1200px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg">
                <source media="(min-width:992px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg">
                <source media="(min-width:768px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg">
                <source media="(min-width:576px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg">
                <source media="(min-width:320px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg" alt="key-visual">
            </picture>
        </div>
        <?php endif; ?>
    </div>

    <div class="maincontent">
        <div class="component-container bg-white">
            <div class="pluginlist container bg-white">

                <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

                $args = array(
	                'posts_per_page'    => 10,
	                'post_type'         => 'downloads',
	                'post_status'       => 'publish',
	                'paged' => $paged
                );

                $tax_query = array();

                if (!empty($download_category)) {
	                $tax_query[] = [
		                'taxonomy' => 'download_category',
		                'field' => 'term_id',
		                'terms' => $download_category,
	                ];
	                $args['tax_query'] = $tax_query;
                }

                if (!empty($q)) {
	                $args['s'] = $q;
                }

                $loop = new WP_Query( $args );

                ?>

                <div class="results-header" data-component="03_molecules/ResultsHeader">
                    <div class="results-header-results-container">
                    <span class="results-header-results">
                        <?php
                        echo count($loop->posts);
                        ?>
                        Загрузки
                    </span>
                    </div>
                </div>

                <div class="teaser-container px-2">
                    <div class="row">
                    <?php

                        if ($loop->have_posts() == false) echo "<h2>По вашему запросу ничего не найдено</h2>";

                        $i = 0;

                        while ( $loop->have_posts() ) : $loop->the_post();
                            $file = get_field('file');
                            $download_category_name = get_the_terms($download_category, 'download_category');
                        ?>
                            <div class="downloads">
                                <div class="downloads-entry col-12">
                                    <div class="downloads-title">
                                        <div><?php the_title() ?></div>
                                        <div class="downloads-subtitle"><?php echo $download_category_name[0]->name ?></div>
                                    </div>
                                    <div class="downloads-file-info">
                                        <div class="downloads-file-extension"><?php echo $file['subtype']; ?></div>
                                        <div class="downloads-file-size"><?php echo number_format($file['filesize']/1000000,2); ?> MB</div>
                                    </div>
                                    <div class="downloads-link">
                                        <a href="<?php echo $file['url']; ?>" target="_blank">
                                            <svg class="svg-icon-download-link">
                                                <use xlink:href="#icon-download">
                                                    <svg viewBox="0 0 24 24" id="icon-download" width="100%" height="100%">
                                                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path>
                                                    </svg>
                                                </use>
                                            </svg>Скачать</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;

                    ?>
                        <div class="pt-5"></div>

                        <figure class="krl-pagination">
		                    <?php
		                    echo paginate_links( array(
			                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			                    'total'        => $loop->max_num_pages,
			                    'current'      => max( 1, get_query_var( 'paged' ) ),
			                    'format'       => '?paged=%#%',
			                    'show_all'     => false,
			                    'type'         => 'plain',
			                    'end_size'     => 2,
			                    'mid_size'     => 1,
			                    'prev_next'    => true,
			                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Назад', 'text-domain' ) ),
			                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Вперёд', 'text-domain' ) ),
			                    'add_args'     => false,
			                    'add_fragment' => '',
		                    ) );
		                    ?>

                        </figure>
                    </div>
                </div>
            </div>
    </div>

</figure>

<?php get_footer();?>
