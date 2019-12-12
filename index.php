<?php
include_once 'dataBase.php';
?>

<?php
    session_start();
    $_SESSION["usuario"] = " ";
    $_SESSION["intentos"] = 0;

    //Si se ha cambiado el estado de una tarea
    if(isset($_POST["valuesPHP"]))
    {
        $stringDatos = $_POST["valuesPHP"];
        preg_match_all('!\d+!', $stringDatos, $matches);

        $tareaID = $matches[0][0];
        $nuevoEstado = $matches[0][1];

        $nuevaTarea = DataBase::getSingleton()->seleccionarDeTabla("tarea", $tareaID);
        $objTarea = $nuevaTarea[0];

        //Cabiar el estado del objeto al nuevo
        $objTarea->cambiarEstado($nuevoEstado);
        header("location:$_SERVER[PHP_SELF]");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="CSS/indexStyle.css">
</head>

<header>
        <ul class = "menu">
        <li><a href="formularioRegistro.php">Registrar</a></li>
        <li><a href="formularioLogin.php">Iniciar Sesion</a></li>
        </ul>
</header>
<body>
        <table style="width:100%" class="tablaIndex">
            <tr class = "marcador">
                <td>Proyecto</td>
                <td>Usuario</td>
                <td class = "fijo">Tarea</td>
                <td class = "fijo">Descripcion</td>
                <td class = "comentario">Comentario</td>
                <td class = "estado">Estado</td>
                
            </tr>
            <?php
            $tareas = DataBase::getSingleton()->seleccionarDeTabla("tarea", null);
            foreach ($tareas as $tarea) {
                $filaClass = " ";
                switch ($tarea->getEstado()) {
                    case 0:
                        $ruta = "RES/EMOTES/0.png";
                    break;
                    case 25:
                        $ruta = "RES/EMOTES/25.png";
                    break;
                    case 50:
                        $ruta = "RES/EMOTES/50.png";
                    break;
                    case 100:
                        $ruta = "RES/EMOTES/100.png";
                        $filaClass = "tareaCompleta";
                    break;
                }?>
            <tr class = "tareas" id="<?php echo $filaClass; ?>">
                <td class="proyecto"><?php echo $tarea->getProyecto();?></td>
                <td><?php echo $tarea->getUsuario();?></td>
                <td class = "fijo"><?php echo $tarea->getNombre();?></td>
                <td class = "fijo"><?php echo $tarea->getDescripcion();?></td>
                
                <td class = "comentario"><img src="RES/comentarioWhite.png" alt="comentarios"
                onclick="verComentarios(<?php echo $tarea->getTareaID();?>);"></td>

                <td class = "estado"><img src= <?php echo $ruta; ?> alt="estado"
                id="cambiarEstado" tareaID=<?php echo $tarea->getTareaID();?>
                onclick="mostrarModal(<?php echo $tarea->getTareaID();?>);posicionModal(window.event);"></td>
            </tr>
            <?php 
        } ?> 
        </table>

</body>
<footer>
</footer>

<?php include_once 'INCLUDES/modal.html';?>

<script>
    var idFinal;
    function mostrarModal(id){
        html = document.documentElement;
        if(html.offsetHeight > window.innerHeight){
            document.getElementById("myModal").style.height = html.offsetHeight + "px";
        }
        document.getElementById("myModal").style.display = "block";
        idFinal = id;
    }

    window.onclick = function(e){
        if(e.target == document.getElementById("myModal")){
            document.getElementById("myModal").style.display = "none";
        }
    }
    
    function cambiarEstado(num){ 
        //concateno ambos valores en un string para enviarlos por POST
        var valor = ''.concat(idFinal, " ",num);
        document.enviarVAL.valuesPHP.value=valor;
        document.enviarVAL.submit();
    }

    function posicionModal(event)
    {
        x= event.clientX - 65;
        y=event.clientY + 27 + window.pageYOffset;
        
        document.getElementById("modalID").style.left=x+"px";
        document.getElementById("modalID").style.top=y+"px";
    }

    function verComentarios(tareaID) {
        document.enviarTareaID.tareaComID.value=tareaID;
        document.enviarTareaID.submit();
    }

</script>

<?php
   //formulario para enviar nuevo estado de tarea
    echo "<form action=$_SERVER[PHP_SELF] method='post' name=enviarVAL>
    <input type='hidden' name='valuesPHP'>
    </form>";

    //formulario para enviar tareaID
    echo "<form action='comentarios.php' method='post' name=enviarTareaID>
    <input type='hidden' name='tareaComID'>
    </form>";
 ?>

</html>