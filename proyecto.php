<?php
class Proyecto{
    private $proyectoID;
    private $nombre;

    //Constructor
    public function __construct($proyectoID, $nombre){
        $this->proyectoID = $proyectoID;
        $this->nombre = $nombre;
    }

    //Getters y Setters
    public function getNombre(){
        return $this->nombre;
    }

    public function getProyectoID(){
        return $this->proyectoID;
    }
}
?>