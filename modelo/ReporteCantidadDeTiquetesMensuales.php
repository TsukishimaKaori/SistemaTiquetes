<?php

class ReporteCantidadDeTiquetesMensuales {
    
    public function __construct($mes, $can) {
        $this->mes = $mes;
        $this->cantidadMensuales = $can;
    }
    
    function obtenerMes() {
        return $this->mes;
    }

    function obtenerCantidadMensuales() {
        return $this->cantidadMensuales;
    }

    private $mes;
    private $cantidadMensuales;
}
