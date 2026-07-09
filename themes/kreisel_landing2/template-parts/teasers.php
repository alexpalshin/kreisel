<?php
if (isset($args)):

$background_image   = $args['section']['section_background']['background_image'];
$cols               = $args['section']['number_in_row'];
$cards              = $args['section']['card_item'];

$background_type    = $args['section']['section_background']['background_type'];
$background_color   = $args['section']['section_background']['background'];
$bg_position        = $args['section']['section_background']['bg_position'];

$bg_class = krl_get_bg_class( $background_type,$background_color,$bg_position );

$cols_class = krl_get_column_class($cols);

?>

<div class="component-container <?php echo $bg_class['bg_color']; ?>">
    <?php if (!empty($background_image)): ?>
        <div class="<?php echo $bg_class['bg_pos']; ?>">
            <img src="<?php echo $background_image['alt']; ?>" width="1600" height="809" alt="<?php echo $background_image['alt']; ?>"/>
        </div>
    <?php endif; ?>
    <div class="container content-container">
        <h2 class="text-center"><?php echo $args['section']['title']; ?></h2>
        <div class="teaser-container teaser50">
            <div class="row">
                <?php if (is_array($cards)) foreach ($cards as $card):
	                $noimage = false;
	                if (empty($card['image'])) $noimage = true;
	                ?>
                    <div class="<?php echo $cols_class; ?> teaser">
                        <div class="card <?php if ($card['blue_bg']) echo "bg-color"?>">
                            <?php if (!empty($card['label'])): ?>
                                <div class="teaser-label"><?php echo $card['label']; ?></div>
                            <?php endif; ?>
                            <div class="teaser-mediacontainer <?php if ($noimage) echo "noimage"; ?>">
                                <img src="<?php if (!empty($card['image'])): echo $card['image']['sizes']['large']; else: echo get_theme_file_uri()."/dist/images/white_box.jpg"; endif; ?>"  alt="<?php echo $card['image']['alt']; ?>">
                            </div>
                            <div class="card-body">
	                            <?php if (!empty($card['pretitle'])): ?>
                                    <p class="card-topline"><?php echo $card['pretitle']; ?></p>
	                            <?php endif; ?>
                                <h4 class="card-title"><?php echo $card['title']; ?></h4>
                                <div class="p card-text"><?php echo $card['text']; ?></div>
                            </div>
                            <div class="card-footer">
                                <?php if (!empty($card['link_text'])): ?>
                                    <a href="<?php echo $card['link_url']; ?>"><?php echo $card['link_text']; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php if (!empty($args['button']['text'])): ?>
        <div class="component-container-footer"><a class="btn btn-blue" href="<?php echo $args['button']['url']; ?>"><?php echo $args['button']['text']; ?></a></div>
    <?php endif; ?>
</div>

<?php endif; ?>