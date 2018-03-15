<?php

class Comentario {
   
    public function __construct($no, $fe, $com, $dire, $co) {
        $this->nombreCausante = $no;
        $this->fecha = $fe;
        $this->comentario = $com;
        $this->direccionAdjunto = $dire;
        $this->correoUsuarioCausante = $co;
    }
    
    public function obtenerNombreCausante(){
        return $this->nombreCausante;
    }
    
    public function obtenerFecha(){
        return $this->fecha;
    }
    
    public function obtenerComentario(){
        return $this->comentario;
    }
    
    public function obtenerDireccionAdjunto(){
        return $this->direccionAdjunto;
    }
    
    public function obtenerCorreoUsuarioCausante(){
        return $this->correoUsuarioCausante;
    }
    
    private $nombreCausante;
    private $fecha;
    private $comentario;
    private $direccionAdjunto;
    private $correoUsuarioCausante;
}
