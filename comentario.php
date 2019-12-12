<?php

class Comentario{
    private $comentarioID;
    private $usuarioID;
    private $tareaID;
    private $comentario;

    //Constructor
    public function __construct($comentarioID, $usuarioID, $tareaID, $comentario){
        $this->comentarioID = $comentarioID;
        $this->usuarioID = $usuarioID;
        $this->tareaID = $tareaID;
        $this->comentario = $comentario;
    }

    //Getters y Setters
    public function getComentarioID(){
        return $this->comentarioID;
    }

    public function getUsuarioID(){
        return $this->usuarioID;
    }

    public function getTareaID(){
        return $this->tareaID;
    }

    public function getComentario(){
        return $this->comentario;
    }
}

?>