<?php


class Inventario {
    
        //Constructor para pasivo
    public function __construct($co, $de, $costo, $cat, $est, $can) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->costo = $costo;
        $this->categoria = $cat;
        $this->estado = $est;
        $this->cantidad = $can;
    }
    
    function obtenerCodigoArticulo() {
        return $this->codigoArticulo;
    }

    function obtenerDescripcion() {
        return $this->descripcion;
    }

    function obtenerCosto() {
        return $this->costo;
    }

    function obtenerCategoria() {
        return $this->categoria;
    }
    
    function obtenerEstado() {
        return $this->estado;
    }

    function obtenerCantidad() {
        return $this->cantidad;
    }    
    
    private $codigoArticulo;
    private $descripcion;
    private $costo;
    private $categoria;   //objeto de tipo Categoria
    private $estado;
    private $cantidad;
}
