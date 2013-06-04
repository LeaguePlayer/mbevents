$(function() {
    callback();
});


function callback() {
    $('.callback_button').click(function() {
        var dark = showDark();
        var contentBox = dark.find('.content-box');
        $.ajax({
            url: '/site/callback',
            type: 'GET',
            success: function(data) {
                contentBox.html(data);
                var contentWidth = contentBox.width();
                var contentHeight = contentBox.height();
                var top = ( $(window).height() - contentHeight ) / 2 + $(document).scrollTop();
                var left = ( $(window).width() - contentWidth ) / 2;
                if ( top < 0 ) top = 0;
                if ( left < 0 ) left = 0;
                
                contentBox.css({top: top});
                contentBox.animate({left: left-80}, 'slow');
                bindCallback();
            }
        });
        return false;
    });
    
    function bindCallback() {
        $('.send_callback').click(function () {
            var form = $(this).closest('form');
            var data = form.serialize() + '&ajax=callback-form';
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(data) {
                    if ( !data || data.length == 0 ) {
                        form.find('input, textarea').val('');
                        var successText = $('<p/>').addClass('success_message').hide()
                            .text('Спасибо за заявку, в ближайшее время мы с Вами обязательно свяжемся');
                        form.prepend(successText).find('.success_message').slideDown();
                        return;
                    }
                    for ( var key in data ) {
                        form.find('#'+key).next('.errorMessage').text(data[key]+'').show('slow');
                    }
                }
            });
            return false;
        });
        
        $('.close_contentbox').click(function() {
            closeDark();
            return false;
        });
    }
}