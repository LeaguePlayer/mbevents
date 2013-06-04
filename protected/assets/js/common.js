$(function(){
    
    $.fn.setCursorPosition = function(pos) {
        this.each(function(index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    };
    
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    
    // Всплывающие пользовательские уведомления
    var userMessage = $('#user_message');
    if (userMessage.length) {
        $.colorbox({
            inline: true,
            href: '#user_message',
            title: function() {
                return '<h2>Уведомление пользователя</h2>';
            }
        });
    }
    
    // Фильтр блога {
        $('#blog .filter .select select').chosen();
        
        $('#blog .clear_string').click(function() {
            $(this).prev('input').val('').focus();
        });
    // }
    
    // Кнопка перехода к подробной программе
    $('.come_programm').click(function() {
        var self = $(this);
        var target = $(self.attr('href'));
        var scroller = self.closest('.scroller');
        if ( scroller.size() > 0 ) {
            $(scroller).scrollTo(target, 500, {
                onAfter: function() {
                    $.scrollTo(target, 300);
                }
            });
        } else {
            $.scrollTo(target, 500);
        }
        return false;
    });
    
    // Слайдер для отзывов
    $('#slider-for-review').anythingSlider({
        resizeContents  : false,
		showMultiple    : 2,
        buildArrows     : false,
        hashTags        : false,
        autoPlay        : true,
        delay           : 6000,
    });
    
	//Каруселька
	$('#rounder ul').roundabout({
		tilt: 0.2,
		minScale: 0.6,
		minOpacity: 0.3,
		duration: 800,
        autoplay: true,
        autoplayDuration: 3000,
        autoplayPauseOnHover: true,
	});

	$('#rounder ul').delegate('.right, .left', 'click', function () {
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
    
    $('#rounder ul').delegate('li a', 'click', function() {
        $('#rounder ul').roundabout("animateToNextChild");
    });

	//Скролл
	$(window).on('scroll',function(e){
		var hide = $('#top-header').data('hide');
		var scroll = $(this).scrollTop()
		if(scroll >= 250){
			if(hide == undefined || hide == false){
				$('#top-header').data('hide', true);
                $.cookie('header_hide', true, { expires: 14, path: '/' });
				$('#top-header').animate({top: '-720px'},function(){
					$('#top-header .header-big').hide();
					$('#top-header .header-small').show();
					$('#top-header').css('top', '-256px');
					$('#top-header .hide').removeClass('hide').addClass('show');
                    $('#top-header').css({position: 'absolute'});
				}).delay(100).animate({top: '0px'});
			}
		}
	});

	//Свернуть
	function hideHeader(){
		var hide = $('#top-header').data('hide');
		if(hide){
			$('#top-header').data('hide', false);
            $.cookie('header_hide', false, { expires: 14, path: '/' });
			//header-big
			$('#top-header').animate({top: '-256px'},function(){
				$('#top-header .header-small').hide();
				$('#top-header .header-big').show();
				$('#top-header').css('top', '-720px');
				$('#top-header .hide').removeClass('show').addClass('hide');
                $('#top-header').css({position: 'fixed'});
			}).delay(100).animate({top: '0px'},'fast');
		}else{
			$('#top-header').data('hide', true);
            $.cookie('header_hide', true, { expires: 14, path: '/' });
			$('#top-header').animate({top: '-720px'},function(){
				$('#top-header .header-big').hide();
				$('#top-header .header-small').show();
				$('#top-header').css('top', '-256px');
				$('#top-header .hide').removeClass('hide').addClass('show');
                $('#top-header').css({position: 'absolute'});
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
//	$('body').delegate('#dark-side', 'click', function(e){
//		$(this).fadeOut('fast');
//		$('#posts article').removeClass('show');
//		$(this).remove();
//	});
    
    
    // Кнопка покупки курса
    $('.show_in_cart').click(function() {
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
        var self = $(this);
        if ( self.data('closed') ) {
            $.colorbox({
                href: '/site/register',
                innerWidth: 765,
                onComplete: function() {
                    $('#cboxLoadedContent .blue_button').click(function() {
                        openRegistration();
                        return false;                        
                    });
                    
                    $('#cboxLoadedContent .close_box').click(function() {
                        $.colorbox.close();
                        return false;
                    });                                        
                },
            });
            return;
        }
        
        $.ajax({
            url: '/lesson/view',
            type: 'GET',
            dataType: 'text',
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
                        
                        // отклик на кнопку "Написать нам"
                        callback();
                        
                        // Кнопка "Отправить заметку"
                        var form = $('#lesson_note-form');
                        var inputs = form.find('textarea, input');
                        inputs.click(function() {
                            $(this).next('.errorMessage').hide(300);
                        });
                        form.find('button').click(function() {
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: form.serialize(),
                                dataType: 'json',
                                success: function(data) {
                                    if (data.success) {
                                        var successMessage = $('<div class="success_message">Заметка отправлена</div>').hide();
                                        form.prepend(successMessage);
                                        successMessage.slideDown(300);
                                        setTimeout(function() {
                                            form.find('.success_message').slideUp(300, function() {
                                                $(this).remove();
                                            });
                                        }, 3000);
                                        inputs.filter('textarea').val('');
                                        return;
                                    }
                                    for (var key in data.errors) {
                                        var curInput = inputs.filter('[name$="['+key+']"]');
                                        var errorMessage = curInput.next('.errorMessage');
                                        if (errorMessage.size() == 0) {
                                            errorMessage = $('<div class="errorMessage"></div>').hide();
                                            curInput.after(errorMessage);
                                        }
                                        errorMessage.text(data.errors[key][0]).show(300);
                                    }
                                }
                            });
                            return false;
                        });
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
    
    
//    $('.look_more_about_lesson').click(function() {
//        var self = $(this);
//        self.slideUp(300, function() {
//            $(this).next('.about_lesson_text').slideDown();
//        });
//    });
    
    $('.look_about_lesson').click(function() {
        var self = $(this);
        var target = $(self.attr('href'));
        //var destination = target.offset().top;
        
        var scroller = self.closest('.scroller');
        if ( scroller.size() > 0 ) {
            $(scroller).scrollTo(target, 500, {
                onAfter: function() {
                    $.scrollTo(target, 300);
                }
            });
        } else {
            $.scrollTo(target, 500);
        }
        
//        $('html,body').animate( { scrollTop: destination }, 500, function() {
//            target.find('.block_description').slideDown(500);
//        });
        return false;
    });
    
    $('.hide_block_description').click(function() {
        var target = $(this).closest('.anonce');
        var scroller = $(this).closest('.scroller');
        if ( scroller.size() > 0 ) {
            $(scroller).scrollTo(target, 500, {
                onAfter: function() {
                    $.scrollTo(target, 300);
                    target.find('.block_description').slideUp(500);
                }
            });
        } else {
            $.scrollTo(target, 500);
        }
        return false;
    });
    
//    $('.big-more a').click(function() {
//        alert(1);
//        var self = $(this);
//        console.log(self.data('hide'));
//        var hide = self.data('hide');
//        if ( hide == true ) {
//            self.data('hide', false);
//            self.next('.text').slideDown();
//        } else {
//            self.data('hide', true);
//            self.next('.text').slideUp();
//        }
//        return false;
//    });

    // Показать или не показать окно приветствия
//    if ( !$.cookie('welcome_flag') ) {
//        $.cookie('welcome_flag', true, { expires: 60, path: '/' });
//        showBox({
//            content: '/site/welcome',
//            contentWidth: 740,
//            afterShow: function(content) {
//                content.find('.buttons a').on('click', function() {
//                    closeDark();
//                    return false;
//                });
//            },
//        });
//    }
    
    // замена passwordField на inputField и обратно
    function togglePassword(togglelBtn) {
        var oldInput = togglelBtn.prev('input');
        if ( togglelBtn.hasClass('enable_state') ) {
            var newInput = $('<input type="password" />')
                .attr('name', oldInput.attr('name'))
                .attr('id', oldInput.attr('id'))
                .val(oldInput.val());
            togglelBtn.removeClass('enable_state');
        } else {
            var newInput = $('<input type="text" />')
                .attr('name', oldInput.attr('name'))
                .attr('id', oldInput.attr('id'))
                .val(oldInput.val());
            togglelBtn.addClass('enable_state');
        }
        oldInput.replaceWith(newInput);
        newInput.click(function() {
            $('#' + this.id + '_em_').fadeOut('fast');
        });
        newInput.setCursorPosition( newInput.val().length );
    }
    
    // Страница профиля
    $('#profile-form .toggle_password').click(function() {
        togglePassword($(this));
        return false;
    });
    
    // Блок регистрации
    // ==========================
    $('.reg-button').click(function(e) {
        openRegistration();
        return false;
    });
    
    function openRegistration() {
        $.colorbox({
            href: '/user/registration',
            scrolling: false,
            onComplete: function() {
                bindRegEvents();
            },
            onCleanup: function() {
                var form = $('#cboxLoadedContent form');
                if (form.size() > 0) {
                    var info = form.serialize();
                    $.cookie('registration_info', info, { expires: 1, path: '/' });
                } 
            }
        });

        function bindRegEvents() {
            $('#cboxLoadedContent button').click(function() {
                var self = $(this);
                var form = self.closest('form');
                var submitData = form.serialize() + '&ajax=' + form.attr('id');
                submitData += ( '&current_step=' + self.data('current') );
                if ( self.data('next') == 'finish' ) {
                    submitData += ( '&its_finish_step=1' );
                }
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: submitData,
                    dataType: 'json',
                    success: function(data) {
                        if ( data.status == 'current_valid' ) {
                            showNext(self.data('next'));
                            return;
                        }
                        if ( data.status == 'logined' ) {
                            window.location.reload();
                            return;
                        }
                        if ( data.status == 'saved' ) {
                            showSuccess(data.message);
                            return;
                        }
                        for ( var key in data ) {
                            form.find('#'+key+'_em_').text(data[key]+'').show('slow');
                        }
                    }
                });
                return false;
            });
            
            $('#cboxLoadedContent input, #cboxLoadedContent textarea').click(function(e) {
                $('#' + this.id + '_em_').fadeOut('fast');
            });
            
            // Показать-скрыть пароль
            $('#cboxLoadedContent .toggle_password').click(function(e) {
                togglePassword($(this));
                return false;
            });
            
            $('#cboxLoadedContent .goto_step').click(function(e) {
                var stepNumber = $(this).data('target');
                showPrev(stepNumber);
                return false;
            });
            
            $('#cboxLoadedContent .close_box').click(function(e) {
                $.colorbox.close();
                return false;
            });
            
            var $box = $('#colorbox');
            
            function toggleStep(stepNumber) {
                $box.find('div[class|=step]').hide();
                $box.find('.step-'+stepNumber).show();
                $box.find('.steps li.current').removeClass('current');
                if (isNumeric(stepNumber)) {
                    var index = parseInt(stepNumber) - 1;
                    $box.find('.steps li:eq('+ index +')').addClass('current');
                }
            }
            
            function showNext(stepNumber) {
                if ( stepNumber == 'finish' ) {
                    return false;
                }
                var left = $box.css('left');
                var afterAnimation = function() {
                    toggleStep(stepNumber);
                    $.colorbox.resize();
                    $box.css({left: 5000}).animate({left: left}, 'slow');
                }
                $box.animate({left: -5000}, 'slow', afterAnimation);
                return true;
            }
            
            function showPrev(stepNumber) {
                if ( stepNumber == 0 ) {
                    return false;
                }
                var left = $box.css('left');
                var afterAnimation = function() {
                    toggleStep(stepNumber);
                    $.colorbox.resize();
                    $box.css({left: -5000}).animate({left: left}, 'slow');
                }
                $box.animate({left: 5000}, 'slow', afterAnimation);
                return true;
            }
            
            function showSuccess(message) {
                var left = $box.css('left');
                var afterAnimation = function() {
                    var successContent = $('<div class="success_message">' + message + ' </div> <div style="text-align: center;"><a class="blue_button" href="#">Закрыть</a></div>');
                    successContent.find('.blue_button').on('click', function() {
                        $.colorbox.close();
                        return false;
                    });
                    $box.find('.registration_form').addClass('form').html(successContent);
                    $.colorbox.resize();
                    $box.css({left: 5000}).animate({left: left}, 'slow');
                }
                $box.animate({left: -5000}, 'slow', afterAnimation);
                return true;
            }
        }
    }
    onLoadBlog();
    blogEvents();
    
    
    
    // Функционал покупки курсов
    function saveUserOrders() {
        $.ajax({
            url: '/course/pay',
            type: 'POST',
            data: '',
        });
    }
    
    // Купить может только авторизованный пользователь, иначе вылазит форма автоизации
    
    
    // Если пользователь не авторизован на сайте, выскочит окно
    $('.pay_course').click(function() {
        var self = $(this);
        var payTarget = $(this).data('href');
        
        if (!$(this).data('user-autorized')) {
            autorization();
            return false;
        } 
        else {
            // сохранение в админку информации о покупке
            $.ajax({
                url: '/course/pay',
                type: 'POST',
                data: {
                    CoursePay: {
                        course_id: self.data('course-id'),
                        course_type: self.data('course-type'),
                    }
                },
            });
            location.href = "/";
        }
        
        function autorization() {
            $.colorbox({
                href: '/site/register',
                innerWidth: 765,
                onComplete: function() {
                    $('#cboxLoadedContent .blue_button').click(function() {
                        openRegistration();
                        return false;                        
                    });
                    
                    $('#cboxLoadedContent .close_box').click(function() {
                        $.colorbox.close();
                        return false;
                    });                                        
                },
            });
        }
        
//        function autorization() {
//            $.colorbox({
//                href: '/user/login/ajaxLogin',
//                scrolling: false,
//                onComplete: function() {
//                    $('#cboxLoadedContent a.registration').click(function() {
//                        openRegistration();
//                        return false;
//                    });
//                    $('#cboxLoadedContent button.login').click(function() {
//                        $('#cboxLoadedContent .message').fadeOut(300);
//                        var form = $(this).closest('form');
//                        $.ajax({
//                            url: '/user/login/ajaxLogin',
//                            type: 'POST',
//                            data: form.serialize(),
//                            dataType: 'json',
//                            success: function(data) {
//                                if (!data.success) {
//                                    $('#cboxLoadedContent .message').text(data.error).fadeIn(300);
//                                    return;
//                                }
//                                self.data('user-autorized', true);
//                                $.colorbox.close();
//                            }
//                        });
//                        return false;
//                    });
//                },
//            });
//        }
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
    dark.find('.content-box').on('click', function(event) {
		event.stopPropagation();
	});
	return dark.fadeIn('fast');
}

function closeDark(effect) {
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
        $(this).delay(100).remove();
    });
}

// События статей блога
function blogEvents() {
    // Комментирование блога
    $('#post-content .question .submit').click(function() {
        var form = $(this).closest('form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                if ( data.success ) {
                    form.find('textarea').val('');
                    $('#post-content .reviews .scroll-container').prepend(data.newComment);
                }
            }
        });
        return false;
    });
    // Отправка статьи на почту
    $('#post-content #send_article-form button').click(function() {
        var form = $(this).closest('form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                var inputs = form.find('input');
                var notice = form.find('.notice').hide();
                if (data.success) {
                    form.append('<div class="success_message">Статья отправлена</div>');
                    setTimeout(function() {
                        form.find('.success_message').slideUp(300, function() {
                            $(this).remove();
                        });
                    }, 3000);
                    inputs.val('');
                    return;
                }
                notice.text(data.errors['email'][0]).show(300);
            }
        });
        return false;
    });
}

function onLoadBlog()
{
    $('#posts article').on( 'click', 'a', function(e) {
        e.preventDefault();
        var article = $(this).closest('article');
    	if ( !article.hasClass('show') ) {
            var position = article.position();
            showBox({
                content: '/article/load/'+article.data('id'),
                contentWidth: 740,
                closeEffect: 'left',
                fitToCenter: false,
                beforeShow: function(content, settings) {
                    // счетчик просмотров
                    var countDiv = article.find('.post-views');
                    countDiv.text( +countDiv.text() + 1 );
                    // превьюшка справа
                    var cloneArticle = article.clone();
                    cloneArticle.css({
                        position: 'absolute',
                        top: 0,
                        left: content.outerWidth(),
                    });
                    content.append(cloneArticle);
                    cloneArticle.wrap('<div id="show-article"></div>');
                    var offset = article.offset();
                    settings.boxOffset.top = offset.top - 20;
                    settings.boxOffset.left = offset.left - content.outerWidth() - 40;
                },
                afterShow: function(content) {
                    // подгоняю высоту страницы
                    $('#page-wrap, #dark-side').height(content.outerHeight() + content.offset().top);
                    $.scrollTo(content, 500);
                    blogEvents();
                },
                onClose: function() {
                    article.removeClass('show');
                    // удаляем настройку высоты блока
                    $('#page-wrap').height('auto');
                }
            });
    	}
        return false;
    });
};



function showBox(options) {
    var o = $.extend({
        content: '',
        closeOnOverlay: true,
        contentWidth: 740,
        contentHeight: 'auto',
        openEffect: 'left',
        closeEffect: 'top',
        fitToCenter: true,
        
        beforeLoad: function() {},
        afterLoad: function() {},
        beforeShow: function() {},
        afterShow: function() {},
        onClose: function() {},
    }, options || {});
    
    var settings = {
        // смещение окна относительно родительского элемента, определенного в параметре relativeParent
        boxOffset: {
            left: 0,
            top: 0,
        }
    }
    
    // определенеи инструментария
    var dark;
    var contentBox;
    
    // запуск процесса открытия окна
    showDark();
    
    // определяемые пользователем действия до загрузки контента
    o.beforeLoad();
    
    if ( o.content != '' ) {
        $.ajax({
            type: 'GET',
            url: o.content,
            success: function(data) {
                
                // определяемые пользователем действия после загрузки контента
                o.afterLoad(contentBox);
                
                contentBox.html(data);
                showProcess();
            }
        });
    } else {
        showProcess();
    }
    return;
    
    function resize() {
        var w = $(window).width();
        var h = $(document).height();
        dark.width(w).height(h);
        if ( o.fitToCenter ) {
            var lf = (w - contentBox.outerWidth()) / 2;
            if (lf < 0) lf = 0;
            var tp = (h - contentBox.outerHeight()) / 2 + $(document).scrollTop();
            if (tp < 0) tp = 0;
            contentBox.css({left: lf, top: tp});
        }
    }
    
    function closeContent(callback) {
        if ( contentBox == undefined ) {
            contentBox = $('#dark-side .content-box');
            if ( contentBox.size() == 0 ) {return;}
        }
        o.onClose(contentBox);
        switch (o.closeEffect) {
            case 'left':
                contentBox.animate({left: -9999}, 'slow', callback);
                break;
            case 'right':
                contentBox.animate({right: -9999}, 'slow', callback);
                break;
            case 'bottom':
                contentBox.animate({bottom: -9999}, 'slow', callback);
                break;
            case 'top':
            default:
                contentBox.animate({top: -9999}, 'slow', callback);
        }
    }
    
    function closeDark() {
        if ( !dark ) {
            return;
        }
        var removeDark = function() {
            dark.fadeOut('fast', function() {
                $(this).remove();
                $(window).off('resize.showBox');
            });
        }
        if ( contentBox.size() > 0 ) {
            closeContent(removeDark)
        } else {
            removeDark();
        }
    }
    
    function showDark() {
        dark = $('#dark-side');
    	if(dark.length > 0) {
    		closeContent();
    	} else {
    	   dark = $('<div id="dark-side"><div class="content-box"></div></div>');
    	}
    	var docWidth = $(document).width();
    	var docHeight = $(document).height();
    	dark.width(docWidth).height(docHeight);
    	$('body').append(dark);
        
        contentBox = dark.find('.content-box');
        contentBox.on('click.showBox', function(event) {
    		event.stopPropagation();
    	});
        contentBox.css({width: o.contentWidth, height: o.contentHeight}).hide();
        $(window).on('resize.showBox', resize);
        
        if (o.closeOnOverlay) {
            dark.on('click', function() {
                closeDark(o.closeEffect);
            });
        }
    	dark.fadeIn('fast');
    }
    
    function showProcess() {
        contentBox.find('.close_box').click(function() {
            closeDark(o.closeEffect);
            return false;
        });
        var contentWidth = contentBox.outerWidth();
        var contentHeight = contentBox.outerHeight();
        
        settings.boxOffset.left = ( $(window).width() - contentWidth ) / 2;
        settings.boxOffset.top = ( ($(window).height() - contentHeight) / 2 ) + $(document).scrollTop();
        if ( settings.boxOffset.left < 0 ) settings.boxOffset.left = 0;
        if ( settings.boxOffset.top < 0 ) settings.boxOffset.top = 0;
        
        // определяемые пользователем действия перед началом анимации
        o.beforeShow(contentBox, settings);
        
        switch (o.openEffect) {
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
        switch (o.openEffect) {
            case 'left':
            case 'right':
                contentBox.animate({left: settings.boxOffset.left}, 'slow', function(){ o.afterShow(contentBox); });
                break;
            case 'bottom':
            case 'top':
            default:
                contentBox.animate({top: settings.boxOffset.top}, 'slow', function(){ o.afterShow(contentBox); });
        }
    }
}

// выводи карту для компонента
ymaps.ready(init);
function init () {
      ymaps.geocode('Москва, Цветной бульвар, 11, стр.2 , ТКЗ "Мир"', { results: 1 }).then(function (res) {
          var firstGeoObject = res.geoObjects.get(0);
          window.myMap = new ymaps.Map("map", {
              center: firstGeoObject.geometry.getCoordinates(),
              zoom: 15
          });
          myMap.geoObjects.add(firstGeoObject);
      }, function (err) {
          alert(err.message);
      });
 }