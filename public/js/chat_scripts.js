$(document).ready(function(){
    // bind the message send button to enter key
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    function generateMessage(myId=null, data) {
        console.log(data.user_id);
        // let msgType = data.user_id == myId ? "outgoing_msg" : "incomming_msg";
        let msgType = data.user_id == myId ? "out" : "in";
        let img = data.img_path;
        let msg = `
        <ul class="message-list">
          <li class=${ msgType }>
            <div class="message-img">
              <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar2.png">
            </div>
            <div class="message-body">
              <div class="chat-message">
                <h5 class="name">${ data.name }</h5>
                <p class="text">${ data.message }</p>
                <p class="date">${ data.created_at }</p>
              </div>
            </div>
          </li>
        </ul>`
        return msg;
    }

    $('.chat_list').click(function() {
        localStorage.setItem('your_id', $(this).data('id'));

        $(this).siblings().removeClass('active_chat');
        $(this).siblings().removeClass('active_messaging');

        $(this).addClass('active_chat');
        $(this).addClass('active_messaging');

        $('.room_list').removeClass('active_messaging');
        $(".participate"). css("display", "none");
        $(".room_name"). css("display", "none");
        $(".new_room_name_btn"). css("display", "none");


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


    $('.adding_room').click(function(){
        $(".msg_history").empty();
        $(".room_name"). css("display", "block").val('').attr('readonly', false);
        $(".new_room_name_btn"). css("display", "block").val('').attr('readonly', false);
    });


    $('.new_room_name_btn').click(function() {
        let new_room_name = $('.room_name').val();
        $(".msg_history").empty();
        $(this). css("display", "none");
        $(".room_name"). css("display", "none");


        $.ajax({
            url: "/add_room/" + new_room_name,
            success: function () {
                $(".write_msg").val('').attr('readonly', false).append(location.reload(true));
            }
        });
    });


    // // generate in place the user in table
    // let user = {};
    // let html = `<div className="chat_list" data-id="${user.id}">
    //     <div className="chat_people">
    //         <div className="chat_img">
    //             <img src="${user.img_path}" alt="img loading error">
    //         </div>
    //         <div className="chat_ib">
    //             <h5>${$user.name}
    //                 <span className="chat_date">${$user.created_at}</span>
    //             </h5>
    //             <p>${user.email}</p>
    //         </div>
    //     </div>
    // </div>`;


    $('.participate').click(function (){
        let roomId = localStorage.getItem('roomId');
        let myId = localStorage.getItem("my_id");

        $(".msg_history").empty();
        // $(".participate").hide();
        $(".participate"). css("display", "none");

        // load the messages
        $.ajax({
            url: "/getmessages/" + roomId,
            success: function (data) {
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
        })
    });

    $('.room_list').click(function() {
        localStorage.setItem('roomId', $(this).data('chat_id'));
        var roomId = localStorage.getItem('roomId');
        $(".msg_history").empty();

        $(this).siblings().removeClass('active_chat');
        $(this).siblings().removeClass('active_messaging');

        $(this).addClass('active_chat');
        $(this).addClass('active_messaging');

        $(".chat_list").removeClass('active_messaging');
        $(".write_msg").val('').attr('readonly', true);
        $(".participate"). css("display", "none");

        $(".room_name"). css("display", "none");
        $(".new_room_name_btn"). css("display", "none");

        $.ajax({
            url: "/checking/" + roomId,
            success: function (data) {
                $(".write_msg").val('').attr('readonly', true);

                if (data['status'] == true){
                    console.log('already in');
                    $(".msg_history").empty();
                    let myId = localStorage.getItem("my_id");
                    $(".write_msg").val('').attr('readonly', false);
                    $(".msg_history").empty();

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
                    $(".participate"). css("display", "block");
                }
            }
        });
    });
});
