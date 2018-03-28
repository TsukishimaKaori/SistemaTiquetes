<?php

require_once '../modelo/EstadoEquipo.php';
require_once '../modelo/Categoria.php';
require_once '../modelo/Inventario.php';
require_once '../modelo/Activo.php';
require_once '../modelo/Licencia.php';
require_once '../modelo/Repuesto.php';
require_once '../modelo/Conexion.php';


//Obtiene todos los dispositivos pasivos
function obtenerInventario() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerInventario }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha orricudo un error al obtener el inventario';
    }
    $pasivos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $pasivos[] = crearInventario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $pasivos;
}

//Obtiene todos los dispositivos activos
function obtenerActivosFijos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerActivosFijos }";
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
function obtenerLicencias($placa) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerLicencias (?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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
function obtenerRepuestos($placa) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerRepuestos (?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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

function crearCategoria($row) {
    $codigoCategoria = $row['codigoCategoria'];
    $nombreCategoria = utf8_encode($row['nombreCategoria']);
    return new Categoria($codigoCategoria, $nombreCategoria);
}

function crearInventario($row) {
    $codigoArticulo = $row['codigoArticulo'];
    $descripcion = utf8_encode($row['descripcion']);
    $costo = $row['costo'];
    $categoria = crearCategoria($row);
    $estado = utf8_encode($row['estado']);
    $cantidad = $row['cantidad'];  
    return new Inventario($codigoArticulo, $descripcion, $costo, $categoria, $estado, $cantidad);
}

function crearActivo($row) {
    $placa = $row['placa'];
    $categoria = crearCategoria($row);
    $estado = crearEstadoEquipo($row);
    $serie = $row['serie'];
    $proveedor = utf8_encode($row['proveedor']);
    $modelo = utf8_encode($row['modelo']);
    $marca = utf8_encode($row['marca']);
    $fechaSalidaInventario = $row['fechaSalidaInventario'];
    $fechaDesechado = $row['fechaDesechado'];
    $fechaExpiraGarantia = $row['fechaExpiraGarantia'];
    $correoUsuarioAsociado = $row['correoUsuarioAsociado'];
    $nombreUsuarioAsociado = utf8_encode($row['nombreUsuarioAsociado']);
    $departamentoUsuarioAsociado = utf8_encode($row['departamentoUsuarioAsociado']);
    $jefaturaUsuarioAsociado = utf8_encode($row['jefaturaUsuarioAsociado']);
    return new Activo($placa, $categoria, $estado, $serie, $proveedor, $modelo, $marca, $fechaSalidaInventario, 
        $fechaDesechado, $fechaExpiraGarantia, $correoUsuarioAsociado, $nombreUsuarioAsociado,
        $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado);
    
}

function crearLicencia($row) {
    $fechaDeVencimiento = $row['fechaDeVencimiento'];
    $claveDeProducto = $row['claveDeProducto'];
    $proveedor = utf8_encode($row['proveedor']);
    $fechaAsociado = $row['fechaAsociado'];
    $descripcion = utf8_encode($row['descripcion']);
    $placa = $row['placa'];
    return new Licencia($fechaDeVencimiento, $claveDeProducto, $proveedor, $fechaAsociado, $descripcion, $placa);
}

function crearRepuesto($row) {
    $descripcion = utf8_encode($row['descripcion']);
    $fechaAsociado = $row['fechaAsociado'];
    $placa = $row['placa'];
    return new Repuesto($descripcion, $fechaAsociado, $placa);
}

//$pasivos = obtenerInventario();
//
//foreach ($pasivos as $tema) {   
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerEstado(). '<br />'; 
//    echo $tema->obtenerCosto() . '<br />';
//    echo $tema->obtenerCantidad() . '<br />';
//    echo '<br />';
//}
//
//echo 'Activos' . '<br />';
//$activos = obtenerActivosFijos();
//
//foreach ($activos as $tema) {   
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerPlaca() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerProveedor() . '<br />';
//    echo $tema->obtenerMarca() . '<br />';
//    echo $tema->obtenerNombreUsuarioAsociado() . '<br />';
//    echo $tema->obtenerCorreoUsuarioAsociado() . '<br />';
//    echo '<br />';
//}
//
//echo 'Licencias' . '<br />';
//$licencias = obtenerLicencias('456');
//
//foreach ($licencias as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerProveedor() . '<br />';
//    echo $tema->obtenerClaveDeProducto() . '<br />';
//    echo $tema->obtenerPlaca().'<br />'; 
//    echo '<br />';
//}
//
//echo 'Repuestos' . '<br />';
//$repuestos = obtenerRepuestos('456');
//
//foreach ($repuestos as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerPlaca() . '<br />';
//    echo '<br />';
//}