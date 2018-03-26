<?php


class EstadoEquipo {
    
    public function __construct($co, $no) {
        $this->codigoEstado = $co;
        $this->nombreEstado = $no;
    }
    
    public function obtenerCodigoEstado(){
        return $this->codigoEstado;
    }
    
    public function obtenerNombreEstado(){
        return $this->nombreEstado;
    }
    
    
    private $codigoEstado;
    private $nombreEstado;
}
