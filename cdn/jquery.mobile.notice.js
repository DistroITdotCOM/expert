/*
 name:    Notice Plugin for jQuery Mobile v1.1.0
 version: 1.0
 auther:  Yu Ishihara
 url:     http://normo.jp
 */
 
(function( $, window, undefined ) {

	$.extend($.mobile, {
		notice: function( _options ) {
			
			var plugin = this;
			var defaults = {
				version: '1.0',
				type: 'success',//success, error
				title: 'Notice title.',
				content: 'Notice content.',
				theme: 'notice',
				margin: 5,
				time: 1200,
				speed: 300
			};
			
			plugin.init = function(){
	      plugin.options = $.extend({}, defaults, _options);
				if($('.ui-notice').length == 0) $('.ui-page').append('<div class="ui-notice"></div>');
				plugin.add();
			};
			
			plugin.add = function(){
				
				var html = '<div class="ui-body ui-body-'+this.options.theme+' '+this.options.type+'"><div class="img"></div><div class="tx"><h3>'+this.options.title+'</h3><p>'+this.options.content+'</p></div></div>'
				$('.ui-notice').empty();
				$('.ui-notice').append(html);
				
				$('.ui-notice').css({
					top: ($('.ui-notice').height()+this.options.margin)*-1
				});
				$('.ui-notice').stop().animate({
					top: 0
				},
				this.options.speed);
				
				if(this.timer) clearTimeout(this.timer);
				this.timer = setTimeout(function(){
					plugin.remove();
				}, this.options.time);
			};
			
			plugin.remove = function(){
				$('.ui-notice').stop().animate({
					top: ($('.ui-notice').height()+this.options.margin)*-1
				},
				this.options.speed,
				function() {
					$('.ui-notice').empty();
				});
			}
			
			plugin.init();
		}
	});

	
})( jQuery, this );


$(document).bind("pageinit", function(){
	$(':jqmData(notice)').each(function(i) {
  		$(this).click(function() {
			$.mobile.notice({
				type: $(this).attr('data-notice'),
				title: $(this).attr('data-notice-title'),
				content: $(this).attr('data-notice-content')
			});
			return false;
		});
	});
});


