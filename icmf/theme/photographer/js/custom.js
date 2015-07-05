/* Share & Comment */
$(document).on("mouseenter", "'.shareCommentBox'", function() {
	$(this).animate({
		height : '100px'
	}, {
		queue : false,
		duration : 500
	});
	$('>.shareBox', this).fadeIn();
	// $('>.commentBox', this).fadeIn();
	startShare();
	// $('>.commentBox', this).farajax('loader', '/comment/v_addObject');
}).on("mouseleave", ".shareCommentBox", function() {
	$(this).animate({
		height : '20px'
	}, {
		queue : false,
		duration : 500
	});
	$('>.shareBox', this).fadeOut();
	// $('>.commentBox', this).fadeOut();
});

/* Post search auto Complete */
$('#postSearchList').keyup(
		function() {
			var text = $(this).val();
			if (text.length >= 2) {
				$("#postSearchResult").css('background', 'url(load.gif);');
				$('#postSearchResult').slideDown();
				$('#postSearchResult').farajax(
						'loader',
						'/post/c_showTitleListObject/title='
								+ $('#postSearchList').val());
			} else {
				$('#postSearchResult').slideUp();
			}
		});

/* Order window */
$('#orderButton').live(
		'click',
		function() {
			switch ($(this).attr('rel')) {
			case 'order':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/order');
				break;
			case 'wordpress':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/wordpress');
				break;
			case 'webdesign':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/webdesign');
				break;
			case 'cooperation':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/cooperation');
				break;
			case 'analysis':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/analysis');
				break;
			default:
			case 'full':
				$('#orderForm').farajax('loader',
						'/humanResource/v_addObject/full');
				break;
			}
			// $(this).fadeOut('slow');
			$('#orderWindow').fadeIn('slow');
			$('#orderWindowClose').fadeIn('slow');
			$('#orderWindow').animate({
				height : '350px'
			}, {
				queue : false,
				duration : 500
			});
		});

$('#orderWindowClose').live('click', function() {
	// $('#orderButton').fadeIn('slow');
	$('#orderWindow').fadeOut('slow');
	$('#orderWindow').animate({
		height : '0px'
	}, {
		queue : false,
		duration : 500
	});
});

