</div><!-- / MAINCONTENT -->
<footer>
    <?php
    $footer_contacts = get_field('footer_contacts', 'option');
    ?>
    <div class="footer-container bg-white">
        <div class="container container-inner">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="footerimage"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_207181.jpg" width="618" height="413" alt=""/></div>
                        </div>
                        <div class="col-lg-8">
                            <h2><?php echo $footer_contacts['contact_1']['title']; ?></h2>
                            <div class="p">
                                <?php echo $footer_contacts['contact_1']['text']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="footerimage"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/100_207204.jpg" width="618" height="413" alt=""/></div>
                        </div>
                        <div class="col-lg-8">
                            <h2><?php echo $footer_contacts['contact_2']['title']; ?></h2>
                            <div class="p">
		                        <?php echo $footer_contacts['contact_2']['text']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footernav">
        <div class="container">
            <div class="row">
                <div class="logo col-md-6">
                    <div class="footerlogo">
                        <a href="https://www.fixit-gruppe.com" target="_blank">FIXIT GRUPPE
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 247.6 46.7" class="svg-logo">
                                <polygon fill="#FFFFFF" points="0,1 22.7,1 22.7,10.2 10.2,10.2 10.2,11.3 22.7,11.3 22.7,19 10.2,19 10.2,27.8 0,27.8 "/>
                                <rect x="24" y="1" fill="#FFFFFF" width="10.4" height="26.8"/>
                                <rect x="67.3" y="1" fill="#FFFFFF" width="10.4" height="26.8"/>
                                <polygon fill="#FFFFFF" points="50,6.6 50,22.6 46.5,27.9 34.8,27.9 43.4,14.3 34.9,1 46,1 "/>
                                <polygon fill="#FFFFFF" points="79,1 103.5,1 103.5,10.5 96.1,10.5 96.1,27.8 85.5,27.8 85.5,10.5 79,10.5 "/>
                                <polygon fill="#FFFFFF" points="54.1,26.5 55,27.8 66.7,27.8 65.8,26.5 "/>
                                <polygon fill="#FFFFFF" points="52.8,24.5 53.6,25.7 65.4,25.7 64.6,24.5 "/>
                                <polygon fill="#FFFFFF" points="51.5,22.6 52.3,23.8 64.1,23.8 63.4,22.6 "/>
                                <polygon fill="#FFFFFF" points="51.5,20.6 51.5,21.8 62.9,21.8 62.2,20.6 "/>
                                <polygon fill="#FFFFFF" points="51.5,18.7 51.5,19.9 61.7,19.9 60.9,18.7 "/>
                                <polygon fill="#FFFFFF" points="51.5,16.7 51.5,17.9 60.5,17.9 59.7,16.7 "/>
                                <polygon fill="#FFFFFF" points="51.5,14.7 51.5,16 59.2,16 58.5,14.7 "/>
                                <polygon fill="#FFFFFF" points="51.5,12.8 51.5,14 58.3,14 59.1,12.8 "/>
                                <polygon fill="#FFFFFF" points="51.5,10.8 51.5,12 59.5,12 60.3,10.8 "/>
                                <polygon fill="#FFFFFF" points="51.5,8.9 51.5,10.1 60.8,10.1 61.5,8.9 "/>
                                <polygon fill="#FFFFFF" points="51.5,6.9 51.5,8.1 62,8.1 62.8,6.9 "/>
                                <polygon fill="#FFFFFF" points="52.6,5 51.8,6.2 63.3,6.2 64,5 "/>
                                <polygon fill="#FFFFFF" points="54,3 53.2,4.2 64.5,4.2 65.3,3 "/>
                                <polygon fill="#FFFFFF" points="55.5,1 54.5,2.3 65.7,2.3 66.6,1 "/>
                                <rect x="0" y="31.3" fill="#FFFFFF" width="247.6" height="1.3"/>
                                <path fill="#FFFFFF" d="M133.8,24.1c-2.1,2.8-5.5,4-8.6,4c-8,0-12.8-6.5-12.8-13.5c0-7.8,4.3-14.6,12.8-14.6c5.9,0,10.5,2.6,11.5,8.9
	h-3.6c-0.7-4.1-4-5.9-8-5.9c-6.5,0-9.2,5.6-9.2,11.4c0,5.6,3.2,10.7,9.2,10.7c5.5,0,8.8-3.9,8.6-8.8h-8.6v-3H137v14.1h-2.3
	L133.8,24.1z"/>
                                <path fill="#FFFFFF" d="M150.3,13c3.3,0,6.2-0.9,6.2-4.8c0-2.6-1.4-4.6-4.8-4.6h-8.9V13H150.3z M139.3,0.6h12.6c5,0,8.2,2.7,8.2,7
	c0,3.2-1.4,5.9-4.7,6.8v0.1c3.1,0.6,3.8,2.9,4,5.5c0.2,2.6,0.1,5.6,1.6,7.4h-4c-1-1.1-0.5-4-1-6.6c-0.4-2.6-1-4.9-4.5-4.9h-8.7v11.5
	h-3.6V0.6z"/>
                                <path fill="#FFFFFF" d="M183.5,17.8c0,6.8-3.9,10.3-10.6,10.3c-6.9,0-11-3.2-11-10.3V0.6h3.6v17.2c0,4.7,2.7,7.3,7.4,7.3
	c4.5,0,7-2.6,7-7.3V0.6h3.6V17.8z"/>
                                <path fill="#FFFFFF" d="M189.8,13.5h7c4,0,5.9-1.7,5.9-4.9c0-3.2-1.8-4.9-5.9-4.9h-7V13.5z M186.2,0.6H198c5.3,0,8.2,3,8.2,7.9
	s-2.9,8-8.2,7.9h-8.2v11h-3.6V0.6z"/>
                                <path fill="#FFFFFF" d="M211.1,13.5h7c4,0,5.9-1.7,5.9-4.9c0-3.2-1.8-4.9-5.9-4.9h-7V13.5z M207.6,0.6h11.8c5.3,0,8.2,3,8.2,7.9
	s-2.9,8-8.2,7.9h-8.2v11h-3.6V0.6z"/>
                                <polygon fill="#FFFFFF" points="228.9,0.6 247.5,0.6 247.5,3.6 232.5,3.6 232.5,12.2 246.5,12.2 246.5,15.2 232.5,15.2 232.5,24.5
	247.6,24.5 247.6,27.5 228.9,27.5 "/>
                                <path fill="#FFFFFF" d="M1.8,45H5c1.1,0,1.7-0.6,1.7-1.6c0-1-0.6-1.6-1.7-1.6H1.8V45z M1.8,40.4h3c0.9,0,1.5-0.5,1.5-1.4
	c0-1-0.5-1.4-1.5-1.4h-3V40.4z M0,36.1h5.1c1.9,0,3.1,0.8,3.1,2.6c0,1-0.5,1.8-1.5,2.2v0c1.3,0.3,2,1.3,2,2.7c0,1.6-1.1,2.9-3.8,2.9
	H0V36.1z"/>
                                <path fill="#FFFFFF" d="M16,42.4h3.2l-1.6-4.5h0L16,42.4z M16.7,36.1h1.9l4,10.4h-2l-1-2.8h-4.2l-1,2.8h-1.9L16.7,36.1z"/>
                                <path fill="#FFFFFF" d="M27.2,36.1h1.8v6.1c0,1.4,0.1,3,2.4,3c2.4,0,2.4-1.6,2.4-3v-6.1h1.8v6.7c0,2.7-1.7,4-4.3,4
	c-2.6,0-4.3-1.3-4.3-4V36.1z"/>
                                <path fill="#FFFFFF" d="M42.8,43c0,1.6,1.2,2.2,2.6,2.2c1.6,0,2.2-0.8,2.2-1.6c0-0.8-0.4-1.1-0.9-1.3c-0.7-0.3-1.7-0.5-3.1-0.9
	c-1.8-0.5-2.3-1.6-2.3-2.6c0-2.1,1.9-3.1,3.8-3.1c2.2,0,4,1.2,4,3.3h-1.8c-0.1-1.3-1-1.8-2.2-1.8c-0.8,0-1.9,0.3-1.9,1.4
	c0,0.7,0.5,1.1,1.2,1.3c0.2,0,2.5,0.6,3,0.8c1.4,0.4,2,1.6,2,2.7c0,2.3-2.1,3.3-4.1,3.3c-2.4,0-4.3-1.1-4.3-3.7H42.8z"/>
                                <polygon fill="#FFFFFF" points="53.8,36.1 62.2,36.1 62.2,37.7 58.9,37.7 58.9,46.5 57.1,46.5 57.1,37.7 53.8,37.7 "/>
                                <path fill="#FFFFFF" d="M68.4,41.3c0,2,0.9,4,3.2,4c2.2,0,3.2-2,3.2-4c0-2-0.9-4-3.2-4C69.3,37.3,68.4,39.3,68.4,41.3 M76.6,41.3
	c0,3-1.9,5.5-5,5.5s-5-2.5-5-5.5c0-3,1.9-5.5,5-5.5S76.6,38.3,76.6,41.3"/>
                                <polygon fill="#FFFFFF" points="82,36.1 89.1,36.1 89.1,37.7 83.8,37.7 83.8,40.4 88.5,40.4 88.5,41.9 83.8,41.9 83.8,46.5 82,46.5 "/>
                                <polygon fill="#FFFFFF" points="94.3,36.1 101.5,36.1 101.5,37.7 96.2,37.7 96.2,40.4 100.9,40.4 100.9,41.9 96.2,41.9 96.2,46.5
	94.3,46.5 "/>
                                <polygon fill="#FFFFFF" points="106.7,36.1 114.2,36.1 114.2,37.7 108.5,37.7 108.5,40.4 113.8,40.4 113.8,41.9 108.5,41.9 108.5,44.9
	114.3,44.9 114.3,46.5 106.7,46.5 "/>
                                <polygon fill="#FFFFFF" points="127.4,36.1 129.9,36.1 132.8,44.2 132.8,44.2 135.6,36.1 138.2,36.1 138.2,46.5 136.4,46.5 136.4,38.5
	136.4,38.5 133.5,46.5 132,46.5 129.1,38.5 129.1,38.5 129.1,46.5 127.4,46.5 "/>
                                <rect x="144.1" y="36.1" fill="#FFFFFF" width="1.8" height="10.4"/>
                                <polygon fill="#FFFFFF" points="150.9,36.1 159.3,36.1 159.3,37.7 156,37.7 156,46.5 154.2,46.5 154.2,37.7 150.9,37.7 "/>
                                <path fill="#FFFFFF" d="M173.2,43c0,1.6,1.2,2.2,2.6,2.2c1.6,0,2.2-0.8,2.2-1.6c0-0.8-0.4-1.1-0.9-1.3c-0.7-0.3-1.7-0.5-3.1-0.9
	c-1.8-0.5-2.3-1.6-2.3-2.6c0-2.1,1.9-3.1,3.8-3.1c2.2,0,4,1.2,4,3.3h-1.8c-0.1-1.3-1-1.8-2.2-1.8c-0.8,0-1.9,0.3-1.9,1.4
	c0,0.7,0.5,1.1,1.2,1.3c0.2,0,2.5,0.6,3,0.8c1.4,0.4,2,1.6,2,2.7c0,2.3-2.1,3.3-4.1,3.3c-2.4,0-4.3-1.1-4.3-3.7H173.2z"/>
                                <polygon fill="#FFFFFF" points="187.9,42.4 184,36.1 186.1,36.1 188.9,40.8 191.6,36.1 193.6,36.1 189.7,42.4 189.7,46.5 187.9,46.5
	"/>
                                <path fill="#FFFFFF" d="M199.6,43c0,1.6,1.2,2.2,2.6,2.2c1.6,0,2.2-0.8,2.2-1.6c0-0.8-0.4-1.1-0.9-1.3c-0.7-0.3-1.7-0.5-3.1-0.9
	c-1.8-0.5-2.3-1.6-2.3-2.6c0-2.1,1.9-3.1,3.8-3.1c2.2,0,4,1.2,4,3.3h-1.8c-0.1-1.3-1-1.8-2.2-1.8c-0.8,0-1.9,0.3-1.9,1.4
	c0,0.7,0.5,1.1,1.2,1.3c0.2,0,2.5,0.6,3,0.8c1.4,0.4,2,1.6,2,2.7c0,2.3-2.1,3.3-4.1,3.3c-2.4,0-4.3-1.1-4.3-3.7H199.6z"/>
                                <polygon fill="#FFFFFF" points="210.6,36.1 219,36.1 219,37.7 215.7,37.7 215.7,46.5 213.9,46.5 213.9,37.7 210.6,37.7 "/>
                                <polygon fill="#FFFFFF" points="223.9,36.1 231.4,36.1 231.4,37.7 225.8,37.7 225.8,40.4 231,40.4 231,41.9 225.8,41.9 225.8,44.9
	231.5,44.9 231.5,46.5 223.9,46.5 "/>
                                <polygon fill="#FFFFFF" points="236.8,36.1 239.4,36.1 242.3,44.2 242.3,44.2 245.1,36.1 247.6,36.1 247.6,46.5 245.9,46.5 245.9,38.5
	245.9,38.5 243,46.5 241.5,46.5 238.6,38.5 238.5,38.5 238.5,46.5 236.8,46.5 "/>
                            </svg>
                        </a></div>
                </div>
                <div class="col-md-6 footermenue">
	                <?php
	                wp_nav_menu(array(
		                'theme_location' => 'footer-menu',
		                'container' => false,
		                'menu_class' => '',
		                'fallback_cb' => '__return_false',
		                'depth' => 1
	                ));
	                ?>
                </div>
            </div>
        </div>

    </div>
</footer>

<!-- Feedback Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Обратная связь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode($footer_contacts['feedback_form']); ?>
            </div>
        </div>
    </div>
</div>


<?php wp_footer();?>
</body>
</html>
