<?php

class Tematica {

    public function __construct($co, $des, $cP, $ac) {
        $this->codigoTematica = $co;
        $this->descripcionTematica = $des;
        $this->codigoPadre = $cP;
        $this->activo = $ac;
        
    }
    public function obtenerCodigoTematica(){
        return $this->codigoTematica;
    }

    public function obtenerDescripcionTematica() {
        return $this->descripcionTematica;
    }

    public function obtenerCodigoPadre() {
        return $this->codigoPadre;
    }

    public function obtenerActivo(){
        return $this->activo;
    }
    
    private $codigoTematica;  //codigo utilizado
    private $descripcionTematica;
    private $codigoPadre;   //codigo de la tematica padre
    private $activo;
}
