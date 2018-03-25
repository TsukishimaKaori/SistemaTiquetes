<?php


class Activo {

    public function __construct($pla, $ti, $es, $est, $se, $pro, $mo, $mar, $feI, $feS, $feE, $pre, $c, $n, $d, $j) {
        $this->placa = $pla;
        $this->tipo = $ti;
        $this->esNuevo = $es;
        $this->estado = $est;
        $this->serie = $se;
        $this->proveedor = $pro;
        $this->modelo = $mo;
        $this->marca = $mar;
        $this->fechaIngresoSistema = $feI;
        $this->fechaSalidaInventario = $feS;
        $this->fechaExpiraGarantia = $feE;
        $this->precio = $pre;
        $this->correoUsuarioAsociado = $c;
        $this->nombreUsuarioAsociado = $n;
        $this->departamentoUsuarioAsociado = $d;
        $this->jefaturaUsuarioAsociado = $j;
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

    function obtenerFechaSalidaInventario() {
        return $this->fechaSalidaInventario;
    }

    function obtenerFechaExpiraGarantia() {
        return $this->fechaExpiraGarantia;
    }

    function obtenerPrecio() {
        return $this->precio;
    }

    function obtenerCorreoUsuarioAsociado() {
        return $this->correoUsuarioAsociado;
    }

    function obtenerNombreUsuarioAsociado() {
        return $this->nombreUsuarioAsociado;
    }

    function obtenerDepartamentoUsuarioAsociado() {
        return $this->departamentoUsuarioAsociado;
    }

    function obtenerJefaturaUsuarioAsociado() {
        return $this->jefaturaUsuarioAsociado;
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
    private $fechaSalidaInventario;
    private $fechaExpiraGarantia;
    private $precio;
    private $correoUsuarioAsociado;
    private $nombreUsuarioAsociado;
    private $departamentoUsuarioAsociado;
    private $jefaturaUsuarioAsociado; 
}
