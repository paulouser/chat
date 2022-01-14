<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <link rel="stylesheet" href="../../css/chat_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/chat_scripts.js"></script>
    <script>localStorage.setItem("my_id", "{{ \Illuminate\Support\Facades\Auth::id() }}");</script>
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
                                    <button type="button">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    @foreach(\App\Models\User::all()->except(\Illuminate\Support\Facades\Auth::id()) as $user)
                        <div class="chat_list" data-id="{{ $user->id }}" data-my_id="{{ \Illuminate\Support\Facades\Auth::id() }}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img src="https://static.thenounproject.com/png/862013-200.png" alt="img loading error">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{ $user->name }}</h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Rooms
                                <button class="plus-button"></button>
                            </h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar"  placeholder="Search" >
                                <span class="input-group-addon"></span>
                            </div>
                        </div>
                    </div>
                    @for($i = 0; $i < 3; $i++)
                        <div class="chat_list">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/chat-room-3-1058983.png" alt="img loading error">
                                </div>
                                <div class="chat_ib">
                                    <h5>General room {{ $i + 1 }}<span class="chat_date">Dec 25</span></h5>
                                    <p>aaa@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history">
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="write_msg" placeholder="Type a message" />
                        <button class="msg_send_btn" type="button">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0c/Message_%28Send%29.png" width="28px">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
