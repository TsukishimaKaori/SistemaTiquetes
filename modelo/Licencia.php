<?php

class Licencia {
    
    public function __construct($feV, $canT, $canU, $cla, $pro, $feI, $de) {
        $this->fechaDeVencimiento = $feV;
        $this->cantidadTotal = $canT;
        $this->cantidadEnUso = $canU;
        $this->claveDeProducto = $cla;
        $this->proveedor = $pro;
        $this->fechaIngresoSistema = $feI;
        $this->descripcion = $de;
    }
    
    function obtenerFechaDeVencimiento() {
        return $this->fechaDeVencimiento;
    }

    function obtenerCantidadTotal() {
        return $this->cantidadTotal;
    }

    function obtenerCantidadEnUso() {
        return $this->cantidadEnUso;
    }

    function obtenerClaveDeProducto() {
        return $this->claveDeProducto;
    }

    function obtenerProveedor() {
        return $this->proveedor;
    }

    function obtenerFechaIngresoSistema() {
        return $this->fechaIngresoSistema;
    }

    function obtenerDescripcion() {
        return $this->descripcion;
    }

        
    private $fechaDeVencimiento;
    private $cantidadTotal;
    private $cantidadEnUso;
    private $claveDeProducto;
    private $proveedor;
    private $fechaIngresoSistema;
    private $descripcion;
}
