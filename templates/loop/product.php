<div class="<?php echo (is_shop() || is_tax('product_cat') ) ? 'col-md-3 col-sm-6 col-xs-6 pro-loop col-4' : 'col-md-4 col-sm-6 col-xs-6 pro-loop' ?> ">
    <div class="product-block product-resize ">
        <div class="product-img ">
            <?php
                $stock = get_post_meta( get_the_ID(), '_stock_status', true );
                if($stock == 'outofstock'){
            ?>
            <div class="sold-out"><span><?php _e('Hết hàng', 'nrglobal') ?></span></div>
            <?php } ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="image-resize ratiobox">
                <picture>
                    <img class="lazyload img-loop"  src="<?php thePostThumbnailUrl() ?>" alt="<?php the_title() ?>">
                </picture>
                <?php
                    global $product;
                    $attachment_ids = $product->get_gallery_attachment_ids(400,600);
                    if(count($attachment_ids) > 0) {
                        for ($i=0; $i < 1; $i++) {
                ?>
                            <picture>
                                 <img class="img-loop img-hover lazyload" src="<?php echo getImageUrlById($attachment_ids[$i], 400, 600) ?>" alt=" <?php the_title() ?>">
                               
                            </picture>
                <?php
                        }
                    }
                ?>
            </a>
           
            <div class="pro-price-mb">
                 <?php echo $product->get_price_html() ?>
            </div>
        </div>
        <div class="product-detail clearfix">
            <div class="box-pro-detail">
                <h3 class="pro-name">
                    <a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
                        <?php the_title() ?>
                    </a>
                </h3>
                <div class="box-pro-prices">
                    <?php echo $product->get_price_html() ?>
                </div>
            </div>
        </div>
    </div>
</div>