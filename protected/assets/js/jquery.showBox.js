(function($) {
    
    var methods = {
        show: function(options) {
            var dark = $('#dark-side');
        	if(dark.length == 0){
        		dark = $('<div id="dark-side"><div class="content-box"></div></div>');
        	}
        
        	$('body').append(dark);
            dark.find('.content-box').on('click.showBox', function(event) {
        		event.stopPropagation();
        	});
        	return dark.fadeIn('fast');
        },
        
        close: null,
        
        resize: function() {
            
        }        
    };
    
    $.fn.showBox = function(options) {
        
        var optopns = $.extend({
            content: '',
            closeOnOverlay: true,
            contentWidth: 740,
            contentHeight: 'auto',
            openEffect: 'left',
            closeEffect: 'top',
            fitOnResize: true,
            
            beforeLoad: function() {},
            afterLoad: function() {},
            beforeShow: function() {},
            afterShow: function() {},
            onClose: function() {},
        }, options || {});
        
        var settings = {
            boxOffset: {left:0,top:0},
        }
        
        return this.each(function() {
            
            
            
        });
        
        var showDark = function() {
            
        }
        
        var closeDark = function(effect) {
            var dark = $('#dark-side');
            var contentBox = dark.find('.content-box');
            if ( contentBox.size() > 0 ) {
                switch (effect) {
                    case 'left':
                        contentBox.animate({left: -9999}, 'slow');
                        break;
                    case 'right':
                        contentBox.animate({right: -9999}, 'slow');
                        break;
                    case 'bottom':
                        contentBox.animate({bottom: -9999}, 'slow');
                        break;
                    case 'top':
                    default:
                        contentBox.animate({top: -9999}, 'slow');
                }
            }
            dark.fadeOut('slow', function() {
                o.onClose();            
                $(this).delay(100).remove();
                $(window).off('resize.showBox');
            });
        }
        
        var dark = showDark();
        if (options.closeOnOverlay) {
            dark.on('click', function() {
                closeDark(options.closeEffect);
            });
        }
        var contentBox = dark.find('.content-box').css({width: options.contentWidth, height: options.contentHeight}).hide();
        
        $(window).on('resize.showBox' ,function() {
            var w = $(window).width();
            var h = $(window).height();
            dark.width(w);
            if ( options.fitOnResize ) {
                var l = (w - contentBox.outerWidth()) / 2;
                if (l < 0) l = 0;
                var t = (h - contentBox.outerHeight()) / 2 + $(document).scrollTop();
                if (t < 0) t = 0;
                contentBox.css({left: l, top: t});
            } 
        });
        
        switch ( $.type(options.content) ) {
            case "string":
                options.beforeLoad(settings);
                $.ajax({
                    type: 'GET',
                    url: options.content,
                    success: function(data) {
                        contentBox.html(data);
                        contentBox.find('.close_box').click(function() {
                            closeDark(options.closeEffect);
                            return false;
                        });
                        options.afterLoad(contentBox);
                        settings.boxOffset.left = ( $(window).width() - contentBox.outerWidth() ) / 2;                    
                        settings.boxOffset.top = ( ($(window).height() - contentBox.outerHeight()) / 2 ) + $(document).scrollTop();
                        if ( settings.boxOffset.left < 0 ) settings.boxOffset.left = 0;
                        if ( settings.boxOffset.top < 0 ) settings.boxOffset.top = 0;
                        options.beforeShow(contentBox, settings);
                        switch (options.openEffect) {
                            case 'left':
                                contentBox.css({left: -9999, top: settings.boxOffset.top});
                                break;
                            case 'right':
                                contentBox.css({left: 9999, top: settings.boxOffset.top});
                                break;
                            case 'bottom':
                                contentBox.css({top: 9999, left: settings.boxOffset.left});
                                break;
                            case 'top':
                            default:
                                contentBox.css({top: -9999, left: settings.boxOffset.left});
                        }
                        contentBox.show();
                        switch (options.openEffect) {
                            case 'left':
                            case 'right':
                                contentBox.animate({left: settings.boxOffset.left}, 'slow', function(){ options.afterShow(contentBox); });
                                break;
                            case 'bottom':
                            case 'top':
                            default:
                                contentBox.animate({top: settings.boxOffset.top}, 'slow', function(){ options.afterShow(contentBox); });
                        }
                    }
                });
                break;
            
            default:
                return;
        }
        
    };
    
}(jQuery));