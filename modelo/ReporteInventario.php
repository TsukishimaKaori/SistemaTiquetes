<?php

class ReporteInventario {
    
    public function __construct($co, $de, $cat, $can, $fechaI, $fechaE) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->categoria = $cat;
        $this->cantidad = $can;
        $this->fechaUltimoIngreso = $fechaI;
        $this->fechaUltimoEgreso = $fechaE;
    }
    
    function obtenerCodigoArticulo() {
        return $this->codigoArticulo;
    }

    function obtenerDescripcion() {
        return $this->descripcion;
    }

    function obtenerCategoria() {
        return $this->categoria;
    }

    function obtenerCantidad() {
        return $this->cantidad;
    }

    function obtenerFechaUltimoIngreso() {
        return $this->fechaUltimoIngreso;
    }     
    
    function obtenerFechaUltimoEgreso() {
        return $this->fechaUltimoEgreso;
    }


    private $codigoArticulo;
    private $descripcion;
    private $categoria;   //objeto de tipo Categoria
    private $cantidad;
    private $fechaUltimoIngreso;
    private $fechaUltimoEgreso;
}

