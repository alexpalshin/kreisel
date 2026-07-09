<?php
get_header();

$search_query = get_search_query();
?>
<div class="pt-4"></div>
<div class="maincontent">
    <div class="component-container bg-orientation-left">
        <div class="container content-container">
            <div class="search-results">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-results__list d-grid gap-3 paginated">

                            <?php if (empty($search_query)) : ?>
                                <h2>Пустой поисковый запрос</h2>
                            <?php else: ?>

                                <?php if (have_posts()) :

                                    echo "<h2>Результаты поиска по запросу $search_query</h2>";

                                    while(have_posts()) : the_post();
                                        global $post;
                                        $categories = get_the_category($post->ID);
                                        ?>

                                        <div class="px-0 py-3 border-bottom" data-document-score="9.200394" data-document-id="a47d72d80d605b1ad1839080cd0c34102b51094f/pages/8498/0/0/0" data-document-url="/rozwiazania/tynki-tradycyjne/farby">
                                            <div class="search-results__list-element-text-container">

                                                <h4><?php the_title() ?></h4>

                                                <a href="<?php the_permalink(); ?>">
                                                    Читать далее
                                                </a>

                                            </div>
                                        </div>
                                <?php

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
                                <?php else: ?>
                                    <?php echo "<h2>По вашему запросу ничего не найдено</h2>"; ?>
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="c15509" class="component-container bg-orientation-left small-spacing component-container-bg bg-gray mb-0">
        <div class="container content-container">
            <div class="search-results">
                <div class="container-fluid">
                    <div class="container searchbar-content-container">
                        <form method="GET" class="search-form" action="/" accept-charset="utf-8">
                            <div class="searchbar-input-group active">
                                <span class="search-title">Что вы ищете?</span>
                                <div class="input-group search-module">
                                    <input class="form-control searchbarform-input" name="s" type="text" placeholder="Введите поисковый запрос" autocomplete="off">
                                    <button class="input-group-text search-input">
                                        <div class="svg-search-icon">
                                            <svg viewBox="0 0 24 24" class="svg-icon">
                                                <use xlink:href="#icon-magnifier">
                                                    <symbol viewBox="0 0 24 24" id="icon-magnifier">
                                                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                                    </symbol>
                                                </use>
                                            </svg>
                                        </div>
                                        <span>Поиск</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer();?>
