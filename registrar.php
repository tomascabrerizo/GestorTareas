<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Usuario registrado</title>
</head>
<body>

    <?php
    include_once 'dataBase.php';

    //solicito los datos enviados por el formulario
    $user = $_REQUEST;

    DataBase::getSingleton()->InsetarEnTabla("usuario", $user);
    header("location:index.php");
    ?>
    
</body>
</html>