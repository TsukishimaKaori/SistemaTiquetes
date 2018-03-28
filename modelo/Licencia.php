<?php

class Licencia {
    
    public function __construct($feV, $cla, $pro, $feI, $de, $pla) {
        $this->fechaDeVencimiento = $feV;
        $this->claveDeProducto = $cla;
        $this->proveedor = $pro;
        $this->fechaAsociado = $feI;
        $this->descripcion = $de;
        $this->placa = $pla;
    }
    
    function obtenerFechaDeVencimiento() {
        return $this->fechaDeVencimiento;
    }

    function obtenerCantidadTotal() {
        return $this->cantidadTotal;
    }

    function obtenerProveedor() {
        return $this->proveedor;
    }

    function obtenerFechaAsociado() {
        return $this->fechaAsociado;
    }

    function obtenerDescripcion() {
        return $this->descripcion;
    }

    function obtenerPlaca() {
        return $this->placa;
    }
    
    private $fechaDeVencimiento;
    private $claveDeProducto;
    private $proveedor;
    private $fechaAsociado;
    private $descripcion;
    private $placa;
}
