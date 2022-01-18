$(document).ready(function(){
    // bind the message send button to enter key
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    function generateRoom(chat) {
        let img = "https://cdn.iconscout.com/icon/premium/png-256-thumb/chat-room-3-1058983.png";
        let room = $("<div>", { class: "room_list"});
        room.append($("<div>", {class: "chat_people"})
            .append($("<div>", {class: "chat_img"})
                .append($("<img>", {src: img, alt: "Error"})))
            .append($("<div>", {class: "chat_ib"})
                .append($("<h5>", {class: "chat_name"}).text(chat.name)
                    .append($("<span>", {class: "chat_date"}).text(chat.created_at.split(" ")[0])))));
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
        localStorage.setItem('your_id', $(this).data('id'));

        $(this).siblings().removeClass('active_chat');
        $(this).siblings().removeClass('active_messaging');

        $(this).addClass('active_chat');
        $(this).addClass('active_messaging');

        $('.room_list').removeClass('active_messaging');

        $.ajax({
            url: "/chat/" + $(this).data("id"),
            success: function (data) {
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

        if ( $(".chat_list").hasClass('active_messaging')){
            // for users chat messages
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
        }
        else if ( $(".room_list").hasClass('active_messaging')){
            // for rooms messages
            $.ajax({
                url: "/room/" + localStorage.getItem("roomId") + '/' + $('.write_msg').val(),
                success: function (data) {
                    let myId = localStorage.getItem("my_id");

                    if (data === 'emtpy'){
                        alert('empty text')
                        return;
                    } else if (data.length !== 0){
                        $(".write_msg").val('').attr('readonly', false);
                        $(".msg_history").empty();
                        for(let d of data) {
                            $(".msg_history").append(
                                generateMessage(myId, d)
                            )
                        }
                    }
                }
            });
        }
    });


    $('.plus-button').click(function() {
        let new_room_name = prompt('Enter new room name!\n');

        $.ajax({
            url: "/chat_user/" + new_room_name,
            success: function (data) {
                $(".msg_history").empty();
                $(".write_msg").val('').attr('readonly', false);
                $("#rooms_part").append(
                    generateRoom(data),
                    location.reload(true)
                )
            }
        });
    });


    $('.room_list').click(function() {
        localStorage.setItem('roomId', $(this).data('chat_id'));
        var roomId = localStorage.getItem('roomId');

        $(this).siblings().removeClass('active_chat');
        $(this).siblings().removeClass('active_messaging');

        $(this).addClass('active_chat');
        $(this).addClass('active_messaging');

        $(".chat_list").removeClass('active_messaging');

        $.ajax({
            url: "/rooms/" + roomId,
            success: function (data) {
                let myId = localStorage.getItem("my_id");
                $(".msg_history").empty();
                $(".write_msg").val('').attr('readonly', true);

                if (data.length !== 0){
                    $(".write_msg").val('').attr('readonly', false);
                    for(let d of data) {
                        $(".msg_history").append(
                            generateMessage(myId, d)
                        )
                    }
                }
            }
        });
    })
});
