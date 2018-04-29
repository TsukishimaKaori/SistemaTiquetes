<?php

class ReporteCumplimientoPorArea {
    
    public function __construct($co, $de, $cat, $can, $fechaI, $fechaE) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->categoria = $cat;
        $this->cantidad = $can;
        $this->fechaUltimoIngreso = $fechaI;
        $this->fechaUltimoEgreso = $fechaE;
    }
    
    function obtenerNombreArea() {
        return $this->nombreArea;
    }

    function obtenerTotalCalificadas() {
        return $this->totalCalificadas;
    }

    function obtenerTotalAtendidas() {
        return $this->totalAtendidas;
    }

    private $nombreArea;
    private $totalCalificadas;
    private $totalAtendidas;
}
