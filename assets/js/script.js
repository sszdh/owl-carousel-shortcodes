/*jshint jquery:true */
/*global $:true */

var $ = jQuery.noConflict();

$(document).ready(function($) {
  "use strict";

  try {
    var owlWrap = $('.owl-wrapper');
    if (owlWrap.length > 0) {
      if (jQuery().owlCarousel) {

        owlWrap.each(function() {
        var carousel= $(this).find('.owl-carousel'),
            dataCentered = Boolean(carousel.attr('data-centered')) || false,
            dataRtl = Boolean(carousel.attr('data-rtl')) || false,
            dataNum = dataNum2 = dataNum3 = carousel.attr('data-num') || 1,
            dataNum2,
            dataNum3;
        
        if ( dataNum == 2 ) {
            dataNum2 = 2;
            dataNum3 = dataNum - 1;
        } else {
            dataNum2 = dataNum - 1;
            dataNum3 = dataNum - 2;
        }

        carousel.owlCarousel({
            rtl: dataRtl,
            margin:10,
            center: dataCentered,
            responsiveClass:true,
            autoplay: true,
            /*autoplayTimeout: 10000,*/
            autoplaySpeed: 1000,
            navSpeed: 1000,
            loop:true,
            responsive:{
              0 : {
                  items: 1
              },
              768: {
                  items: dataNum3
              },
              1024:{
                  items: dataNum2
              },
              1199: {
                  items: dataNum
              }
            },
            items : dataNum});
        });
      }
    }

  } catch(err) {
    console.log(err);
  }

});
