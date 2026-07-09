<?php
if (isset($args)):
	$q                                  = $args['q'];
	$text_city_search                   = $args['text_city_search'];
	$text_download_category_search      = $args['text_download_category_search'];
	$button_text                        = $args['button_text'];
	$download_category                  = $args['download_category'];
?>
<div class="key-visual-textcontainer">
	<div class="pluginbox-container transparentbox">
        <h1>Загрузки</h1>

		<form class="search-form w-100" action="<?php echo get_permalink( get_the_ID() ) ?>" method="get">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="search-module">
                        <input name="q" class="text-input" type="text" placeholder="<?php echo $text_city_search ?>" value="<?php echo $q ?>"/>
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
                </div>
            </div>

			<div class="pt-4"></div>

			<div class="row">
                <div class="col-12 col-md-6 col-lg-4"></div>
				<div class="col-12 col-md-6 col-lg-4">
                    <div class="search-module">
                        <select class="form-select" name="download_category">
                            <option value=""><?php echo $text_download_category_search ?></option>
							<?php
							$download_categories = get_terms('download_category', [
								'hide_empty' => false,
								'parent' => 0,
							] );

							foreach ($download_categories as $cat):
								?>
                                <option value="<?php echo $cat->term_id; ?>" <?php if ($download_category == $cat->term_id) echo "selected"; ?>><?php echo $cat->name; ?></option>
							<?php
							endforeach;
							?>
                        </select>
                    </div>
                </div>
			</div>

			<div class="pt-4"></div>

			<div class="row">
				<div class="col-md-3 col-lg-4"></div>
				<div class="col-md-6 col-lg-4">
					<button type="submit" class="search-submit btn btn-default btn-blue d-block w-100">
                        <?php echo $button_text ?> <svg viewBox="0 0 24 24" class="svg-icon">
							<use xlink:href="#icon-magnifier">
								<symbol viewBox="0 0 24 24" id="icon-magnifier">
									<path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
								</symbol>
							</use>
						</svg>
					</button>
				</div>
			</div>

		</form>
	</div>
</div>
<?php endif; ?>