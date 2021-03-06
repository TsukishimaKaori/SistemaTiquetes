<?php

class Detalle {
    
    public function __construct($coD, $coA, $copiaC, $can, $cos, $fe, $est, $efec, $bode, $come, $corr, $nom, $norden, $dire, $cotiqu) {
        $this->codigoDetalle = $coD;
        $this->codigoArticulo = $coA;
        $this->copiaCantidadInventario = $copiaC;
        $this->cantidadEfecto = $can;
        $this->costo = $cos;
        $this->fecha = $fe;
        $this->estado = $est;
        $this->efecto = $efec;    
        $this->bodega = $bode; 
        $this->comentarioUsuario = $come;
        $this->correoUsuarioCausante = $corr;
        $this->nombreUsuarioCausante = $nom;
        $this->numeroOrdenDeCompra = $norden;
        $this->direccionOrdenDeCompra = $dire;
        $this->codigoTiquete = $cotiqu;
    }
    
    function obtenerCodigoDetalle() {
        return $this->codigoDetalle;
    }

    function obtenerCodigoArticulo() {
        return $this->codigoArticulo;
    }

    function obtenerCopiaCantidadInventario() {
        return $this->copiaCantidadInventario;
    }

    function obtenerCantidadEfecto() {
        return $this->cantidadEfecto;
    }

    function obtenerCosto() {
        return $this->costo;
    }

    function obtenerFecha() {
        return $this->fecha;
    }

    function obtenerEstado() {
        return $this->estado;
    }

    function obtenerEfecto() {
        return $this->efecto;
    }

    function obtenerBodega() {
        return $this->bodega;
    }

    function obtenerComentarioUsuario() {
        return $this->comentarioUsuario;
    }

    function obtenerCorreoUsuarioCausante() {
        return $this->correoUsuarioCausante;
    }

    function obtenerNombreUsuarioCausante() {
        return $this->nombreUsuarioCausante;
    }
    
    function obtenerNumeroOrdenDeCompra() {
        return $this->numeroOrdenDeCompra;
    }

    function obtenerDireccionOrdenDeCompra() {
        return $this->direccionOrdenDeCompra;
    }

    function obtenerCodigoTiquete() {
        return $this->codigoTiquete;
    }

            
    private $codigoDetalle;
    private $codigoArticulo;
    private $copiaCantidadInventario;
    private $cantidadEfecto;
    private $costo;
    private $fecha;
    private $estado;
    private $efecto;    //Entrada o salida
    private $bodega;   //objeto de tipo Bodega
    private $comentarioUsuario;
    private $correoUsuarioCausante;
    private $nombreUsuarioCausante;
    private $numeroOrdenDeCompra;
    private $direccionOrdenDeCompra;
    private $codigoTiquete;
}
