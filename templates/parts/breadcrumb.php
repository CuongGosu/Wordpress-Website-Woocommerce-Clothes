<?php

if (function_exists('yoast_breadcrumb') && get_option('_use_yoast_breadcrumb') === 'yes') {
?>
		<div class="breadcrumb-shop">
        	<div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5  ">
					<?php yoast_breadcrumb('<div id="page-breadcrumb" class="breadcrumb breadcrumb-arrows">', '</div>');?>
				</div>
            </div>
        </div>
    </div>

<?php } else {
    $title = getPageTitle(); ?>
	<div class="breadcrumb-shop">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5  ">
                    <ol class="breadcrumb breadcrumb-arrows" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a href="/" target="_self" itemprop="item"><span itemprop="name"><?php _e('Trang chủ', 'nrglobal') ?></span></a>
                            <meta itemprop="position" content="1">
                        </li>
                        <li class="active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <span itemprop="item" content="https://mare.vn/pages/about-us"><span itemprop="name"><?php echo $title ?></span></span>
                            <meta itemprop="position" content="2">
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php }