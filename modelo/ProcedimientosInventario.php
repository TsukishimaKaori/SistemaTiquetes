<?php

require_once '../modelo/EstadoEquipo.php';
require_once '../modelo/Categoria.php';
require_once '../modelo/Inventario.php';
require_once '../modelo/Activo.php';
require_once '../modelo/Licencia.php';
require_once '../modelo/Repuesto.php';
require_once '../modelo/Conexion.php';
require_once '../modelo/ProcedimientosTiquetes.php';
require_once '../modelo/Bodega.php';
require_once '../modelo/Detalle.php';
require_once '../modelo/HistorialActivos.php';


//Obtiene todos los dispositivos pasivos
function obtenerInventario() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerInventario }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener el inventario';
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
        return 'Ha ocurrido un error al obtener los activos';
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
        return 'Ha ocurrido un error al obtener las licencias';
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
        return 'Ha ocurrido un error al obtener los repuestos';
    }
    $repuestos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $repuestos[] = crearRepuesto($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $repuestos;
}

//Obtiene todos las categorias para llenar un combo en el agregar articulo al inventario
function obtenerCategorias() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerCategorias }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener las categorias';
    }
    $categorias = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $categorias[] = crearCategoria($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $categorias;
}

//Agregar un articulo al inventario
function agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado,
	$cantidad, $bodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarArticuloInventario (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($descripcion), SQLSRV_PARAM_IN),
        array($costo, SQLSRV_PARAM_IN), array($codigoCategoria, SQLSRV_PARAM_IN),
        array($estado, SQLSRV_PARAM_IN), array($cantidad, SQLSRV_PARAM_IN),
        array($bodega, SQLSRV_PARAM_IN), array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Aumentar la cantidad de un articulo en el inventario
function aumentarCantidadInventario($codigoArticulo, $cantidadEfecto, $comentarioUsuario, 
        $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAaumentarCantidadInventario (?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($cantidadEfecto, SQLSRV_PARAM_IN),
        array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Agregar una licencia asociada a un activo fijo
function agregarLicencia($fechaDeVencimiento, $claveDeProducto, $proveedor, $descripcion, $placa, 
        $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarLicencia (?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($fechaDeVencimiento, SQLSRV_PARAM_IN), 
        array($claveDeProducto, SQLSRV_PARAM_IN), array($proveedor, SQLSRV_PARAM_IN),
        array(utf8_decode($descripcion), SQLSRV_PARAM_IN), array($placa, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Obtiene todos los repuestos cuya cantidad es mayor a 0 para asociar uno a un equipo
function obtenerRepuestosParaAsociar() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerRepuestosParaAsociar }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los repuestos';
    }
    $pasivos = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $pasivos[] = crearInventario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $pasivos;
}


//Asociar un repuesto a un Activo fijo
function asociarRepuesto($codigoArticulo, $placa, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAasociarRepuesto (?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($placa, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } else if ($men == 2) {
        return 2;  //El activo ya tiene asociado un repuesto de ese tipo
    } 
       
    return ''; //agregado correctamente
}


//Crear un Activo fijo y asociarlo a un usuario
//El codigoArticulo tiene que sacarlo del inventario
//El usuario causante es el usuario del sistema
function agregarActivo($codigoArticulo, $correoUsuarioCausante, $nombreUsuarioCausante, $placa,
	$codigoCategoria, $serie, $proveedor, $modelo, $marca, $fechaExpiraGarantia,
	$correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarActivo (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),  
        array($placa, SQLSRV_PARAM_IN), array($codigoCategoria, SQLSRV_PARAM_IN),
        array($serie, SQLSRV_PARAM_IN), array(utf8_decode($proveedor), SQLSRV_PARAM_IN),
        array(utf8_decode($modelo), SQLSRV_PARAM_IN), array(utf8_decode($marca), SQLSRV_PARAM_IN),
        array($fechaExpiraGarantia, SQLSRV_PARAM_IN), array($correoUsuarioAsociado, SQLSRV_PARAM_IN),
        array(utf8_decode($nombreUsuarioAsociado), SQLSRV_PARAM_IN), array(utf8_decode($departamentoUsuarioAsociado), SQLSRV_PARAM_IN),
        array(utf8_decode($jefaturaUsuarioAsociado),SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
       
    return ''; //agregado correctamente
}


//Para llenar el combo de usuarios cuando se quiere asociar un activo 
function obtenerUsuariosParaAsociar() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerUsuariosParaAsociar }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los usuarios';
    }
    $usuarios = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $usuarios[] = crearUsuario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $usuarios;
}


//Obtiene todas las bodegas 
function obtenerBodegas() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerBodegas }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener las bodegas';
    }
    $bodegas = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $bodegas[] = crearBodega($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $bodegas;
}


