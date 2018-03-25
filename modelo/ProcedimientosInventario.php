<?php

require_once '../modelo/EstadoEquipo.php';
require_once '../modelo/TipoDispositivo.php';
require_once '../modelo/Pasivo.php';
require_once '../modelo/Activo.php';
require_once '../modelo/Licencia.php';
require_once '../modelo/Repuesto.php';
require_once '../modelo/Conexion.php';


//Obtiene todos los dispositivos pasivos
function obtenerEquiposPasivos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerEquiposPasivos }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha orricudo un error al obtener los pasivos';
    }
    $pasivos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $pasivos[] = crearPasivo($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $pasivos;
}

//Obtiene todos los dispositivos activos
function obtenerEquiposActivos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerEquiposActivos }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha orricudo un error al obtener los activos';
    }
    $activos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $activos[] = crearActivo($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $activos;
}


//Obtiene todas licencias
function obtenerLicencias() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerLicencias }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha orricudo un error al obtener las licencias';
    }
    $licencias = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $licencias[] = crearLicencia($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $licencias;
}


//Obtiene todos los repuestos
function obtenerRepuestos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerRepuestos }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha orricudo un error al obtener los repuestos';
    }
    $repuestos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $repuestos[] = crearRepuesto($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $repuestos;
}

function crearEstadoEquipo($row) {
    $codigoEstado = $row['codigoEstado'];
    $nombreEstado = utf8_encode($row['nombreEstado']);
    return new EstadoEquipo($codigoEstado, $nombreEstado);
}

function crearTipoDispositivo($row) {
    $codigoTipo = $row['codigoTipo'];
    $nombreTipo = utf8_encode($row['nombreTipo']);
    return new TipoDispositivo($codigoTipo, $nombreTipo);
}

function crearPasivo($row) {
    $placa = $row['placa'];
    $tipo = crearTipoDispositivo($row);
    $esNuevo = 1? 'Nuevo' : 'Viejo'; 
    $estado = crearEstadoEquipo($row);
    $serie = $row['serie'];
    $proveedor = utf8_encode($row['proveedor']);
    $modelo = utf8_encode($row['modelo']);
    $marca = utf8_encode($row['marca']);
    $fechaIngresoSistema = $row['fechaIngresoSistema'];
    $fechaDesechado = $row['fechaDesechado'];
    $fechaExpiraGarantia = $row['fechaExpiraGarantia'];
    $precio = $row['precio'];
    return new Pasivo($placa, $tipo, $esNuevo, $estado, $serie, $proveedor, $modelo, $marca, $fechaIngresoSistema, 
	$fechaDesechado, $fechaExpiraGarantia, $precio );
}

function crearActivo($row) {
    $placa = $row['placa'];
    $tipo = crearTipoDispositivo($row);
    $esNuevo = 1? 'Nuevo' : 'Viejo'; 
    $estado = crearEstadoEquipo($row);
    $serie = $row['serie'];
    $proveedor = utf8_encode($row['proveedor']);
    $modelo = utf8_encode($row['modelo']);
    $marca = utf8_encode($row['marca']);
    $fechaIngresoSistema = $row['fechaIngresoSistema'];
    $fechaSalidaInventario = $row['fechaSalidaInventario'];
    $fechaExpiraGarantia = $row['fechaExpiraGarantia'];
    $precio = $row['precio'];
    $correoUsuarioAsociado = $row['correoUsuarioAsociado'];
    $nombreUsuarioAsociado = utf8_encode($row['nombreUsuarioAsociado']);
    $departamentoUsuarioAsociado = utf8_encode($row['departamentoUsuarioAsociado']);
    $jefaturaUsuarioAsociado = utf8_encode($row['jefaturaUsuarioAsociado']);
    return new Activo($placa, $tipo, $esNuevo, $estado, $serie, $proveedor, $modelo, $marca, $fechaIngresoSistema, 
	$fechaSalidaInventario, $fechaExpiraGarantia, $precio, $correoUsuarioAsociado, $nombreUsuarioAsociado,
        $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado);
}

function crearLicencia($row) {
    $fechaDeVencimiento = $row['fechaDeVencimiento'];
    $cantidadTotal = $row['cantidadTotal'];
    $cantidadEnUso = $row['cantidadEnUso'];
    $claveDeProducto = $row['claveDeProducto'];
    $proveedor = utf8_encode($row['proveedor']);
    $fechaIngresoSistema = $row['fechaIngresoSistema'];
    $descripcion = utf8_encode($row['descripcion']);
    return new Licencia($fechaDeVencimiento, $cantidadTotal, $cantidadEnUso, $claveDeProducto, $proveedor,
        $fechaIngresoSistema, $descripcion);
}

function crearRepuesto($row) {
    $codigoRepuesto = $row['codigoRepuesto'];
    $cantidadTotal = $row['cantidadTotal'];
    $cantidadEnUso = $row['cantidadEnUso'];
    $descripcion = utf8_encode($row['descripcion']);
    return new Repuesto($codigoRepuesto, $cantidadTotal, $cantidadEnUso, $descripcion);
}

//$pasivos = obtenerEquiposPasivos();
//
//foreach ($pasivos as $tema) {   
//    echo $tema->obtenerTipo()->obtenerNombreTipo() . '<br />';
//    echo $tema->obtenerEsNuevo() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerProveedor() . '<br />';
//    echo $tema->obtenerMarca() . '<br />';
//    echo '<br />';
//}

//$activos = obtenerEquiposActivos();
//
//foreach ($activos as $tema) {   
//    echo $tema->obtenerTipo()->obtenerNombreTipo() . '<br />';
//    echo $tema->obtenerEsNuevo() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerProveedor() . '<br />';
//    echo $tema->obtenerMarca() . '<br />';
//    echo $tema->obtenerNombreUsuarioAsociado() . '<br />';
//    echo $tema->obtenerCorreoUsuarioAsociado() . '<br />';
//    echo '<br />';
//}

$licencias = obtenerLicencias();

foreach ($licencias as $tema) {   
    echo $tema->obtenerDescripcion() . '<br />';
    echo $tema->obtenerCantidadTotal() . '<br />';
    echo $tema->obtenerProveedor().'<br />'; 
    echo '<br />';
}

$repuestos = obtenerRepuestos();

foreach ($repuestos as $tema) {   
    echo $tema->obtenerDescripcion() . '<br />';
    echo $tema->obtenerCantidadTotal() . '<br />';
    echo '<br />';
}