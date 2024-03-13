<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @yield("header")



        <!-- Styles -->
        <link rel="stylesheet" href="/index.css">
    </head>
    <body class="">
        @include("components.Header")
        <div class="full flex center p-5">
            @yield("content")

        </div>
        @yield("script")
    </body>
</html>
