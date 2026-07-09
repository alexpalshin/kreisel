<?php
if (isset($args)):
?>

<div class="component-container container">

    <!-- TEXT-BILD-->

    <div class="ce-textpic <?php if ($args['section']['image']['position'] == true): echo "ce-right"; else: echo "ce-left"; endif; ?> ce-intext ce-nowrap">
        <div class="ce-gallery">
            <div class="ce-row">
                <div class="ce-column">
                    <figure class="image">
                        <picture>
                            <source media="(min-width:1200px)" srcset="<?php echo $args['section']['image']['image']['sizes']['2048x2048']; ?>">
                            <source media="(min-width:768px)" srcset="<?php echo $args['section']['image']['image']['sizes']['large']; ?>">
                            <source media="(min-width:320px)" srcset="<?php echo $args['section']['image']['image']['sizes']['medium_large']; ?>">
                            <img src="<?php echo $args['section']['image']['image']['sizes']['1536x1536']; ?>" alt="<?php echo $args['section']['image']['caption']; ?>">
                        </picture>
                        <figcaption class="image-caption"><?php echo $args['section']['image']['caption']; ?></figcaption>
                    </figure>
                </div>
            </div>
        </div>
        <div class="ce-bodytext">
            <h2><?php echo $args['section']['text']['header']; ?></h2>
            <div class="p">
                <?php echo $args['section']['text']['text']; ?>
            </div>
            <?php if (!empty($args['section']['link']['link_text'])): ?>
                <div class="p"><a href="<?php echo $args['section']['link']['link_url']; ?>"><?php echo $args['section']['link']['link_text']; ?></a></div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php endif; ?>