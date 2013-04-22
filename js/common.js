$(function(){
	//Каруселька
	$('#rounder ul').roundabout({
		tilt: 0.2,
		minScale: 0.6,
		minOpacity: 0.3,
		duration: 800
	});

	$('#rounder ul').delegate('.right, .left', 'click', function (){
		var self = $(this);
		var parent = self.parent();

		var right = parent.find('.right').animate({right : '0px'},'fast');
		var left = parent.find('.left').animate({left : '0px'},'fast');

		if(self.hasClass('left')){
			$('#rounder ul').roundabout("animateToPreviousChild", function(){
				right.remove();
				left.remove();
				if(parent.prev().length == 0){
					$('#rounder ul li:last').append(right, left);
				}else{
					parent.prev().append(right, left);
				}
				right.animate({right : '-28px'},'fast');
				left.animate({left : '-28px'},'fast');
			});
		}else if(self.hasClass('right')){
			$('#rounder ul').roundabout("animateToNextChild", function(){
				right.remove();
				left.remove();
				if(parent.next('li').length == 0){
					$('#rounder ul li:first').append(right, left);
				}else{
					parent.next().append(right, left);
				}	
				right.animate({right : '-28px'},'fast');
				left.animate({left : '-28px'},'fast');
			});
			
		}
	});

	//Скролл
	$(window).on('scroll',function(e){
		var hide = $('#top-header').data('hide');
		var scroll = $(this).scrollTop()
		if(scroll >= 250){
			if(hide == undefined || hide == false){
				$('#top-header').data('hide', true);
				$('#top-header').animate({top: '-720px'},function(){
					$('#top-header .header-big').hide();
					$('#top-header .header-small').show();
					$('#top-header').css('top', '-256px');
					$('#top-header .hide').removeClass('hide').addClass('show');
				}).delay(100).animate({top: '0px'});
			}
		}
	});

	//Свернуть
	function hideHeader(){
		var hide = $('#top-header').data('hide');
		if(hide){
			$('#top-header').data('hide', false);
			//header-big
			$('#top-header').animate({top: '-256px'},function(){
				$('#top-header .header-small').hide();
				$('#top-header .header-big').show();
				$('#top-header').css('top', '-720px');
				$('#top-header .hide').removeClass('show').addClass('hide');
			}).delay(100).animate({top: '0px'},'fast');
		}else{
			$('#top-header').data('hide', true);
			$('#top-header').animate({top: '-720px'},function(){
				$('#top-header .header-big').hide();
				$('#top-header .header-small').show();
				$('#top-header').css('top', '-256px');
				$('#top-header .hide').removeClass('hide').addClass('show');
			}).delay(100).animate({top: '0px'});
		}
	}
	$('#top-header #hide-btn').click(function(){
		hideHeader();
	});
    
    //Подгрузка блога
	//$('#posts article').delegate('a', 'click', function(e){
//		if(!$(this).closest('article').hasClass('show')){
//			var dark = showDark();
//			var widthBox = 740;
//
//			var contentBox = dark.find('.content-box');
//			var article = $(this).closest('article');
//
//			var position = article.position();
//			article.addClass('show').css({top: position.top - 20});
//			
//			var offset = article.offset();
//			
//			contentBox.css({top: offset.top});
//			//contentBox.height(article.outerHeight() - 80);
//			contentBox.animate({width: widthBox, left: offset.left - widthBox - 60}, 'slow');
//
//			//Здесь нужен ajax
//            $.ajax({
//                url: '/article/load',
//                type: 'GET',
//                data: {
//                    id: article.data('id'),
//                },
//                success: function(data) {
//                    contentBox.html(data);
//                }
//            });
//			//contentBox.html($('#copy').html());
//
//			//$(this).click(function(){return false;});
//			//не пускаем пузырьки выше
//			contentBox.on('click', function(event){
//				event.stopPropagation();
//			});
//		}
//	});

	//Скрываем темную область при клике
	$('body').delegate('#dark-side', 'click', function(e){
		$(this).fadeOut('fast');
		$('#posts article').removeClass('show');
		$(this).remove();
	});
    
    onLoadBlog();
    
    
    // Кнопка покупки курса
    $('.buy_lessons').click(function() {
        $.ajax({
            url: '/course/buy',
            type: 'POST',
            data: $(this).parents('form').serialize(),
            success: function(data) {
                $.fancybox({
                    content: data,
                    padding: 0,
                    closeBtn: false,
                });
            }
        });
        return false;
    });
    
    // Кнопка ввода промо-кода
    $(document).delegate('.promocode_enter', 'click', function() {
        self = $(this);
        $.ajax({
            url: '/promoCode/enter',
            type: 'POST',
            data: $(this).parents('form').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success == true) {
                    //self.parents('.div_with_steps').html(response.message);
                    self.parents('#look_video').removeClass('alert_error');
                    window.location.reload();
                    return;
                }
                self.parents('#look_video').addClass('alert_error');
                var inputsBox = self.parents('form').find('.div_with_inputs');
                inputsBox.find('input').removeClass('error');
                for ( var key in response.errors ) {
                    inputsBox.find('input[name*='+ key +']').addClass('error');
                }
            }
        });
        return false;
    });
    
    
    // Просмотр уроков
    $(document).delegate('.open_lesson', 'click', function() {
        self = $(this);
        $.ajax({
            url: '/lesson/view',
            type: 'GET',
            data: {
                id: self.data('lesson_id'),
            },
            success: function(data) {
                $.fancybox({
                    content: data,
                    padding: 0,
                    closeBtn: false,
                    modal: true,
                    afterShow: function() {
                        var pManager = new PlayersManager();
                        pManager.initPlayersInHtml(this.content);
                        return true;
                    }
                });
            }
        });
        return false;
    });
    
    $(document).delegate('.close_video', 'click', function() {
        var pManager = new PlayersManager();
        pManager.removePlayer($(this).data('element'));
        $.fancybox.close();
        return false;
    });
    
    
    $(document).delegate('.close_fancybox', 'click', function() {
        $.fancybox.close();
        return false;
    });

});

function showDark() {
	var dark = $('#dark-side');
	if(dark.length == 0){
		dark = $('<div id="dark-side"><div class="content-box"></div></div>');
	}
	var docWidth = $(document).width();
	var docHeight = $(document).height();

	dark.width(docWidth).height(docHeight);

	$('body').append(dark);
	return dark.fadeIn('fast');
}

function onLoadBlog()
{
    $('#posts article').on( 'click', 'a', function(e){
    	if(!$(this).closest('article').hasClass('show')){
    		var dark = showDark();
    		var widthBox = 740;
    
    		var contentBox = dark.find('.content-box');
    		var article = $(this).closest('article');
    
    		var position = article.position();
    		article.addClass('show').css({top: position.top - 20});
    		
    		var offset = article.offset();
    		
    		contentBox.css({top: offset.top});
    		//contentBox.height(article.outerHeight() - 80);
    		contentBox.animate({width: widthBox, left: offset.left - widthBox - 60}, 'slow');
    
    		//Здесь нужен ajax
            $.ajax({
                url: '/article/load',
                type: 'GET',
                data: {
                    id: article.data('id'),
                },
                success: function(data) {
                    contentBox.html(data);
                }
            });
    		//contentBox.html($('#copy').html());
    
    		//$(this).click(function(){return false;});
    		//не пускаем пузырьки выше
    		contentBox.on('click', function(event){
    			event.stopPropagation();
    		});
    	}
    });
};