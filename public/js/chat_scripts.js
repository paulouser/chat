$(document).ready(function(){
    $("img").click(function(){
        $("p").toggle('slow');
    });

    $("button.plus-button--small").click(function(){
        $(".chat_date").fadeToggle('slow');
    });

    $('.chat_list').click(function() {
        console.log($(this).data("id"))
    });

    $(".chat_list").click(function(){
        $(this).siblings().removeClass('active_chat');
        $(this).addClass('active_chat');
    });


    // $("img").dblclick(function(){
    //     $(this).toggle('slow');
    // });

    // $(".chat_date").mouseenter(function(){
    //     alert("You entered chat_date!");
    // });
});
