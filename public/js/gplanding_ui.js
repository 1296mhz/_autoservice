/*

	Template Name : GP Responsive Html Landing Page
	Template Version : 1.0
	Template Author : Taner ÖZDEMİR ( As CRTVMax )
	Creation Date : 30 May 2013

	JAVASCRIPT INDEX OF GP LANDING TEMPLATE

	1  - MENU FIXED 							LINE 24
	2  - TO TOP PLUGIN SETTINGS					LINE 49
	3  - ONE PAGE MENU SETTINGS					LINE 53
	4  - RESPONSIVE NAV SETTINGS 				LINE 94
	5  - COVER SLIDER SETTINGS					LINE 98
	6  - LAYERED SLIDER SETTINGS 				LINE 116
	7  - ISOPTE FILTER SETTINGS 				LINE 132
	8  - SHOWCASE SETTINGS 						LINE 148
	9  - BLOG SETTINGS 							LINE 152
	10 - GMAP SETTINGS 							LINE 243
	11 - VALIDATION & AJAX CONTACT SETTINGS     LINE 261

*/

// Menu Fixed

$(window).scroll(function() {

	if ($(window).scrollTop() > 150 ){

		$('.header').stop().addClass('fixed').animate({background: 'rgba(255,255,255,.8)'}, 200 );
		$('#toTop').animate({'opacity':'1'},200);

	} else {

		$('.header').stop().removeClass('fixed').animate({background: 'rgba(255,255,255,0)'}, 200 );
		$('.header nav#menu li a, .mean-bar nav li a').removeClass('current');	
		$('#toTop').animate({'opacity':'0'},200);			

	};

	if($(window).scrollTop()+110 >= ($(document).height() - ($(window).height()))){
		$('#toTop').stop().addClass('bottom');
	} else {
		$('#toTop').stop().removeClass('bottom');
	};

});

// To Top Plugin Settings

$().UItoTop({ easingType: 'easeOutQuart' });

// One Page Menu Settings

$('.header nav li a:not(.home_button), .scroll, .mean-bar li a').live('click', function() {
	var targetDiv = $(this).attr('href');
	var pos = $(''+targetDiv+'').offset().top-60;
	$.scrollTo(pos+'px', 800 );
	return false;
});

$('#backtotop a, .home_button').click( function(event) {
	event.stopPropagation();
	$.scrollTo('0px', 1000, {easing: 'easeInOutCubic'} );
	return false;
});

function getTargetTop(elem){
    var id = elem.attr("href");
    var offset = 60;
    return $(id).offset().top - offset;
}

var sections = $('.header nav#menu li a:not(.home_button)[href^="#"]');
function checkSectionSelected(scrolledTo){
    var threshold = 100;
    var i;
    for (i = 0; i < sections.length; i++) {
        
        var section = $(sections[i]);
        var target = getTargetTop(section);
        if (scrolledTo > target - threshold && scrolledTo < target + threshold) {
            sections.removeClass("current");
            section.addClass("current");
        }
    };
}

checkSectionSelected($(window).scrollTop());
$(window).scroll(function(e){
    checkSectionSelected($(window).scrollTop())
});

// Responsive Nav Settings

jQuery('header nav').meanmenu();

// Cover Slider Setitngs

if ($('.banner').length != 0) {
$(function() {
    var unslider = $('.banner').unslider({
				fluid: true,
				dots: true
			});
    
    $('.unslider-arrow').click(function() {
        var fn = this.className.split(' ')[1];
        
        //  Either do unslider.data('unslider').next() or .prev() depending on the className
        unslider.data('unslider')[fn]();
    });
});
}

// Layered Slider Plugin Settings

if ($('.slider').length != 0) {
$(window).load(function(){
	$('.slider').fractionSlider({
		'fullWidth': 			false,
		'controls': 			true, 
		'pager': 				true,
		'responsive' : true, // responsive slider (see below for some implementation tipps)
		'dimensions' : '960, 440', /* IMPORTANT:
		if you use the responsive option, you have to set dimensions to the origin (width,height) in px
		you use for data-position,heights of elements, etc. */
	});
});
}

// Isotope Filter Plugin Settings

