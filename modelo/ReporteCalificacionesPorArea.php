<?php

class ReporteCalificacionesPorArea {
    
    public function __construct($co, $nom, $pro) {
        $this->codigoArea = $co;
        $this->nombreArea = $nom;
        $this->promedioCalificiones = $pro;
    }

    public function obtenerCodigoArea() {
        return $this->codigoArea;
    }
    
    public function obtenerNombreArea() {
        return $this->nombreArea;
    }

    public function obtenerPromedioCalificiones() {
        return $this->promedioCalificiones;
    }

    private $codigoArea;
    private $nombreArea;  
    private $promedioCalificiones;
}
