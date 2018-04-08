<?php


class Bodega {
    
    public function __construct($co, $no) {
        $this->codigoBodega = $co;
        $this->nombreBodega = $no;
    }
    
    
    public function obtenerCodigoBodega(){
        return $this->codigoBodega;
    }
    
    public function obtenerNombreBodega(){
        return $this->nombreBodega;
    }
    
    private $codigoBodega;
    private $nombreBodega;
}
