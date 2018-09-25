<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
      <form action="/registration" method="POST">
        <input type="hidden" name="_Token" value="<?= csrf_token() ?>">
        <input name="username">
        <input name="email">
        <input name="password">
        <input name="confirmPassword">
        <button type="submit">submit</button>
      </form> 
    </body>
</html>