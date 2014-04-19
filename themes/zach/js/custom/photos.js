(function($) {

	var openFullScreenImage = function() {
		var imageSource = $('img', this).attr('src');
		var imageTag = '<img src="'+imageSource+'"></img>';
		$( '.fullscreen-photo')
			.append( imageTag )
			.fadeIn(900);
		$('body').animate({scrollTop:$('.fullscreen-photo img').offset().top},500)
	};

	var closeFullScreenImage = function() {
		$( this ).fadeOut(900);
		$( '.fullscreen-photo img' ).remove();
	}

	var showInfo = function() {
		$(this).find( '.photo-info' ).fadeIn(200);
	}

	var hideInfo = function() {
		$(this).find( '.photo-info' ).fadeOut(200);
	}


	$(window).load( function() {
		// Fade in the photos
		$( '.photo' ).fadeIn(1000).css('display', 'inline-block');

		// Show photo info on hover
		$( '.photo' ).mouseenter( showInfo ).mouseleave( hideInfo );

		// Open fullscreen photo onclick
		$( '.photo' ).click(openFullScreenImage);

		// Close fullscreen photo onclick
		$( '.fullscreen-photo' ).click(closeFullScreenImage);
	});

})(jQuery);