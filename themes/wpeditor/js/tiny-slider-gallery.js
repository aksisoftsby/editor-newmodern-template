/**
 * Tiny slider gallery in attachment page
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */	
(function( slider ) {
"use strict";
	var slider = tns({
		container: '.gmr-singlegallery',
		loop: true,
		gutter: 10,
		edgePadding: 30,
		controlsText: ['&nbsp;', '&nbsp;'],
		items: 3,
		lazyload: true,
		autoplay: true,
		autoplayButtonOutput: false,
		swipeAngle: false,
		mouseDrag: true,
		nav: false,
		responsive : {
			0 : {
				items : 1,
			},
			250 : {
				items : 2,
			},
			400 : {
				items : 2,
			},
			600 : {
				items : 2,
			},
			1000 : {
				items : 3,
			}
		}
	});
})( window.slider );
