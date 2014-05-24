(function($) {


	/*******************
	***Init Functions***
	*******************/

	var setContainers = function() {
		var windowHeight = $( window ).height();
		$( '.business-card' ).height( (windowHeight-55) );
		$( '.about-sections' ).height( (windowHeight-65) ).css('margin-top', windowHeight);
		$( '.primary-skills' ).height( (windowHeight-65) );
	};

	var initListeners = function() {

	};

	var fadeInContent = function() {
		$( '.about-content' ).fadeIn( 1000 );
	};

	var fadeInBusinessCard = function() {
		$( '.business-card img' ).animate({opacity: 1}, 2000);
		$( '.business-card h2' ).delay( 2000 ).fadeIn( 1500 );
		$( '.business-card .self-summary').delay( 3500 ).fadeIn( 1500 );
		$( '.down-arrow' ).delay( 6000 ).fadeIn( 500 );
		$( '.arrow-instructions').delay( 6000 ).fadeIn( 500 )
	};




	/***********************
	***Behavior Functions***
	***********************/


	var parallax = function() {
		// Set parallax motion for background image
	    var scrolled = $(window).scrollTop();
	    var windowHeight = $(window).height();
	    $('.about-background').css('top', -(scrolled * 0.1) + 'px');

	    // After interests, hide first image and show second
	    if ( scrolled > windowHeight * 1.9) {
	    	$( '.overlooking-water').css('z-index', '1');
	    	$( '.edc' ).css('z-index', '2');	
	    }
	    else if ( (scrolled < (windowHeight * 1.9) ) && ( $( '.edc' ).css('z-index') == 2 ) ) {
	    		$( '.overlooking-water').css('z-index', '2');
	    		$( '.edc' ).css('z-index', '1');
	    }
	};



	/***********************
	***jCarousel Behavior***
	***********************/
	var setupCarousel = function() {
		var jcarousel = $('.skill-carousel-wrapper');
	    jcarousel
	        .on('jcarousel:reload jcarousel:create', function () {
	            var width = jcarousel.innerWidth();
	            jcarousel.jcarousel('items').css('width', width + 'px');
	        })
	        .jcarousel({
	            wrap: 'circular'
	        });

	    $('.skill-carousel-prev')
	        .jcarouselControl({
	            target: '-=1'
	        });

	    $('.skill-carousel-next')
	        .jcarouselControl({
	            target: '+=1'
	        });
    }



	$(window).load( function() {
		fadeInContent();
		setContainers();
		initListeners();
		fadeInBusinessCard();
		setupCarousel();
		$( window ).scroll(parallax);	
	});

})(jQuery);