/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************!*\
  !*** ./src/js/custom.js ***!
  \**************************/
// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
  window.addEventListener('scroll', function () {
    if (window.scrollY > 50) {
      document.getElementById('navbar_top').classList.add('fixed-top'); // add padding top to show content behind navbar
      //document.getElementById('navbar_mobile').classList.add('fixed-top'); // add padding top to show content behind navbar

      navbar_height = document.querySelector('.navbar').offsetHeight;
      document.body.style.paddingTop = navbar_height + 'px';
    } else {
      document.getElementById('navbar_top').classList.remove('fixed-top'); // remove padding top from body
	  //document.getElementById('navbar_mobile').classList.remove('fixed-top');
      document.body.style.paddingTop = '0';
    }
  });
}); // DOMContentLoaded  end

document.addEventListener("DOMContentLoaded", function () {
  // make it as accordion for smaller screens
  if (window.innerWidth > 992) {
    document.querySelectorAll('.navbar .nav-item').forEach(function (everyitem) {
      everyitem.addEventListener('mouseover', function (e) {
        var el_link = this.querySelector('a[data-bs-toggle]');

        if (el_link != null) {
          var nextEl = el_link.nextElementSibling;
          el_link.classList.add('show');
          nextEl.classList.add('show');
        }
      });
      everyitem.addEventListener('mouseleave', function (e) {
        var el_link = this.querySelector('a[data-bs-toggle]');

        if (el_link != null) {
          var nextEl = el_link.nextElementSibling;
          el_link.classList.remove('show');
          nextEl.classList.remove('show');
        }
      });
    });
  } // end if innerWidth

}); // DOMContentLoaded  end


var items = document.querySelectorAll('.carousel .carousel-item');
items.forEach(function (el) {
  var minPerSlide = 5;
  var next = el.nextElementSibling;

  for (var i = 1; i < minPerSlide; i++) {
    if (!next) {
      // wrap carousel by using first child
      next = items[0];
    }

    var cloneChild = next.cloneNode(true);
    el.appendChild(cloneChild.children[0]);
    next = next.nextElementSibling;
  }
});
/******/ })()
;

function darken_screen(yesno){
  if( yesno == true ){
    document.querySelector('.screen-darken').classList.add('active');
  }
  else if(yesno == false){
    document.querySelector('.screen-darken').classList.remove('active');
  }
}
	
function close_offcanvas(){
  darken_screen(false);
  document.querySelector('.mobile-offcanvas.show').classList.remove('show');
  document.body.classList.remove('offcanvas-active');
}

function show_offcanvas(offcanvas_id){
  darken_screen(true);
  document.getElementById(offcanvas_id).classList.add('show');
  document.body.classList.add('offcanvas-active');
}

document.addEventListener("DOMContentLoaded", function(){
  
  document.querySelectorAll('[data-trigger]').forEach(function(everyelement){
    let offcanvas_id = everyelement.getAttribute('data-trigger');
    everyelement.addEventListener('click', function (e) {
      e.preventDefault();
          show_offcanvas(offcanvas_id);
    });
  });

  document.querySelectorAll('.close').forEach(function(everybutton){
    everybutton.addEventListener('click', function (e) { 
          close_offcanvas();
      });
  });

  document.querySelector('.screen-darken').addEventListener('click', function(event){
    close_offcanvas();
  });

}); 
// DOMContentLoaded  end

