<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <link rel="stylesheet" href="../../css/chat_style.css">
</head>
<body>
<div class="container">
    <h3 class="text-center">Chat history</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Users</h4>
                    </div>
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar"  placeholder="Search" >
                            <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    <div class="chat_list active_chat">
                        <div class="chat_people">
                            <div class="chat_img"> <img src="https://library.kissclipart.com/20180913/hfe/kissclipart-helpdesk-icon-clipart-help-desk-computer-icons-cli-37cda048479ee068.png" alt="sunil"> </div>
                            <div class="chat_ib">
                                <h5>Narek<span class="chat_date">Dec 25</span></h5>
                                <button onclick="/#">click here</button>
                            </div>
                        </div>
                    </div>
                    @foreach(\App\Models\User::all()->except(\Illuminate\Support\Facades\Auth::id()) as $user)
                        <div class="chat_list">
                            <div class="chat_people">
                                <div class="chat_img"> <img src="https://static.thenounproject.com/png/862013-200.png" alt="sunil"> </div>
                                <div class="chat_ib">
                                    <h5>{{ $user->name }} <span class="chat_date">Dec 25</span></h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr style="height:5px; width:100%; border-width:0;">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Rooms
                            <button class="plus-button plus-button--small"></button>

                            </h4></div>

                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar"  placeholder="Search" >
                                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>

                        </div>
                    </div>
                    <div class="chat_list active_chat">
                        <div class="chat_people">
                            <div class="chat_img"> <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/chat-room-3-1058983.png" alt="sunil"> </div>
                            <div class="chat_ib">
                                <h5>General room<span class="chat_date">Dec 25</span></h5>
                                <p>aaa@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history">
                    <div class="incoming_msg">
                        <div class="incoming_msg_img"> <img src="https://static.thenounproject.com/png/862013-200.png" alt="sunil"> </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>Lorem ipsum<br>Lorem ipsum</p>
                                <span class="time_date"> 11:01 AM    |    June 9</span></div>
                        </div>
                    </div>
                    <div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>Lorem ipsum<br>Lorem ipsum</p>
                            <span class="time_date"> 11:01 AM    |    June 9</span> </div>
                    </div>
                    <div class="incoming_msg">
                        <div class="incoming_msg_img"> <img src="https://static.thenounproject.com/png/862013-200.png" alt="sunil"> </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>Lorem ipsum</p>
                                <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
                        </div>
                    </div>
                    <div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>Lorem ipsum</p>
                            <span class="time_date"> 11:01 AM    |    Today</span> </div>
                    </div>
                    <div class="incoming_msg">
                        <div class="incoming_msg_img"> <img src="https://static.thenounproject.com/png/862013-200.png" alt="sunil"> </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>Lorem ipsum<br>Lorem ipsum</p>
                                <span class="time_date"> 11:01 AM    |    Today</span></div>
                        </div>
                    </div>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="write_msg" placeholder="Type a message" />
                        <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</body>
</html>
