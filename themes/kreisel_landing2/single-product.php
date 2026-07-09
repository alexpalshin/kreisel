<?php
get_header();

$checklist              = get_field('checklist');
$variants               = get_field('variants');
$documents              = get_field('documents');
$description            = get_field('description');
$instructions           = get_field('instructions');
$application_tips       = get_field('application_tips');
$recommended_products   = get_field('recommended_products');

?>

<?php if (have_posts()) : while(have_posts()) : the_post();?>

<figure class="single-product">
    <div class="maincontent">
        <div class="component-container bg-white">
            <div class="container productcontainer-inner">
                <div class="productwrapper">
                    <h1 class="product-title"><?php the_title(); ?></h1>
                    <div class="product-subtitle">
                        <div class="p"><?php the_content(); ?></div>
                    </div>
                    <div class="productimage-container">
                        <div class="imagewrapper" style="border-color: #DF0020">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid" width="270" height="489" alt="<?php the_title(); ?>"/>
                        </div>
                    </div>
                    <div class="productinfo-container">
                        <div class="product-seal-wrapper">
                        </div>
                        <ul class="product-checklist">
                            <?php if (!empty($checklist)) foreach ($checklist as $item): ?>
                                <li><?php echo $item["checklist_item"]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="product-accordeon">
                    <button class="btn btn-blue" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> Доступные варианты </button>
                    <div class="collapse" id="collapseExample">
                        <div class="table-responsive-md">
                            <?php
                            if (!empty($variants)) :
	                            $pack_type      = array_column($variants, 'pack_type');
	                            $color          = array_column($variants, 'color');
	                            $surface        = array_column($variants, 'surface');
	                            $volume         = array_column($variants, 'volume');
	                            $volume         = array_column($variants, 'volume');
	                            $pack_weight    = array_column($variants, 'pack_weight');
	                            $pallete_pcs    = array_column($variants, 'pallete_pcs');
	                            $items_in_pack  = array_column($variants, 'items_in_pack');
	                            $m2_roll        = array_column($variants, 'm2_roll');
	                            $consumption    = array_column($variants, 'consumption');
                            endif;
                            ?>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th scope="col">Штрих-код</th>
                                    <?php if (!empty($pack_type)): ?>
                                        <th scope="col">Упаковка</th>
                                    <?php endif; ?>
	                                <?php if (!empty($color)): ?>
                                        <th scope="col">Цвет</th>
	                                <?php endif; ?>
	                                <?php if (!empty($surface)): ?>
                                        <th scope="col">Поверхность</th>
	                                <?php endif; ?>
	                                <?php if (!empty($volume)): ?>
                                        <th scope="col">Объём</th>
	                                <?php endif; ?>
	                                <?php if (!empty($pack_weight)): ?>
                                        <th scope="col">кг/шт.</th>
	                                <?php endif; ?>
	                                <?php if (!empty($pallete_pcs)): ?>
                                        <th scope="col"> шт./пал.</th>
	                                <?php endif; ?>
	                                <?php if (!empty($items_in_pack)): ?>
                                        <th scope="col">шт./упак.</th>
	                                <?php endif; ?>
	                                <?php if (!empty($m2_roll)): ?>
                                        <th scope="col">м<sup>2</sup>/рул.</th>
	                                <?php endif; ?>
	                                <?php if (!empty($consumption)): ?>
                                        <th scope="col">Расход</th>
	                                <?php endif; ?>
                                </tr>
                                <?php if (!empty($variants)) foreach ($variants as $variant): ?>
                                <tr>
                                    <td><?php echo $variant["article_nr"] ?></td>
	                                <?php if (!empty($pack_type)): ?>
                                        <td scope="col"><?php if (!empty($variant["pack_type"])): echo $variant["pack_type"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($color)): ?>
                                        <td scope="col"><?php if (!empty($variant["color"])): echo $variant["color"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($surface)): ?>
                                        <td scope="col"><?php if (!empty($variant["surface"])): echo $variant["surface"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($volume)): ?>
                                        <td scope="col"><?php if (!empty($variant["volume"])): echo $variant["volume"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($pack_weight)): ?>
                                        <td scope="col"><?php if (!empty($variant["pack_weight"])): echo $variant["pack_weight"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($pallete_pcs)): ?>
                                        <td scope="col"><?php if (!empty($variant["pallete_pcs"])): echo $variant["pallete_pcs"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($items_in_pack)): ?>
                                        <td scope="col"><?php if (!empty($variant["items_in_pack"])): echo $variant["items_in_pack"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($m2_roll)): ?>
                                        <td scope="col"><?php if (!empty($variant["m2_roll"])): echo $variant["m2_roll"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
	                                <?php if (!empty($consumption)): ?>
                                        <td scope="col"><?php if (!empty($variant["consumption"])): echo $variant["consumption"]; else: echo "-"; endif;?></td>
	                                <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="component-container small bg-gray no-margin">
            <div class="container content-container">
                <div class="social-sharing-container">
                    <div class="social-link-container">
                        <a class="btn btn-green" href="#contactModal" data-bs-toggle="modal">Сделать заказ</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="component-container bg-white anchor">
            <div class="container content-container">
                <h2 class="text-center">Какая информация интересует Вас об этом продукте?</h2>
                <div class="anchor-menu">
                    <ul class="nav nav-fill">
                        <li class="nav-item"> <a class="nav-link" href="#download">Документы</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#productbenefits">Преимущества</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#productdescription">Описание</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#processinginformation">Инструкции</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="download" class="component-container download accordionmenu bg-white">
            <div class="content-container">
                <div class="accordion accordion-flush mobile-accordion" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header text-center" id="flush-headingOne">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> Техническая документация </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body container">
                                <h2 class="accordion-body-header text-center">Техническая документация</h2>
                                <?php
                                if (is_array($documents)) foreach ($documents as $document):
                                ?>
                                <div class="downloads">
                                    <div class="downloads-entry col-12">
                                        <div class="downloads-title"><?php echo $document['file_title']; ?></div>
                                        <div class="downloads-file-info">
                                            <div class="downloads-file-extension"><?php echo $document['file']['subtype']; ?></div>
                                            <div class="downloads-file-size"><?php echo number_format($document['file']['filesize']/1000000,2); ?> MB</div>
                                        </div>
                                        <!--<div class="downloads-link"> <a href="">
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
                                                <span class="bookmarker-text-add">Zur Merkliste hinzufügen</span> <span class="bookmarker-text-remove">Von der Merkliste entfernen</span> </a> </div>-->
                                        <div class="downloads-link">
                                            <a href="<?php echo $document['file']['url']; ?>" target="_blank">
                                                <svg class="svg-icon-download-link">
                                                    <use xlink:href="#icon-download">
                                                        <svg viewBox="0 0 24 24" id="icon-download" width="100%" height="100%">
                                                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path>
                                                        </svg>
                                                    </use>
                                                </svg>
                                                Скачать
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

        $slides = array();
        $i = 0;
        if (is_array($recommended_products)):
            foreach($recommended_products as $product):

                $slides[$i]['title'] = $product->post_title;
                $slides[$i]['link_url'] = get_permalink($product->ID);
                $slides[$i]['image'] = get_the_post_thumbnail($product->ID);
                $slides[$i]['text'] = $product->post_content;
                $slides[$i]['link_text'] = 'Подробнее';

                $i++;
            endforeach;

            $section = array(
                    'title'     => 'Рекомендуемые товары',
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

        <div class="component-container download accordionmenu bg-white">
            <div class="content-container">
                <div class="accordion accordion-flush mobile-accordion" id="accordionFlushExample">
                    <div id="productbenefits" class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo"> Преимущества </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="component-container bg-gray-right productbenefits accordionmenu">
                                    <div class="bg-image-right">
                                        <picture>
                                            <source media="(min-width:1200px)" srcset="<?php echo get_stylesheet_directory_uri() ?>/dist/images/csm_references-involved-companies_fce972cbae-1200.jpg">
                                            <source media="(min-width:768px)" srcset="<?php echo get_stylesheet_directory_uri() ?>/dist/images/csm_references-involved-companies_ecb2eff4f8-768.jpg">
                                            <img src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/csm_references-involved-companies_fce972cbae.jpg"> </picture>
                                    </div>
                                    <div class="container content-container">
                                        <h2 class="accordion-body-header text-center">Преимущества</h2>
                                        <div class="row textwrapper">
	                                        <?php if (!empty($checklist)) foreach ($checklist as $item): ?>
                                                <div class="col-md-4">
                                                    <p class="list-big-check"><?php echo $item["checklist_item"]; ?></p>
                                                </div>
	                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="productdescription" class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree"> Описание </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body container">
                                <h2 class="accordion-body-header text-center">Описание</h2>
                                <div class="row">
                                    <div class="col-md-4 product-image text-center"><img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid" width="270" height="489" alt="<?php the_title() ?>"/></div>
                                    <div class="col-md-8 product-text">
                                        <?php the_field('description'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="processinginformation" class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour"> Инструкции </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="component-container bg-gray processinginformation accordionmenu">
                                    <div class="container container-inner">
                                        <h2 class="accordion-body-header text-center">Инструкции</h2>
                                        <div class="row">
                                            <?php
                                            if (is_array($instructions)) foreach ($instructions as $post):
                                                setup_postdata($post); ?>
                                                <div class="col-md-4 text-icon">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid" width="50" height="50" alt=""/>
                                                    <div class="p">
                                                        <?php the_title(); ?>
                                                    </div>
                                                </div>
                                            <?php
                                            endforeach;
                                            wp_reset_postdata();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="processingtips" class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive"> Рекомендации по применению</button>
                        </h2>
                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body container">
                                <h2 class="accordion-body-header text-center">Рекомендации по применению</h2>
                                <div class="videocontainer">
                                    <?php echo $application_tips; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="component-container bg-gray-left">
            <div class="bg-image-left"><img src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/csm_181011_HASIT_784_by_Weissengruber_Partner_ab4cd23961.png" width="618" height="413" alt=""/></div>
            <div class="container content-container contact-box">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h2>Заинтересовал товар, или нужна наша консультация?</h2>
                        <p>Сообщите нам! Мы будем рады помочь.</p>
                    </div>
                    <div class="col-md-4">
                        <h2>Мы предлагаем:</h2>
                        <div class="contact-box-highlight">
                            <div class="img-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-icon">
                                    <g>
                                        <path d="M119.467,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2s51.2-22.963,51.2-51.2
			C170.667,360.03,147.703,337.067,119.467,337.067z M119.467,422.4c-18.825,0-34.133-15.309-34.133-34.133
			c0-18.825,15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133C153.6,407.091,138.291,422.4,119.467,422.4z"></path>
                                        <path d="M409.6,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2c28.237,0,51.2-22.963,51.2-51.2
			C460.8,360.03,437.837,337.067,409.6,337.067z M409.6,422.4c-18.825,0-34.133-15.309-34.133-34.133
			c0-18.825,15.309-34.133,34.133-34.133c18.825,0,34.133,15.309,34.133,34.133C443.733,407.091,428.425,422.4,409.6,422.4z"></path>
                                        <path d="M510.643,289.784l-76.8-119.467c-1.57-2.441-4.275-3.917-7.177-3.917H332.8c-4.719,0-8.533,3.823-8.533,8.533v213.333
			c0,4.719,3.814,8.533,8.533,8.533h34.133v-17.067h-25.6V183.467h80.674l72.926,113.442v82.825h-42.667V396.8h51.2
			c4.719,0,8.533-3.814,8.533-8.533V294.4C512,292.77,511.531,291.157,510.643,289.784z"></path>
                                        <path d="M375.467,277.333V217.6h68.267v-17.067h-76.8c-4.719,0-8.533,3.823-8.533,8.533v76.8c0,4.719,3.814,8.533,8.533,8.533h128
			v-17.067H375.467z"></path>
                                        <path d="M332.8,106.667H8.533C3.823,106.667,0,110.49,0,115.2v273.067c0,4.719,3.823,8.533,8.533,8.533H76.8v-17.067H17.067v-256
			h307.2v256H162.133V396.8H332.8c4.719,0,8.533-3.814,8.533-8.533V115.2C341.333,110.49,337.519,106.667,332.8,106.667z"></path>
                                        <rect x="8.533" y="345.6" width="51.2" height="17.067"></rect>
                                        <rect x="179.2" y="345.6" width="145.067" height="17.067"></rect>
                                        <rect x="469.333" y="345.6" width="34.133" height="17.067"></rect>
                                        <rect x="34.133" y="140.8" width="298.667" height="17.067"></rect>
                                        <rect x="110.933" y="379.733" width="17.067" height="17.067"></rect>
                                        <rect x="401.067" y="379.733" width="17.067" height="17.067"></rect>
                                        <rect x="34.133" y="72.533" width="119.467" height="17.067"></rect>
                                        <rect y="72.533" width="17.067" height="17.067"></rect>
                                    </g>
                                </svg>
                            </div>
                            <p>Выстроенную логистику</p>
                        </div>
                        <div class="contact-box-highlight">
                            <div class="img-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-icon">
                                    <g>
                                        <path d="M490.14,178.611l-42.868-8.572c-2.839-9.047-6.48-17.834-10.867-26.228l24.252-36.378
			c7.165-10.748,5.737-25.176-3.398-34.312l-18.38-18.38c-9.134-9.135-23.563-10.566-34.312-3.398l-36.378,24.252
			c-8.395-4.387-17.183-8.028-26.228-10.867l-8.574-42.868C330.854,9.193,319.641,0,306.724,0h-25.995
			c-12.916,0-24.131,9.193-26.664,21.86l-8.574,42.868c-9.046,2.839-17.834,6.48-26.228,10.867l-36.378-24.252
			c-10.748-7.165-25.179-5.738-34.312,3.396l-18.381,18.382c-9.133,9.134-10.561,23.563-3.396,34.31l24.252,36.378
			c-4.387,8.395-8.028,17.182-10.867,26.228l-42.868,8.573c-12.666,2.534-21.86,13.747-21.86,26.665v25.993
			c0,12.917,9.193,24.132,21.86,26.665l27.755,5.55c4.379,0.874,8.637-1.964,9.512-6.342c0.875-4.378-1.964-8.637-6.342-9.512
			l-27.755-5.55c-5.134-1.025-8.861-5.573-8.861-10.809v-25.993c0-5.236,3.727-9.784,8.861-10.81l47.645-9.529
			c2.984-0.597,5.38-2.819,6.2-5.75c3.105-11.1,7.545-21.812,13.193-31.84c1.494-2.652,1.371-5.919-0.317-8.452l-26.955-40.433
			c-2.905-4.357-2.325-10.208,1.378-13.909l18.381-18.382c3.703-3.703,9.552-4.281,13.909-1.376L214.35,91.75
			c2.532,1.689,5.799,1.811,8.452,0.318c10.029-5.649,20.741-10.087,31.84-13.192c2.931-0.82,5.152-3.215,5.75-6.2l9.529-47.645
			c1.027-5.135,5.573-8.862,10.809-8.862h25.995c5.236,0,9.783,3.727,10.809,8.862l9.529,47.645c0.597,2.985,2.819,5.38,5.75,6.2
			c11.098,3.105,21.811,7.543,31.84,13.192c2.653,1.493,5.919,1.371,8.452-0.318l40.434-26.955
			c4.357-2.905,10.207-2.327,13.909,1.378l18.38,18.38c3.704,3.704,4.282,9.553,1.378,13.91l-26.955,40.433
			c-1.689,2.533-1.812,5.8-0.317,8.452c5.648,10.028,10.087,20.74,13.193,31.84c0.82,2.931,3.216,5.152,6.2,5.75l47.645,9.529
			c5.135,1.026,8.861,5.574,8.861,10.81v25.993c0,5.236-3.727,9.784-8.861,10.81l-47.645,9.529c-2.984,0.597-5.38,2.819-6.2,5.749
			c-3.105,11.098-7.544,21.81-13.193,31.84c-1.494,2.653-1.371,5.919,0.317,8.452l26.955,40.433
			c2.905,4.357,2.325,10.208-1.378,13.909l-18.381,18.382c-3.703,3.703-9.551,4.281-13.909,1.376l-40.433-26.954
			c-3.714-2.477-8.734-1.474-11.21,2.242c-2.477,3.714-1.472,8.734,2.242,11.21l40.433,26.955
			c4.582,3.055,9.831,4.548,15.057,4.548c7.03,0,14.015-2.704,19.254-7.944l18.381-18.382c9.133-9.134,10.561-23.563,3.396-34.31
			l-24.252-36.378c4.387-8.396,8.028-17.183,10.867-26.228l42.868-8.572c12.666-2.534,21.86-13.748,21.86-26.665v-25.993
			C512,192.359,502.807,181.146,490.14,178.611z"></path>
                                        <path d="M320.674,280.253h-75.453c-4.465,0-8.084,3.618-8.084,8.084c0,4.466,3.62,8.084,8.084,8.084h75.453
			c7.43,0,13.474,6.044,13.474,13.474v10.779c0,7.43-6.044,13.474-13.474,13.474h-75.453c-4.465,0-8.084,3.619-8.084,8.084
			c0,4.466,3.62,8.084,8.084,8.084h75.453c7.43,0,13.474,6.044,13.474,13.474v10.779c0,7.43-6.044,13.474-13.474,13.474h-75.453
			c-4.465,0-8.084,3.618-8.084,8.084c0,4.466,3.62,8.084,8.084,8.084h75.453c7.43,0,13.474,6.044,13.474,13.474v10.779
			c0,7.43-6.044,13.474-13.474,13.474h-75.453c-4.465,0-8.084,3.618-8.084,8.084c0,4.466,3.62,8.084,8.084,8.084h75.453
			c7.43,0,13.474,6.044,13.474,13.474v10.779c0,7.43-6.044,13.474-13.474,13.474h-146.44c-7.644,0-14.838-2.97-20.256-8.36
			c-8.553-8.51-19.843-13.198-31.79-13.198H102.4v-88.926c0-4.466-3.62-8.084-8.084-8.084s-8.084,3.618-8.084,8.084v107.789
			c0,1.486-1.209,2.695-2.695,2.695H59.284V385.347c0-4.466-3.62-8.084-8.084-8.084s-8.084,3.618-8.084,8.084v110.484H18.863
			c-1.485,0-2.695-1.208-2.695-2.695V309.895c0-1.486,1.209-2.695,2.695-2.695h64.674c1.485,0,2.695,1.208,2.695,2.695v43.116
			c0,4.466,3.62,8.084,8.084,8.084s8.084-3.618,8.084-8.084v-24.253h19.492c12.778,0,24.079-8.146,28.121-20.268l3.009-9.032
			c9.324-27.965,14.051-57.093,14.051-86.574c0-7.43,6.044-13.474,13.474-13.474c6.479,0,12.569,2.523,17.15,7.104
			s7.103,10.671,7.103,17.15v86.229c0,4.465,3.62,8.084,8.084,8.084c4.465,0,8.084-3.618,8.084-8.084v-86.229
			c0-10.797-4.204-20.949-11.839-28.584c-7.635-7.635-17.786-11.84-28.584-11.84c-16.345,0-29.642,13.298-29.642,29.642
			c0,27.74-4.448,55.147-13.221,81.461l-3.011,9.032c-1.837,5.51-6.973,9.213-12.782,9.213H102.4v-2.695
			c0-10.401-8.463-18.863-18.863-18.863H18.863C8.463,291.032,0,299.494,0,309.895v183.242C0,503.537,8.463,512,18.863,512h64.674
			c10.401,0,18.863-8.463,18.863-18.863v-2.695h19.787c7.644,0,14.884,3.016,20.386,8.491c8.469,8.426,19.713,13.067,31.66,13.067
			h146.441c16.345,0,29.642-13.298,29.642-29.642v-10.779c0-8.485-3.584-16.149-9.317-21.558
			c5.733-5.409,9.317-13.073,9.317-21.558v-10.779c0-8.485-3.584-16.149-9.317-21.558c5.733-5.409,9.317-13.073,9.317-21.558
			v-10.779c0-8.485-3.584-16.149-9.317-21.558c5.733-5.409,9.317-13.073,9.317-21.558v-10.779
			C350.316,293.551,337.019,280.253,320.674,280.253z"></path>
                                        <path d="M293.701,259.775c2.119,0,4.265-0.163,6.423-0.5c22.608-3.53,38.129-24.793,34.6-47.399
			c-3.528-22.608-24.796-38.133-47.398-34.602c-22.608,3.53-38.129,24.793-34.6,47.399
			C255.918,245.122,273.62,259.774,293.701,259.775z M289.82,193.248c13.8-2.143,26.777,7.321,28.931,21.119
			c2.154,13.799-7.32,26.777-21.118,28.932c-13.798,2.154-26.777-7.321-28.931-21.119
			C266.548,208.381,276.022,195.403,289.82,193.248z"></path>
                                        <path d="M366.829,296.421c2.129,0,4.253-0.835,5.841-2.494c23.782-24.85,34.382-58.57,29.084-92.514
			c-2.692-17.244-9.208-33.113-19.371-47.163c-2.616-3.616-7.669-4.43-11.289-1.813c-3.617,2.617-4.429,7.67-1.813,11.289
			c8.652,11.964,14.203,25.483,16.497,40.18c4.514,28.925-4.521,57.662-24.79,78.843c-3.087,3.225-2.975,8.343,0.251,11.43
			C362.807,295.677,364.82,296.421,366.829,296.421z"></path>
                                        <path d="M361.144,142.298c2.688-3.565,1.977-8.634-1.589-11.321c-23.838-17.972-53.206-25.34-82.691-20.73
			c-33.834,5.28-62.67,25.561-79.115,55.644c-2.142,3.918-0.702,8.829,3.215,10.972c1.231,0.673,2.56,0.993,3.871,0.992
			c2.86,0,5.632-1.521,7.1-4.207c14.017-25.64,38.591-42.926,67.422-47.425c25.126-3.925,50.151,2.352,70.464,17.666
			C353.388,146.574,358.457,145.864,361.144,142.298z"></path>
                                    </g>
                                </svg>
                            </div>
                            <p>Отменное качество</p>
                        </div>
                        <div class="contact-box-highlight">
                            <div class="img-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496" class="svg-icon">
                                    <g>
                                        <path d="M447.82,390.192c-5.376-32.232-27.976-58.68-58.976-69.016l-8.216-2.736c10.864-7.44,17.576-17.32,18.032-18.008
			l4.192-6.296l-6.04-4.536c-9.944-7.464-17.832-17.424-22.792-28.808l-14.672,6.408c4.968,11.368,12.312,21.576,21.472,29.912
			c-5.048,5.512-13.928,12.96-23.808,13.456l-37.008-12.336V288h-16v15.032l-11.936,47.744L259.756,312h-23.504l-32.312,38.776
			l-11.936-47.744V288h-16v10.232L139.02,310.56c-9.976-0.296-18.808-7.896-23.848-13.432
			c18.184-16.568,28.832-40.344,28.832-65.128h-16c0,22.536-10.768,44.072-28.808,57.6l-6.048,4.536l4.192,6.296
			c0.456,0.68,7.176,10.568,18.024,18.008l-8.208,2.736c-31,10.336-53.6,36.784-58.976,69.016L30.556,496h434.888L447.82,390.192z
			 M388.812,480c1.776-5.768,3.192-13.528,3.192-24c0-27-17.592-44.904-18.344-45.656l-11.312,11.312
			c0.136,0.144,13.656,13.888,13.656,34.344c0,13.272-2.64,20.624-4.312,24H256.004V344h-16v136H124.348
			c-1.736-3.472-4.344-10.816-4.344-24c0-20.208,13.544-34.224,13.68-34.368l-5.68-5.632l-5.656-5.656
			C121.596,411.096,104.004,429,104.004,456c0,10.472,1.416,18.232,3.192,24H49.452l14.52-87.176
			c4.4-26.368,22.888-48.008,48.256-56.472l29.24-9.744c0.152-0.008,0.304-0.008,0.456-0.016l-0.008-0.136l36.424-12.136
			l17.728,70.904L243.756,328h8.496l47.688,57.224l17.728-70.904l36.36,12.12l-0.016,0.2c0.224,0.016,0.44,0.008,0.664,0.024
			l29.096,9.696c25.368,8.464,43.856,30.104,48.256,56.472L446.556,480H388.812z"></path>
                                        <rect x="272.004" y="392" width="16" height="16"></rect>
                                        <rect x="272.004" y="448" width="16" height="16"></rect>
                                        <path d="M120.004,216h27.648c4.112,13.864,11.616,26.576,22.128,37.088l31.192,31.192c7.552,7.552,17.6,11.72,28.288,11.72
			h37.488c10.688,0,20.736-4.168,28.288-11.72l20.28-20.28h12.688c22.056,0,40-17.944,40-40v-8h8c22.056,0,40-17.944,40-40v-32
			c0-22.056-17.944-40-40-40h-9.32C358.78,45.128,308.108,0,248.004,0s-110.776,45.128-118.68,104h-9.32c-22.056,0-40,17.944-40,40
			v32C80.004,198.056,97.948,216,120.004,216z M384.004,121.48c9.288,3.304,16,12.104,16,22.52v32c0,10.416-6.712,19.216-16,22.528
			V121.48z M314.916,241.776L308.692,248h-84.688v16h68.688l-8.968,8.968c-4.536,4.536-10.56,7.032-16.976,7.032H229.26
			c-6.416,0-12.448-2.496-16.976-7.032l-31.192-31.192c-13.592-13.6-21.088-31.68-21.088-50.912V184c0-26.472,21.528-48,48-48
			h14.032c13.312,0,26.496-4.392,37.152-12.376l11.312-8.488C282.156,128.328,298.94,136,316.844,136h19.16v8v46.864
			C336.004,210.096,328.508,228.176,314.916,241.776z M352.004,190.864V144v-24h16v80h-16V190.864z M352.004,224
			c0,12.168-9.128,22.136-20.872,23.688c7.944-9.36,13.792-20.104,17.224-31.688h3.648V224z M248.004,16
			c51.36,0,94.824,38.024,102.592,88h-14.592v16h-19.16c-15.384,0-29.656-7.64-38.184-20.44l-4.688-7.04l-24.392,18.304
			c-7.888,5.92-17.68,9.176-27.544,9.176h-14.032c-19.12,0-36.264,8.472-48,21.808V104h-14.592
			C153.18,54.024,196.644,16,248.004,16z M128.004,120h16v24v46.864V200h-16V120z M96.004,144c0-10.416,6.712-19.216,16-22.528
			v77.048c-9.288-3.312-16-12.112-16-22.528V144z"></path>
                                    </g>
                                </svg>
                            </div>
                            <p>Индивидуальные консультации</p>
                        </div>
                    </div>
                    <div class="col-md-10"><a class="btn btn-green" href="#contactModal" data-bs-toggle="modal">Контактная форма</a></div>
                </div>
            </div>
        </div>
    </div>
</figure>

<?php endwhile; endif;?>

<?php get_footer();?>
