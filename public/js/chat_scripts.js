$(document).ready(function(){
    $.ajax({ url: "/generate_friend_list",
        context: document.body,
        success: function(data){
            const unique = [];
            data.map(x => unique.filter(a => a.name == x.name && a.id == x.id).length > 0 ? null : unique.push(x));
            myId = localStorage.getItem('my_id');
            $('#friend_list').empty();
            for(let friend of unique) {
                if (friend.id != myId) {
                    $('#friend_list').append(
                        generateFriend(friend)
                    )
                }
            }
        }
    });

    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
    });

    $('#ddlist').empty().hide();

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

    function generateFriend(friend){
        return  ` <div class="chat_list" data-id=${ friend.id }>
                <div class="chat_people">
                    <div class="chat_img">
                        <img src="storage/img_paths/${ friend.id }/${ friend.img_path }" alt="img loading error">
                    </div>
                    <div class="chat_ib">
                        <h5>${ friend.name }
                            <span class="chat_date">${ friend.created_at }</span>
                        </h5>
                        <p>${ friend.email }</p>
                    </div>
                </div>
            </div>`
    };


    $(document).on ("click", ".chat_list", function () {
        // alert("hi");
        localStorage.setItem('your_id', $(this).data('id'));

        $(this).siblings().removeClass('active_chat');
        $(this).siblings().removeClass('active_messaging');

        $(this).addClass('active_chat');
        $(this).addClass('active_messaging');

        $('.room_list').removeClass('active_messaging');
        $(".participate"). css("display", "none");
        $(".room_name"). css("display", "none");
        $(".new_room_name_btn"). css("display", "none");
        // alert('before ajax');


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

    $(document).on ("click", ".room_list", function (){
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


    $(document).on('change', '#searching', function() {
        myId = localStorage.getItem('my_id');
        $('#ddlist').empty().show();
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
                            if (d.id != myId){
                                $('#ddlist').append(
                                    `<option class="items" value="${ d.id }" data-list_item_id="${ d.id }">${ d.name }</option>`
                                )
                            }
                        }
                    }
                }
            }
        });
    });

    $(document).on('change', 'select', function() {
        clicked_item_id = this.value;
        $('#ddlist').empty().hide();
        $.ajax({
            url: "/add_friend/" + clicked_item_id,
            success: function (data) {
                if (data == true){
                    $('.inbox_chat').append(location.reload(true))
                }
            },
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
                    } else{
                        $(".msg_history").empty();
                        $(".write_msg").val('').attr('readonly', false);
                        if (data.length === 0) {
                            alert('All chat history deleted from server!')
                        }else if (data.length !== 0){
                            for(let d of data) {
                                $(".msg_history").append(
                                    generateMessage(myId, d)
                                )
                                $(".msg_history").animate({scrollTop: $(".msg_history")[0].scrollHeight}, 10);
                            }
                        }
                    }
                }
            });
        }
    });

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

});
