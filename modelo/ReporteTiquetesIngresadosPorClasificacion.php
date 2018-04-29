<?php

class ReporteTiquetesIngresadosPorClasificacion {
    
    public function __construct($des, $can) {
        $this->descripcionClasificacion = $des;
        $this->cantidadClasificacion = $can;
    }
    
    function obtenerDescripcionClasificacion() {
        return $this->descripcionClasificacion;
    }

    function obtenerCantidadClasificacion() {
        return $this->cantidadClasificacion;
    }

    private $descripcionClasificacion;
    private $cantidadClasificacion;
    
}
