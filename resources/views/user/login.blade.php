<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>

    <h1>请登录</h1>

    <form action="/login" method="post">
        {{csrf_field()}}
        <input type="text" name="u"><br>
        <input type="password" name="p"><br>
        <input type="submit" value="LOGIN">

    </form>
</body>
</html>