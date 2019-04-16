$(document).ready(function () {
    $( "#submit" ).on("click",function( event ){
        $.ajax({
            url:     "data.php", //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#dataForm").serialize()
            ,  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                $('#result_form').html(response);
            },
            error: function(response) { // Данные не отправлены
                $('#result_form').html('Ошибка. Данные не отправлены.');
            }
        });
    });
});