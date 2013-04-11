
$(document).ready(function() {
    $('#tabs').tabs();


    var $lessonContainer = $( ".lesson-list" ),
        $freeBlock = $(".tab-content.free-basic");
        $payBlock = $(".tab-content.pay-basic");
        $advancedBlock = $(".tab-content.advanced");
 
    $(".lesson-item").draggable({
        revert: "invalid",
        cursor: "move",
        helper: "clone"
    });
    
    $('.removeButton').bind('click', function() {
        removeFromCourse($(this).parents('.lesson-item'));
        return false;
    });
    
    $freeBlock.droppable({
        accept: ".lesson-list .lesson-item",
        activeClass: "highlight",
        drop: function( event, ui ) {
            addToCourse( ui.draggable, $freeBlock );
        }
    });
    
    $payBlock.droppable({
        accept: ".lesson-list .lesson-item",
        activeClass: "highlight",
        drop: function( event, ui ) {
            addToCourse( ui.draggable, $payBlock );
        }
    });
    
    $advancedBlock.droppable({
        accept: ".lesson-list .lesson-item",
        activeClass: "highlight",
        drop: function( event, ui ) {
            addToCourse( ui.draggable, $advancedBlock );
        }
    });


    $lessonContainer.droppable({
        accept: ".tab-content .lesson-item",
        activeClass: "highlight",
        drop: function( event, ui ) {
            removeFromCourse( ui.draggable );
        }
    });
    
    var removeButton = "<a href='#' title='Удалить' class='removeButton'>&rarr;</a>";
    function addToCourse( $item, $currentTarget ) {
        sendAjax({
            operation: 'addLesson',
            lessonId: $item.attr('lessonId'),
            blockType: $currentTarget.attr('blockType')
        }, function(data) {
            if ( data.success ) {
                $item.fadeOut(function() {
                    $item.appendTo( $('.lessons', $currentTarget) )
                        .css({position: 'relative',left: 0,top: 0})
                        .append(removeButton)
                        .find('.removeButton').bind('click', function() {
                            removeFromCourse($item);
                            return false;
                        }).end()
                        .fadeIn();
                });
            }
        });
    }
    
    function removeFromCourse( $item ) {
        sendAjax({
            operation: 'removeLesson',
            lessonId: $item.attr('lessonId'),
        }, function(data) {
            if ( data.success ) {
                $item.fadeOut(function() {
                    $item
                        .find('.removeButton').remove().end()
                        .appendTo( $lessonContainer ).css({
                            position: 'relative',
                            left: 0,
                            top: 0,
                        }).fadeIn();
                });
            }
        });   
    }
    
    
    function sendAjax(params, callback) {
        var p = $.extend({
            operation: false,
            courseId: $('#Course_id').val(),
            lessonId: 0,
            blockType: 0,
        }, params || {});
        
        var url = '';
        var dataParams = {};
        
        switch ( p.operation ) {
            case 'addLesson':
                url = '/course/addLesson';
                dataParams = {
                    Lesson: {
                        id: p.lessonId,
                        course_id: p.courseId,
                        course_type: p.blockType,
                    }
                };
                break;
                
            case 'removeLesson':
                url = '/course/removeLesson';
                dataParams = {
                    Lesson: {
                        id: p.lessonId,
                    }
                };
                break;
            
            default:
                return false;
        }
        
        $.ajax({
            url: url,
            type: 'POST',
            data: dataParams,
            dataType: 'json',
            success: function(data) {
                callback(data);
            }
        });
    }
});