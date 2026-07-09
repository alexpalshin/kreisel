<?php
if (isset($args)):

$background_image   = $args['section']['section_background']['background_image'];

$reduced            = $args['section']['reduced_width'];
$background_type    = $args['section']['section_background']['background_type'];
$background_color   = $args['section']['section_background']['background'];
$bg_position        = $args['section']['section_background']['bg_position'];
$title              = $args['section']['text']['header'];
$text_cols          = $args['section']['text']['text_col'];

$bg_class = krl_get_bg_class( $background_type,$background_color,$bg_position );
?>
<div class="component-container <?php echo $bg_class['bg_color'] ?>">
    <?php if (!empty($background_image) && $args['section']['section_background']['background_type'] == 'image') { ?>
        <div class="<?php echo $bg_class['bg_pos'] ?>">
            <img
                    src="<?php echo $background_image['sizes']['2048x2048']; ?>"
                    width="1600" height="774"
                    alt="<?php echo $background_image['alt']; ?>">
        </div>
    <?php } ?>
    <div class="container content-container <?php if ($reduced) echo "reduce"; ?>">
        <h2><?php echo $title; ?></h2>
        <div class="row">
            <?php if(is_array($text_cols)) foreach ($text_cols as $text_col) : ?>
                <div class="col">
                    <div class="p"><?php echo $text_col['text']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php endif; ?>