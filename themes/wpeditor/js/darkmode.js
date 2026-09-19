/**
 * Darkmode Button
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */

/* Dark Mode */
(function(){

	var root = document.body;
	var btn  = document.querySelector( '.darkmode-button' );

	var nightBtn = '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="currentColor"><path d="M12 16a4 4 0 0 0 0-8v8Z"/><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2Zm0 2v4a4 4 0 1 0 0 8v4a8 8 0 1 0 0-16Z" clip-rule="evenodd"/></g></svg>';

	var sunBtn = '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M5 5l1.5 1.5m11 11L19 19M2 12h2m16 0h2M5 19l1.5-1.5m11-11L19 5"/></g></svg>';

	var currentTheme = localStorage.getItem( 'theme' );
	if ( currentTheme == 'dark' ) {
		root.classList.toggle( 'dark-theme' );
		btn.innerHTML = sunBtn;
	} else if ( currentTheme == 'light' ) {
		btn.innerHTML = nightBtn;
	}

	if ( btn ) {
		btn.addEventListener(
			'click',
			function( e ) {
				e.preventDefault();
				/* root.classList.toggle( 'dark-theme' ); */
				root.classList.toggle( 'dark-theme' );
				if ( root.classList.contains( 'dark-theme' ) ) {
					btn.innerHTML = sunBtn;
					var theme     = 'dark';
				} else {
					btn.innerHTML = nightBtn;
					var theme     = 'light';
				}
				localStorage.setItem( 'theme', theme );
			}
		);
	}
})();
