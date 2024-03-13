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
      <!-- Header -->
      <div class="top w-full center flex  header2">
        <div>
            <div class="flex w-full text-center center">
                <p class="titulo">Chats</p>
            </div>
            <p class="subtitulo"> (Norochat) </p>
        </div>
    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div id="m" class=" messages-container  w-full p-10 ">
            @foreach ($canais as $id => $name)
            <form  id="inscrever" method="POST">
                @csrf
            <div class="flex w-full justify-between"><a  href="{{ URL::to('/'.$id) }}">{{$name}}</a><button>inscrever</button> </div>
            </form>
            @endforeach
    </div>
    <div>
    <div class="flex pt-5"><h2 class="subtitulo">Crie o seu Chat</h2></div>
    <form id="criar" action="{{route('criarchat')}}"" method="POST">
        @csrf
        <input class="input-custom1" id="nomechat" name="nomechat" type="text">
        <button type="submit">Criar</button>
    </form>
    </div>
    <!-- End Chat -->

    <!-- Footer -->

    <!-- End Footer -->

  </div>
@endsection

@section('script')
<script>

</script>

@endsection
