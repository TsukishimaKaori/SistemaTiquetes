<?php


class HistorialActivos {
   
    public function __construct($coH, $pla, $des, $fe, $corrC, $nomC, $corrA, $nomA, $come, $acla) {
 
        $this->codigoHistorial = $coH;
        $this->placa = $pla;
        $this->descripcionIndicador = $des;
        $this->fechaHora = $fe;
        $this->correoUsuarioCausante = $corrC;
        $this->nombreUsuarioCausante = $nomC;
        $this->correoUsuarioAsociado = $corrA;
        $this->nombreUsuarioAsociado = $nomA;
        $this->comentarioUsuario = $come;
        $this->aclaracionSistema = $acla;
    }
    
    
    function obtenerCodigoHistorial() {
        return $this->codigoHistorial;
    }

    function obtenerPlaca() {
        return $this->placa;
    }

    function obtenerDescripcionIndicador() {
        return $this->descripcionIndicador;
    }

    function obtenerFechaHora() {
        return $this->fechaHora;
    }

    function obtenerCorreoUsuarioCausante() {
        return $this->correoUsuarioCausante;
    }

    function obtenerNombreUsuarioCausante() {
        return $this->nombreUsuarioCausante;
    }

    function obtenerCorreoUsuarioAsociado() {
        return $this->correoUsuarioAsociado;
    }

    function obtenerNombreUsuarioAsociado() {
        return $this->nombreUsuarioAsociado;
    }

    function obtenerComentarioUsuario() {
        return $this->comentarioUsuario;
    }

    function obtenerAclaracionSistema() {
        return $this->aclaracionSistema;
    }

    private $codigoHistorial;
    private $placa;
    private $descripcionIndicador;
    private $fechaHora;
    private $correoUsuarioCausante;
    private $nombreUsuarioCausante;
    private $correoUsuarioAsociado;
    private $nombreUsuarioAsociado;
    private $comentarioUsuario;
    private $aclaracionSistema;
}
