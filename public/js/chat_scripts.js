$(document).ready(function(){
    $("img").click(function(){
        $("p").toggle('slow');
    });

    $("button.plus-button--small").click(function(){
        $(".chat_date").toggle('fast');
    });

    $('.chat_list').click(function() {
        console.log($(this).data("id"))
    });

    // $("p").click(function(){
    //     $(this).hide(1000);
    // });

    $("img").dblclick(function(){
        $(this).toggle('slow');
    });

    // $(".chat_date").mouseenter(function(){
    //     alert("You entered chat_date!");
    // });
});
