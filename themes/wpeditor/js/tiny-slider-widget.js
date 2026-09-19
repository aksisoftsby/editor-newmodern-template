/**
 * Tiny slider widget
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */	

(function(){
	"use strict";

	var sl = document.querySelectorAll( '[data-token]' );
	
	sl.forEach( function( t ) {
		var token = t.dataset.token;
		var o = window['gmrobjslide' + token];
		var slider = tns({
			container: o.wgtclass,
			loop: true,
			gutter: 24,
			controlsText: ['&nbsp;', '&nbsp;'],
			items: o.number,
			lazyload: true,
			swipeAngle: false,
			mouseDrag: true,
			nav: false,
			autoplay: true,
			autoplayButtonOutput: false,
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
					items : o.number,
				}
			},
		});
	});
})();