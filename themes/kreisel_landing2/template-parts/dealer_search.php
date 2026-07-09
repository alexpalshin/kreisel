<?php
if (isset($args)):
	$title              = $args['title'];
	$text               = $args['text'];
	$text_city_search   = $args['text_city_search'];
	$button_text        = $args['button_text'];
	$city_name          = $args['city_name'];
	$city_radius        = $args['city_radius'];
?>
	<div class="key-visual-textcontainer">
		<div class="pluginbox-container transparentbox">
			<h1><?php echo $title ?></h1>
			<div class="p"><?php echo $text ?></div>
			<form class="search-form" action="<?php echo get_permalink(get_the_ID()) ?>" method="get">

				<div class="search-module">

					<input class="w-100" type="text" name="dealer-title" placeholder="Название компании-дистрибьютора" value="<?php echo isset($_GET['dealer-title']) ? $_GET['dealer-title'] : ''; ?>">

					<div class="pt-4"></div>

					<select class="form-select" id="single_city_field" data-placeholder="<?php echo $text_city_search ?>" name="city-name">
						<option></option>
						<?php
						$cities = get_terms('dealer_city', [
							'hide_empty' => false,
							'parent' => 0,
						]);

						foreach ($cities as $city) {
						?>
							<option value="<?php echo $city->term_id; ?>" <?php if ($city_name == $city->term_id) echo "selected"; ?>><?php echo $city->name; ?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="pt-4"></div>

				<div class="row">
					<div class="col-12 col-md-3 col-lg-4"></div>
					<div class="col-12 col-md-6 col-lg-4">
						<select class="form-select form-control" name="city-radius">
							<option value="10" <?php if ($city_radius == 10) echo "selected"; ?>>10 km</option>
							<option value="50" <?php if ($city_radius == 50) echo "selected"; ?>>50 km</option>
							<option value="100" <?php if ($city_radius == 100) echo "selected"; ?>>100 km</option>
						</select>
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