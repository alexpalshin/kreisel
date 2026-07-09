<?php
if (isset($args)):

	$contact_person = $args['section']['contact_person'];

?>
    <div class="person-card map-container__item ">
        <div class="person-card-text-container ">
            <div class="person-card-name">
				<?php echo $contact_person['office_name']; ?>
            </div>
            <div class="person-card-contact-info">
                <div class="person-card-contact-container">
					<?php echo $contact_person['office_address']; ?>
                </div>
            </div>
        </div>
        <div class="person-card-media-container  map-container__map-single-wrapper " style="z-index: 1;">
            <div id="map0" class="map-container__map map-container__map--single" style="position: relative; overflow: hidden; height: 100%">
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            ymaps.ready(init);

            function init() {
                var myMap = new ymaps.Map("map0", {
                        center: [<?php echo $contact_person['coordinates']['long'] ?>, <?php echo $contact_person['coordinates']['lat'] ?>],
                        zoom: 8,
                        controls: ['zoomControl']
                    }, {
                        searchControlProvider: 'yandex#search'
                    }
                );


                myMap.geoObjects
                    .add(new ymaps.Placemark([<?php echo $contact_person['coordinates']['long'] ?>, <?php echo $contact_person['coordinates']['lat'] ?>], {
                        balloonContent: '<strong><?php echo $contact_person['office_name']; ?></strong><br><strong><?php echo $contact_person['office_address']; ?></strong>'
                    }, {
                        // Опции.
                        // Необходимо указать данный тип макета.
                        iconLayout: 'default#image',
                        // Своё изображение иконки метки.
                        iconImageHref: '<?php echo get_stylesheet_directory_uri()?>/dist/images/marker.png',
                        // Размеры метки.
                        iconImageSize: [22, 42],
                        // Смещение левого верхнего угла иконки относительно
                        // её "ножки" (точки привязки).
                        iconImageOffset: [-11, -21]
                    }))

            }
        });

    </script>

<?php endif; ?>