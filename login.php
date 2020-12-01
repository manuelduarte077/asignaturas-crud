<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="text" name="user" placeholder="Nombre de usuario" >
        <input type="password" name="pass" placeholder="Password">
        <input type="submit" name="ingresar" value="Ingresar">
        <br>
        <a href="registroUser.php">Crear Cuenta </a>
    </form>
</body>
</html>
