<?php
include_once 'usuario.php';
session_start();
$usuario = $_SESSION["usuario"];

if(isset($_POST['modificarT']))
{
    DataBase::getSingleton()->modificarTarea($_POST["tareaSelec"], 
    $_POST["nombre"], $_POST["descripcion"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Tarea</title>
    <link rel="stylesheet" href="CSS/indexStyle.css">
    <link rel="stylesheet" href="CSS/formLoginStyle.css">   
</head>
<header>
        <ul class = "menu">
        <li><a href="login.php"><?php echo $usuario->getNombre()?></a></li>
        <li><a href="formularioProyecto.php">Proyectos</a></li>
        <li><a href="opcionesTarea.php">Tareas</a></li>
        <li><a href="index.php">Cerrar sesion</a></li>
        </ul>
</header>
<body>

<?php
$tareas = $usuario->obtenerTareas();
?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <p><select name="tareaSelec" class="mySelect">
        <?php foreach($tareas as $tarea){ ?>
        <option class="myOption" value= <?php echo $tarea->getTareaID() ?>><?php echo $tarea->getNombre() ?></option>
        <?php } ?>
        </select></p>
    <p><input type="text" name="nombre" placeholder="Nombre" class="field" maxlength="40"></p>
    <p><input type="text" name="descripcion" placeholder="Descripcion" class="field" maxlength="40"></p>
    <p><input type="submit" name="modificarT" value="Modificar" class = "bottom"></p>
    </form>
</body>
</html>