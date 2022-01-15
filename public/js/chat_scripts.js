$(document).ready(function(){
    // bind the message send button to enter key
    $('.type_msg').keypress(function(e){
        if (e.which === 13){
            $(".msg_send_btn").click();
        }
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
        $(this).siblings().removeClass('active_chat');
        $(this).addClass('active_chat');
        localStorage.setItem('your_id', $(this).data('id'));

        $.ajax({
            url: "/chat/" + $(this).data("id"),
            success: function (data) {
                localStorage.setItem("clicked_id",  $(this).data("id"));
                let myId = localStorage.getItem("my_id");

                $(".msg_history").empty();
                $(".write_msg").val('');
                $(".write_msg").attr("readonly", false);

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
        // alert($('.write_msg').val());

        $.ajax({
            url: "/messages/" + localStorage.getItem("your_id") + '/' + $('.write_msg').val(),
            success: function (data) {
                if (data === 'emtpy_message'){
                    alert('empty text')
                    return;
                }else if (data.length === 0){
                    alert('you enter delete, \nall chat history deleted from server\noops!')
                }
                let myId = localStorage.getItem("my_id");
                $(".msg_history").empty();
                $(".write_msg").val('');
                $(".write_msg").attr("readonly", false);

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
});
