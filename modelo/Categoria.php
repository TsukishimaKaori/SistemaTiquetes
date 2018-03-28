<?php

class Categoria {
    
    public function __construct($co, $no) {
        $this->codigoCategoria = $co;
        $this->nombreCategoria = $no;
    }
    
    public function obtenerCodigoCategoria(){
        return $this->codigoCategoria;
    }
    
    public function obtenerNombreCategoria(){
        return $this->nombreCategoria;
    }
    
    
    private $codigoCategoria;
    private $nombreCategoria;
}
