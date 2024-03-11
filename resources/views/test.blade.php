<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('./../js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
    <form action="">
        <input type="text" id="message">
        <button type="submit" >click</button>
    </form>
    <button onclick="showAlert('Hello')">Click</button>
    <script>
        import Echo from 'laravel-echo';
        import Pusher from 'pusher-js';

        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            forceTLS: false
            wsHost: window.location.hostname,
            wsPort: 6001,
            encrypted:false,
            enabledTransports: ['ws','wss'],
        });
        const message = document.getElementById('message');
        const form = document.getElementById('form');

        form.addEventListener('submit', (e) => {

        }
        Echo.private(`orders.${orderId}`)
        .listen('OrderShipmentStatusUpdated', (e) => {
           // console.log(e.order);
            showAlert(e.order);
        })

    </script>
</body>
</html>