//Adjuntar un archivo a un activo fijo
function adjuntarContrato($placa, $direccionAdjunto, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAadjuntarContrato (?, ?, ?, ?, ?) }";
    $params = array( array($placa, SQLSRV_PARAM_IN), array($direccionAdjunto, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Obtiene todos los documentos adjuntos que tiene un activo
function obtenerDocumentosAsociados($placa) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerDocumentosAsociados (?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los documentos';
    }
    $direcciones = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $direcciones[] = $row['comentarioUsuario'];
    }
    sqlsrv_free_stmt($getMensaje);
    return $direcciones;
}


//Obtiene los posibles estados siguientes desde el estado actual
function obtenerEstadosEquipo($codigoEstadoActual) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerEstadosEquipo (?) }";
    $params = array(array($codigoEstadoActual, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los estados';
    }
    $estados = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $estados[] = crearEstadoEquipo($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $estados;
}


//Actualizar el estado de un activo fijo
function actualizarEstadoEquipo($placa, $codigoEstadoSiguiente, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarEstadoEquipo (?, ?, ?, ?, ?, ?) }";
    $params = array( array($placa, SQLSRV_PARAM_IN), array($codigoEstadoSiguiente, SQLSRV_PARAM_IN),
        array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Obtiene los detalles de movimientos de un articulo del inventario
function obtenerDetalleArticuloInventario($codigoArticulo, $bodega) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerDetalleArticuloInventario (?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($bodega), SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los detalles';
    }
    $detalles = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $detalles[] = crearDetalle($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $detalles;
}

//Obtiene el historial de un activo 
function obtenerHistorialActivosFijos($placa) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerHistorialActivosFijos (?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener el historial';
    }
    $historial = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $historial[] = crearHistorialActivos($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $historial;
}


function crearEstadoEquipo($row) {
    $codigoEstado = $row['codigoEstado'];
    $nombreEstado = utf8_encode($row['nombreEstado']);
    return new EstadoEquipo($codigoEstado, $nombreEstado);
}

function crearCategoria($row) {
    $codigoCategoria = $row['codigoCategoria'];
    $nombreCategoria = utf8_encode($row['nombreCategoria']);
    $esRepuesto = $row['esRepuesto'];
    return new Categoria($codigoCategoria, $nombreCategoria, $esRepuesto);
}

function crearInventario($row) {
    $codigoArticulo = $row['codigoArticulo'];
    $descripcion = utf8_encode($row['descripcion']);
    $costo = $row['costo'];
    $categoria = crearCategoria($row);
    $estado = utf8_encode($row['estado']);
    $cantidad = $row['cantidad'];  
    $bodega = crearBodega($row);
    return new Inventario($codigoArticulo, $descripcion, $costo, $categoria, $estado, $cantidad, $bodega);
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

function crearBodega($row) {
    $codigoBodega = $row['codigoBodega'];
    $nombreBodega = utf8_encode($row['nombreBodega']);
    return new Bodega($codigoBodega, $nombreBodega);
}

function crearDetalle($row) {
    $codigoDetalle = $row['codigoDetalle'];
    $codigoArticulo = $row['codigoArticulo'];
    $copiaCantidadInventario = $row['copiaCantidadInventario'];
    $cantidadEfecto = $row['cantidadEfecto'];
    $costo = $row['costo'];
    $fecha = $row['fecha'];
    $estado = utf8_encode($row['estado']);
    $efecto = utf8_encode($row['efecto']);   
    $bodega = crearBodega($row); 
    $comentarioUsuario = utf8_encode($row['comentarioUsuario']);
    $correoUsuarioCausante = $row['correoUsuarioCausante'];
    $nombreUsuarioCausante = utf8_encode($row['nombreUsuarioCausante']);
    return new Detalle($codigoDetalle, $codigoArticulo, $copiaCantidadInventario, $cantidadEfecto,
            $costo, $fecha, $estado, $efecto, $bodega, $comentarioUsuario, $correoUsuarioCausante,
            $nombreUsuarioCausante);
}

function crearHistorialActivos($row) {
    $codigoHistorial = $row['codigoHistorial'];
    $placa = $row['placa'];
    $descripcionIndicador = utf8_encode($row['descripcionIndicador']);
    $fechaHora = $row['fechaHora'];
    $correoUsuarioCausante = $row['correoUsuarioCausante'];
    $nombreUsuarioCausante = utf8_encode($row['nombreUsuarioCausante']);
    $correoUsuarioAsociado = $row['correoUsuarioAsociado'];
    $nombreUsuarioAsociado = utf8_encode($row['nombreUsuarioAsociado']);
    $comentarioUsuario = utf8_encode($row['comentarioUsuario']);
    $aclaracionSistema = utf8_encode($row['aclaracionSistema']);
    return new HistorialActivos($codigoHistorial, $placa, $descripcionIndicador, $fechaHora,
            $correoUsuarioCausante, $nombreUsuarioCausante, $correoUsuarioAsociado, $nombreUsuarioAsociado,
            $comentarioUsuario, $aclaracionSistema);
}

//$pasivos = obtenerInventario();
//
//foreach ($pasivos as $tema) {   
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerCategoria()->obtenerEsRepuesto() . '<br />';
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerEstado(). '<br />'; 
//    echo $tema->obtenerCosto() . '<br />';
//    echo $tema->obtenerCantidad() . '<br />';
//    echo $tema->obtenerBodega()->obtenerNombreBodega() . '<br />';
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

//$categorias = obtenerCategorias();
//
//foreach ($categorias as $tema) {   
//    echo $tema->obtenerCodigoCategoria() . '<br />';
//    echo $tema->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerEsRepuesto() . '<br />';
//    echo '<br />';
//}


//$mensaje = agregarArticuloInventario('765','Portatil Lenovo', '30', 2, 'Activo', 2, 'Bodega C', 'La compu de la jefa ya llegó', 
//        'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//
//echo $mensaje;

//'876', 2, 'Bodega A7', 'Son muchísimos teléfonos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales'
//$mensaje = aumentarCantidadInventario('987', 5, 'Bodega A7', 'Son muchos teléfonos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//
//echo $mensaje;

//$mensaje = agregarLicencia('2020/01/01', '1234-1234-1234-1234', 'YO XD', 'Vea ust! Es un sistema de tiquetes', '456', 
//        'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//
//echo $mensaje;

//$mensaje = asociarRepuesto('10', '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 'B6');
//echo $mensaje;

//$usuarios = obtenerUsuariosParaAsociar();
//
//foreach ($usuarios as $tema) {   
//    echo $tema->obtenerNombreUsuario() . '<br />';
//    echo $tema->obtenerCorreo() . '<br />';
//    echo $tema->obtenerDepartamento() . '<br />';
//    echo $tema->obtenerJefatura() . '<br />';
//    echo '<br />';
//}

//$mensaje = agregarActivo('11', 'CorreoSospechoso@gmail.com', 'Ali Al Shaez', 'C12', '999', 1, 'T67Y8', 'DELL', 'Inspiron', 'DELL', '2018/04/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
//echo $mensaje;

//
//$bodegas = obtenerBodegas();
//
//foreach ($bodegas as $tema) {   
//    echo $tema->obtenerCodigoBodega() . '<br />';
//    echo $tema->obtenerNombreBodega() . '<br />';
//    echo '<br />';
//}

//$mensaje = adjuntarContrato('456', 'C:un/lugar/diferente/archivito.pdf', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//echo $mensaje;

//$archivos = obtenerDocumentosAsociados('456');
//
//foreach ($archivos as $tema) {   
//    echo $tema . '<br />';
//    echo '<br />';
//}

//$estados = obtenerEstadosEquipo(2);
//
//foreach ($estados as $tema) {   
//    echo $tema->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerCodigoEstado() . '<br />';
//    echo '<br />';
//}

//$mensaje = actualizarEstadoEquipo('456', 1, 'El disposito está en perfectísimo estado :D', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//echo $mensaje;

//$usuarios = obtenerDetalleArticuloInventario('11', 'Bodega centro de distribución');
//
//foreach ($usuarios as $tema) {   
//    echo $tema->obtenerCodigoArticulo() . '<br />';
//    echo $tema->obtenerComentarioUsuario() . '<br />';
//    echo '<br />';
//}

//$usuarios = obtenerHistorialActivosFijos('456');
//
//foreach ($usuarios as $tema) {   
//    echo $tema->obtenerCodigoHistorial() . '<br />';
//    echo $tema->obtenerComentarioUsuario() . '<br />';
//    echo $tema->obtenerAclaracionSistema() . '<br />';
//    echo '<br />';
//}