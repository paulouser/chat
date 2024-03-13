@extends('layout.main');

@section('content')
<div class="login-box center flex">

    <!-- /.login-logo -->
    <div>
    <div class="flex center"> <h2>Norologic</h2> </div>
    <div class="login-box-body ">

        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
    </div>
</div>
@endsection
