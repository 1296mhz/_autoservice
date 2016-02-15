/*---------------------------
Video Resizes
----------------------------*/
$(function() {

	// Find all YouTube videos
	var $allVideos = $("iframe[src^='http://www.youtube.com/embed'], iframe[src^='https://www.youtube.com/embed'], iframe[src^='http://player.vimeo.com'], iframe[src^='https://player.vimeo.com']"),

	    // The element that is fluid width
	    $fluidEl = $(".video-holder");

	// Figure out and save aspect ratio for each video
	$allVideos.each(function() {

		$(this)
			.data('aspectRatio', this.height / this.width)
			
			// and remove the hard coded width/height
			.removeAttr('height')
			.removeAttr('width');

	});

	// When the window is resized
	// (You'll probably want to debounce this)
	$(window).resize(function() {

		var newWidth = $fluidEl.width();
		
		// Resize all videos according to their own aspect ratio
		$allVideos.each(function() {

			var $el = $(this);
			$el
				.width(newWidth)
				.height(newWidth * $el.data('aspectRatio'));

		});

	// Kick off one resize to fix all videos on page load
	}).resize();

	//anchor scroll
	$('a').click(function(){
	    $('html, body').animate({
	        scrollTop: $( $(this).attr('href') ).offset().top
	    }, 500);
    return false;
});

});


/**
* Fullscreenr - lightweight full screen background jquery plugin
* By Jan Schneiders
* Version 1.0
* www.nanotux.com
**/
(function($){	
	$.fn.fullscreenr = function(options) {
		if(options.height === undefined) alert('Please supply the background image height, default values will now be used. These may be very inaccurate.');
		if(options.width === undefined) alert('Please supply the background image width, default values will now be used. These may be very inaccurate.');
		if(options.bgID === undefined) alert('Please supply the background image ID, default #bgimg will now be used.');
		var defaults = { width: 1440,  height: 1100, bgID: 'bgimg' };
		var options = $.extend({}, defaults, options); 
		$(document).ready(function() { $(options.bgID).fullscreenrResizer(options);	});
		$(window).bind("resize", function() { $(options.bgID).fullscreenrResizer(options); });		
		return this; 		
	};	
	$.fn.fullscreenrResizer = function(options) {
		// Set bg size
		var ratio = options.height / options.width;	
		// Get browser window size
		var browserwidth = $(window).width();
		var browserheight = $(window).height();
		// Scale the image
		if ((browserheight/browserwidth) > ratio){
		    $(this).height(browserheight);
		    $(this).width(browserheight / ratio);
		} else {
		    $(this).width(browserwidth);
		    $(this).height(browserwidth * ratio);
		}
		// Center the image
		$(this).css('left', (browserwidth - $(this).width())/2);
		$(this).css('top', (browserheight - $(this).height())/2);
		return this; 		
	};
})(jQuery);

$(function() {
  
  /*---------------------------
  Full Width Background
  ----------------------------*/
  <!--// Full Screen Background You need to specify the size of your background image here
      var FullscreenrOptions = {  width: 1440, height: 1100, bgID: '#bgimg' };
      // This will activate the full screen background!
      jQuery.fn.fullscreenr(FullscreenrOptions);
  //-->

});