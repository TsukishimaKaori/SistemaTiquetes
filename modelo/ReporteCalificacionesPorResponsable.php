<?php

class ReporteCalificacionesPorResponsable {
    
    public function __construct($nom, $pro) {
        $this->nombreResponsable = $nom;
        $this->promedioCalificiones = $pro;
    }

    public function obtenerNombreResponsable() {
        return $this->nombreResponsable;
    }

    public function obtenerPromedioCalificiones() {
        return $this->promedioCalificiones;
    }

    private $nombreResponsable;  
    private $promedioCalificiones;
}
