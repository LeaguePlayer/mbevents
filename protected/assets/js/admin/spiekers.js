$(function() {
    
    var hideSpiekerForm = function() {
        $('#newspieker_form').hide().prev('.nav').show();
        $('#component_spiekers-form input:submit').prop('disabled', false);
    }
    var showSpiekerForm = function() {
        $('#newspieker_form').show().prev('.nav').hide();
        $('#component_spiekers-form input:submit').prop('disabled', true);
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
    
    
    
    $('#newspieker_form').delegate('.cancel', 'click', function() {
        hideSpiekerForm();
        return false;
    });
    
    $('#newspieker_form').delegate('.access', 'click', function() {
        var form = $(this).closest('form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                $('#newspieker_form .errorMessage').hide();
                if ( !data.success ) {
                    for ( var key in data.errors ) {
                        var message = data.errors[key][0];
                        var input = $('#newspieker_form input[name="Spiekers['+ key +']"], #newspieker_form textarea[name="Spiekers['+ key +']"]');
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
                
                var inputIds = $('#ComponentSpiekers_spieker_ids');
                var newIds = pushToString(data.spieker['id'], inputIds.val());
                if ( newIds ) {
                    $('#speakers').append(data.spiekerHtml);
                    inputIds.val( newIds );
                    hideSpiekerForm();
                } else {
                    ;
                }
            }
        });
        return false;
    });
    
    $('#newspieker_wrap .add_spieker').click(function() {
        var self = $(this);
        $.ajax({
            url: self.attr('href'),
            type: 'GET',
            data: {
                id: self.data('id'),
            },
            success: function(data) {
                $('#newspieker_form').html(data);
                $('#newspieker_wrap .select').hide();
                showSpiekerForm();
                // искусственно подключаю запуск файлового менеджера
                $("#Spiekers_photobrowse").click(function(){window.elfinderBrowse("Spiekers_photo", '/elfinder/connector')});
            }
        });
        return false;
    });
    
    $('#newspieker_wrap .select_spieker').click(function() {
        $(this).next('.select').toggle();
        return false;
    });
    
    $('#change_spieker').change(function() {
        var self = $(this);
        self.next('.add_spieker').data('id', self.val());
        return false;
    });
    
    $('#speakers .remove_spieker').click(function() {
        if ( confirm('Вы уверены, что хотите удалить этого спикера?') ) {
            var self = $(this);
            var inputIds = $('#ComponentSpiekers_spieker_ids');
            var newIds = removeFromString(self.data('id'), inputIds.val());
            inputIds.val(newIds);
            self.closest('.one_spieker').remove();
        }
    });
    
});