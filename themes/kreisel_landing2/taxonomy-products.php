<?php
get_header();

$product_search     = get_field('product_search', 'option');
$background_img     = $product_search['background_img'];
$title              = $product_search['title'];
$button_text        = $product_search['button_text'];
$queried_object     = get_queried_object();
?>
<figure class="products-page">
    <div class="key-visual">
        <div class="key-visual-container">
            <?php if (!empty($background_img)): ?>
                <picture>
                    <source media="(min-width:1200px)" srcset="<?php echo $background_img['sizes']['2048x2048']; ?>">
                    <source media="(min-width:768px)" srcset="<?php echo $background_img['sizes']['large']; ?>">
                    <source media="(min-width:320px)" srcset="<?php echo $background_img['sizes']['medium_large']; ?>">
                    <img src="<?php echo $background_img['sizes']['1536x1536']; ?>" alt="key-visual">
                </picture>
            <?php else: ?>
            <picture>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg" alt="key-visual">
            </picture>
            <?php endif; ?>
        </div>
        <?php
        echo get_template_part(
                'template-parts/product_search',
                null,
                array(
                        'title'             => $title,
                        'button_text'       => $button_text,
                        'queried_object'    => $queried_object,
                )
        );
        ?>
    </div>

    <div class="maincontent">
        <div class="component-container bg-white">
            <div class="pluginlist container bg-white">
                <div class="products-container">
                    <div class="row">

                        <?php
                            $i = 0;
                            if (have_posts()) : while(have_posts()) : the_post();?>

                                <?php
                                if ( $i == 1 && ( krl_check_for_new_products() === true ) ) {
                                    echo get_template_part('template-parts/product_card_neu');
                                }
                                $categories = get_the_category($post->ID);
                                echo get_template_part('template-parts/product_card');
                                $i++;

                                endwhile;

	                            global $wp_query;

                                ?>
                                <div class="pt-5"></div>

                                <figure class="krl-pagination">
		                            <?php
		                            echo paginate_links( array(
			                            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			                            'total'        => $wp_query->max_num_pages,
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
                            <?php
                            else:
                                echo '<h2>Нет записей</h2>';
                            endif;
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-5"></div>
    <div class="pt-5"></div>

</figure>

<?php get_footer();?>
