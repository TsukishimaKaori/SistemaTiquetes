<?php

class Permiso {
   
    public function __construct($co, $de) {
        $this->codigoPermiso = $co;
        $this->descripcionPermiso = $de;
    }
    
    public function obtenerCodigoPermiso(){
        return $this->codigoPermiso;
    }
    
    public function obtenerDescripcionPermiso(){
        return $this->descripcionPermiso;
    }
    
    public function cambiarDescripcionPermiso($de){
        $this->descripcionPermiso = $de;
    }
    
    private $codigoPermiso;
    private $descripcionPermiso;
}
