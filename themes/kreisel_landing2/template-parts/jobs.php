<?php
if (isset($args)):
?>

<div class="component-container bg-orientation-left" style="">
	<!-- default -->
	<div class="container content-container">
        <h2 class="text-center"><?php echo $args['section']['title']; ?></h2>
		<div class="tx-fixitjobs">
			<div id="fixitjobs" class="container">
				<ul class="row tx-fixitjobs-listView">
                    <?php
                    $args = array(
                        'post_type' => 'jobs',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );
                    $jobs = new WP_Query( $args );

                    while ( $jobs->have_posts() ) : $jobs->the_post();
	                    $contact = get_field('contact_person')
                    ?>
                        <li class="tx-fixitjobs-jobitem singleItem">
                            <div class="p" style="margin-bottom: 0">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?><br>

                                    <?php echo $contact['office_name']?>
                                </a>
                            </div>
                        </li>
                    <?php

                    endwhile;

                    wp_reset_postdata();
                    ?>

				</ul>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>