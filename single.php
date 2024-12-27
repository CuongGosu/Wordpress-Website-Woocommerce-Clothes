
<main class="mainContent-theme ">
    <div id="article">
        <?php theBreadcrumb() ?>
        <div class=" wrapper-row pd-page">
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
                        <div class="content-page">
                            <div class="article-content">
                                <div class="box-article-heading clearfix">
                                    
                                    <h1 class="sb-title-article"><?php thePageTitle() ?></h1>
                                    <ul class="article-info-more">
                                        <li> Người viết: <?php the_author() ?> - <time pubdate=""><?php the_time('d.m.Y') ?></time></li>
                                        <li><i class="fa fa-file-text-o"></i><?php the_terms(get_the_ID(), 'category') ?> </li>
                                    </ul>
                                </div>
                                <div class="article-pages">
                                    <?php theContent() ?>
                                </div>
                                <div class="post-navigation">
                                	<?php
                                		$prev_post = get_adjacent_post(false, '', true);
                                        if(!empty($prev_post)) {
                                            echo '<span class="left"><a href="' . get_permalink($prev_post->ID) . '" title="">&larr; '.__('Bài trước', 'nrglobal').'</a></span>'; 
                                        }
                                		$next_post = get_adjacent_post(false, '', false);
                                        if(!empty($next_post)) {
                                            echo '<span class="right"><a href="' . get_permalink($next_post->ID) . '" title="">'.__('Bài sau', 'nrglobal').' &rarr;</a></span>'; 
                                        }
                                	?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer() ?>