<?php
get_header();

$responsibility             = get_field('responsibility');
$skills                     = get_field('skills');
$compensation               = get_field('compensation');
$contact_person             = get_field('contact_person');

?>

<?php if (have_posts()) : while(have_posts()) : the_post();?>

<figure class="single-job sectioned-page">

	<?php
	if ( !empty(get_the_post_thumbnail_url()) ) {
		$section['background_img'] = get_the_post_thumbnail_url();
	} else {
		$section['background_img'] = get_stylesheet_directory_uri() . '/dist/images/100_153755.jpg';
	}

	$section['title'] = get_the_title();
	$section['text'] = '';
	$section['button_text'] = '';
	$section['button_url'] = '';
	$section['title_position'] = false;

	echo get_template_part(
		'template-parts/banner',
		null,
		array(
			'section' => $section,
		));
	?>

    <div class="container content-container">
        <div class="component-container ">
            <div class="content-container">
                <div class="container col-md-10">
                    <div class="col job-property">
                        <div class="p">
                            <p><strong>Требования:</strong></p>
			                <?php echo $responsibility; ?>
                        </div>

                        <div class="p">
                            <p><strong>Обязанности:</strong></p>
			                <?php echo $skills; ?>
                        </div>

                        <div class="p">
                            <p><strong>Условия труда:</strong></p>
			                <?php echo $compensation; ?>
                        </div>

                        <div class="p">
                            Отправляйте резюме по электронной почте:<br>
                            <a href="mailto:<?php echo $contact_person['email'] ?>"><?php echo $contact_person['email'] ?></a>
                        </div>
                    </div>

                    <div class="pt-5"></div>

	                <?php
	                $section['contact_person'] = $contact_person;

	                echo get_template_part(
		                'template-parts/contact_map',
		                null,
		                array(
			                'section' => $section,
		                ));


	                echo get_template_part(
		                'template-parts/job_application',
		                null,
		                array ());


	                $section = array(
	                        'quote_image'   => '',
	                        'quote_text'    => $contact_person['phone'].'<br>'.$contact_person['email'],
	                        'quote_source'  => $contact_person['contact_name']
                    );

	                echo get_template_part(
		                'template-parts/quote',
		                null,
		                array (
		                        'section' => $section
                        ));
	                ?>


                </div>
            </div>
        </div>
    </div>
</figure>



<?php endwhile; endif;?>

<?php get_footer();?>
