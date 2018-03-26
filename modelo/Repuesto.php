<?php


class Repuesto {
    
    public function __construct($co, $canT, $canU, $de) {
        $this->codigoRepuesto = $co;
        $this->cantidadTotal = $canT;
        $this->cantidadEnUso = $canU;
        $this->descripcion = $de;
    }
    
    function obtenerCodigoRepuesto() {
        return $this->codigoRepuesto;
    }

    function obtenerCantidadTotal() {
        return $this->cantidadTotal;
    }

    function obtenerCantidadEnUso() {
        return $this->cantidadEnUso;
    }

    function obtenerDescripcion() {
        return $this->descripcion;
    }

    private $codigoRepuesto;
    private $cantidadTotal;
    private $cantidadEnUso;
    private $descripcion;
}
