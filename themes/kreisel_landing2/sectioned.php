<?php /* Template Name: Sectioned Page */ ?>
<?php get_header(); ?>

<figure class="sectioned-page">

    <?php
    if (post_password_required()) {
        ?>
        <div class="container">
	    <?php
        echo get_the_password_form();
        ?>
        </div>
        <?php
    } else {
	    $sections = get_field('sections');
	    $layouts = array_column($sections, 'acf_fc_layout');
	    foreach ($sections as $index => $section) {
		    $firstOfClass = (array_search($section['acf_fc_layout'], $layouts) == $index);
		    $lastOfClass = (array_search($section['acf_fc_layout'], array_reverse($layouts, true)) == $index);
		    echo get_template_part(
			    'template-parts/'.$section['acf_fc_layout'],
			    null,
			    array(
				    'section' => $section,
				    'firstOfClass' => $firstOfClass,
				    'lastOfClass' => $lastOfClass
			    ));
	    }

    }
    ?>

</figure>
<?php get_footer(); ?>
