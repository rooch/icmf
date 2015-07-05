$(document).ready(function() {
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined") {
		setTimeout(commands, 100);
	}
	// ///////////////

	$('.tip').tipTip();
	// $('#temp').farajax('loader', '/pageLoader/v_load/announce');
});

(function($) {
	$.fn.preload = function(options) {
		var opts = $.extend({}, $.fn.preload.defaults, options);
		o = $.meta ? $.extend({}, opts, this.data()) : opts;
		var c = this.length, l = 0;
		return this.each(function() {
			var $i = $(this);
			$('<img/>').load(function(i) {
				++l;
				if (l == c)
					o.onComplete();
			}).attr('src', $i.attr('src'));
		});
	};
	$.fn.preload.defaults = {
		onComplete : function() {
			return false;
		}
	};
})(jQuery);