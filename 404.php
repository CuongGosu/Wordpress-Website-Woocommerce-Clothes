<?php get_header() ?>

<main class="mainContent-theme ">
    <div class="pageAbout-us page-layout">
        <?php theBreadcrumb() ?>
        <div class=" wrapper-row pd-page">
            <div class="container-fluid">
                <div class="row">
                
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="content-page">
                            <div class="article-content">
                                <div class="box-article-heading clearfix">
                                    <h1 class="sb-title-article"><?php thePageTitle() ?></h1>
                                </div>
                                <div class="article-pages">
                                    <img src="<?php echo get_template_directory_uri() . "/resources/images/404.png" ?>" alt="404">
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