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

    window.chartColors = {
        red: 'rgb(255, 0, 0)',
        orange: 'rgb(255, 165, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(231,233,237)'
    };
});