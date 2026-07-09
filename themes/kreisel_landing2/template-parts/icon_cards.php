<?php
if (isset($args)):

$cols               = $args['section']['number_in_row'];
$cards              = $args['section']['card_item'];

$cols_class = krl_get_column_class($cols);

?>

<div class="component-container bg-white">
    <div class="container containerinner icons-container content-container  reduce">
        <h2 class="text-center"><?php echo $args['section']['title']; ?></h2>
        <div class="row">
        <?php if (is_array($cards)) foreach ($cards as $card):
        ?>
            <div class="<?php echo $cols_class; ?> icons-box">
                <div class="card">
                    <div class="icons-mediacontainer">
                        <img src="<?php if (!empty($card['image'])): echo $card['image']['sizes']['large']; else: echo get_theme_file_uri()."/dist/images/white_box.jpg"; endif; ?>"  alt="<?php echo $card['image']['alt']; ?>">
                    </div>
                    <div class="card-body text-center">
                        <h4 class="card-title"><?php echo $card['title']; ?></h4>
                        <div class="p card-text"><?php echo $card['text']; ?></div>
                    </div>
                    <div class="card-footer text-center">
	                    <?php if (!empty($card['link_text'])): ?>
                            <a href="<?php echo $card['link_url']; ?>"><?php echo $card['link_text']; ?></a>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
	    <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($args['button']['text'])): ?>
        <div class="component-container-footer"><a class="btn btn-blue" href="<?php echo $args['button']['url']; ?>"><?php echo $args['button']['text']; ?></a></div>
    <?php endif; ?>
</div>

<?php endif; ?>