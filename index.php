<?php get_header() ?>

<main class="mainContent-theme main-index">
	<?php
		template('parts/slider-home');
		dynamic_sidebar('home');
	?>
</main>


<?php get_footer() ?>