
$(document).ready(function() {
    
    (function selectComponent() {
        var componentId = $('.component_id').val();
        var announceId = $('#Announce_id').val();
        
        $('.component_id').change(function() {
            componentId = $(this).val();
        });
        
        
        
        $('#select_component_box .cancel').click(function() {
            $.fancybox.close();
        });
    })();
    
    var componentManager = new ComponentManager;
    
});










function ComponentManager() {
    if (ComponentManager.instance !== undefined) {
        return Component.instance;
    }
    var Manager = {
        announceId: $('#Announce_id').val(),
        typeForCreate: $('#selected_type').val(),
        emptyContainer: $('.component_container.empty'),
        newContainer: $('.component_container.new'),
        openTypeBox: function() {
            Manager.emptyContainer.show(0);
            return Manager;
        },
        closeTypeBox: function() {
            Manager.emptyContainer.hide(0);
            return Manager;
        },
        openNewBox: function() {
            Manager.newContainer.show(0);
            return Manager;
        },
        closeNewBox: function() {
            Manager.newContainer.hide(0);
            return Manager;
        },
        removeContainer: function(component_id, component_type) {
            $('#component-'+component_id+'_'+component_type).slideUp(function() {
                $(this).remove();
            });
            return Manager;
        },
        init: function() {
            setListeners(Manager);
            ComponentManager.instance = Manager;
            return Manager;
        }
    }
    Manager.init();
}

function setListeners(componentManager) {
    // Кнопка добавления компонента
    componentManager.newContainer.find('.add_component').unbind('click').bind('click', function() {
        componentManager.closeNewBox().openTypeBox();
        return false;
    });
    
    // Выбор типа компонента для создания
    $('#selected_type').unbind('change').bind('change', function() {
        componentManager.typeForCreate = $(this).val();
        return false;
    });
    
    // Кнопка отмены создания компонента на этапе выбора его типа
    componentManager.emptyContainer.find('.cancel').unbind('click').bind('click', function() {
        componentManager.closeTypeBox().openNewBox();
        return false;
    });
    
    // Кнопка подтверждения типа компонента
    componentManager.emptyContainer.find('.accept').unbind('click').bind('click', function() {
        var url = mergeGetParams($(this).attr('url'), {
            typeId: componentManager.typeForCreate,
            announceId: componentManager.announceId
        });
        window.location.href = url;
        return false;
    });
    
    // Кнопка удаления существующего компонента
    $('.delete_component').unbind('click.components').bind('click.components', function() {
        if ( confirm('Вы уверены, что хотите удалить этот компонент?') ) {
            var componentId = $(this).attr('component_id');
            var componentType = $(this).attr('component_type');
            $.ajax({
                url: '/announceComponent/delete',
                type: 'POST',
                data: {
                    id: componentId,
                    typeId: componentType,
                },
                success: function() {
                    componentManager.removeContainer(componentId, componentType);
                }
            });
        }
        return false;
    });
}

function mergeGetParams(url, newParams) {
    var partsUrl = url.split('?');
    var newUrl = partsUrl[0];
    
    var separator = '&';
    if ( partsUrl[1] ) {
        newUrl += '?' + partsUrl[1];
    } else if ( newParams ) {
        newUrl += '?';
        separator = '';
    }
    for ( var key in newParams ) {
        newUrl += separator + key+'='+newParams[key];
        if (separator == '') {
            separator = '&';
        }
    }
    return newUrl;
}