<?php

class Area {
   
    public function __construct($co, $no, $ac) {
        $this->codigoArea = $co;
        $this->nombreArea = $no;
        $this->areaActiva = $ac;
    }
    
    public function obtenerCodigoArea(){
        return $this->codigoArea;
    }
    
    public function obtenerNombreArea(){
        return $this->nombreArea;
    }
    
    public function cambiarNombreArea($no){
        $this->nombreArea = $no;
    }
    
    public function obtenerAreaActiva(){
        return $this->areaActiva;
    }
    
    
    private $codigoArea;
    private $nombreArea;
    private $areaActiva;
}
