/**
 * Tiny slider for module
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */
(function( slider ) {
"use strict";
	var element = document.getElementById( 'moduleslidebig' );
	if ( typeof( element ) != 'undefined' && element != null ) {
		var slider = tns({
			container: '.wpberita-moduleslidebig',
			loop: true,
			gutter: 0,
			controls: false,
			items: 1,
			lazyload: true,
			swipeAngle: false,
			mouseDrag: true,
			autoplay: true,
			autoplayButtonOutput: false,
			nav: true,
			responsive : {
				0 : {
					items : 1,
				},
				250 : {
					items : 1,
				},
				400 : {
					items : 1,
				},
				600 : {
					items : 1,
				},
				1000 : {
					items : 1,
				}
			}
		});
	}
})( window.slider );
