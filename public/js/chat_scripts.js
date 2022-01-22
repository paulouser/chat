$(document).ready(function(){
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    // $('.srch_bar').change(function (){
    //     // alert($('#searching').val());
    // });

    function generateMessage(myId=null, data) {
        console.log(data.user_id);
        // let msgType = data.user_id == myId ? "outgoing_msg" : "incomming_msg";
        let msgType = data.user_id == myId ? "out" : "in";
        let img = data.img_path;
        let msg = `
        <ul class="message-list">
          <li class=${ msgType }>
            <div class="message-img">
              <img alt="Avatar" src= ${ "storage/img_paths/" + data.user_id + '/' + data.img_path }>
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
    };

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
        $("#myFile"). css("display", "block");
    });


    $('.new_room_name_btn').click(function() {
        let new_room_name = $('.room_name').val();

        $(".msg_history").empty();
        $(this). css("display", "none");
        $(".room_name"). css("display", "none");
        $("#myFile"). css("display", "none");

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

    // window.getValue = function getValue() {
    //     let value = $('#searching').val();
    //     $('#ddlist').append(`<option value="Select">${ localStorage.getItem('my_id') + ' || ' + localStorage.getItem('your_id') + ' || ' + localStorage.getItem('roomId')}</option>`);
    // }

    $(document).on('change', '#searching', function() {
        $.ajax({
            url: "/generate_searching_list/" + $(this).val(),
            success: function (data) {
                // if there is a list of matching users then generate dropdown list
                if (data['status'] == true){
                    // if matching list not empty, then generate dropdown list
                    // before generating dropdown we must clear previous list
                    $('#ddlist').empty();
                    $('#ddlist').append(
                        `<option class="items" value="Select">Select user</option>`
                    )
                    if (data['list'].length !== 0){
                        // $('#ddlist').attr('size', data['list'].length);
                        for(let d of data['list']) {
                            $('#ddlist').append(
                                `<option class="items" value="${ d.id }" data-list_item_id="${ d.id }">${ d.name }</option>`
                            )
                        }
                    }
                }
            }
        });
    });

    function generateFriend(friend){
        return
        ` <div class="chat_list" data-id="${ friend.user_id }">
                <div class="chat_people">
                    <div class="chat_img">
                        <img src="storage/img_paths/${ friend.user_id }/${ friend.img_path }" alt="img loading error">
                    </div>
                    <div class="chat_ib">
                        <h5>${ friend.user_name }
                            <span class="chat_date">${ friend.created_at.format("Y m d") }</span>
                        </h5>
                        <p>${ friend.user_email }</p>
                    </div>
                </div>
            </div>`
    }

    $(document).on('change', 'select', function() {
        myId = localStorage.getItem('my_id')
        clicked_item_id = this.value;
        $('#ddlist').empty();
        console.log(this.value);
        $.ajax({
            url: "/add_and_generate_friend_list/" + clicked_item_id,
            success: function (data) {
                if (data.length !== 0){
                    for(let d of data) {
                        if (d.id != myId){
                            $('.inbox_chat').append(
                                generateFriend(myId, d)
                            )
                        }
                    }
                }
            }
        });
    });
});
