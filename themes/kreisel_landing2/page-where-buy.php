<?php
/*
Template Name: Where to buy
 */

get_header();

(isset($_GET['city-name'])) ? $city_name = $_GET['city-name'] : $city_name = '';
(isset($_GET['city-radius'])) ? $city_radius = $_GET['city-radius'] : $city_radius = '';
(isset($_GET['dealer-title'])) ? $s = $_GET['dealer-title'] : $s = '';

$city_coord_n = get_field('coord_N', 'dealer_city_' . $city_name);
$city_coord_e = get_field('coord_E', 'dealer_city_' . $city_name);
if (!empty($city_coord_n) && !empty($city_coord_e)) {
    $city_coords = array($city_coord_n, $city_coord_e);
}

?>

<figure class="where-buy">
    <!--CAROUSEL-->

    <?php
    $carousel = get_field('carousel');
    ?>
    <div class="key-visual">
        <?php if (!empty($carousel) && is_array($carousel)): ?>

            <div class="key-visual-inner-content slick">
                <?php
                $i = 0;
                foreach ($carousel as $item):
                    $i++;
                    $background_img     = $item['background_img'];
                    $title              = $item['title'];
                    $text               = $item['text'];
                    $text_city_search   = $item['text_city_search'];
                    $button_text        = $item['button_text'];
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
                            'template-parts/dealer_search',
                            null,
                            array(
                                'title'             => $title,
                                'text'              => $text,
                                'text_city_search'  => $text_city_search,
                                'button_text'       => $button_text,
                                'city_name'         => $city_name,
                                'city_radius'       => $city_radius,
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
                // Get dealers by city and radius

                $args = array(
                    'post_type'         => 'dealers',
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1
                );

                $loop = new WP_Query($args);

                $dealers_in = array();

                while ($loop->have_posts()) : $loop->the_post();

                    $dealer_coords_n = get_field('coord_n');
                    $dealer_coords_e = get_field('coord_e');

                    if (!empty($dealer_coords_n) && !empty($dealer_coords_e) && !empty($city_coords)) {
                        $dealer_coords = array($dealer_coords_n, $dealer_coords_e);

                        $dealer_distance = round(krl_dealer_distance($dealer_coords, $city_coords), 0);

                        if ($dealer_distance < $city_radius) {
                            $dealers_in[] = get_the_ID();
                        }
                    }

                endwhile;

                wp_reset_postdata();
                ?>


                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Показать на карте
                            </button>
                            <div class="accordion-body">
                                <?php

                                // Get dealers for list

                                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                $args2 = array(
                                    'post_type'         => 'dealers',
                                    'post_status'       => 'publish',
                                    'order'             => 'ASC',
                                    'orderby'           => 'post_title',
                                    'posts_per_page'    => 10,
                                    'paged'             => $paged
                                );

                                if (!empty($city_name)) {
                                    $args2['post__in'] = empty($dealers_in) ? [0] : $dealers_in;
                                }

                                if (!empty($s)) {
                                    $args2['s'] = $s;
                                }

                                $loop2 = new WP_Query($args2);

                                if ($loop2->have_posts() == false) echo "<h2>По вашему запросу ничего не найдено</h2>";

                                while ($loop2->have_posts()) : $loop2->the_post();

                                    $dealer_city = get_the_terms($post, 'dealer_city');
                                    $dealer_city = $dealer_city[0]->name;

                                    $company_address = get_field('company_address', $post->ID);
                                    $company_postcode = get_field('company_postcode', $post->ID);
                                    $company_phone = get_field('company_phone', $post->ID);
                                    $company_email = get_field('company_email', $post->ID);
                                    $company_website = get_field('company_website', $post->ID);

                                ?>

                                    <div class="person-card person-card-dealer map-container__item">
                                        <div class="person-card-text-container">
                                            <div class="person-card-info-container">
                                                <?php
                                                $dealer_coords_n = get_field('coord_n');
                                                $dealer_coords_e = get_field('coord_e');

                                                if (!empty($dealer_coords_n) && !empty($dealer_coords_e) && !empty($city_coords)) {
                                                    $dealer_coords = array($dealer_coords_n, $dealer_coords_e);

                                                    $dealer_distance = round(krl_dealer_distance($dealer_coords, $city_coords), 1);
                                                }
                                                if (!empty($dealer_distance)): ?>
                                                    <span class="person-card-distance-icon">
                                                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" aria-label="Symbol das eine geografische Position darstellt">
                                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path>
                                                        </svg>
                                                    </span>
                                                    <span class="person-card__distance-text"><?php echo $dealer_distance; ?>км от</span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="person-card-name">
                                                <?php the_title() ?>, <?php echo $dealer_city ?>
                                            </div>

                                            <div class="person-card-address">
                                                <div class="person-card__street">
                                                    <?php echo $company_address ?>
                                                </div>
                                                <div class="person-card-city">
                                                    <?php echo $company_postcode ?><br>
                                                    <?php echo $dealer_city ?>
                                                </div>
                                            </div>


                                            <div class="person-card-contact-info">

                                                <?php if (!empty($company_phone)): ?>
                                                    <div class="person-card-contact-container">
                                                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" aria-label="Telefon-Symbol" class="svg-icon">
                                                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path>
                                                        </svg>

                                                        <a href="tel:<?php echo $company_phone ?>"><?php echo $company_phone ?></a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($company_email)): ?>
                                                    <div class="person-card-contact-container">
                                                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" aria-label="Symbol das einen Brief für E-Mails darstellt" class="svg-icon">
                                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                                                        </svg>

                                                        <a href="mailto:<?php echo $company_email ?>"><span><?php echo $company_email ?></span></a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($company_website)): ?>
                                                    <div class="person-card-contact-container">
                                                        <a href="<?php echo $company_website ?>" target="_blank"><span><?php echo $company_website ?></span></a>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div>
                                <?php
                                endwhile;
                                ?>

                                <figure class="krl-pagination">
                                    <?php
                                    echo paginate_links(array(
                                        'total'        => $loop2->max_num_pages,
                                        'current'      => max(1, get_query_var('paged')),
                                        'format'       => '?paged=%#%',
                                        'show_all'     => false,
                                        'type'         => 'plain',
                                        'end_size'     => 2,
                                        'mid_size'     => 1,
                                        'prev_next'    => true,
                                        'prev_text'    => sprintf('<i></i> %1$s', __('Назад', 'text-domain')),
                                        'next_text'    => sprintf('%1$s <i></i>', __('Вперёд', 'text-domain')),
                                        'add_args'     => false,
                                        'add_fragment' => '',
                                    ));
                                    ?>

                                </figure>

                                <?php
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Показать список
                            </button>
                            <div class="accordion-body">
                                <?php

                                // Get dealers for map

                                $args = array(
                                    'post_type' => 'dealers',
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1,
                                );

                                if (!empty($city_name)) {
                                    $args['post__in'] = empty($dealers_in) ? [0] : $dealers_in;
                                }

                                $map_markers = array();

                                $loop = new WP_Query($args);

                                while ($loop->have_posts()) : $loop->the_post();

                                    $map_markers[] = array(
                                        'title' => get_the_title(),
                                        'lat' => get_field('coord_n'),
                                        'lng' => get_field('coord_e'),
                                        'address' => get_field('company_address'),
                                        'phone' => get_field('company_phone'),
                                    );

                                endwhile;

                                wp_reset_postdata();

                                if (!empty($city_coords)) {
                                    $center_coord_n = $city_coords[0];
                                    $center_coord_e = $city_coords[1];
                                    $zoom = 10;
                                } else {
                                    $center_coord_n = 55;
                                    $center_coord_e = 38;
                                    $zoom = 7;
                                }
                                ?>

                                <div id="map" style="width: 100%; height: 80vh; min-height: 300px"></div>

                                <script type='text/javascript' src='https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=e260a992-7c5a-4bf1-9e98-4dc6a12dbdd6'></script>

                                <script>
                                    function mapInit() {

                                        ymaps.ready(init);

                                        function init() {

                                            var myMap = new ymaps.Map("map", {
                                                center: [<?php echo $center_coord_n ?>, <?php echo $center_coord_e ?>],
                                                zoom: <?php echo $zoom ?>,
                                                controls: ['zoomControl']
                                            }, {
                                                searchControlProvider: 'yandex#search'
                                            });


                                            myMap.geoObjects
                                            <?php foreach ($map_markers as $marker) : ?>
                                                    .add(new ymaps.Placemark([<?php echo $marker['lat'] ?>, <?php echo $marker['lng'] ?>], {
                                                        balloonContent: '<strong><?php echo $marker['title']; ?></strong><br><?php echo $marker['address']; ?><br><?php echo $marker['phone']; ?>'
                                                    }, {
                                                        // Опции.
                                                        // Необходимо указать данный тип макета.
                                                        iconLayout: 'default#image',
                                                        // Своё изображение иконки метки.
                                                        iconImageHref: '<?php echo get_stylesheet_directory_uri() ?>/dist/images/marker.png',
                                                        // Размеры метки.
                                                        iconImageSize: [22, 42],
                                                        // Смещение левого верхнего угла иконки относительно
                                                        // её "ножки" (точки привязки).
                                                        iconImageOffset: [-11, -21]
                                                    }))
                                            <?php endforeach; ?>

                                        }
                                    }

                                    document.addEventListener("DOMContentLoaded", mapInit);
                                </script>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

</figure>

<?php get_footer(); ?>