<?php

class Historial {
   
    public function __construct($coH, $coI, $com, $fe, $correoC, $nomC, $coR, $nomR, $acla) {
        $this->codigoHistorial = $coH;
        $this->codigoIndicador = $coI;
        $this->comentarioUsuario = $com;
        $this->fechaHora = $fe;
        $this->correoUsuarioCausante = $correoC;
        $this->nombreUsuarioCausante = $nomC;
        $this->correoResponsable = $coR;        
        $this->nombreResponsable = $nomR;
        $this->aclaracionSistema = $acla;
    }
    
    public function obtenerCodigoHistorial(){
        return $this->codigoHistorial;
    }
    
    public function obtenerCodigoIndicador(){
        return $this->codigoIndicador;
    }
    
    public function obtenerComentarioUsuario(){
        return $this->comentarioUsuario;
    }
    
    public function obtenerFechaHora(){
        return $this->fechaHora;
    }
    
    public function obtenerCorreoUsuarioCausante(){
        return $this->correoUsuarioCausante;
    }
    
    public function obtenerNombreUsuarioCausante(){
        return $this->nombreUsuarioCausante;
    }
    
    public function obtenerCorreoResponsable(){
        return $this->correoResponsable;
    }
    
    public function obtenerNombreResponsable(){
        return $this->nombreResponsable;
    }
    
    public function obtenerAclaracionSistema() {
        return $this->aclaracionSistema;
    }
    
    private $codigoHistorial;
    private $codigoIndicador;
    private $comentarioUsuario;
    private $fechaHora;
    private $correoUsuarioCausante;
    private $nombreUsuarioCausante;
    private $correoResponsable;         
    private $nombreResponsable;
    private $aclaracionSistema;
}
