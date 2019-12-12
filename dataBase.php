<?php

include_once 'usuario.php';
include_once 'tarea.php';
include_once 'proyecto.php';
include_once 'comentario.php';

class DataBase
{
    //La base de datos es un SINGLETON
    private static $instance;

    //Atributos
    private $host;
    private $puerto;
    private $usuario;
    private $password;
    private $baseDeDatos;

    private $link;

    //Array con las diferentes tablas
    private $tablas = [
        'usuario',
        'tarea', 
        'proyecto',
        'comentarios'
    ];

    private function tablaValida($tableName){
        for($i = 0; $i < sizeof($this->tablas); $i++){
            if($this->tablas[$i] == $tableName){
                return true;
            }
        }
        return false;
    }

    //Constructor
    private function __construct() {
    $this->host = "localhost";
    $this->puerto = "3306";
    $this->usuario = "tomas";
    $this->password = "123";
    $this->baseDeDatos = "gestortareas";
    $this->connectMYSQL();
    $this->connectBaseDeDatos();

    }

    //Destructor
    public function __destruct(){
        $this->disconnectMYSQL();
    }

    //Metodo para acceder a la base de datos
    public function getSingleton(){
        if(!self::$instance instanceof self){
            self::$instance = new DataBase();
        }
        return self::$instance;
    }

    //Funcines de coneccion
    public function connectMYSQL() {
        //Coneccion a MYSQL
        if(!($this->link = mysqli_connect($this->host.":".$this->puerto, $this->usuario, $this->password))) {
            echo "Error conectando a MYSLQ.<br>";
            exit();
        }
    }

    public function connectBaseDeDatos() {
       if(!mysqli_select_db($this->link, $this->baseDeDatos)) {
            echo "Error conectando a la Base de Datos.<br>";
            exit();
       }
    }
 
    public function disconnectMYSQL()
    {
        mysqli_close($this->link);
    }

    //Funciones Manjo de Tablas

