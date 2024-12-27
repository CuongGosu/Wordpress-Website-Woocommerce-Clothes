<?php 
if ( !is_checkout()){
get_header(); ?>
<main class="mainContent-theme ">
    <div class="pageAbout-us page-layout">
        <?php theBreadcrumb() ?>
        <div class=" wrapper-row pd-page">
            <div class="container-fluid">
                <div class="row">
                    <?php
                        if(!is_cart() &&!is_checkout() ):
                    ?>
                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                        <div class="sidebar-blog">
                            <div class="menu-blog">
                                <div class="group-menu">
                                    <div class="page_menu_title title_block">
                                        <h2><?php _e(get_nav_name('gm-sidebar'), 'nrglobal') ?></h2>
                                    </div>
                                    <div class="layered layered-category">
                                        <?php
                                            wp_nav_menu([
                                                'menu'           => 'gm-sidebar',
                                                'theme_location' => 'gm-sidebar',
                                                'container'      => false,
                                                'menu_class' => 'tree-menu',
                                                'depth' => 1
                                            ])
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-<?php if(is_cart() || is_checkout()){echo '12';}else{echo '9';} ?> col-sm-12 col-xs-12">
                        <div class="content-page">
                            <div class="article-content">
                                <div class="box-article-heading clearfix">
                                    <h1 class="sb-title-article"><?php thePageTitle() ?></h1>
                                </div>
                                <div class="article-pages">
                                    <?php theContent() ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php get_footer();
}
else
    {
        if(is_wc_endpoint_url( 'order-received' )){
            get_header(); ?>
<main class="mainContent-theme ">
    <div class="pageAbout-us page-layout">
        <div class=" wrapper-row pd-page">
            <div class="container-fluid">
                <div class="row">
                    <?php
                        if(!is_cart() &&!is_checkout() ):
                    ?>
                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                        <div class="sidebar-blog">
                            <div class="menu-blog">
                                <div class="group-menu">
                                    <div class="page_menu_title title_block">
                                        <h2><?php _e(get_nav_name('gm-sidebar'), 'nrglobal') ?></h2>
                                    </div>
                                    <div class="layered layered-category">
                                        <?php
                                            wp_nav_menu([
                                                'menu'           => 'gm-sidebar',
                                                'theme_location' => 'gm-sidebar',
                                                'container'      => false,
                                                'menu_class' => 'tree-menu',
                                                'depth' => 1
                                            ])
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-<?php if(is_cart() || is_checkout()){echo '12';}else{echo '9';} ?> col-sm-12 col-xs-12">
                        <div class="content-page">
                            <div class="article-content">
                                <div class="box-article-heading clearfix">
                                    <h1 class="sb-title-article"><?php thePageTitle() ?></h1>
                                </div>
                                <div class="article-pages">
                                    <?php theContent() ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php get_footer();
        }
        else{

        ?>
<!doctype html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
    <style>
      .woocommerce-form-coupon-toggle{
        display: none;
      }
    </style>
</head>
<?php
theContent();
    }
}

?>