$(document).ready(function(){
    $('.btn').hide();
    // bind the message send button to enter key
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    function generateMessage(myId=null, data) {
        console.log(data.user_id);
        let msgType = data.user_id == myId ? "outgoing_msg" : "incomming_msg";
        let img = "https://static.thenounproject.com/png/862013-200.png";
        let msg = $("<div>", {class: "message"});
        msg.append($("<div>", {class: msgType})
            .append($("<div>", {class: "message_img"})
                .append($("<img>", {src: img, alt: "Error"})))
            .append($("<div>", {class: "message_body"})
                .append($("<p>", {class: 'message_writer'}).text(data.name))
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
                        $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);
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
                        console.log('empty text');
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
                                );
                            }
                            $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);
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
                        console.log('empty text');
                        return;
                    } else if (data.length !== 0){
                        $(".write_msg").val('').attr('readonly', false);
                        $(".msg_history").empty();
                        for(let d of data) {
                            $(".msg_history").append(
                                generateMessage(myId, d)
                            )
                            $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);

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
                $(".write_msg").val('').attr('readonly', false).append(location.reload(true));
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
        $(".write_msg").val('').attr('readonly', true);


        $.ajax({
            url: "/checking/" + roomId,
            success: function (data) {
                $(".write_msg").val('').attr('readonly', true);
                $(".msg_history").empty();

                if (data['status'] == true){
                    console.log('already in');
                    data['status'] = false;
                    let myId = localStorage.getItem("my_id");
                    $(".write_msg").val('').attr('readonly', false);
                    $(".msg_history").empty();

                    console.log(data);
                    if (data['messages'].length !== 0){
                        for(let d of data['messages']) {
                            $(".msg_history").append(
                                generateMessage(myId, d)
                            )
                            $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);
                        }
                    }
                }
                else if (data['status'] == false){
                    $('.btn').show();
                    // $('.btn-success').trigger('click');
                    //
                    // $('.btn-success').click(function (){
                    //     $(".write_msg").val('').attr('readonly', false);
                    //     console.log('accepted');
                    //     data['status'] = true;
                    // })
                }
                return data;
            }
        }).then(function (data){
            if (data['status'] ==  true){
                return $.ajax({
                    url: "/rooms/" + roomId,
                    success: function (data) {
                        let myId = localStorage.getItem("my_id");
                        $(".write_msg").val('').attr('readonly', false);
                        $(".msg_history").empty();

                        console.log(data[0]);
                        if (data.length !== 0){
                            for(let d of data) {
                                $(".msg_history").append(
                                    generateMessage(myId, d)
                                )
                                $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);
                            }
                        }
                    }
                })
            }
        });
    });
});
