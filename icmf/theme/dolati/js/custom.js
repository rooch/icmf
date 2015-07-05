/* Footer */
$('#footer').hover(function() {
	$('#footer').animate({height : '450px'}, {queue : false, duration : 500} );
	$('#footer').hover(function() {
	}, function() {
		$('#footer').animate({height : '32px'}, {queue : false, duration : 500} );
	});
});

function shutter() {

	var container = $('#shutterFrame'), li = container.find('li');

	// Using the tzShutter plugin. We are giving the path
	// to he shutter.png image in the plugin folder and two
	// callback functions.

	container.tzShutter({
		imgSrc : 'theme/photographer/img/shutter.png',
		closeCallback : function() {

			// Cycling the visibility of the li items to
			// create a simple slideshow.

			li.filter(':visible:first').hide();

			if (li.filter(':visible').length == 0) {
				li.show();
			}

			// Scheduling a shutter open in 0.1 seconds:
			setTimeout(function() {
				container.trigger('shutterOpen')
			}, 100);
		},
		loadCompleteCallback : function() {
			setInterval(function() {
				container.trigger('shutterClose');
			}, 4000);

			container.trigger('shutterClose');
		}
	});
}

/* Minimizer */
$('.minimizer').live('click', function(){
	if($('#leftBox').width() < 10){
		$('#rightBox').animate({ "width": "80%" }, { queue:false, duration:500 } );
		$('#leftBox').fadeIn('slow');
		$('#leftBox').animate({ "width": "20%" }, { queue:false, duration:500 } );
		$('#footer').animate({height : '32px'}, {queue : false, duration : 500} );
		
		$(body).css({ 'background-color': '#000' });
	    $(body).css('background-image', 'none');
	}
});