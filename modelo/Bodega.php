<?php


class Bodega {
    
    public function __construct($no) {
        $this->nombreBodega = $no;
    }
    
    public function obtenerNombreBodega(){
        return $this->nombreBodega;
    }
    
    private $nombreBodega;
}
