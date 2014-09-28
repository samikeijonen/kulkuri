/**
 * Enable tab support for dropdown menus.
 */
( function() {
	var container, menu, links;

	container = document.getElementById( 'menu-primary' );
	if ( ! container )
		return;

	menu = container.getElementsByTagName( 'ul' )[0];

	/**
	 * Make dropdown menus keyboard accessible.
	 */

	// Get all the link elements within the menu.
	links = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred call the function toggleFocus.
	for ( var i = 0, len = links.length; i < len; i++ ) {
		links[i].onfocus = toggleFocus;
		links[i].onblur = toggleFocus;
	}

	function toggleFocus() {
		var current = this,
		    ancestors = [];

		// Create an array of <li> ancestors of the current link. Stop upon
		// reaching .menu-items at the top of the current menu system.
		while ( -1 === current.className.indexOf( 'menu-items' ) ) {
			if ( 'li' === current.tagName.toLowerCase() ) {
				ancestors.unshift( current );
			}
			current = current.parentElement;
		}

		// For each element in ancestors[] toggle the class .focus.
		for ( i = 0, len = ancestors.length; i < len; i++ ) {
			if ( -1 !== ancestors[i].className.indexOf( 'focus' ) )
				ancestors[i].className = ancestors[i].className.replace( ' focus', '' );
			else
				ancestors[i].className += ' focus';
		}
	}
} )();

/**
 * Skip link focus fix.
 */
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();
