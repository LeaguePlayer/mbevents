$(document).ready(function() {
    
    
    new AjaxUpload('#upload_sources', {
        //crossDomain: true,
        // какому скрипту передавать файлы на загрузку? только на свой домен
        action: '/source/upload',
        // имя файла
        name: 'Source[]',
        // дополнительные данные для передачи
        data: {},
        // авто submit
        autoSubmit: true,
        // формат в котором данные будет ответ от сервера .
        // HTML (text) и XML определяются автоматически .
        // Удобно при использовании  JSON , в таком случае устанавливаем параметр как "json" .
        // Также установите тип ответа (Content-Type) в text/html, иначе это не будет работать в IE6
        responseType: 'json',
        // отправка файла сразу после выбора
        // удобно использовать если  autoSubmit отключен
        onChange: function(file, extension){},
        // что произойдет при  начале отправки  файла
        onSubmit: function(file, extension) {
            $('#status span').text("Загрузка на сервер...");
            $('#status span').addClass('work');
        },
        // что выполнить при завершении отправки  файла
        onComplete: function(file, response) {            
            $('#status span').text("Ожидание файлов");
            $('#status span').removeClass('work');
            $('#source-grid').yiiGridView('update');
        }
    });
    
});