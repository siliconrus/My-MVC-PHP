$(document).ready(function()
{ 
    $('form').submit(function(event)
    {
        let json;
        event.preventDefault();
        $.ajax(
        {
            type: $(this).attr('method'),
            url: $(this). attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(result)
            {
                json = jQuery.parseJSON(result);
                if(json.url)
                {
                    window.location.href =  '/' + json.url;
                } else
                {
                    alert(json.status + ' - ' + json.message);
                }
            },
        });
    });

    // $('#printCheck').on('click', function (e) {
    //     //e.preventDefault();
    //     email = $('#JSONcheck').val();
    //     submit = $('#printCheck').attr('id');
    //     arrData = {email: email, submit: submit};
    //
    //     $.ajax({
    //         url: "/main/delete/<?=$posts['id']?>",
    //         method: "GET",
    //         data: arrData,
    //         success: function (data) {
    //             try {
    //                 alert(data)
    //
    //             } catch(e) {
    //                 alert("JS Error:", e)
    //             }
    //         },
    //     });
    // });

});

// Закрыть попап «спасибо»
$('.js-close-thank-you').click(function() { // по клику на крестик
    $('.js-overlay-thank-you').fadeOut();
});

$(document).mouseup(function (e) { // по клику вне попапа
    var popup = $('.popup');
    if (e.target!=popup[0]&&popup.has(e.target).length === 0){
        $('.js-overlay-thank-you').fadeOut();
    }
});


