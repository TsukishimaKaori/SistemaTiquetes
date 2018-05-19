<?php

class ReporteCalificacionesPorArea {
    
    public function __construct($nom, $pro) {
        $this->nombreArea = $nom;
        $this->promedioCalificiones = $pro;
    }

    public function obtenerNombreArea() {
        return $this->nombreArea;
    }

    public function obtenerPromedioCalificiones() {
        return $this->promedioCalificiones;
    }

    private $nombreArea;  
    private $promedioCalificiones;
}
