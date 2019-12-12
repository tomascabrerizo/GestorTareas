<?php
include_once 'usuario.php';
session_start();
$usuario = $_SESSION["usuario"];

if(isset($_POST['eliminarP']))
{
    DataBase::getSingleton()->eliminarProyecto($_POST["proyecSelec"]);
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
        <li><a href="opcionesProyecto.php">Proyectos</a></li>
        <li><a href="opcionesTarea.php">Tareas</a></li>
        <li><a href="index.php">Cerrar sesion</a></li>
        </ul>
</header>
<body>

<?php
$proyectos = $usuario->obtenerProyectos();
?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <p><select name="proyecSelec" class="mySelect">
        <?php foreach($proyectos as $proyecto){ ?>
        <option class="myOption" value= <?php echo $proyecto->getProyectoID() ?>><?php echo $proyecto->getNombre() ?></option>
        <?php } ?>
        </select></p>
    <p><input type="submit" name="eliminarP" value="Eliminar" class = "bottom"></p>
    </form>
</body>
</html>