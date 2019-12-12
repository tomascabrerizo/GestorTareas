<?php

include_once 'dataBase.php';

class Tarea {
    private $tareaID;
    private $usuarioID;
    private $proyectoID;
    private $nombre;
    private $descripcion;
    private $estado;

    //Constructor
    public function __construct($tareaID, $usuarioID, $proyectoID, $nombre, $des, $estado){
        $this->tareaID = $tareaID;
        $this->usuarioID = $usuarioID;
        $this->proyectoID = $proyectoID;
        $this->nombre = $nombre;
        $this->descripcion = $des;
        $this->estado = $estado;
    }

    public function cambiarEstado($valor){
        DataBase::getSingleton()->actualizarTarea($this->tareaID, $valor);
    }

    //Getters y Setters
    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getUsuario(){
        $usuario = DataBase::getSingleton()->seleccionarDeTabla("usuario", $this->usuarioID);
        return $usuario[0]->getNombre();
    }

    public function getProyecto(){
        $proyecto = DataBase::getSingleton()->seleccionarDeTabla("proyecto", $this->proyectoID);
        return $proyecto[0]->getNombre();  
    }

    public function getTareaID(){
        return $this->tareaID;
    }

    public function getUsuarioID(){
        return $this->usuarioID;
    }

    public function getProyectoID(){
        return $this->proyectoID;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }
}
?>