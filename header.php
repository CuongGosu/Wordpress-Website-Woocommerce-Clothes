<!doctype html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
</head>
<body <?php body_class() ?> id="lama-theme">
	<div class="main-body">
    <header class="header-common">
        <div class="wrapper">
          <div class="header-wrapper">
            <nav class="header-list-navigation">
            <?php
                                            wp_nav_menu([
                                                'menu'           => 'gm-primary',
                                                'theme_location' => 'gm-primary',
                                                'container'      => false,
                                                'menu_class' => 'list-navigation',
                                                'walker'         => new Custom_Walker_Nav_Menu(),
                                            ])
                                        ?>

            </nav>
            <a class="trans logo-header-primary" href="/">
            <img itemprop="logo" src="<?php theOPtionImage('desktop_logo') ?>" alt="<?php theOption('ten_cong_ty') ?>" class="object-common">

            </a>

            <div class="header-right">
                <div class="header-action header-action_search">
                                    <div class="header-action_text">
                                        <a class="header-action__link header-action-toggle" href="javascript:void(0)" id="site-search-handle" aria-label="Search" title="Search">
              
                                            <span class="box-icon">
                           
                                                    Search
                                            </span> 
                                        </a>
                                    </div>
                                    <div class="header-action_dropdown">
                                        <span class="box-triangle">
                                            <svg viewbox="0 0 20 9" role="presentation">
                                                <path d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z" fill="#ffffff"></path>
                                            </svg>
                                        </span>
                                        <div class="header-dropdown_content">
                                            <p class="ttbold">Search</p>
                                            <div class="site_search">
                                                <div class="search-box wpo-wrapper-search">
                                                    <form action="/" class="searchform searchform-categoris ultimate-search" method="get">
                                                        <div class="wpo-search-inner">
                                                            <input type="hidden" name="post_type" value="product">
                                                            <input required="" name="s" maxlength="40" autocomplete="off" class="searchinput input-search search-input" type="text" size="20" placeholder="<?php _e('Search...', 'nrglobal') ?>" aria-label="Search">
                                                        </div>
                                                        <button type="submit" class="btn-search btn" id="search-header-btn" aria-label="Search">
                                                            <svg version="1.1" class="svg search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 24 27" style="enable-background:new 0 0 24 27;" xml:space="preserve">
                                                                <path d="M10,2C4.5,2,0,6.5,0,12s4.5,10,10,10s10-4.5,10-10S15.5,2,10,2z M10,19c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7S13.9,19,10,19z"></path>
                                                                <rect x="17" y="17" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -9.2844 19.5856)" width="4" height="8"></rect>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
              <a class="header-cart" href="/gio-hang">
                <span class="text">Cart</span>
                <span class="count"><?php  echo WC()->cart->get_cart_contents_count() ?></span>
              </a>
            </div>
          </div>
        </div>
      </header>
    <header class="header-common-mobile">
        <div class="wrapper">
          <div class="header-wrapper">
            <a
              class="button-hamburger"
              data="hamburger-menu"
              href="#header-list-navigation__mobile"
            >
              <b></b>
              <b></b>
              <b></b>
            </a>
            <nav
              class="header-list-navigation__mobile"
              id="header-list-navigation__mobile"
            >
            <?php
                                            wp_nav_menu([
                                                'menu'           => 'gm-primary',
                                                'theme_location' => 'gm-primary',
                                                'container'      => false,
                                                'menu_class' => 'list-navigation',
                                                'walker'         => new Custom_Walker_Nav_Menu(),
                                            ])
                                        ?>

            </nav>
            <a class="trans logo-header-primary" href="#">
            <img  src="<?php theOPtionImage('desktop_logo') ?>" alt="<?php theOption('ten_cong_ty') ?>" class="object-common">
            </a>

            <div class="header-right">
            <div class="header-action header-action_search">
                                    <div class="header-action_text">
                                        <a class="header-action__link header-action-toggle" href="javascript:void(0)" id="site-search-handle" aria-label="Search" title="Search">
                                            <span class="box-icon">
                                             <svg class="svg-ico-search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 24 27" style="enable-background:new 0 0 24 27;" xml:space="preserve">
                                                    <path d="M10,2C4.5,2,0,6.5,0,12s4.5,10,10,10s10-4.5,10-10S15.5,2,10,2z M10,19c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7S13.9,19,10,19z"></path>
                                                    <rect x="17" y="17" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -9.2844 19.5856)" width="4" height="8"></rect>
                                                </svg>
                                                <span class="box-icon--close">
                                                    <svg viewbox="0 0 19 19" role="presentation">
                                                        <path d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z" fill="currentColor" fill-rule="evenodd"></path>
                                                    </svg>
                                            </span> 
                                        </a>
                                    </div>
                                    <div class="header-action_dropdown">
                                        <span class="box-triangle">
                                            <svg viewbox="0 0 20 9" role="presentation">
                                                <path d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z" fill="#ffffff"></path>
                                            </svg>
                                        </span>
                                        <div class="header-dropdown_content">
                                            <p class="ttbold">Search</p>
                                            <div class="site_search">
                                                <div class="search-box wpo-wrapper-search">
                                                    <form action="/" class="searchform searchform-categoris ultimate-search" method="get">
                                                        <div class="wpo-search-inner">
                                                            <input type="hidden" name="post_type" value="product">
                                                            <input required="" name="s" maxlength="40" autocomplete="off" class="searchinput input-search search-input" type="text" size="20" placeholder="<?php _e('Search...', 'nrglobal') ?>" aria-label="Search">
                                                        </div>
                                                        <button type="submit" class="btn-search btn" id="search-header-btn" aria-label="Search">
                                                            <svg version="1.1" class="svg search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 24 27" style="enable-background:new 0 0 24 27;" xml:space="preserve">
                                                                <path d="M10,2C4.5,2,0,6.5,0,12s4.5,10,10,10s10-4.5,10-10S15.5,2,10,2z M10,19c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7S13.9,19,10,19z"></path>
                                                                <rect x="17" y="17" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -9.2844 19.5856)" width="4" height="8"></rect>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
              <a class="header-cart" href="/gio-hang">
                <span class="text">Cart</span>
                <span class="count"><?php  echo WC()->cart->get_cart_contents_count() ?></span>
              </a>
            </div>
          </div>
        </div>
      </header>
