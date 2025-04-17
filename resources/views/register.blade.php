<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

     <form action="{{ route('register') }}" method="post">
        @csrf

        <input type="email" placeholder="email" name="email" >
        <input type="text" placeholder="password" name = "password">
        <input type="text" placeholder="confirm password" name = "password_confirmation">
        <input type="text" placeholder="name" name = "name">
        <input type="text" placeholder="username" name = "username">
        <input type="submit" placeholder="Register">

        <div>{{ $errors }}</div>
    </form>
    
</body>
</html>