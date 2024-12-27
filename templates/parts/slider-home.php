<?php
    if(getOption('main_slider')){
?>
    <div id="home-slider">
        <div id="homepage_slider" class="owl-carousel owl-theme">
            <?php foreach(getOption('main_slider') as $main_slider): ?>
            <div class="item ">
                <a href="<?php echo ($main_slider['link'] !='') ? $main_slider['link'] : 'javascript:void(0)'; ?>">
                    <img src="<?php echo getImageUrlById($main_slider['image']) ?>" alt="<?php echo get_the_title($main_slider['image']) ?>">
                </a>
            </div>
        <?php endforeach; ?>
        </div>
        <div id="homepage_slider_mobile" class="owl-carousel owl-theme">
            <?php foreach(getOption('mobile_slider') as $mobile_slider): ?>
            <div class="item ">
                <a href="<?php echo ($mobile_slider['link'] !='') ? $mobile_slider['link'] : 'javascript:void(0)'; ?>">
                    <img src="<?php echo getImageUrlById($mobile_slider['image']) ?>" alt="<?php echo get_the_title($mobile_slider['image']) ?>">
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php } ?>