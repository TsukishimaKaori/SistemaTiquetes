<?php

class Categoria {
    
    public function __construct($co, $no, $re) {
        $this->codigoCategoria = $co;
        $this->nombreCategoria = $no;
        $this->esRepuesto = $re;
    }
    
    public function obtenerCodigoCategoria(){
        return $this->codigoCategoria;
    }
    
    public function obtenerNombreCategoria(){
        return $this->nombreCategoria;
    }
    
    public function obtenerEsRepuesto(){
        return $this->esRepuesto;
    }
    
    private $codigoCategoria;
    private $nombreCategoria;
    private $esRepuesto;   //1 -> repuesto 0-> algo mas
}
