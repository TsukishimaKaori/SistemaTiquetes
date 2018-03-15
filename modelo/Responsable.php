<?php

class Responsable {

    public function __construct($co, $no, $lo, $a, $r, $c) {
        $this->codigoEmpleado = $co;
        $this->nombreResponsable = $no;
        $this->loginActivo = $lo;
        $this->area = $a;
        $this->rol = $r;
        $this->correo = $c;
    }
    public function obtenerCorreo(){
        return $this->correo;
    }

    public function obtenerCodigoEmpleado() {
        return $this->codigoEmpleado;
    }

    public function obtenerNombreResponsable() {
        return $this->nombreResponsable;
    }

    public function obtenerLoginActivo() {
        return $this->loginActivo;
    }

    public function obtenerArea() {  //Retorna un objeto de tipo Area
        return $this->area;
    }

    public function obtenerRol() { //Retorna un objeto de tipo Rol
        return $this->rol;
    }

    private $codigoEmpleado;  //codigo utilizado en la empresa para identificar a cada empleado
    private $nombreResponsable;
    private $loginActivo;
    private $area;   //objeto Area
    private $rol;    //objeto Rol
    private $correo;

}
