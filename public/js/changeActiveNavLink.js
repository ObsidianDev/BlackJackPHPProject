( function( window ) {

	var linkName = $("input[name=page]").val();	
	$( "#nav"+linkName ).addClass( "active" );

})( window );