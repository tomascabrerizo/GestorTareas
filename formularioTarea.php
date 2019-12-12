<?php
include_once 'usuario.php';
session_start();
$usuario = $_SESSION["usuario"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Tarea</title>
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
    <form action="login.php" method="post">
    <p><select name="selecProyecto" class="mySelect">
        <?php foreach($proyectos as $proyecto){ ?>
        <option class="myOption" value= <?php echo $proyecto->getProyectoID() ?>><?php echo $proyecto->getNombre() ?></option>
        <?php } ?>
        </select></p>
    <p><input type="text" name="nombre" placeholder="Nombre" class="field" maxlength="40"></p>
    <p><input type="text" name="descripcion" placeholder="Descripcion" class="field" maxlength="40"></p>
    <p><input type="submit" name="crearT" value="Crear" class = "bottom"></p>
    </form>
</body>
</html>