/* Footer */
$('#footerHandler').hover(function() {
	$('#footer').animate({
		height : '500px'
	}, {
		queue : false,
		duration : 500
	});
	$('#footer').hover(function() {
	}, function() {
		$('#footer').animate({
			height : '32px'
		}, {
			queue : false,
			duration : 500
		});
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

$(function() {
	var $tf_bg = $('#tf_bg'), $tf_bg_images = $tf_bg.find('img'), $tf_bg_img = $tf_bg_images
			.eq(0), $tf_thumbs = $('#tf_thumbs'), total = $tf_bg_images.length, current = 0, $tf_content_wrapper = $('#tf_content_wrapper'), $tf_next = $('#tf_next'), $tf_prev = $('#tf_prev'), $tf_loading = $('#tf_loading');

	// preload the images
	$tf_bg_images.preload({
		onComplete : function() {
			$tf_loading.hide();
			init();
		}
	});

	// shows the first image and initializes events
	function init() {
		// get dimentions for the image, based on the windows size
		var dim = getImageDim($tf_bg_img);
		// set the returned values and show the image
		$tf_bg_img.css({
			width : dim.width,
			height : dim.height,
			left : dim.left,
			top : dim.top
		}).fadeIn();

		// resizing the window resizes the $tf_bg_img
		$(window).bind('resize', function() {
			var dim = getImageDim($tf_bg_img);
			$tf_bg_img.css({
				width : dim.width,
				height : dim.height,
				left : dim.left,
				top : dim.top
			});
		});

		// expand and fit the image to the screen
		$('#tf_zoom').live('click', function() {
			if ($tf_bg_img.is(':animated'))
				return false;

			var $this = $(this);
			if ($this.hasClass('tf_zoom')) {
				resize($tf_bg_img);
				$this.addClass('tf_fullscreen').removeClass('tf_zoom');
			} else {
				var dim = getImageDim($tf_bg_img);
				$tf_bg_img.animate({
					width : dim.width,
					height : dim.height,
					top : dim.top,
					left : dim.left
				}, 350);
				$this.addClass('tf_zoom').removeClass('tf_fullscreen');
			}
		});

		// click the arrow down, scrolls down
		$tf_next.bind('click', function() {
			if ($tf_bg_img.is(':animated'))
				return false;
			scroll('tb');
		});

		// click the arrow up, scrolls up
		$tf_prev.bind('click', function() {
			if ($tf_bg_img.is(':animated'))
				return false;
			scroll('bt');
		});

		// mousewheel events - down / up button trigger the scroll down / up
		$(document).mousewheel(function(e, delta) {
			if ($tf_bg_img.is(':animated'))
				return false;

			if (delta > 0)
				scroll('bt');
			else
				scroll('tb');
			return false;
		});

		// key events - down / up button trigger the scroll down / up
		$(document).keydown(function(e) {
			if ($tf_bg_img.is(':animated'))
				return false;

			switch (e.which) {
			case 38:
				scroll('bt');
				break;

			case 40:
				scroll('tb');
				break;
			}
		});
	}

	// show next / prev image
	function scroll(dir) {
		// if dir is "tb" (top -> bottom) increment current,
		// else if "bt" decrement it
		current = (dir == 'tb') ? current + 1 : current - 1;

		// we want a circular slideshow,
		// so we need to check the limits of current
		if (current == total)
			current = 0;
		else if (current < 0)
			current = total - 1;

		// flip the thumb
		$tf_thumbs.flip({
			direction : dir,
			speed : 400,
			onBefore : function() {
				// the new thumb is set here
				var content = '<span id="tf_zoom" class="tf_zoom"></span>';
				content += '<img src="'
						+ $tf_bg_images.eq(current).attr('longdesc')
						+ '" alt="Thumb' + (current + 1) + '"/>';
				$tf_thumbs.html(content);
			}
		});

		// we get the next image
		var $tf_bg_img_next = $tf_bg_images.eq(current),
		// its dimentions
		dim = getImageDim($tf_bg_img_next),
		// the top should be one that makes the image out of the viewport
		// the image should be positioned up or down depending on the direction
		top = (dir == 'tb') ? $(window).height() + 'px' : -parseFloat(
				dim.height, 10)
				+ 'px';

		// set the returned values and show the next image
		$tf_bg_img_next.css({
			width : dim.width,
			height : dim.height,
			left : dim.left,
			top : top
		}).show();

		// now slide it to the viewport
		$tf_bg_img_next.stop().animate({
			top : dim.top
		}, 700);

		// we want the old image to slide in the same direction, out of the
		// viewport
		var slideTo = (dir == 'tb') ? -$tf_bg_img.height() + 'px' : $(window)
				.height()
				+ 'px';
		$tf_bg_img.stop().animate({
			top : slideTo
		}, 700, function() {
			// hide it
			$(this).hide();
			// the $tf_bg_img is now the shown image
			$tf_bg_img = $tf_bg_img_next;
			// show the description for the new image
			$tf_content_wrapper.children().eq(current).show();
		});
		// hide the current description
		$tf_content_wrapper.children(':visible').hide()

	}

	// animate the image to fit in the viewport
	function resize($img) {
		var w_w = $(window).width(), w_h = $(window).height(), i_w = $img
				.width(), i_h = $img.height(), r_i = i_h / i_w, new_w, new_h;

		if (i_w > i_h) {
			new_w = w_w;
			new_h = w_w * r_i;

			if (new_h > w_h) {
				new_h = w_h;
				new_w = w_h / r_i;
			}
		} else {
			new_h = w_w * r_i;
			new_w = w_w;
		}

		$img.animate({
			width : new_w + 'px',
			height : new_h + 'px',
			top : '0px',
			left : '0px'
		}, 350);
	}

	// get dimentions of the image,
	// in order to make it full size and centered
	function getImageDim($img) {
		var w_w = $(window).width(), w_h = $(window).height(), r_w = w_h / w_w, i_w = $img
				.width(), i_h = $img.height(), r_i = i_h / i_w, new_w, new_h, new_left, new_top;

		if (r_w > r_i) {
			new_h = w_h;
			new_w = w_h / r_i;
		} else {
			new_h = w_w * r_i;
			new_w = w_w;
		}

		return {
			width : new_w + 'px',
			height : new_h + 'px',
			left : (w_w - new_w) / 2 + 'px',
			top : (w_h - new_h) / 2 + 'px'
		};
	}
});