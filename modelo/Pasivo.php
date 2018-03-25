<?php


class Pasivo {
    
        //Constructor para pasivo
    public function __construct($pla, $ti, $es, $est, $se, $pro, $mo, $mar, $feI, $feD, $feE, $pre) {
        $this->placa = $pla;
        $this->tipo = $ti;
        $this->esNuevo = $es;
        $this->estado = $est;
        $this->serie = $se;
        $this->proveedor = $pro;
        $this->modelo = $mo;
        $this->marca = $mar;
        $this->fechaIngresoSistema = $feI;
        $this->fechaDesechado = $feD;
        $this->fechaExpiraGarantia = $feE;
        $this->precio = $pre;
    }
    
    function obtenerPlaca() {
        return $this->placa;
    }

    function obtenerTipo() {
        return $this->tipo;
    }

    function obtenerEsNuevo() {
        return $this->esNuevo;
    }

    function obtenerEstado() {
        return $this->estado;
    }

    function obtenerSerie() {
        return $this->serie;
    }

    function obtenerProveedor() {
        return $this->proveedor;
    }

    function obtenerModelo() {
        return $this->modelo;
    }

    function obtenerMarca() {
        return $this->marca;
    }

    function obtenerFechaIngresoSistema() {
        return $this->fechaIngresoSistema;
    }

    function obtenerFechaDesechado() {
        return $this->fechaDesechado;
    }

    function obtenerFechaExpiraGarantia() {
        return $this->fechaExpiraGarantia;
    }

    function obtenerPrecio() {
        return $this->precio;
    }  
    
    private $placa;
    private $tipo; //Objeto de TipoDispositivo
    private $esNuevo; 
    private $estado;  //Objeto de EstadoEquipo
    private $serie;
    private $proveedor;
    private $modelo;
    private $marca;
    private $fechaIngresoSistema;
    private $fechaDesechado;
    private $fechaExpiraGarantia;
    private $precio;
}
