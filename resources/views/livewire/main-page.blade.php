<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/chat_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/chat_scripts.js"></script>
    <script>
        localStorage.setItem("my_id", "{{ \Illuminate\Support\Facades\Auth::id() }}");
    </script>
</head>

<body>
<div class="container">
    <h3 class="text-center">Chat history</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="heading_srch">
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
                        <div class="chat_list" data-id="{{ $user->id }}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img src="storage/img_paths/{{ $user->id }}/{{ $user->img_path }}" alt="img loading error">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{ $user->name }}
                                        <span class="chat_date">{{ $user->created_at->format("Y m d") }}</span>
                                    </h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="heading_srch">
                        <div class="recent_heading">
                            <h4 >Rooms
                                <button class="adding_room plus-button plus-button--small"></button>
                            </h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar"  placeholder="Search" >
                                <span class="input-group-addon"></span>
                            </div>
                        </div>
                    </div>
                    <div id="rooms_part">
                        @foreach(\App\Models\chat::all() as $chat)
                            @if(!$chat->type)
                                <div class="room_list" style='overflow: hidden' data-chat_id="{{ $chat->id }}">
                                    <div class="chat_people">
                                        <div class="chat_img">
                                            <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/chat-room-3-1058983.png" alt="img loading error">
                                        </div>
                                        <div class="chat_ib">
                                            <h5>{{ $chat->name }}<span class="chat_date">{{ $chat->created_at->format('Y m d') }}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mesgs">
                <button type="button" class=" btn btn-outline-success participate" style="display: none">Participate</button>
                <input type="text" class="room_name" placeholder="Enter a new room name!" style="display: none" readonly />
                <button type="button" class="btn btn-outline-success new_room_name_btn"  style="display: none" id="new_room_name">Create</button>

                <div class="msg_history">
                </div>
                <div class="type_msg">
                    <div>

                        <input type="text" class="write_msg" placeholder="Type a message" readonly />
                        <button class="msg_send_btn" type="button" id="send_message">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0c/Message_%28Send%29.png" width="28px">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</div>
</body>
</html>
