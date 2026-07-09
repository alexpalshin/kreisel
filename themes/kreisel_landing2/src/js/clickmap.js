// JavaScript Document

// Clickmap
     $('.clickmap-item').one('click', (event) => {
          $(event.currentTarget).addClass('animate');
     }).on('click', (event) => {
         $(event.currentTarget).toggleClass('open').siblings().removeClass('open');
     });