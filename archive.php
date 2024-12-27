<?php get_header() ?>

<main class="mainContent-theme ">
    <div id="blog">
        <?php theBreadcrumb() ?>
        <div class="wrapper-row pd-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                        <div class="sidebar-blog">
                            <div class="menu-blog">
                                <div class="group-menu">
                                    <div class="sidebarblog-title title_block">
                                        <h2><?php _e(get_nav_name('gm-product'), 'nrglobal') ?><span class="fa fa-angle-down"></span></h2>
                                    </div>
                                    <div class="layered layered-category">
                                        <?php
				                            wp_nav_menu([
				                                'menu'           => 'gm-product',
				                                'theme_location' => 'gm-product',
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
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="heading-page clearfix">
                            <h1><?php thePageTitle() ?></h1>
                        </div>
                        <div class="blog-content">
                            <div class="list-article-content blog-posts">
                                <!-- Begin: Nội dung blog -->
                                <?php
                                	if(have_posts()){
                                		while(have_posts()): the_post();
                                			template('loop/post');
                                		endwhile;
                                		wp_reset_postdata();
                                		wp_reset_query();
                                	}else{
                                        template('loop/none');
                                    }
                                ?>
                            </div>
                            <?php thePagination() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer() ?>