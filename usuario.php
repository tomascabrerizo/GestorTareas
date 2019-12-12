<?php

include_once 'dataBase.php';

class Usuario {
    //Atributos del usuario
    private $usuarioID;
    private $userName;
    private $userPass;
    private $email;

    //Funciones del Usuario
    //Construcor
    public function __construct($usuarioID, $userName, $email, $userPass){
        $this->usuarioID = $usuarioID;
        $this->userName = $userName;
        $this->userPass = $userPass;
        $this->email = $email;
    }

    //Manejo de Projectos
    public function nuevoProyecto($nombre){
        DataBase::getSingleton()->InsetarEnTabla("proyecto",$nombre);
    }

    public function obtenerProyectos(){
        $todosLosProyectos = DataBase::getSingleton()->seleccionarDeTabla('proyecto', null);
        return $todosLosProyectos;
    }

    public function eliminarProyecto($proyectoID){

    }

    //Manejo de tareas
    public function nuevaTarea($proyecto, $nombre, $descripcion, $comentario){

        $valores["usuarioID"] = $this->usuarioID;
        $valores["proyectoID"] = $proyecto;
        $valores["nombre"] = $nombre;
        $valores["descripcion"] = $descripcion;
        $valores["comentario"] = $comentario;
        $valores["estado"] = 0;

        DataBase::getSingleton()->InsetarEnTabla("tarea", $valores);
    }

    public  function obtenerTareas(){
        $tareas = array();
        $todasLasTareas = DataBase::getSingleton()->seleccionarDeTabla("tarea", null);

        foreach($todasLasTareas as $tarea){
            if($tarea->getUsuarioID() == $this->usuarioID){
                array_push($tareas, $tarea);
            }
        }
        return $tareas;
    }

    public function eliminarTarea($tareaID){
    //TODO: elimiar una tarea
    }

    //getters y setters
    public function getUsuarioID(){
        return $this->usuarioID;
    }

    public function getNombre(){
        return $this->userName;
    }

    public function getPass(){
        return $this->userPass;
    }

    public function getEmail(){
        return $this->email;
    }

}

?>