$(function() {
    
    var hideReviewForm = function() {
        $('#newreview_form').hide().prev('.nav').show();
        $('#component_reviews-form input:submit').prop('disabled', false);
    }
    var showReviewForm = function() {
        $('#newreview_form').show().prev('.nav').hide();
        $('#component_reviews-form input:submit').prop('disabled', true);
    }
    var pushToString = function(value, string, separator) {
        if ( !value ) {
            return false;
        }
        separator = separator || ',';
        var pieces = string ? string.split(separator) : [];
        for (var i = 0; i < pieces.length; i++) {
            if ( pieces[i] == value ) {
                return false;
            }
        }
        pieces.push(value);
        return pieces.join(separator);
    }
    var removeFromString = function(value, string, separator) {
        separator = separator || ',';
        var pieces = string ? string.split(separator) : [];
        for (var i = 0; i < pieces.length; i++) {
            if ( pieces[i] == value ) {
                pieces.splice(i, 1);
            }
        }
        return pieces.join(separator);
    }
    
    
    
    $('#newreview_form').delegate('.cancel', 'click', function() {
        hideReviewForm();
        return false;
    });
    
    $('#newreview_form').delegate('.access', 'click', function() {
        var form = $(this).closest('form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                $('#newreview_form .errorMessage').hide();
                if ( !data.success ) {
                    for ( var key in data.errors ) {
                        var message = data.errors[key][0];
                        var input = $('#newreview_form input[name="Reviews['+ key +']"], #newreview_form textarea[name="Reviews['+ key +']"]');
                        var errorDiv = input.closest('.row').find('.errorMessage');
                        if ( errorDiv.size() > 0 ) {
                            errorDiv.text(message).show();
                        } else {
                            errorDiv = $('<div class="errorMessage">'+ message +'</div>');
                            errorDiv.appendTo(input.closest('.row'));
                        }
                    }
                    return;
                }
                
                var inputIds = $('#ComponentReviews_reviews_ids');
                var newIds = pushToString(data.review['id'], inputIds.val());
                if ( newIds ) {
                    $('#reviews').append(data.reviewHtml);
                    inputIds.val( newIds );
                    hideReviewForm();
                } else {
                    ;
                }
            }
        });
        return false;
    });
    
    $('#newreview_wrap .add_review').click(function() {
        var self = $(this);
        $.ajax({
            url: self.attr('href'),
            type: 'GET',
            data: {
                id: self.data('id'),
            },
            success: function(data) {
                $('#newreview_form').html(data);
                $('#newreview_wrap .select').hide();
                showReviewForm();
                // искусственно подключаю запуск файлового менеджера
                $("#Reviews_photobrowse").click(function(){window.elfinderBrowse("Reviews_photo", '/elfinder/connector')});
            }
        });
        return false;
    });
    
    $('#newreview_wrap .select_review').click(function() {
        $(this).next('.select').toggle();
        return false;
    });
    
    $('#change_review').change(function() {
        var self = $(this);
        self.next('.add_review').data('id', self.val());
        return false;
    });
    
    $('#reviews .remove_review').click(function() {
        if ( confirm('Вы уверены, что хотите удалить этого спикера?') ) {
            var self = $(this);
            var inputIds = $('#ComponentReviews_reviews_ids');
            var newIds = removeFromString(self.data('id'), inputIds.val());
            inputIds.val(newIds);
            self.closest('.one_review').remove();
        }
    });
    
});