<?php
    include_once 'dataBase.php';
    session_start();
    
    if($_SESSION["usuario"] == " "){

        $_SESSION["tareaComID"] = $_POST['tareaComID'];
        header("Location:formularioLogCom.php");
    }

    if(isset($_POST['tareaComID'])){
        $_SESSION["tareaComID"] = $_POST['tareaComID'];
    }
    $usuario = $_SESSION["usuario"];
    $tareaID = $_SESSION["tareaComID"];

    $tareaArray = DataBase::getSingleton()->seleccionarDeTabla("tarea", $tareaID);
    $tareaFinal = $tareaArray[0];

    if(isset($_POST['Com'])){
        $values["usuarioID"] = $usuario->getUsuarioID();
        $values["tareaID"] = $tareaID;
        $values["comentario"] = $_POST["comentario"];

        DataBase::getSingleton()->InsetarEnTabla("comentarios", $values);
        header("location:$_SERVER[PHP_SELF]");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comentarios</title>
    <link rel="stylesheet" href="CSS/indexStyle.css">
    <link rel="stylesheet" href="CSS/comentarioStyle.css">
</head>
<header>
<header>
        <ul class = "menu">
        <li><a href="login.php"><?php echo $usuario->getNombre()?></a></li>
        <li><a href="opcionesProyecto.php">Proyectos</a></li>
        <li><a href="opcionesTarea.php">Tareas</a></li>
        <li><a href="index.php">Cerrar sesion</a></li>
        </ul>
</header>
</header>
<body>
    <?php $Comentarios = DataBase::getSingleton()->seleccionarDeTabla("comentarios", $tareaFinal->getTareaID()); ?>
    <div class="contenedor">
        <?php foreach ($Comentarios as $Comentario) {
            $usuarioArray = DataBase::getSingleton()->seleccionarDeTabla("usuario", $Comentario->getUsuarioID());
            $usuarioFinal = $usuarioArray[0];
            ?>
            <div class="comentarioTarea">
                <p class = "usuarioTarea">Usuario: <?php echo $usuarioFinal->getNombre(); ?></p>
                <p class="contenido"><b>Comentario:</b><br> <?php echo $Comentario->getComentario(); ?></p>
            </div>
        <?php } ?>
    </div>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <p><textarea maxlength="1000" name="comentario" id="nuevoCom" cols="100" rows="5"></textarea></p>
    <p><input type="submit" name="Com" value="Comentar" class="bottom"></p>
    </form>
</body>
<footer>
</footer>
</html>