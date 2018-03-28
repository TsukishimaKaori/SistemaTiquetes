<?php


class Repuesto {
    
    public function __construct($de, $fe, $pla) {
        $this->descripcion = $de;
        $this->fechaAsociado = $fe;
        $this->placa = $pla;
    }
    
    function obtenerDescripcion() {
        return $this->descripcion;
    }
    
    function obtenerFechaAsociado() {
        return $this->fechaAsociado;
    }

    function obtenerPlaca() {
        return $this->placa;
    }

    private $descripcion;
    private $fechaAsociado;
    private $placa;
}
