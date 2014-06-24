/**
 * Theme functions file
 *
 * Contains handlers for navigation accessibility.
 *
 */
( function( $ ) {
	var body    = $( 'body' ),
		_window = $( window );

	$( function() {
	
		// Focus styles for menus.
		$( '.main-navigation' ).find( 'a' ).on( 'focus blur', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );
		$( '.nav-toggle' ).on( 'focus blur', function() {
			$( this ).toggleClass( 'focus' );
		} );
	} );
} )( jQuery );
