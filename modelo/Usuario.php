<?php

class Usuario {

    public function __construct($no, $dep, $jef, $c, $codE, $numeC) {
        $this->nombreUsuario = $no;  
        $this->departamento = $dep;
        $this->jefatura = $jef;
        $this->correo = $c;  
        $this->codigoEmpleado = $codE;
        $this->numeroCedula = $numeC;
    }
    public function obtenerCorreo(){
        return $this->correo;
    }

    public function obtenerCodigoEmpleado() {
        return $this->codigoEmpleado;
    }

    public function obtenerNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function obtenerDepartamento() {
        return $this->departamento;
    }

    public function obtenerJefatura() {  
        return $this->jefatura;
    }
    
    public function obtenerNumeroCedula() {  
        return $this->numeroCedula;
    }

    private $nombreUsuario;  
    private $departamento;
    private $jefatura;
    private $correo;   
    private $codigoEmpleado;
    private $numeroCedula;

}
