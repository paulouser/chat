@extends('layout.main');
@section("header")

  <!-- JavaScript -->
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- End JavaScript -->


@endsection
@section('content')
<div class="chat full">

    <!-- Header -->
    <div class="top w-full center flex  mb-10">
    <div>
      <div class="flex w-full text-center center">
        <p class="titulo">{{$name}}</p>
      </div>
      <p class="subtitulo">Este é um chat Norologioc (Norochat) </p>
    </div>

    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div id="m" class="messages-container w-full p-10 p">

    </div>
    <!-- End Chat -->

    <!-- Footer -->
    <div class="flex center w-full">
      <form class="w-full">
        @csrf
        <textarea class="w-full" id="message" name="message" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off placeholder="Enter message..." autocomplete="off"></textarea>

        <button class="w-full" type="submit">Send</button>
      </form>
    </div>
    <!-- End Footer -->

  </div>
@endsection

@section('script')
<script>
    const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'eu'});
    const channel = pusher.subscribe('public');

    //Receive messages
    channel.bind('chat'+{{$id}}, function (data) {
      $.post("receive", {
        _token:  '{{csrf_token()}}',
        message: data.message,
        user:data.user,
      })
       .done(function (res) {
        $("#m").append(res);
         $(document).scrollTop($(document).height());
       });
    });

    //Broadcast messages
    $("form").submit(function (event) {
      event.preventDefault();

      $.ajax({
        url:     "broadcast",
        method:  'POST',
        headers: {
          'X-Socket-Id': pusher.connection.socket_id
        },
        data:    {
          _token:  '{{csrf_token()}}',
          message: $("form #message").val(),
          user:'{{auth()->user()->name}}'
        }
      }).done(function (res) {
        $("#m").append(res);
        $("form #message").val('');
        $(document).scrollTop($(document).height());
      });
    });

  </script>
@endsection
