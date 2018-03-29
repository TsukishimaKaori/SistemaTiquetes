<?php

require_once ("../control/AdministrarTablaInventario.php");
require ("../modelo/ProcedimientosInventario.php");
if (isset($_POST['codigoActivo'])) {
    $codigo = $_POST['codigoActivo'];
    $activos = obtenerActivosFijos();
    panelActivos($activos, $codigo);
}

if (isset($_POST['codigoPasivo'])) {
    $codigo = $_POST['codigoPasivo'];
    $inventario = obtenerInventario();
    panelPasivos($inventario, $codigo);
}

if (isset($_POST['codigoSumarInventario'])) {
    $codigo = $_POST['codigoSumarInventario'];
    $inventario = obtenerInventario();
    panelSumarAInventario($inventario,$codigo);
}


if (isset($_POST['codigoAgregarInventario'])) {
    $codigo = $_POST['codigoAgregarInventario'];
    $categorias = obtenerCategorias();
    panelAgregarInventario($categorias);
}

if (isset($_POST['codigoArticuloAgregarInventario'])) {
    $codigoArticulo = $_POST['codigoArticuloAgregarInventario'];
    $descripcion = $_POST['descripcion'];
    $codigoCategoria = $_POST['categoria'];
    $estado = $_POST['estado'];
    $cantidad = $_POST['cantidad'];
    $bodega = $_POST['bodega'];
    $costo =  $_POST['costo'];
    $comentarioUsuario = $_POST['comentario'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];
    agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado,
	$cantidad, $bodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante);
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);

}

if (isset($_POST['codigoArticuloSuma'])) {
    $codigoArticulo = $_POST['codigoArticuloSuma'];
    $cantidadEfecto = $_POST['cantidadSuma'];
    $bodega = $_POST['bodegaSuma'];
    $comentarioUsuario = $_POST['comentarioSuma'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];
    aumentarCantidadInventario($codigoArticulo, $cantidadEfecto, $bodega, $comentarioUsuario, 
        $correoUsuarioCausante, $nombreUsuarioCausante) ;
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);

}

