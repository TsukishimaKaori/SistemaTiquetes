<?php

class ReporteCantidadTiquetesPorEstado {
    
    public function __construct($nom, $can) {
        $this->nombreEstado = $nom;
        $this->cantidad = $can;
    }

    public function obtenerNombreEstado() {
        return $this->nombreEstado;
    }

    public function obtenerCantidad() {
        return $this->cantidad;
    }

    private $nombreEstado;  
    private $cantidad;
}

