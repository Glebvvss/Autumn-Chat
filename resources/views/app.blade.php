<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Autumn Chat</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="main"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.dev.js"></script>
        <script src="{{asset('js/app.js')}}" ></script>
    </body>
</html>
