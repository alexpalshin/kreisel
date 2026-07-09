<?php
get_header();
?>

<?php if (is_single()) : ?>

    <div class="pt-5"></div>

	<?php if (have_posts()) : while(have_posts()) : the_post();?>

        <div class="container">
            <h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
        </div>

	<?php endwhile; endif;?>

    <div class="pt-5"></div>
    <div class="pt-5"></div>

<?php else: ?>

    <?php
	$archive_title = str_replace('Архивы','',get_the_archive_title());
	if (empty($archive_title)) $archive_title = 'Новости';
	$term = get_queried_object();
	$thumb = get_the_post_thumbnail_url($term->ID);
    ?>

    <div class="key-visual">
        <div class="key-visual-container">
            <?php if(!empty($thumb)): ?>
                <picture>
                    <img src="<?php echo $thumb; ?>" alt="key-visual">
                </picture>
            <? else: ?>
                <picture>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/key-visual.jpg" alt="key-visual">
                </picture>
            <?php endif; ?>
        </div>
        <div class="container">
            <div class="key-visual_border-headline"><h1><?php echo $archive_title; ?></h1></div>
        </div>
    </div>

    <div class="container teaser-container">
        <div class="row">
			<?php if (have_posts()) : while(have_posts()) : the_post();?>

                <?php
				global $post;
				$categories = get_the_category($post->ID);
                ?>

                <div class="col-12 col-md-3 col-xl-4 teaser">
                    <div class="card">
		                <?php if (!empty($categories)): ?>
                            <div class="teaser-label"><?php echo $categories[0]->name; ?></div>
		                <?php endif; ?>
                        <div class="teaser-mediacontainer">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php the_title() ?></h4>
                            <div class="p card-text"><?php the_excerpt(); ?></div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php the_permalink(); ?>">Читать далее</a>
                        </div>
                    </div>
                </div>

			<?php endwhile; endif;?>
        </div>
    </div>

    <div class="pt-5"></div>
    <div class="pt-5"></div>

<?php endif; ?>

<?php get_footer();?>
