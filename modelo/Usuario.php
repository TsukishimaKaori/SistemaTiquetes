<?php

class Usuario {

    public function __construct($no, $dep, $jef, $c, $codE) {
        $this->nombreUsuario = $no;  
        $this->departamento = $dep;
        $this->jefatura = $jef;
        $this->correo = $c;  
        $this->codigoEmpleado = $codE;
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

    public function obtenerJefatura() {  //Retorna un objeto de tipo Area
        return $this->jefatura;
    }

    private $nombreUsuario;  
    private $departamento;
    private $jefatura;
    private $correo;   
    private $codigoEmpleado;    

}
