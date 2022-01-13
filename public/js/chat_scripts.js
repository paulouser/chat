$(document).ready(function(){
    $("img").click(function(){
        $("p").toggle('slow');
    });

    $("button.plus-button--small").click(function(){
        $(".chat_date").fadeToggle('slow');
    });

    $('.chat_list').click(function() {
        $.ajax({
            url: "/chat/" + $(this).data("id"),

            success: function (data){
                $(".msg_history").empty();
                let ch = '';
                for(let d of data) {
                    ch += '<button>' + d.message + '</button><br>';
                }
                $(".msg_history").html(ch);
            }
        });


        // console.log($(this).data("id"));
        // $(this).data("my_id", $(this).data("my_id"));
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
