<?php
if (isset($args)):

    $title             = $args['section']['title'];
    $downloads         = $args['section']['downloads'];
	?>
    <div class="home-downloads component-container bg-white download-component-container">
        <div id="downloads" class="scroll-anchor"></div>
        <div class="container">
            <header>
                <h3 class="headline-center"><?php echo $title ?></h3>
            </header>
			<?php
			if (is_array($downloads)) foreach ($downloads as $download):
				if ( is_array($download['file']) ):
				?>
                <div class="downloads">
                    <div class="downloads-entry col-12">
                        <div class="downloads-title"><?php echo $download['file_title']; ?></div>
                        <div class="downloads-file-info">
                            <div class="downloads-file-extension"><?php echo $download['file']['subtype']; ?></div>
                            <div class="downloads-file-size"><?php echo number_format($download['file']['filesize']/1000000,2); ?> MB</div>
                        </div>
                        <!--<div class="downloads-link">
							<a href="">
								<svg class="svg-icon-download-link">
									<use xlink:href="#icon-rss">
										<svg viewBox="0 0 24 24" id="icon-rss" width="100%" height="100%">
											<circle cx="6.18" cy="17.82" r="2.18"></circle>
											<path d="M4 4.44v2.83c7.03 0 12.73 5.7 12.73 12.73h2.83c0-8.59-6.97-15.56-15.56-15.56zm0 5.66v2.83c3.9 0 7.07 3.17 7.07 7.07h2.83c0-5.47-4.43-9.9-9.9-9.9z"></path>
										</svg>
									</use>
								</svg>
								<span>Abonnieren</span>
							</a>
						</div>
						<div class="downloads-link">
							<a href="">
								<svg class="svg-icon-download-link">
									<use xlink:href="#icon-grade">
										<svg viewBox="0 0 20 19" id="icon-grade" width="100%" height="100%">
											<path d="M10 15.3l6.2 3.7-1.6-7L20 7.2l-7.2-.6L10 0 7.2 6.6 0 7.2 5.5 12l-1.6 7 6.1-3.7z"></path>
										</svg>
									</use>
								</svg>
								<span class="bookmarker-text-add">Zur Merkliste hinzufügen</span>
								<span class="bookmarker-text-remove">Von der Merkliste entfernen</span>
							</a>
						</div>-->
                        <div class="downloads-link">
                            <a href="<?php echo $download['file']['url']; ?>" target="_blank">
                                <svg class="svg-icon-download-link">
                                    <use xlink:href="#icon-download">
                                        <svg viewBox="0 0 24 24" id="icon-download" width="100%" height="100%">
                                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path>
                                        </svg>
                                    </use>
                                </svg>Скачать</a>
                        </div>
                    </div>
                </div>
				<?php
				endif;
			endforeach;
			?>
        </div>
    </div>

<?php endif; ?>