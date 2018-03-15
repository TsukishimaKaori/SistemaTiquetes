<?php

class Rol {
    
    public function __construct($co, $no) {
        $this->codigoRol = $co;
        $this->nombreRol = $no;
    }
    
    public function obtenerCodigoRol(){
        return $this->codigoRol;
    }
    
    public function obtenerNombreRol(){
        return $this->nombreRol;
    }
    
    public function cambiarNombreRol($no){
        $this->nombreRol = $no;
    }
    
    private $codigoRol;
    private $nombreRol;
}
