$(function() {
    
    $('#component_slider-form .add_slide').click(function() {
        $.ajax({
            url: '/componentSlider/addSlide',
            type: 'GET',
            success: function(data) {
                $('#component_slider-form .slider_rows').append(data);
            }
        });
        return false;
    });
    
    $('#component_slider-form .slide_item .remove_item').click(function() {
        var self = $(this);
        $.ajax({
            url: '/componentSlider/removeSlide/'+self.data('id'),
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                self.closest('.slide_item').fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });
    
});