+function ($) {
  // Clickmap
  $('.clickmap-item').on('click', (event) => {
    $(event.currentTarget).addClass('animate');
  }).on('click', (event) => {
    $(event.currentTarget).toggleClass('open').siblings().removeClass('open');
  });


  $('.home-news .card .card-footer a').click(function (e) {
    e.preventDefault();
    $(this).parents('.card').find('.card-text').toggleClass('read-all');
    $(this).hide();
  });

  function goToByScroll(id){
    // Scroll
    $('html,body').animate({
          scrollTop: $(id).offset().top-50},
        'slow');
  }

  $('form.wpcf7-form').each(function () {
    $(this).find('input[name="loaded"]').val("loaded");
  });

  $(".slick").slick({
    prevArrow: $(".slick-control-prev"),
    nextArrow: $(".slick-control-next"),
    dots: true,
    mobileFirst: true,
    infinite: true,
    autoplay: false,
    autoplaySpeed: 1e4,
    pauseOnFocus: false,
    pauseOnHover: false,
    pauseOnDotsHover: false,
    focusOnSelect: true,
    adaptiveHeight: true
  });

  $(".carousel--centered").slick({dots:true,mobileFirst:true,slidesToShow:1,slidesToScroll:1,infinite:true,centerMode:true,variableWidth:true,centerPadding:0});

  $( '#single_city_field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    allowClear: true
  } );

  $( '#single_product_field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    allowClear: true
  } );

  $( '#project_location_field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    allowClear: true
  } );

  $( '#project_type_field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    allowClear: true
  } );

  $( '#construction_type_field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    allowClear: true
  } );


  $('.product-category-form .dropdown_list-item').on('click', function () {
    window.location.href = $(this).data('link');
  });

  $(document).ready(function () {
      $('.dropdown.products').each(function () {
        var current_cat_title = $(this).data('current-cat');
        var current_cat_color = $(this).data('color');

        if ( $(current_cat_title).length > 0) {
          $(this).find('.dropdown-toggle').html(current_cat_title);
          $(this).find('.dropdown-toggle').css('background-color', '#ffffff').css('color', current_cat_color).css('border-color', current_cat_color);
        }
    });
  });

  /* Load Featured articles via AJAX */

  $( 'button.ajax-nav' ).on('click', function (e) {
    e.preventDefault();

    var button          = $(this);
    var parent          = $(button).closest('.other-articles');
    var content         = $('#articlesWrapper');
    var $current_page   = $(content).attr('data-page') * 1;
    var $ppp            = $(content).attr('data-ppp') * 1;
    var $max_pages      = $(content).attr('data-pages') * 1;
    var $offset         = $(content).attr('data-offset') * 1;
    var $page           = 1;


    if ( !($(this).hasClass( 'inactive' )) ) {

      $page = $current_page + 1;

      if ($page === $max_pages) {
        $( button ).css('opacity','0').attr('disabled','disabled');
      }

      var $load_posts_data = {
        action: 'omf_more_post_ajax',
        security: localization.ajax_nonce,
        ppp: $ppp,
        page_num: $page,
        offset: $offset
      };

      if ( !($(parent).hasClass( 'loading' )) ) {

        $.ajax({
          type: 'post',
          url: localization.ajaxurl,
          data: $load_posts_data,
          beforeSend : function () {
            $(parent).addClass( 'loading' );
          },
          success: function (data) {
            var $data = $(data);
            if ($data.length) {
              var $newElements = $data.css({ opacity: 0 });
              $(content).attr( 'data-page', $page );
              $(content).attr( 'data-offset', $offset+$ppp );
              $(content).append($newElements);
              $newElements.animate({ opacity: 1 });
              $(parent).removeClass( 'loading' );

            } else {
              $(parent).removeClass( 'loading' ).addClass( 'post_no_more_posts' );
            }
          },
          error : function (jqXHR, textStatus, errorThrown) {
            console.log('Error');
            console.log(jqXHR);
          }
        });
      }

    } else {

      return false;

    }

  }).trigger('click');


  /* AJAX Search */

  $('input#s').on( 'keyup change', function (e) {
    e.preventDefault();
    var searchString = $(this).val();

    if(searchString.length > 2){
      $('#header_search_result').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
      $.ajax({
        url: localization.ajaxurl,
        type: 'POST',
        data:{
          'action':'omf_ajax_search',
          'security': localization.ajax_nonce,
          'term'  :searchString
        },
        success:function(result){
          $('#header_search_result').html(result);
        }
      });
    }


  });

}(jQuery);
