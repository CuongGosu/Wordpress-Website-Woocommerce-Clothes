<?php

use SocialLinks\Page;

$page = new Page([
    'url'   => get_the_permalink(),
    'title' => get_the_title(),
    'text'  => get_the_excerpt(),
    'image' => get_the_post_thumbnail_url('full'),
]);
?>

<ul class="text-right gaumap-sharebox">
	<li class="facebook">
		<a href="javascript:"
		   onclick="window.open('<?php echo $page->facebook->shareUrl ?>','Chia sẻ bài viết','width=600,height=600,top=150,left=250'); return false;"><i class="fa fa-facebook-f"></i> Facebook</a>
	</li>
	<li class="twitter">
		<a href="javascript:"
		   onclick="window.open('<?php echo $page->twitter->shareUrl ?>','Chia sẻ bài viết','width=600,height=600,top=150,left=250'); return false;"><i class="fa fa-twitter"></i> Twitter</a>
	</li>
	<li class="google">
		<a href="javascript:"
		   onclick="window.open('<?php echo $page->plus->shareUrl ?>','Chia sẻ bài viết','width=600,height=600,top=150,left=250'); return false;"><i class="fa fa-google-plus"></i> Google</a>
	</li>
	<li class="pinterest">
		<a href="javascript:"
		   onclick="window.open('<?php echo $page->pinterest->shareUrl ?>','Chia sẻ bài viết','width=600,height=600,top=150,left=250'); return false;"><i class="fa fa-pinterest-p"></i> Pinterest</a>
	</li>
</ul>

<style>
	.gaumap-sharebox
	{
		display         : flex;
		align-items     : center;
		justify-content : flex-start;
	}

	.gaumap-sharebox li
	{
		margin-right : 5px;
		padding      : 2px 10px;
		border-radius: 5px;
	}

	.gaumap-sharebox li.twitter
	{
		background : #1da1f2;
	}

	.gaumap-sharebox li.google
	{
		background : #dd4b39;
	}

	.gaumap-sharebox li.facebook
	{
		background : #3b5998;
	}

	.gaumap-sharebox li.pinterest
	{
		background : #bd081c;
	}

	.gaumap-sharebox li a
	{
		color : #ffffff;
	}
</style>