<?php

class TipoDispositivo {
    
    public function __construct($co, $no) {
        $this->codigoTipo = $co;
        $this->nombreTipo = $no;
    }
    
    public function obtenerCodigoTipo(){
        return $this->codigoTipo;
    }
    
    public function obtenerNombreTipo(){
        return $this->nombreTipo;
    }
    
    
    private $codigoTipo;
    private $nombreTipo;
}
