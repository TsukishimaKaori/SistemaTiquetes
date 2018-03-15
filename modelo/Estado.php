<?php

class Estado {

    public function __construct($co, $nom, $en) {
        $this->codigoEstado = $co;
        $this->nombreEstado = $nom;
        $this->enviaCorreos = $en;
    }

    public function obtenerCodigoEstado() {
        return $this->codigoEstado;
    }

    public function obtenerNombreEstado() {
        return $this->nombreEstado;
    }

    public function obtenerEnviaCorreos() {
        return $this->enviaCorreos;
    }

    private $codigoEstado;  //codigo utilizado
    private $nombreEstado;
    private $enviaCorreos;   //codigo de la tematica padre

}
