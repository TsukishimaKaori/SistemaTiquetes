<?php


class Activo {

    public function __construct($pla, $cat, $est, $se, $pro, $mo, $mar, $feS, $feD, $feE, $c, $n, $d, $j) {
        $this->placa = $pla;
        $this->categoria = $cat;
        $this->estado = $est;
        $this->serie = $se;
        $this->proveedor = $pro;
        $this->modelo = $mo;
        $this->marca = $mar;
        $this->fechaSalidaInventario = $feS;
        $this->fechaDesechado = $feD;
        $this->fechaExpiraGarantia = $feE;
        $this->correoUsuarioAsociado = $c;
        $this->nombreUsuarioAsociado = $n;
        $this->departamentoUsuarioAsociado = $d;
        $this->jefaturaUsuarioAsociado = $j;
    }
    
    function obtenerPlaca() {
        return $this->placa;
    }

    function obtenerCategoria() {
        return $this->categoria;
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

    function obtenerFechaSalidaInventario() {
        return $this->fechaSalidaInventario;
    }
    
    function obtenerFechaDesechado() {
        return $this->fechaDesechado;
    }

    function obtenerFechaExpiraGarantia() {
        return $this->fechaExpiraGarantia;
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
    private $categoria; //Objeto de tipo categoria
    private $estado;  //Objeto de EstadoEquipo
    private $serie;
    private $proveedor;
    private $modelo;
    private $marca;
    private $fechaSalidaInventario;
    private $fechaDesechado;
    private $fechaExpiraGarantia;
    private $correoUsuarioAsociado;
    private $nombreUsuarioAsociado;
    private $departamentoUsuarioAsociado;
    private $jefaturaUsuarioAsociado; 
    
}
