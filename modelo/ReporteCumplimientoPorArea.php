<?php

class ReporteCumplimientoPorArea {
    
    public function __construct($nombre, $totalC, $totalA) {
        $this->nombreArea = $nombre;
        $this->totalCalificadas = $totalC;
        $this->totalAtendidas = $totalA;
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
