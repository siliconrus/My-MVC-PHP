$(document).ready(function () {

    // Кнопка закрытия флеш-сообщения
    $('.close').on('click', function() {
        $('.alert').hide();
    });

    $('#printCheck').on('click', function (e) {
        e.preventDefault();
        

        $.ajax({
            url: "/main/delete/",
            method: "GET",
            //dataType: "json",
            data: ,
            success: function (data) {
                try {
                    alert(data)

                } catch(e) {
                    alert("JS Error:", e)
                }
            },
        });
    });
});