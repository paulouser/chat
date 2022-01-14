$(document).ready(function(){
    $("img").click(function(){
        $("p").toggle('slow');
    });

    $("button.plus-button--small").click(function(){
        $(".chat_date").fadeToggle('slow');
    });

    function generateMessage(myId, data) {
        let msgType = data.user_id == myId ? "outgoing_msg" : "incomming_msg";
        let img = "https://static.thenounproject.com/png/862013-200.png";
        let msg = $("<div>", {class: "message"});
        msg.append($("<div>", {class: msgType})
            .append($("<div>", {class: "message_img"})
                .append($("<img>", {src: img, alt: "Error"})))
            .append($("<div>", {class: "message_body"})
                .append($("<p>", {class: "message_text"}).text(data.message))
                .append($("<span>", {class: "message_time"}).text(data.created_at))));
        return msg;
    }

    $('.chat_list').click(function() {
        $.ajax({
            url: "/chat/" + $(this).data("id"),
            success: function (data) {
                let myId = localStorage.getItem("my_id");
                $(".msg_history").empty();

                for(let d of data) {
                    $(".msg_history").append(
                        generateMessage(myId, d)
                    )
                }
            }
        });
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
