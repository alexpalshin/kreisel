<?php
/*
Template Name: Home page
 */

get_header();
?>

<main role="main" class="home-page">
    <!--CAROUSEL-->

    <?php
    $carousel = get_field('carousel');
    ?>
    <div class="key-visual key-visual-container-overlay-small">

		<?php if ( !empty($carousel) && is_array($carousel) ): ?>

            <div class="key-visual-inner-content slick">
				<?php
				$i = 0;
				foreach ($carousel as $item):
					$i++;
					$background_img     = $item['background_img'];
					$text               = $item['text'];
					$button_text        = $item['button_text'];
					$button_url         = $item['button_url'];
					$button_atts        = $item['button_atts'];

                    
					?>
                    <div class="key-visual-slide">
                        <div class="key-visual-imagecontainer">
                            <?php 
                            echo grif_image($background_img['ID']);
                            ?>
                        </div>
	                    <?php if (!empty($text)): ?>
                        <div class="key-visual-textcontainer">
                            <div class="textbox right primary">
                                <?php if ($i == 1): ?>
                                    <h1><?php echo $text ?></h1>
                                <?php else: ?>
                                    <div class="h1"><?php echo $text ?></div>
                                <?php endif; ?>
								<?php if (!empty($button_text)): ?>
                                    <a href="<?php echo $button_url ?>" class="btn btn-cta" <?php echo $button_atts; ?>><?php echo $button_text ?></a>
								<?php endif; ?>
                            </div>
                        </div>
	                    <?php endif; ?>
                    </div>
				<?php endforeach; ?>
            </div>
        <?php if (count($carousel) > 1): ?>
            <div class="key-visual-control slick-control-prev"><svg fill="#FFFFFF" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" class="svg-icon"><path d="M15.6,6.3l-5.3,5.3l5.3,5.3l-0.8,1l-6.3-6.3l6.3-6.3L15.6,6.3z"></path></svg></div>
            <div class="key-visual-control slick-control-next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" fill="#FFFFFF" viewBox="0 0 24 24" class="svg-icon"><path d="M8.5,16.9l5.3-5.3L8.5,6.3l0.8-1l6.3,6.3l-6.3,6.3L8.5,16.9z"></path></svg></div>
        <?php endif; ?>

		<?php else: ?>

            <div class="key-visual-container">
                <?php 
                    echo grif_image( get_stylesheet_directory_uri().'/dist/images/key-visual.jpg' );
                ?>
            </div>

		<?php endif;?>

    </div>

    <div class="top-50"></div>

    <!--PRODUCTS AND CONTACTS-->
    <?php
    $products_contacts  = get_field('products_contacts');
    $contacts_1         = $products_contacts['contacts_1'];
    $contacts_2         = $products_contacts['contacts_2'];
    ?>
    <div class="products-contacts component-container bg-white">
        <div class="icon-container container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-4 icon-element"> <a href="#downloads" class="iconlink">
                        <div class="iconimage-container">
                            <?php 
                                echo grif_image( get_stylesheet_directory_uri().'/dist/images/Silo_Icon.png', "iconimage", "Produktfinder", "54px", "54px" );
                            ?>
                        </div>
                    </a>
                    <div class="icon-textcontainer">
                        <div class="h4"><?php echo $contacts_1['title'] ?></div>
                        <div class="icon-text">
                            <div class="p"><?php echo $contacts_1['text'] ?></div>
                            <p><a href="<?php echo $contacts_1['link_url'] ?>"><?php echo $contacts_1['link_text'] ?></a></p>
                        </div>
                    </div>
                </div>
                <div class="col-4 icon-element"> <a href="#contacts" class="iconlink">
                        <div class="iconimage-container"> 
                            <?php 
                                echo grif_image( get_stylesheet_directory_uri().'/dist/images/call-us.png', "iconimage", "Produktfinder", "54px", "54px" );
                            ?>
                        </div>
                    </a>
                    <div class="icon-textcontainer">
                        <div class="h4"><?php echo $contacts_2['title'] ?></div>
                        <div class="icon-text">
                            <div class="p"><?php echo $contacts_2['text'] ?></div>
                            <p><a href="<?php echo $contacts_2['link_url'] ?>"><?php echo $contacts_2['link_text'] ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--SEARCH-->
    <div class="component-container bg-white">
        <div class="container-fluid searchbar-container-dunkel">
            <div class="container searchbar-content-container">
                <form method="GET" class="search-form" action="/" accept-charset="utf-8">
                    <div class="searchbar-input-group active"> <span class="search-title"> Что вы ищете? </span>
                        <div class="input-group">
                            <input class="form-control searchbarform-input" name="s" type="text" placeholder="Введите поисковый запрос." autocomplete="off">
                            <button class="input-group-text search-input">
                                Поиск
                                <div class="svg-search-icon">
                                    <svg viewBox="0 0 24 24">
                                    <use xlink:href="#icon-magnifier"></use>
                                    <svg viewBox="0 0 24 24" id="icon-magnifier-dunkel" width="100%" height="100%">
                                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                    </svg>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--NEWS-->
    <?php
    $news               = get_field('news');

    $args = array(
	    'posts_per_page' => 2,
	    'post_type' => 'post',
	    'post_status' => 'publish'
    );

    $myposts = get_posts( $args );
    if (!empty($myposts)):
    ?>
    <div class="home-news component-container bg-orientation-right component-container-bg bg-lightgray">
        <div class="pt-4"></div>
        <div id="news" class="scroll-anchor"></div>
        <div class="container content-container">
            <h2 class="text-center"><?php echo $news['title'] ?></h2>
            <div class="teaser-container teaser50">
                <div class="row">
					<?php
					foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

                        <div class="col-md-6 teaser">
                            <div class="card">
                                <div class="teaser-mediacontainer"><?php the_post_thumbnail(); ?></div>
                                <div class="card-body">
                                    <div class="card-title h4"><?php the_title(); ?></div>
                                    <div class="card-text"><?php the_content(); ?></div>
                                </div>
                                <div class="card-footer"> <a href="#">Читать полностью</a>
                                </div>
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
    <?php endif; ?>


    <!--DONWLOAD-->
    <?php
    $downloads           = get_field('downloads');

    if (!empty($downloads['downloads'])):
    ?>
    <div class="home-downloads component-container bg-white download-component-container">
        <div id="downloads" class="scroll-anchor"></div>
        <div class="container">
            <header>
                <h3 class="headline-center">Загрузки</h3>
            </header>
            <?php
            if (is_array($downloads)) foreach ($downloads as $download):
            ?>
            <div class="downloads">
                <div class="downloads-entry col-12">
                    <div class="downloads-title"><?php echo $download['file_title']; ?></div>
                    <div class="downloads-file-info">
                        <div class="downloads-file-extension"><?php echo $download['file']['subtype']; ?></div>
                        <div class="downloads-file-size"><?php echo number_format($download['file']['filesize']/1000000,2); ?> MB</div>
                    </div>
                    <!--<div class="downloads-link">
                        <a href="">
                            <svg class="svg-icon-download-link">
                                <use xlink:href="#icon-rss">
                                    <svg viewBox="0 0 24 24" id="icon-rss" width="100%" height="100%">
                                        <circle cx="6.18" cy="17.82" r="2.18"></circle>
                                        <path d="M4 4.44v2.83c7.03 0 12.73 5.7 12.73 12.73h2.83c0-8.59-6.97-15.56-15.56-15.56zm0 5.66v2.83c3.9 0 7.07 3.17 7.07 7.07h2.83c0-5.47-4.43-9.9-9.9-9.9z"></path>
                                    </svg>
                                </use>
                            </svg>
                            <span>Abonnieren</span>
                        </a>
                    </div>
                    <div class="downloads-link">
                        <a href="">
                            <svg class="svg-icon-download-link">
                                <use xlink:href="#icon-grade">
                                    <svg viewBox="0 0 20 19" id="icon-grade" width="100%" height="100%">
                                        <path d="M10 15.3l6.2 3.7-1.6-7L20 7.2l-7.2-.6L10 0 7.2 6.6 0 7.2 5.5 12l-1.6 7 6.1-3.7z"></path>
                                    </svg>
                                </use>
                            </svg>
                            <span class="bookmarker-text-add">Zur Merkliste hinzufügen</span>
                            <span class="bookmarker-text-remove">Von der Merkliste entfernen</span>
                        </a>
                    </div>-->
                    <div class="downloads-link">
                        <a href="<?php echo $download['file']['url']; ?>" target="_blank">
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
            endforeach;
            ?>
        </div>
    </div>
    <?php endif; ?>

    <!--TEASERBOXEN-->
    <?php
    $about = get_field('about');
    ?>
    <div class="home-about component-container bg-white">
        <div id="about" class="scroll-anchor"></div>
        <div class="container">
            <div class="row">
                <div class="topteaser-container">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-lg-4">
                                <div class="topteaser-mediacontainer">
                                    <?php 
                                        echo grif_image( $about['image']['ID'] );
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-8 textbox">
                                <div class="card-body">
                                    <div class="card-title h3"><?php echo $about['title'] ?></div>
                                    <div class="p card-text"><?php echo $about['text'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($about['more_text'])): ?>
        <div class="pt-5"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
	                <?php echo $about['more_text'] ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>


    <!--CLICKMAP-->
    <?php
    $click_map = get_field('click_map');
    ?>
    <div class="home-clickmap component-container bg-white">
        <div id="clickmap" class="scroll-anchor"></div>
        <div class="container containerinner">
            <h2 class="headline-center"><?php echo $click_map['title'] ?></h2>
        </div>
    </div>
    <div class="component-container bg-white">
        <div class="container containerinner">
            <div class="clickmap">
                <div class="row">
                    <div class="col-md-6 clickmap-description">
                        <div class="clickmap-description-visible text-center">
                            <div class="p"><?php echo $click_map['subtitle'] ?></div>
                        </div>
                        <div class="clickmap-description-hidden text-center">
                            <div class="p">Для просмотра 3D модели используйте Desktop</div>
                        </div>
                    </div>
                    <div class="clickmap-image">
                        <picture>
                            <source media="(min-width:1200px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/csm_Clickmap_22c83f4c27.jpg">
                            <source media="(min-width:768px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/csm_Clickmap_c30586fd1d.jpg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/csm_Clickmap_22c83f4c27.jpg" alt="clickmap" class="img-fluid" width="1235" height="755" loading="lazy">
                        </picture>
                        <!--CLICKMAP ITEM-->
                        <div class="clickmap-items">
                            <!--CLICKMAP ITEM-->
                            <?php
                            $spot_1 = $click_map['spot_1'];
                            ?>
                            <div class="clickmap-item bottom-right animate" style="top: 30%; left: 25%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_1['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_1['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_1['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_2 = $click_map['spot_2'];
	                        ?>
                            <div class="clickmap-item bottom-right animate" style="top: 43%; left: 18%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_2['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_2['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_2['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_3 = $click_map['spot_3'];
	                        ?>
                            <div class="clickmap-item bottom-right animate" style="top: 40%; left: 55%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_3['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_3['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_3['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_4 = $click_map['spot_4'];
	                        ?>
                            <div class="clickmap-item bottom-right" style="top: 53%; left: 35%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_4['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_4['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_4['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_5 = $click_map['spot_5'];
	                        ?>
                            <div class="clickmap-item bottom-right" style="top: 60%; left: 55%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_5['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_5['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_5['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_6 = $click_map['spot_6'];
	                        ?>
                            <div class="clickmap-item bottom-right" style="top: 73%; left: 35%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_6['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_6['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_6['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                            <!--CLICKMAP ITEM-->
	                        <?php
	                        $spot_7 = $click_map['spot_7'];
	                        ?>
                            <div class="clickmap-item bottom-right" style="top: 70%; left: 70%;">
                                <div class="clickmap-item-toggle"></div>
                                <div class="clickmap-item-content">
                                    <div class="clickmap-item-content-header"><?php echo $spot_7['title'] ?></div>
                                    <div class="clickmap-item-content-inner">
                                        <div class="clickmap-item-text"><?php echo $spot_7['text'] ?></div>
                                        <div class="clickmap-item-links">
                                            <!--<a href="<?php echo $spot_7['link'] ?>">
                                                Перейти к продуктам
                                            </a>
                                            <a href="/trendi-ta-rishennja/farbi" class="btn btn-blue">
                                                Дізнатися більше
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CLICKMAP ITEM ENDE-->
                        </div>
                        <!--CLICKMAP ITEM ENDE-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--CLICKMAP ENDE-->

    <!--REFS-->
    <?php
	$references = get_field('references');

    $args = array(
	    'posts_per_page' => 3,
	    'post_type' => 'refs',
	    'post_status' => 'publish'
    );

    $refposts = get_posts( $args );

    if (!empty($refposts)):
	?>
    <div class="component-container bg-white-left">
        <div id="refs" class="scroll-anchor"></div>
        <div class="bg-image-left">
            <?php echo grif_image( get_stylesheet_directory_uri().'/dist/images/csm__WOK2110_a718f9a8c1.jpg', '', '', '1600', '809' ); ?>
        </div>
        <div class="container content-container">
            <h2 class="text-center"><?php echo $references['title'] ?></h2>
            <div class="teaser-container teaser50">
                <div class="row">
					<?php

					foreach ( $refposts as $post ) : setup_postdata( $post ); ?>

						<?php
						$label = get_field('label', $post->ID);
						?>
                        <div class="col-md-4 teaser">
                            <div class="card">
                                <div class="teaser-label"><?php echo $label ?></div>
                                <div class="teaser-mediacontainer">
									<?php echo grif_image( get_post_thumbnail_id($post) ); ?>
                                </div>
                                <div class="card-body">
                                    <div class="card-title h4"><?php the_title(); ?></div>
                                    <div class="card-text"><?php the_content(); ?></div>
                                </div>
                            </div>
                        </div>

					<?php

					endforeach;
					wp_reset_postdata();

					?>

                </div>
            </div>
        </div>
        <!--<div class="component-container-footer"><a class="btn btn-blue" href="#">Betrachten Sie alle Referenzen</a></div>-->
    </div>
 <?php endif; ?>

    <!--FACTS-->
	<?php
	$facts = get_field('facts');
	?>
    <div class="component-container bg-darkgray facts-component-container">
        <div id="facts" class="scroll-anchor"></div>
        <div class="container">
            <div class="facts" >
                <div class="row">
                    <div class="col fact-section">
                        <div class="fact-title"><?php echo $facts['fact_1']['number'] ?></div>
                        <div class="fact-text"><?php echo $facts['fact_1']['description'] ?></div>
                        <hr>
                    </div>
                    <div class="col fact-section">
                        <div class="fact-title"><?php echo $facts['fact_2']['number'] ?></div>
                        <div class="fact-text"><?php echo $facts['fact_2']['description'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--CONTACTS-->
    <?php
    $contacts = get_field('contacts');
    ?>
    <!--
    <div class="home-contacts component-container bg-white">
        <div id="contacts" class="scroll-anchor"></div>
        <div class="container containerinner">
            <h2 class="text-center"><?php echo $contacts['title']; ?></h2>
            <div class="teaser-container teaser33">
                <div class="row">
                    <?php
                    $contact_blocks = $contacts['contact_blocks'];
                    $i = 1;
                    if (is_array($contact_blocks)) foreach ($contact_blocks as $block):
	                    $noimage = false;

	                    if (empty($block['image'])) $noimage = true;
	                    ?>
                        <div class="<?php if ( count($contact_blocks) == 1 ): echo "col-12"; else: echo "col-md-4"; endif;?> teaser">
                            <div class="card <?php if ($i == 2 || $i == 5 || $i == 8 || $noimage == true) echo "bg-color";?>">
                                <?php if (!empty($block['label'])): ?>
                                    <div class="teaser-label"><?php echo $block['label']; ?></div>
                                <?php endif; ?>
                                <div class="teaser-mediacontainer <?php if ($noimage) echo "noimage"; ?>">
                                    <img src="<?php if (!empty($block['image'])): echo $block['image']['sizes']['large']; else: echo get_theme_file_uri()."/dist/images/white_box.jpg"; endif; ?>"  alt="">
                                </div>
                                <div class="card-body">
                                    <p class="card-topline"><?php echo $block['pretitle'] ?></p>
                                    <div class="card-title h4"><?php echo $block['title'] ?></div>
                                    <div class="card-text"><?php echo $block['text'] ?></div>

                                    <div class="collapse" id="collapseExample<?php echo $i ?>">
                                        <div class="p card-text pt-4">
			                                <?php
			                                $contact_details = $block['contact_details'];
			                                if (is_array($contact_details)) foreach ($contact_details as $contact_detail):
				                                ?>
                                                <div class="p">
                                                    <strong><?php echo $contact_detail['dept_name'] ?></strong><br>
					                                <?php echo $contact_detail['name'] ?><br>
                                                    <a href="tel:<?php echo $contact_detail['phone_number'] ?>"><?php echo $contact_detail['phone'] ?></a><br>
                                                    <?php if (!empty($contact_detail['phone_2'])): ?>
                                                        <a href="tel:<?php echo $contact_detail['phone_2_number'] ?>"><?php echo $contact_detail['phone_2'] ?></a><br>
                                                    <?php endif; ?>
                                                    <a href="mailto:<?php echo $contact_detail['email'] ?>"><?php echo $contact_detail['email'] ?></a>
                                                </div>
			                                <?php endforeach; ?>
                                        </div>
                                    </div>

                                </div>
                                <?php if (!empty($block['contact_details'])): ?>
                                    <div class="card-footer">
                                        <a data-bs-toggle="collapse" href="#collapseExample<?php echo $i ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $i ?>">Контакты</a>
                                    </div>
	                            <?php endif; ?>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    -->
</figure>

<?php get_footer();?>
