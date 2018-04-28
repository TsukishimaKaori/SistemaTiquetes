<?php

class ReporteDeMovimientos {
    
    public function __construct($co, $de, $cat, $can, $cos, $fecha, $efec) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->categoria = $cat;
        $this->cantidad = $can;
        $this->costo = $cos;
        $this->fecha = $fecha;
        $this->efecto = $efec;
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

    function obtenerCosto() {
        return $this->costo;
    }     
    
    function obtenerFecha() {
        return $this->fecha;
    }
    
    function obtenerEfecto() {
        return $this->efecto;
    }

    private $codigoArticulo;
    private $descripcion;
    private $categoria;   //objeto de tipo Categoria
    private $cantidad;
    private $costo;
    private $fecha;
    private $efecto;
}
