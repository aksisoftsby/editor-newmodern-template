/**
 * Tiny slider for module
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */
(function (slider) {
  "use strict";
  var element = document.getElementById("moduleslide");
  if (typeof element != "undefined" && element != null) {
    var slider = tns({
      container: ".wpberita-moduleslide",
      loop: true,
      gutter: 10,
      controlsText: ["&nbsp;", "&nbsp;"],
      items: 4,
      lazyload: true,
      swipeAngle: false,
      mouseDrag: true,
      autoplay: true,
      autoplayButtonOutput: false,
      nav: false,
      responsive: {
        0: {
          items: 1,
        },
        250: {
          items: 2,
        },
        400: {
          items: 2,
        },
        600: {
          items: 3,
        },
        1000: {
          items: 4,
        },
      },
    });
  }
})(window.slider);

/**
 * Tiny slider for module
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */
(function (slider) {
  "use strict";
  var element = document.getElementById("moduleslide-2saja");
  if (typeof element != "undefined" && element != null) {
    var slider = tns({
      container: ".wpberita-moduleslide-2saja",
      loop: true,
      gutter: 10,
      controlsText: ["&nbsp;", "&nbsp;"],
      items: 2,
      lazyload: true,
      swipeAngle: false,
      mouseDrag: true,
      autoplay: true,
      autoplayButtonOutput: false,
      nav: false,
      responsive: {
        0: {
          items: 2,
        },
        250: {
          items: 1,
        },
        400: {
          items: 2,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    });
  }
})(window.slider);

var menuTopx;
var menuMainDiv;
var wpAdminBarTop = 0;
jQuery(document).ready(() => {
  if (window.innerWidth > 700) {
    menuMainDiv = jQuery("nav#main-nav.main-navigation");
    menuTopx = menuMainDiv.offset().top;
    if (jQuery("#wpadminbar").length > 0) {
      wpAdminBarTop = wpAdminBarTop + jQuery("#wpadminbar").height();
    }
    window.onscroll = function () {
      scrollFunction();
    };
    let scrollFunction = () => {
      if (
        document.body.scrollTop >= menuTopx ||
        document.documentElement.scrollTop >= menuTopx
      ) {
        menuMainDiv.css({
          position: "fixed",
          top: 0 + wpAdminBarTop,
          width: "100%",
          left: 0,
        });
      } else {
        menuMainDiv.css({
          position: "",
          top: "",
          left: "",
          width: "",
        });
      }
    };
  }
});
