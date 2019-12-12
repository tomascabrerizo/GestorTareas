<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="CSS/indexStyle.css">
<link rel="stylesheet" href="CSS/formLoginStyle.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<header>
        <ul class = "menu">
        <li><a href="formularioRegistro.php">Registrar</a></li>
        <li><a href="formularioLogin.php">Iniciar Sesion</a></li>
        <li><a href="index.php">Menu</a></li>
        </ul>
</header>
<body>

<?php
    //Validar Formulario
    include_once 'dataBase.php';
    
    session_start();

    //echo $_SESSION["intentos"];

    if($_SESSION["intentos"] >= 2)
    {
        header("Location:error.php");
    }

    $incUser = false;
    $incPass = false;

    if(isset($_POST['loginB'])){
        $user = $_POST['userName'];
        $password = $_POST['userPass'];

        //Traigo array con todos los usuarios con los que validar
        $usuarios = DataBase::getSingleton()->seleccionarDeTabla("usuario", null);

        foreach($usuarios as $usuario){ 
            if($usuario->getNombre() == $user){
                $incUser = false;
                if($usuario->getPass() == $password){
                    
                    $_SESSION["usuarioID"] = $usuario->getUsuarioID();
                    $_SESSION["userName"] = $usuario->getNombre();
                    $_SESSION["email"] = $usuario->getEmail();
                    $_SESSION["userPass"] = $usuario->getPass();
                    $incPass = false;
                    header("Location:login.php");
                }
                else {
                    $incPass = true;
                break;
                }
            }
            else {
                $incUser = true;
            }
        }

        if($incUser == true || $incPass == true)
        {
            $_SESSION["intentos"]++;
        }
    }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <p><input type="text" name="userName" placeholder="Username" class = "field" maxlength="15"></p>
    <?php if($incUser == true){echo "<p class='error'>Usuario incorrecto</p>";}?>
    <p><input type="password" name="userPass" placeholder="Password"class = "field" maxlength="8"></p>
    <?php if($incPass == true){echo "<p class='error'>Contrasena incorrecta</p>";}?>
    <p><input type="submit" name="loginB" value="Login" class = bottom></p>
    </form>
</body>
</html>

