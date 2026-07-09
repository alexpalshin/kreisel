<?php
if (isset($args)):
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
	                                <?php if (!empty($args['section']['image']['sizes'])): ?>
                                        <source media="(min-width:1200px)" srcset="<?php echo $args['section']['image']['sizes']['2048x2048']; ?>">
                                        <source media="(min-width:768px)" srcset="<?php echo $args['section']['image']['sizes']['large']; ?>">
                                        <source media="(min-width:320px)" srcset="<?php echo $args['section']['image']['sizes']['medium_large']; ?>">
                                        <img src="<?php echo $args['section']['image']['sizes']['1536x1536']; ?>" alt="<?php echo $args['section']['image']['alt']; ?>">
                                    <?php elseif (!empty($args['section']['image'])): ?>
                                        <img src="<?php echo $args['section']['image']; ?>" alt="<?php echo $args['section']['text']['header']; ?>">
	                                <?php endif; ?>
                                </picture>
                            </div>
                        </div>
                        <div class="col-lg-4 textbox">
                            <?php if (!empty($args['section']['text']['label'])): ?>
                                <div class="teaser-label"><?php echo $args['section']['text']['label']; ?></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <p class="topline"><?php echo $args['section']['text']['top_line']; ?></p>
                                <h3 class="card-title"><?php echo $args['section']['text']['header']; ?></h3>
                                <div class="p card-text"><?php echo $args['section']['text']['text']; ?></div>
                            </div>
                            <div class="card-footer">
	                            <?php if (!empty($args['section']['link']['link_text'])): ?>
                                    <a href="<?php echo $args['section']['link']['link_url']; ?>" class="btn btn-green"><?php echo $args['section']['link']['link_text']; ?></a>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>