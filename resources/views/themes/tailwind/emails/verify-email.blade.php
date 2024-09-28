<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido Email</title>
</head>

<body>
<h2>Bienvenido a Vitris {{$user['name']}}</h2>
<br/>
Su identificación de correo electrónico registrada es {{$user['email']}} , Haga clic en el siguiente enlace para verificar su cuenta de correo electrónico.
<br/>
<a href="{{ url('user/verify/', $user['verification_code']) }}">Verificar Correo Electronico</a>
</body>

</html>