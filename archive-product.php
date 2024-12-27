<?php get_header() ?>

 <main class="mainContent-theme ">
    <div id="collection" class="collection-page">
        <?php theBreadcrumb() ?>
        <div class="main-content ">
            <div class="container-fluid">
                <div class="row">
                    <div id="collection-body" class="wrap-collection-body clearfix">
                        <div class="col-md-3 col-sm-12 col-xs-12 sidebar-fix">
                            <div class="wrap-filter">
                                <div class="box_sidebar">
                                    <div class="block left-module">
                                        <div class=" filter_xs">
                                            <div class="layered">
                                                <div class="group-menu">
                                                    <div class="sidebarblog-title title_block visible-sm visible-xs">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="wrap-collection-title row">
                                <div class="heading-collection row">
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <h1 class="title">
                                            <?php woocommerce_page_title() ?>
                                        </h1>
                                        <div class="alert-no-filter"></div>
                                    </div>
                                    <div class="col-md-4 hidden-sm hidden-xs">
                                        <div class="option browse-tags">
                                            <label class="lb-filter hide" for="sort-by">Sắp xếp theo:</label>
                                            <?php woocommerce_catalog_ordering() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row filter-here ">
                                <div class="content-product-list product-list filter clearfix d-flex flex-wrap">
                                	<?php
	                                	if(have_posts()){
	                                		while(have_posts()): the_post();
	                                			template('loop/product');
	                                		endwhile;
	                                		wp_reset_postdata();
	                                		wp_reset_query();
	                                	}else{
                                            template('loop/none');
                                        }
	                                ?>
                                </div>
                                <div class="sortpagibar pagi clearfix text-center">
                                    <?php thePagination() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="text" class="hidden" id="coll-handle" value="(collectionid:product>0)">
    </div>
   
</main>

<?php get_footer() ?>