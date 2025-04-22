<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="{{ route('login.post') }}" method="post">
        @csrf

        <input type="text" placeholder="email" name="email" >
        <input type="text" placeholder="password" name = "password">
        <input type="submit" placeholder="Login">

        <div>{{ $errors }}</div>
    </form>
    
</body>
</html>