$('#screens').isotope({
	itemSelector : '.screen',
	layoutMode : 'fitRows',
	animationEngine : 'jquery'
});

$('#filters a').click(function(){
	var selector = $(this).attr('data-filter');
	$('#filters a').removeClass('active');
	$(this).addClass('active');
	$('#screens').isotope({ filter: selector });
	return false;
});

// Showcase Gallery Plugin

$(".boxer").boxer({});

// Blog Retrieving

$('a.get_blog').live('click', function() {

	var data_get = $(this).attr('href');

	$('#blog .content').animate({'opacity':'0'}, 1000, function() {

		$('#blog').append('<div id="loading_blog_overlay"></div>');

		$(this).slideUp(1000, function() { 
			
			$('#blog .content').remove();

			random_number = Math.ceil(Math.random() * 1000)+Math.ceil(Math.random() * 1000);

			$('#blog').append('<div class="content get_blog" id="'+random_number+'"></div>');
			$('.get_blog#'+random_number).slideUp();

			$.ajax({
				url: data_get,
				success: function(data) {

					$('.get_blog#'+random_number).html(data);

					$('.get_blog#'+random_number).slideDown(1000, function() { 

						$('.get_blog#'+random_number).animate({
							opacity: '1'
						}, 500);

						$('#loading_blog_overlay').remove();

					});

				}
			});

		}); 

	});

	return false;

});

$('a.down_blog').live('click', function() {

	var data_get = $(this).attr('href');

	$('#blog .content').animate({'opacity':'0'}, 1000, function() {

		$('#blog').append('<div id="loading_blog_overlay"></div>');

		$(this).slideUp(1000, function() { 
			
			$('#blog .content').remove();

			random_number = Math.ceil(Math.random() * 1000)+Math.ceil(Math.random() * 1000);

			$('#blog').append('<div class="content all" id="'+random_number+'"></div>');
			$('.all#'+random_number).slideUp();

			$.ajax({
				url: data_get,
				success: function(data) {

					$('.all#'+random_number).html(data);

					$('.all#'+random_number).slideDown(1000, function() { 

						$('.all#'+random_number).animate({
							left: '0',
							opacity: '1'
						}, 500);

						$('#loading_blog_overlay').remove();

					});

				}
			});

		}); 

	});

	return false;

});

// GMap Settings

function initialize() {
	var myLatLong = new google.maps.LatLng(-37.811123,144.966767);
	var mapOptions = {
  	center: myLatLong,
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("Map"), mapOptions);
  var marker = new google.maps.Marker({
      position: myLatLong,
      map: map
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

// Validation & Ajax Contact Form Settings

$('#contact_form input[type="submit"]').bind('click', function() {

	$("#contact_form").validate({
		rules: {
			name: { required:true },
			email: 		{ required:true, email: true },
			subject: { required:true },
			message: {required: true}
		},
		messages: {
			name: "Enter Your Name",
			email: { required: "E-Mail Required", email: "Please Enter an Valided E-Mail Address" },
			subject: "Please Enter a Subject",
			message: "Please Enter a Message"
		},
		errorElement: "span"
	});
	
	if($("#contact_form").valid()) {
	
		$.ajax({  
			url: "mail.php",
			type: 'POST',
			data: "name="+$('#name').val()+"&email="+$('#email').val()+"&subject="+$('#subject').val()+"&message="+$('#message').val(), 
		  	success: function(data) {
		  		if(data == 'Complete') {
		  			alert();
					$('#contact_form').html("<div id='notification'><h2 style='color: rgb(33, 197, 26);'>Your Message Has Been Sent !</h2><p>"+data+"</p></div>")  
					.hide()  
					.fadeIn(1500, function() {  
					  $('#contact_form').append("");  
					});  
				} else {
					$('#contact_form').html("<div id='notification'><h2 style='color: #F00;'>Error !</h2><p>"+data+"</p></div>")  
					.hide()  
					.fadeIn(1500, function() {  
					  $('#contact_form').append("");  
					});  
				}

		  	},
		  	error: function() {
				$('#contact_form').html("<div id='error'><h2>Sorry, an error occurred.</h2></div>").css('color', 'red');
			}  
		});  
		
		return false;  

	}

});