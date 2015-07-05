$(document).ready(
		function() {
			$('dl').toggle();
			$('h2').bind('click', function(event) {
				event.preventDefault();
				$(this).next('dl').slideToggle(500, function() {
					$('.video-background').videobackground('resize');
				});
			});
			$('body').prepend('<div class="video-background"></div>');
			$('.video-background').videobackground({
						preload: 'در حال بارگذاری...',
						videoSource : [ 'theme/movie/video/WD0143.webm' ],
						controlPosition : '#main',
						poster : 'logo.jpg',
						loop: true,
						loadedCallback : function() {
							$(this).videobackground('mute', {
								controlPosition : '#main'
							});
						}
					});
			$('#dock2').Fisheye(
					{
						maxWidth: 60,
						items: 'a',
						itemsText: 'span',
						container: '.dock-container2',
						itemWidth: 40,
						proximity: 80,
						alignment : 'left',
						valign: 'bottom',
						halign : 'center'
					}
				);
		});
		loader('POST', '', 'login', 'op=userMan&mode=c_loginContent');
		$('ul.sf-menu').superfish();
		
//		$("#wrapper").show("fold", {horizFirst:true}, 3000);
//		$("#leftSide").show("fold", {horizFirst:true}, 4000);

		loader('POST', '', 'content', 'op=pageLoader&mode=v_load&page=splash'); 
		$('#content').slideDown(1000);

function startUp(op, mode, RefNum, MID, State, ResNum) {
	
}