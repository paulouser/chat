$(document).ready(function(){
    // bind the message send button to enter key
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    $('.room_list').click(function() {

        $(this).siblings().removeClass('active_chat');
        $(this).addClass('active_chat');
        $(".msg_history").empty();
    })

    function generateNewRoom(room_name) {
        let img = "https://cdn.iconscout.com/icon/premium/png-256-thumb/chat-room-3-1058983.png";
        let room = $("<div>", { class: "room_list"});

        room.append($("<div>", {class: "chat_people"})
            .append($("<div>", {class: "chat_img"})
                .append($("<img>", {src: img, alt: "Error"})))
            .append($("<div>", {class: "chat_ib"})
                .append($("<h5>", {class: "chat_name"}).text(room_name)
                    .append($("<span>", {class: "chat_date"}).text("Dec 25")))));
        return room;
    }



    function generateMessage(myId=null, data) {
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
        $(this).siblings().removeClass('active_chat');
        $(this).addClass('active_chat');
        localStorage.setItem('your_id', $(this).data('id'));

        $.ajax({
            url: "/chat/" + $(this).data("id"),
            success: function (data) {
                localStorage.setItem("clicked_id",  $(this).data("id"));
                let myId = localStorage.getItem("my_id");

                $(".msg_history").empty();
                $(".write_msg").val('').attr('readonly', false);

                if (data.length !== 0){
                    for(let d of data) {
                        $(".msg_history").append(
                            generateMessage(myId, d)
                        )
                    }
                }
            }
        });
    });

    $('.msg_send_btn').click(function() {
        $.ajax({
            url: "/messages/" + localStorage.getItem("your_id") + '/' + $('.write_msg').val(),
            success: function (data) {
                let myId = localStorage.getItem("my_id");

                if (data === 'emtpy'){
                    // alert('empty text')
                    return;
                } else{
                    $(".msg_history").empty();
                    if (data.length === 0){
                        alert('All chat history deleted from server!')
                    }else if (data.length !== 0){
                        $(".write_msg").val('').attr('readonly', false);
                        for(let d of data) {
                            $(".msg_history").append(
                                generateMessage(myId, d)
                            )
                        }
                    }
                }
            }
        });
    });


    $('.plus-button').click(function() {
        var chat_name = prompt("Please enter chat name");

        $.ajax({
            url: "/chat_user/" + chat_name,
            success: function (data) {
                $(".msg_history").empty();
                $(".write_msg").val('').attr('readonly', false);

                $("#rooms_part").append(
                    generateNewRoom()
                )
                if (data.length !== 0) {
                    for (let d of data) {
                        $(".msg_history").append(
                            generateMessage(data)
                        )
                    }
                }
            }
        });
    });
});
