(function($) {

	var initIsotope = function() {
		$( '.photo-content' ).isotope({
  			// options
  			itemSelector : '.photo',
  			layoutMode : 'fitRows',
  			transitionDuration: '1.0s',
		});
	};

	var openFullScreenImage = function() {

	};

	var closeFullScreenImage = function() {

	}


	$(window).load( function() {
		initIsotope();

		// Open fullscreen photo onclick
		$( '.photo' ).click(function() {
			var imageSource = $('img', this).attr('src');
			var imageTag = '<img src="'+imageSource+'"></img>';
			$( '.fullscreen-photo')
				.append( imageTag )
				.fadeIn(900);
			$('body').animate({scrollTop:$('.fullscreen-photo img').offset().top},500)


		});

		// Close fullscreen photo onclick
		$( '.fullscreen-photo' ).click(function() {
			$( this ).fadeOut(900);
			$( '.fullscreen-photo img' ).remove();
		});
	});

})(jQuery);