    //Funciones de Seleccion de Tablas
    //Si value es null devuelve la tabla entera, si value tiene una PK o FK devuelve esa fila
    public function seleccionarDeTabla($tableName, $values){

        if($this->tablaValida($tableName)){
            $query = "SELECT * FROM $tableName";
            $result = mysqli_query($this->link, $query);
            $tablaFinal = array();
            //Devuelve arrays con los objetos de la tabla
            if($values == null){
                switch ($tableName) {
                    case 'usuario':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            $objUsuario = new Usuario(
                                $fila["usuarioID"], $fila["userName"],
                                $fila["email"], $fila["userPass"]
                            );
                            array_push($tablaFinal, $objUsuario);
                        }
                    break;

                    case 'tarea':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            $objTarea =  new Tarea(
                                $fila["tareaID"], $fila["usuarioID"],
                                $fila["proyectoID"], $fila["nombre"],
                                $fila["descripcion"], $fila["estado"]
                            );
                           array_push($tablaFinal, $objTarea);
                        }
                    break;

                    case 'proyecto':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            $objProyecto = new Proyecto(
                                $fila["proyectoID"], $fila["nombre"]
                            );
                            array_push($tablaFinal, $objProyecto);
                        }
                    break;

                    case 'comentarios':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            $objComentario = new Comentario(
                                $fila["comentarioID"], $fila["usuarioID"], 
                                $fila["tareaID"], $fila["comentario"]
                            );
                            array_push($tablaFinal, $objComentario);
                        }
                    break;
                }
            }
            else {

                switch ($tableName) {
                    case 'usuario':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            if($fila["usuarioID"] == $values){
                                $objUsuario = new Usuario(
                                    $fila["usuarioID"], $fila["userName"],
                                    $fila["email"], $fila["userPass"]
                                );
                                array_push($tablaFinal, $objUsuario);
                            }
                        }
                    break;

                    case 'tarea':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            if($fila["tareaID"] == $values){
                                $objTarea =  new Tarea(
                                    $fila["tareaID"], $fila["usuarioID"],
                                    $fila["proyectoID"], $fila["nombre"],
                                    $fila["descripcion"], $fila["estado"]
                                );
                               array_push($tablaFinal, $objTarea);
                            }
                        }

                    break;

                    case 'proyecto':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            if($fila["proyectoID"] == $values){
                                $objProyecto = new Proyecto(
                                    $fila["proyectoID"], $fila["nombre"]
                                );
                                array_push($tablaFinal, $objProyecto);
                            }
                        }
                    break;

                    case 'comentarios':
                        while ($fila = mysqli_fetch_assoc($result)) {
                            if($fila["tareaID"] == $values){
                                $objComentario = new Comentario(
                                    $fila["comentarioID"], $fila["usuarioID"], 
                                    $fila["tareaID"], $fila["comentario"]
                                );
                                array_push($tablaFinal, $objComentario);
                            }
                        }
                    break;
                }
            }
            mysqli_free_result($result);
            return $tablaFinal;
        }
        else {
            echo "No se encontro la tabla: ".$tableName."</br>";
        }
    }

    //Funciones de Inserccion a Tablas
    public function InsetarEnTabla($tableName, $values){
        switch ($tableName) {
            case 'usuario':
                $userName = $values["userName"];
                $email = $values["email"];
                $userPass = $values["userPass"];

                mysqli_query($this->link, "INSERT INTO usuario (userName, email, userPass)
                VALUES ('$userName', '$email', '$userPass')");
                break;

            case 'tarea':
                $usuarioID = $values["usuarioID"];
                $proyectoID = $values["proyectoID"];
                $nombre = $values["nombre"];
                $descripcion = $values["descripcion"];
                $estado = $values["estado"];

                mysqli_query($this->link, "INSERT INTO tarea (usuarioID, proyectoID, nombre, descripcion, estado)
                VALUES ('$usuarioID', '$proyectoID', '$nombre', '$descripcion', '$estado')");
                break;
                
            case 'proyecto':
                $nombre = $values; 
                mysqli_query($this->link, "INSERT INTO proyecto (nombre)
                VALUES ('$nombre')");
                break;
            
            case 'comentarios':
                $usuarioID = $values["usuarioID"];
                $tareaID = $values["tareaID"];
                $comentario = $values["comentario"];

                mysqli_query($this->link, "INSERT INTO comentarios (usuarioID, tareaID, comentario)
                VALUES ('$usuarioID', '$tareaID', '$comentario')");
                break;

            default:
                echo "No se encontro la tabla: ".$tableName."<br>";
                break;
        }    
    }


    //Funciones para eliminar de la base de datos
    public function borrarDeTabla($tableName, $id){
            switch ($tableName) {
                case 'usuario':
                    mysqli_query($this->link, "DELETE FROM usuario WHERE usuarioID='".$id."';");
                    break;
                case 'tarea':
                    mysqli_query($this->link, "DELETE FROM tarea WHERE tareaID='".$id."';");
                    break;
                case 'proyecto':
                    mysqli_query($this->link, "DELETE FROM proyecto WHERE proyectoID='".$id."';");
                    break;
                
                default:
                    echo "No se encontro la tabla: ".$tableName."<br>";
                break;
         }
    }

    //Funciones Espesificas
    public function eliminarTarea($id){
        mysqli_query($this->link, "DELETE FROM comentarios WHERE tareaID='".$id."';");
        mysqli_query($this->link, "DELETE FROM tarea WHERE tareaID='".$id."';");
    }

    public function modificarTarea($id, $nombre, $des)
    {
        mysqli_query($this->link, "UPDATE tarea SET nombre='".$nombre."',
                    descripcion='".$des."' WHERE tareaID='".$id."';");
    }

    public function eliminarProyecto($id){
        $result = mysqli_query($this->link, "SELECT * FROM tarea WHERE proyectoID='".$id."';");
        while ($fila = mysqli_fetch_assoc($result)){
            $this->eliminarTarea($fila["tareaID"]);
        }
        mysqli_query($this->link, "DELETE FROM proyecto WHERE proyectoID='".$id."';");
    }

    public function actualizarTarea($tareaID, $valor){
        mysqli_query($this->link, "UPDATE tarea SET estado='".$valor."'
                    WHERE tareaID='".$tareaID."';");
    }
}

?>