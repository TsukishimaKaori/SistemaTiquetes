<?php


class Inventario {
    
    public function __construct($co, $de, $costo, $cat, $est, $can, $bo, $pro, $mar) {
        $this->codigoArticulo = $co;
        $this->descripcion = $de;
        $this->costo = $costo;
        $this->categoria = $cat;
        $this->estado = $est;
        $this->cantidad = $can;
        $this->bodega = $bo;
        $this->proveedor = $pro;
        $this->marca = $mar;
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

    function obtenerBodega() {
        return $this->bodega;
    }     
    
    function obtenerProveedor() {
        return $this->proveedor;
    }

    function obtenerMarca() {
        return $this->marca;
    }

    private $codigoArticulo;
    private $descripcion;
    private $costo;
    private $categoria;   //objeto de tipo Categoria
    private $estado;
    private $cantidad;
    private $bodega;   //objeto de tipo Bodega
    private $proveedor;
    private $marca;
}
