<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    
    <p>Dear Mr./Ms. {{$name}}</p>
    <p>Thank you for registering!</p>
    <p>To start, you can access the site <a href="{{ $appURL }}">here</a>.</p>
    <p>Welcome!</p>

    {{-- $appURLはenvのAPP_URLに書かれているURL--}}
    {{-- laravel-insta\app\Http\Controllers\Auth\RegisterController.phpで定義している --}}
    
</body>
</html>