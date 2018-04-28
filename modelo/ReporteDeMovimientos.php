<?php

class ReporteDeMovimientos {
    
    public function __construct($co, $de, $cat, $canI, $canE, $cos, $fecha, $efec) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->categoria = $cat;
        $this->cantidadInventario = $canI;
        $this->cantidadEfecto = $canE;
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

    function obtenerCantidadInventario() {
        return $this->cantidadIventario;
    }
    
    function obtenerCantidadEfecto() {
        return $this->cantidadEfecto;
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
    private $cantidadIventario;
    private $cantidadEfecto;
    private $costo;
    private $fecha;
    private $efecto;
}
