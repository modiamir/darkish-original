$(document).ready(function() {
    

    /**
     * Main menu change site with scroll and scrolling 
     */
    var winh = $(window).height();
    var numOfSections = 9;
	var winh = $(window).height();
    var doch = $(document).height();
    var scrl = $(document).scrollTop();
    var curSection = Math.floor(scrl/doch*10+1);
    var customScroll = 0;



    function makeFullHeight() {
    	winh = $(window).height();
    	doch = $(document).height();
    	scrl = $(document).scrollTop();	
    	var minSecHeight = (winh <= 600)? 600 : winh;
    	var sectionOneHeight = minSecHeight;
    	if($(window).width() < 992) {
    		if(curSection == 1) {
    			sectionOneHeight = sectionOneHeight - 60;
    		} else {
    			sectionOneHeight = sectionOneHeight - 40;
    		}
    	}
    	$('#fullpage .section').height(minSecHeight);
    	$('#fullpage #section-1').height(sectionOneHeight);


    	/**
    	 *	Sync section one's element's height;
    	 */
		$('#fullpage #section-1 .main-slideshow').height(sectionOneHeight - 60);    	

		$('#fullpage #section-2 .description').height(200);
		$('#fullpage #section-2 .records').height(minSecHeight - 260);
		$('#fullpage #section-2 .records #records-container').height(minSecHeight - 260);
		// $('#fullpage #section-1 .main-slideshow').height((sectionOneHeight - 100) * 0.6);    	
		// $('#fullpage #section-1 .offer-slider').height( ((minSecHeight - 100) * 0.4) );    	
		// $('#fullpage #section-1 .offer-slider ul ').height( ((minSecHeight - 100) * 0.4) );    	
		// $('#fullpage #section-1 .offer-slider ul li').height( ((minSecHeight - 100) * 0.4) );    	


    }
    function handleFixNavbar() {
    	if($(window).width() < 992) {
    		$('#main-menu').removeClass('navbar-fixed-top');
    	}else {
    		$('#main-menu').addClass('navbar-fixed-top');
    	}
    }
    makeFullHeight();
    handleFixNavbar();
    

    function detectCurrentSection() {
    	winh = $(window).height();
    	doch = $(document).height();
    	scrl = $(document).scrollTop();	

    	

    	if( scrl > winh/2) {
    		$('#main-menu').addClass('mini');
    	} else {
    		$('#main-menu').removeClass('mini');
    	}

    	curSection = Math.floor(scrl/doch*10+1);
    	$('#main-menu ul.navbar-nav li.level-one').removeClass('active');
    	if(curSection>=2) {
    		$('#main-menu ul.navbar-nav li.level-one:nth-child('+(curSection - 1)+')').addClass('active');
    	}
    }

    $('#main-menu #main-navigation .navbar-nav li.level-one > a').click(function(){
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 1000);
        return false;
    });

    $('#main-menu a.navbar-brand').click(function(){
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
        return false;
    });


 //    $(document).on('mousewheel', function(event) {
	// 	clearTimeout($.data(this, 'timer'));
	// 	  	$.data(this, 'timer', setTimeout(function() {
	// 			if(event.deltaY == 1) {
	// 				if(curSection-1 <= 1) {
	// 					var target = 1
	// 				} else {
	// 					var target = curSection-1;
	// 				}
	// 				$('html, body').animate({
	// 				    scrollTop: $('#section-'+target).offset().top
	// 				}, 1000);
	// 			} else {
	// 				if(curSection+1 >= 9) {
	// 					var target = 9
	// 				} else {
	// 					var target = curSection+1;
	// 				}
	// 				$('html, body').animate({
	// 				    scrollTop: $('#section-'+target).offset().top
	// 				}, 1000);
	// 			}
	// 	  	}, 250));
	// });

	$(document).keydown(function(e) {
	    switch(e.which) {
	        case 37: // left
	        break;

	        case 38: // up
	        	if(curSection-1 <= 1) {
	        		var target = 1
	        	} else {
	        		var target = curSection-1;
	        	}
	        	$('html, body').animate({
	        	    scrollTop: $('#section-'+target).offset().top
	        	}, 700);
	        break;

	        case 39: // right
	        break;

	        case 40: // down
	        	if(curSection+1 >= 9) {
	        		var target = 9
	        	} else {
	        		var target = curSection+1;
	        	}
	        	$('html, body').animate({
	        	    scrollTop: $('#section-'+target).offset().top
	        	}, 700);
	        break;

	        default: return; // exit this handler for other keys
	    }
	    e.preventDefault(); // prevent the default action (scroll / move caret)
	});
	
	$(window).resize(function() {
		makeFullHeight();
		handleFixNavbar();
	})

    
    $(document).scroll(function(){
    	
    	detectCurrentSection();
    	
    })


    /**
     * Sequence Slideshow
     */
    // var sequence = $("#sequence").sequence().data("sequence");


    /**
     *
     * Offer slidere
     */
    $('.offer-slider-wrapper .item .offer-bg').each(function(){
    	console.log($(this).attr('src'));
    	$(this).css('background-image','url('+$(this).attr('src')+')');
    })

    /**
     *
     * Gridster
     */
    
     $('#fullpage #section-2 .records #records-container .item').each(function(){
     	h = 1 + 2 * Math.random() << 0;
		// w = 1 + 2 * Math.random() << 0;
     	$(this).height(h * 150);
     	$(this).width(h * 150);
     })

 	var wall = new freewall("#records-container");
	wall.reset({
		selector: '.item',
		animate: false,
		cellW: 160,
		cellH: 160,
		delay: 30,
		onResize: function() {
			wall.refresh($('#fullpage #section-2 .records #records-container').width() - 30, $('#fullpage #section-2 .records #records-container').height() - 30);
		}
	});
	// caculator width and height for IE7;
	wall.fitZone($('#fullpage #section-2 .records #records-container').width() - 30 , $('#fullpage #section-2 .records #records-container').height() - 30);
	
 	
 	
 	
 	
});



