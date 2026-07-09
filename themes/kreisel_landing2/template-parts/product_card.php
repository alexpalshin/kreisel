<?php
global $post;

$category = get_the_terms( $post, 'products' );
$root_category = array();
foreach ($category as $cat) {
    if ($cat->parent == 0) {
        $root_category = $cat;
    }
}
if (!empty($root_category)) {
    $root_cat = get_term_by('id', $root_category->term_id, 'products');
	$cat_color = get_field( 'category_color', $root_cat );
} else {
    $cat_color = '#012597';
}
?>
<div class="col-xl-2 col-md-3 col-6 card-wrap">
	<div class="card product-card">
		<!--<div class="card_bookmark"> <a class="link-bookmark" href="#">
				<div class="card_icon-round">
					<svg height="19" viewBox="0 0 20 19" width="20" xmlns="http://www.w3.org/2000/svg" aria-label="Symbol einen Stern der Bewertung darstellt" class="svg-icon">
						<path d="M10,15.3l6.2,3.7l-1.6-7L20,7.2l-7.2-0.6L10,0L7.2,6.6L0,7.2L5.5,12l-1.6,7L10,15.3z"></path>
					</svg>
				</div>
			</a> </div>-->
		<div class="card-mediacontainer" style="border-color: <?php echo $cat_color; ?>">
			<figure> <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php the_title() ?>"> </figure>
		</div>
		<h4 class="card-title"><?php the_title() ?></h4>
		<p class="card-text"><?php the_content(); ?></p>
		<div class="card-linkwrapper">
            <a class="produktlink" href="<?php the_permalink(); ?>">К продукту</a>
        </div>
	</div>
</div>
