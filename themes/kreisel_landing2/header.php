<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge"/>

	    <?php
	    $url = site_url();
	    $image = get_stylesheet_directory_uri().'/src/images/kreisel_logo.png';
        if (is_archive() || is_tax()) {
            $term = get_queried_object();
            $title = $term->label;
        } else {
	        if ( is_front_page() ) {
		        $title = get_bloginfo('name');
	        } else {
		        global $post;
		        $url = get_permalink( $post );
		        $title = get_the_title( $post );
		        $image = get_the_post_thumbnail_url( $post );
	        }
        }
	    ?>

	    <meta property="og:url"           content="<?php echo $url; ?>" />
	    <meta property="og:type"          content="website" />
	    <meta property="og:title"         content="<?php echo $title; ?>" />
        <meta property="og:image"         content="<?php echo $image; ?>" />

        <?php wp_head();?>

    </head>
    <body <?php body_class();?>>
        <span class="screen-darken"></span>
        <header class="main-site-header <?php if (krl_is_overlaying_header()){ ?>main-header-overlaying<?php } ?>">
            <div class="expanded-navbar">
                <div class="meta-navigation">
                    <div class="meta-navigation-inner container">
                        <div class="row">
                            <div class="col-md-5 metamenu">
	                            <?php
	                            wp_nav_menu(array(
		                            'theme_location' => 'meta-menu',
		                            'container' => false,
		                            'menu_class' => '',
		                            'fallback_cb' => '__return_false',
		                            'depth' => 1
	                            ));
	                            ?>
                            </div>
                            <div class="col-md-3 suche">
                                <form class="search-form" method="GET" action="/">
                                    <div class="search-module">
                                        <input class="search-module_text-input" name="s" type="text" placeholder="Поиск по сайту">
                                        <button class="search-icon-container">
                                            Поиск
                                            <svg viewBox="0 0 24 24" class="svg-icon">
                                                <use xlink:href="#icon-magnifier">
                                                    <symbol viewBox="0 0 24 24" id="icon-magnifier">
                                                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                                                        </path>
                                                    </symbol>
                                                </use>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 sprache">
                            </div>
                            <div class="col-md-2 merkliste">
                            </div>
                        </div>
                    </div>
                </div>
                <nav id="navbar_top" class="navbar navbar-expand navbar-light">
                    <div class="container navbarinner">
                        <div class="logo-container">
                            <a href="<?php echo home_url() ?>">
                                <svg id="Ebene_1" data-name="Ebene 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 464 62" class="svg-icon"><defs><style>.cls-1{fill:#323c8d;fill-rule:evenodd;}</style></defs><g id="Warstwa_1"><g id="_1879293760208" data-name=" 1879293760208"><path class="cls-1" d="M285.36,46a3.54,3.54,0,0,0,3.36-3.54,3.34,3.34,0,0,0-3.32-3.37H271a18.94,18.94,0,0,1-19.11-19.21C252,9.4,260.54.13,271.23.13H390.71l-4.28,16H352.49l-1.85,6.91h33.93l-4.28,16H346.35L344.53,46H387.6L399.88.13h24.89L412.49,46h41l-4.28,16h-134l12.28-45.83H282.51a3.69,3.69,0,0,0-3.36,3.71,3.11,3.11,0,0,0,3.32,3.2h12a19,19,0,0,1,19.11,19.38C313.56,53,304.66,62,294.3,62H118.06L102.62,34.68,95.31,62H47.73L32.3,34.68,25,62H0L16.52.13H41.58L35.43,23.05,58.24.13H83.13L54.24,29.28,71.13,59.11,87,.13h38.59A19.51,19.51,0,0,1,145,19.85c-.06,11.79-9.78,18.36-15,19.21l11.42,20,15.8-59h58.88l-4.34,16H177.91l-1.84,6.91H210l-4.25,16H171.78L169.93,46H213L225.31.13H250.2L237.92,46ZM107.6,16.14l-3.54,13.14h11.33c7-1.85,10.09-13.14,1.07-13.14Z"></path><path class="cls-1" d="M458.27,11.58A5.73,5.73,0,1,1,464,5.85,5.73,5.73,0,0,1,458.27,11.58Zm0-1A4.72,4.72,0,1,1,463,5.85,4.73,4.73,0,0,1,458.27,10.57ZM455.81,9V2.76h2.63a4.51,4.51,0,0,1,1.44.17,1.43,1.43,0,0,1,.72.59,1.77,1.77,0,0,1,.27,1,1.69,1.69,0,0,1-.41,1.16,2,2,0,0,1-1.22.57,2.77,2.77,0,0,1,.67.52,7.14,7.14,0,0,1,.71,1L461.37,9h-1.49L459,7.6a11,11,0,0,0-.66-.91,1.12,1.12,0,0,0-.38-.26,2.27,2.27,0,0,0-.63-.07h-.25V9Zm1.25-3.57H458a4.8,4.8,0,0,0,1.13-.08.75.75,0,0,0,.35-.26.84.84,0,0,0,.12-.47.75.75,0,0,0-.16-.5.74.74,0,0,0-.47-.24,8.8,8.8,0,0,0-.92,0h-1V5.38Z"></path></g></g></svg>
                            </a>
                        </div>
                        <div id="main_nav" class="navbar-collapse">
	                        <?php
	                        krl_create_bootstrap_desktop_menu('top-menu');
	                        ?>
                        </div>
                    </div>
                </nav>
            </div>

            <!--MOBILE MENU-->
            <div class="mobile-navbar">
                <div class="mainnav">
                    <div class="logo">
                        <svg id="Ebene_1" data-name="Ebene 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 464 62" class="svg-icon"><defs><style>.cls-1{fill:#323c8d;fill-rule:evenodd;}</style></defs><g id="Warstwa_1"><g id="_1879293760208" data-name=" 1879293760208"><path class="cls-1" d="M285.36,46a3.54,3.54,0,0,0,3.36-3.54,3.34,3.34,0,0,0-3.32-3.37H271a18.94,18.94,0,0,1-19.11-19.21C252,9.4,260.54.13,271.23.13H390.71l-4.28,16H352.49l-1.85,6.91h33.93l-4.28,16H346.35L344.53,46H387.6L399.88.13h24.89L412.49,46h41l-4.28,16h-134l12.28-45.83H282.51a3.69,3.69,0,0,0-3.36,3.71,3.11,3.11,0,0,0,3.32,3.2h12a19,19,0,0,1,19.11,19.38C313.56,53,304.66,62,294.3,62H118.06L102.62,34.68,95.31,62H47.73L32.3,34.68,25,62H0L16.52.13H41.58L35.43,23.05,58.24.13H83.13L54.24,29.28,71.13,59.11,87,.13h38.59A19.51,19.51,0,0,1,145,19.85c-.06,11.79-9.78,18.36-15,19.21l11.42,20,15.8-59h58.88l-4.34,16H177.91l-1.84,6.91H210l-4.25,16H171.78L169.93,46H213L225.31.13H250.2L237.92,46ZM107.6,16.14l-3.54,13.14h11.33c7-1.85,10.09-13.14,1.07-13.14Z"></path><path class="cls-1" d="M458.27,11.58A5.73,5.73,0,1,1,464,5.85,5.73,5.73,0,0,1,458.27,11.58Zm0-1A4.72,4.72,0,1,1,463,5.85,4.73,4.73,0,0,1,458.27,10.57ZM455.81,9V2.76h2.63a4.51,4.51,0,0,1,1.44.17,1.43,1.43,0,0,1,.72.59,1.77,1.77,0,0,1,.27,1,1.69,1.69,0,0,1-.41,1.16,2,2,0,0,1-1.22.57,2.77,2.77,0,0,1,.67.52,7.14,7.14,0,0,1,.71,1L461.37,9h-1.49L459,7.6a11,11,0,0,0-.66-.91,1.12,1.12,0,0,0-.38-.26,2.27,2.27,0,0,0-.63-.07h-.25V9Zm1.25-3.57H458a4.8,4.8,0,0,0,1.13-.08.75.75,0,0,0,.35-.26.84.84,0,0,0,.12-.47.75.75,0,0,0-.16-.5.74.74,0,0,0-.47-.24,8.8,8.8,0,0,0-.92,0h-1V5.38Z"></path></g></g></svg>
                    </div>
                    <div class="burger-menu-toggle" data-trigger="mainnav"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span><span class="toggle-text">MENÜ</span> </div>
                </div>
                <!--<div id="navbar_mobile" class="mobile-favorite-navigation"></div>-->
                <nav id="mainnav" class="mobile-offcanvas">
                    <div class="container-fluid">
                        <div class="offcanvas-header close"> <span class="closetext">Закрыть</span> <span class="closeicon"></span> </div>
                    </div>
                    <div class="mobile-accordionnav">
	                    <?php
	                    krl_create_bootstrap_mobile_menu1('top-menu');
	                    ?>
	                    <?php
	                    krl_create_bootstrap_mobile_menu2('meta-menu');
	                    ?>
                        <form class="search-form" action="/">
                            <div class="search-module">
                                <input class="search-module-text" name="s" type="text" placeholder="Что вы ищете?">
                                <button class="search-module-icon">
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-magnifier">
                                            <symbol viewBox="0 0 24 24" id="icon-magnifier">
                                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>

            <?php if ((is_page() || is_singular('product')) && !is_front_page()) { ?>
            <div class="breadcrumb-container  ">
                <div class="breadcrumb-inner container">

                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">

                        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

                            <li class="breadcrumb-item first" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <a href="<?php echo home_url(); ?>" itemprop="item">
                                    <span itemprop="name" style="display:none;">Home</span>
                                    <svg viewBox="0 0 24 24" class="svg-icon">
                                        <use xlink:href="#icon-home">
                                            <symbol viewBox="0 0 24 24" id="icon-home">
                                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                </a>
                                <meta itemprop="position" content="1">
                            </li>

                            <li class="breadcrumb-item current" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <span itemprop="name"><?php the_title(); ?></span>
                                <meta itemprop="position" content="2">
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
            <?php } ?>

        </header>

        <!-- MAINCONTENT -->
        <div class="maincontent">