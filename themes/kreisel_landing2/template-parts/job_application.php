<?php
$job_application = get_field('job_application', 'option');
?>

<div class="component-container bg-white">
    <div class="container <?php if ($args['section']['reduced_width']) echo "reduce"; ?>">
        <div class="row">
            <div class="topteaser-container">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-lg-8">
                            <div class="topteaser-mediacontainer">
                                <picture>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_215725.jpg" alt="">
                                </picture>
                            </div>
                        </div>
                        <div class="col-lg-4 textbox">
                            <?php if (!empty($job_application['label'])): ?>
                                <div class="teaser-label"><?php echo $job_application['label']; ?></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <p class="topline"><?php echo $job_application['pre_title']; ?></p>
                                <h3 class="card-title"><?php echo $job_application['title']; ?></h3>
                                <div class="p card-text"><?php echo $job_application['text']; ?></div>
                            </div>
                            <div class="card-footer">
                                <a href="#jobModal" class="btn btn-cta" data-bs-toggle="modal"><?php echo $job_application['button_text']; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalLabel">Заявка на вакансию</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<?php echo do_shortcode($job_application['job_form']); ?>
            </div>
        </div>
    </div>
</div>