<?php

class Prioridad {
   
    public function __construct($co, $no) {
        $this->codigoPrioridad = $co;
        $this->nombrePrioridad = $no;

    }
    
    public function obtenerCodigoPrioridad(){
        return $this->codigoPrioridad;
    }
    
    public function obtenerNombrePrioridad(){
        return $this->nombrePrioridad;
    }
    
    private $codigoPrioridad;
    private $nombrePrioridad;
}
