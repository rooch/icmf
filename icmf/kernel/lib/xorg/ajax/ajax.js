(function($) {
	
	var baseTitle = $(document).attr('title');
	var href;
	var target;
	var title;
	var rel;
	var fileContent;
	var prompt = 0;
	var init = true;
	var state = window.history.pushState !== undefined;
	
	$(document).on('click', 'a', function(event){
		event.preventDefault();
	
		href = $(this).attr('href') ? $(this).attr('href') : '';
		target = $(this).attr('target') ? '#' + $(this).attr('target') : '#content';
		title = $(this).attr('title') ? $(this).attr('title') : '';
		rel = $(this).attr('rel') ? $(this).attr('rel') : '';
		
		if($(target).css('display') == 'none'){
			$(target).fadeIn('slow');
		}
		
		$(document).attr('title', baseTitle + ' ' +title);
		
		if(href.match('http://') || href.match('https://') || href.match('ymsgr:') || href.match('skype:') || href.match('mailto:')){
			window.location = href;
		}else{
			if(href != '' && !href.match('javascript:void') && rel != 'download'){
//				alert('href: http://' + $(location).attr('host') + href + '\nlocation: ' + $(location).attr('href'));
				if($(location).attr('href') == 'http://' + $(location).attr('host') + href){
					$.address.value(href + '/');
				}else{
					$.address.value(href);
				}
			}
		}
	});
	
	$.address.state('').init(function(event) {
    }).change(function(event) {
		$.address.state().replace(/^\/$/, '') + event.value;
		$(target).farajax('loader', event.value, 'crawl=' + event.value);
		$.scrollTo(target, {duration:3000});
	});

    $.fn.extend({
        farajax: function(options,arg, data){
            if (options && typeof(options) == 'object') {
                options = $.extend({}, $.fJax.defaults, options);
            }

            this.each(function() {
                new $.fJax(this, options, arg, data);
            });
            return;
        }
    });

    $.fJax = function(elem, options, arg, data) {

    	var target = '#' + elem.id;
        if (options && typeof(options) == 'string') {
           if (options == 'loader') {
               loader(arg, data);
           }
           return;
        }

        function loader(href, data){
        	var LoadMsg = 'Please Wait ...';
        	
    			$.ajax({
    				type: 'POST',
    				url: href,
    				data: data,
    				dataType: 'html',
    				timeout: 60000,
    				cache: false,
    				tryCount: 0,
    				retryLimit: 3,
    				
    				beforeSend:function(){
    				    $(target).showLoading();
    				},
    				
    				success: function(d,s){
    					fileContent = d;
						if (d.match('ENO: #') || d.match('SNO: #') || d.match('WNO: #') || d.match('INO: #') || d.match('UNO: #') || d.match('POPUP: #')) {
							prompt = 1;
							$(this).remove();
							$('#modalMask').fadeIn('slow', function (){
								$('#modalWindow').fadeIn('slow');
								$('#modalContent').html(d);
								disable_scroll();
							});
						}else{
							$(this).remove();
							$(target).html(d);
						}
    				},
    				
    				complete: function(){
    					var commands = fileContent.match(/commands value="(.+?)"/);
						if(commands){
	    					if (typeof commands !== "undefined") {
								setTimeout(commands[1], 100);
							}
						}
//						alert(prompt);
						if (editor && prompt == 0) { removeEditor(); }
    					$(target).hideLoading();
    				},
    						
    				error: function(o,s,e){
    					if (s == 'timeout') {
    			            this.tryCount++;
    			            if (this.tryCount <= this.retryLimit) {
    			                //try again
    			            	$(target).html('Your internet speed is very low<br>Retry number:' + this.tryCount); 
    			                $.ajax(this);
    			                return;
    			            }            
    			            return;
    			        }
    			        if (o.status == 500) {
    			        	$(target).html('Internal server error, please contact to system administrator.');
    			        } else if(o.status == 404){
    			        	$(target).html('Cant find, please contact to system administrator.');
    			        }else{
    			        	$(target).html('Error number ' + o.status + ', please contact to system administrator.');
    			        }
    				}
    			});
        }
    };

})(jQuery);