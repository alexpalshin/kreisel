<?php
get_header();
?>

<div class="pt-2"></div>

<?php if (have_posts()) : while(have_posts()) : the_post();?>

	<div class="container">
        <h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>

<?php endwhile; endif;?>

<?php get_footer();?>
