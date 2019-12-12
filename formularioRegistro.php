<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="CSS/indexStyle.css">
    <link rel="stylesheet" href="CSS/formLoginStyle.css">
</head>
<header>
        <ul class = "menu">
        <li><a href="formularioRegistro.php">Registrar</a></li>
        <li><a href="formularioLogin.php">Iniciar Sesion</a></li>
        <li><a href="index.php">Menu</a></li>
        </ul>
</header>
<body>
    <form action=registrar.php method="post">
    <p><input type="text" name="userName" size="10" placeholder="Username" class = "field" maxlength="15"></p>
    <p><input type="text" name="email"  size="10" placeholder="Email" class = "field"></p>
    <p><input type="password" name="userPass"  size="10" placeholder="Password" class = "field" maxlength="8"></p>
    <p><input type="submit" name="registrarB" value='Registrar' class = "bottom"></p>
    </form>
</body>

</html>
