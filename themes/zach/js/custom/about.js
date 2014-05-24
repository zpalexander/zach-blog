(function($) {


	/*******************
	***Init Functions***
	*******************/

	var setContainers = function() {
		var windowHeight = $( window ).height();
		$( '.business-card' ).height( (windowHeight-55) );
		$( '.about-sections' ).height()
		$( '.about-sections' ).css('margin-top', windowHeight);
		//$( '.primary-skills' ).height( (windowHeight-65) );
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

	    // Load skills once we hit that section
	    if ( $( '#primary-skills' ).visible( 'partial' ) ) {
	    	turnUpSkills();
	    }
	};


	var turnUpSkills = function() {
		var html5        = '70%';
		var css3         = '80%';
		var php          = '70%';
		var javascript   = '60%';
		var jquery       = '80%';
		var mysql        = '40%';
		var drupal       = '50%';
		var wordpress    = '80%';
		var git          = '60%';
		var java         = '40%';
		var android      = '30%';
		var photoshop    = '40%';
		$( '.html5-skill' ).delay( 1000 ).animate({width: html5}, 1200);
		$( '.css3-skill' ).delay( 1000 ).animate({width: css3}, 1200);
		$( '.php-skill' ).delay( 1000 ).animate({width: php}, 1200);
		$( '.javascript-skill').delay( 1000 ).animate({width: javascript}, 1200);
		$( '.jquery-skill' ).delay( 1000 ).animate({width: jquery}, 1200);
		$( '.mysql-skill' ).delay( 1000 ).animate({width: mysql}, 1200);
		$( '.drupal-skill' ).delay( 1000 ).animate({width: drupal}, 1200);
		$( '.wordpress-skill' ).delay( 1000 ).animate({width: wordpress}, 1200);
		$( '.git-skill' ).delay( 1000 ).animate({width: git}, 1200);
		$( '.java-skill' ).delay( 1000 ).animate({width: java}, 1200);
		$( '.android-skill' ).delay( 1000 ).animate({width: android}, 1200);
		$( '.photoshop-skill' ).delay( 1000 ).animate({width: photoshop}, 1200);
	}



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