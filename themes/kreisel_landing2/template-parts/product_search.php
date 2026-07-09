<?php
if (isset($args)):
	$title              = $args['title'];
    $button_text        = $args['button_text'];

	$root_category = get_terms( 'products', array(
		'hide_empty' => 0,
		'parent' => 0,
	) );


	if (!empty(get_queried_object()->term_id)) {
		if ( get_queried_object()->parent == 0 ) {
			$current_root_category = get_queried_object()->term_id;
			$current_sub_category = '';
		} else {
			$current_root_category = get_queried_object()->parent;
			$current_sub_category = get_queried_object()->term_id;
		}
    } else {
		$current_root_category = '';
		$current_sub_category = '';
		$sub_categories = array();
    }


	if (!empty($current_root_category)):
        $current_root_cat = get_term_by('id', $current_root_category, 'products');
        $current_root_category_name = $current_root_cat->name;
		$current_root_category_slug = $current_root_cat->slug;
        $current_root_category_color = get_field('category_color', $current_root_cat);
		$sub_categories = get_terms( 'products', array(
				'hide_empty' => 0,
				'parent' => $current_root_category
			)
		);
	endif;

	if (!empty($current_sub_category)):
        $current_sub_cat = get_term_by('id', $current_sub_category, 'products');
        $current_sub_category_name = $current_sub_cat->name;
	endif;

?>
<div class="key-visual-textcontainer">
	<div class="pluginbox-container transparentbox">
		<h1><?php echo $title ?></h1>
        <form class="search-form search-form-products" action="<?php echo home_url() ?>/products">
            <div class="search-module">
                <input name="q" class="text-input" type="text" placeholder="<?php echo $button_text ?>"/>
                <button type="submit" class="product-search-submit" tabindex="0">
                    <svg viewBox="0 0 24 24" class="svg-icon">
                        <use xlink:href="#icon-magnifier">
                            <symbol viewBox="0 0 24 24" id="icon-magnifier">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </symbol>
                        </use>
                    </svg>
                </button>
            </div>
        </form>

        <form class="product-category-form" value="product-category-form">
            <div class="dropdownbox">
                <div class="dropdown products">
                    <button class="btn btn-blue dropdown-toggle <?php if(!empty($current_root_cat)) echo "selected"; ?>" type="button" id="produktbereich" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,0" style="<?php if(!empty($current_root_cat)): ?>color: <?php echo $current_root_category_color;?>; background-color: #ffffff;<?php endif; ?> border-color: <?php echo $current_root_category_color ?>;">
                        <div class="dropdown-title-container"> <span><?php if ( !empty($current_root_category_name)): echo $current_root_category_name; else: ?>Категории продуктов<?php endif; ?></span> </div>
                    </button>
                    <ul class="dropdown-menu product-cat">
                        <li class="dropdown_list-item neutral" data-link="<?php echo home_url(); ?>/products">
                            <div class="product-category-container">
                                <div class="category-title-container">
                                    <svg viewBox="0 0 24 24" class="svg-icon reset-icon">
                                        <use xlink:href="#icon-close">
                                            <symbol viewBox="0 0 24 24" id="icon-close">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                    <span class="category-title">Категории продуктов</span>
                                </div>
                            </div>
                        </li>
                        <?php
                        foreach ($root_category as $item):
	                        $root_cat = get_term_by('id', $item->term_id, 'products');
	                        $cat_color = get_field( 'category_color', $root_cat );
                        ?>
                            <li class="dropdown_list-item" data-id="<?php echo $item->term_id ?>" data-color="<?php echo $cat_color ?>" data-link="<?php echo home_url(); ?>/prodcat/<?php echo $item->slug ?>">
                                <div class="product-category-container" style="background-color: <?php echo $cat_color ?>">
                                    <div class="category-title-container">
                                        <div class="product-category-color-marker" style="background-color: <?php echo $cat_color ?>"></div>
                                        <span class="category-title"><?php echo $item->name ?></span> </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
                if (!empty($sub_categories)):
                    ?>
                    <div class="dropdown products produktgruppen">
                        <button class="btn btn-blue dropdown-toggle" type="button" id="produktgruppen" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,0" style="background-color: #DF0020; border: 1px solid #DF0020;">
                            <div class="dropdown-title-container"> <span><?php if ( !empty($current_sub_category_name)): echo $current_sub_category_name; else: ?>Группы продуктов<?php endif; ?></span> </div>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="produktgruppe">
                            <li class="dropdown_list-item neutral" data-link="<?php echo home_url(); ?>/prodcat/<?php echo $current_root_category_slug; ?>">
                                <div class="dropdown_list-item-container">
                                    <svg viewBox="0 0 24 24" class="svg-icon reset-icon">
                                        <use xlink:href="#icon-close">
                                            <symbol viewBox="0 0 24 24" id="icon-close">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                            </symbol>
                                        </use>
                                    </svg>
                                    <span class="dropdown_list-item-title">Группы продуктов</span></div>
                            </li>
                            <?php foreach ($sub_categories as $category): ?>
                            <li class="dropdown_list-item" data-id="<?php echo $category->term_id ?>" data-link="<?php echo home_url(); ?>/prodcat/<?php echo $current_root_category_slug; ?>/<?php echo $category->slug ?>">
                                <div class="dropdown_list-item-container">
                                    <span class="dropdown_list-item-title"><?php echo $category->name ?></span>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </form>
	</div>
</div>
<?php endif; ?>