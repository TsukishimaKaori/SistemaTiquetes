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
require_once '../modelo/ReporteInventario.php';
require_once '../modelo/ReporteDeMovimientos.php';


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

//Obtiene todos los activos
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
//Si no se asocia un tiquete, entonces mande null en el codigoTiquete
function agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado,
	$cantidad, $codigoBodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante,
        $proveedor, $marca, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete) {
    $men = -1;
    $conexion = Conexion::getInstancia();//16
    $tsql = "{call PAagregarArticuloInventario (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($descripcion), SQLSRV_PARAM_IN),
        array($costo, SQLSRV_PARAM_IN), array($codigoCategoria, SQLSRV_PARAM_IN),
        array($estado, SQLSRV_PARAM_IN), array($cantidad, SQLSRV_PARAM_IN),
        array($codigoBodega, SQLSRV_PARAM_IN), array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array(utf8_decode($proveedor), SQLSRV_PARAM_IN), array(utf8_decode($marca), SQLSRV_PARAM_IN),
        array($numeroOrdenDeCompra, SQLSRV_PARAM_IN), array($direccionOrdenDeCompra, SQLSRV_PARAM_IN),
        array($codigoTiquete, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
    return ''; //agregado correctamente
}


//Aumentar la cantidad de un articulo en el inventario
//Si no se asocia un tiquete, entonces mande null en el codigoTiquete
function aumentarCantidadInventario($codigoArticulo, $cantidadEfecto, $comentarioUsuario, 
        $correoUsuarioCausante, $nombreUsuarioCausante, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAaumentarCantidadInventario (?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($cantidadEfecto, SQLSRV_PARAM_IN),
        array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($numeroOrdenDeCompra, SQLSRV_PARAM_IN), array($direccionOrdenDeCompra, SQLSRV_PARAM_IN),
        array($codigoTiquete, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
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
    } else if ($men == 2) {
        return 2;  //No se pueden asociar licencias a activos desechados
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
    } else if ($men == 3) {
        return 3;  //No se pueden agregar repuestos a activos desechados
    } 
       
    return ''; //agregado correctamente
}


//Crear un Activo fijo y asociarlo a un usuario
//El codigoArticulo tiene que sacarlo del inventario
//El usuario causante es el usuario del sistema
//Si no se quiere asociar ningun tiquete, entonces se envia null en el codigo de tiquete
function agregarActivo($codigoArticulo, $correoUsuarioCausante, $nombreUsuarioCausante, $placa,
	$codigoCategoria, $serie, $modelo, $fechaExpiraGarantia,
	$correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado, 
        $codigoTiquete) {
    $men = -1;
    $conexion = Conexion::getInstancia(); //14
    $tsql = "{call PAagregarActivo (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),  
        array($placa, SQLSRV_PARAM_IN), array($codigoCategoria, SQLSRV_PARAM_IN),
        array($serie, SQLSRV_PARAM_IN), array(utf8_decode($modelo), SQLSRV_PARAM_IN), 
        array($fechaExpiraGarantia, SQLSRV_PARAM_IN), array($correoUsuarioAsociado, SQLSRV_PARAM_IN),
        array(utf8_decode($nombreUsuarioAsociado), SQLSRV_PARAM_IN), array(utf8_decode($departamentoUsuarioAsociado), SQLSRV_PARAM_IN),
        array(utf8_decode($jefaturaUsuarioAsociado),SQLSRV_PARAM_IN), array($codigoTiquete, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } 
       
    return ''; //agregado correctamente
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
    } else if ($men == 2) {
        return 2;  //No se pueden realizar acciones sobre activos desechados
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
    } else if ($men == 2) {
        return 2;  //No se pueden realizar acciones sobre activos desechados
    }
    return ''; //agregado correctamente
}


//Obtiene los detalles de movimientos de un articulo del inventario
function obtenerDetalleArticuloInventario($codigoArticulo, $codigoBodega) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerDetalleArticuloInventario (?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($codigoBodega, SQLSRV_PARAM_IN));
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


//Eliminar una licencia asociada a un activo fijo
function eliminarLicencia($claveDeProducto, $placa, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarLicencia (?, ?, ?, ?, ?) }";
    $params = array(array($claveDeProducto, SQLSRV_PARAM_IN), array($placa, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } else if ($men == 2) {
        return 2;  //No se pueden eliminar licencias de activos desechados
    } else if ($men == 3) {
        return 3;  //NO existe la licencia a eliminar
    }
    return ''; //agregado correctamente
}


//Eliminar un repuesto asociado un Activo fijo
function eliminarRepuesto($descripcion, $placa, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarRepuesto (?, ?, ?, ?, ?) }";
    $params = array(array(utf8_decode($descripcion), SQLSRV_PARAM_IN), array($placa, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } else if ($men == 2) {
        return 2;  //El repuesto no esta asociado al activo
    } else if ($men == 3) {
        return 3;  //No se pueden eliminar repuestos a activos desechados
    } 
       
    return ''; //agregado correctamente
}

//Asociar un usuario a un activo fijo que no este desechado
function asociarUsuarioActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante,
	$correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAasociarUsuarioActivo (?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN), array($correoUsuarioAsociado, SQLSRV_PARAM_IN),
        array(utf8_decode($nombreUsuarioAsociado), SQLSRV_PARAM_IN), array(utf8_decode($departamentoUsuarioAsociado), SQLSRV_PARAM_IN),
        array(utf8_decode($jefaturaUsuarioAsociado),SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } if ($men == 2) {
        return 2;  //No se puede asociar un usuario a un activo desechado
    }
       
    return ''; //agregado correctamente
}


//Eliminar un usuario a un activo fijo 
function eliminarUsuarioActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarUsuarioActivo (?, ?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante),SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    }
       
    return ''; //agregado correctamente
}


//Busqueda avanzada de items del inventario, todos los campos se pueden poner en inputs,
//excepto el esRepuesto, que es mejor si fuera un check
function busquedaAvanzadaInventario($codigoArticulo, $descripcion, $nombreCategoria, $esRepuesto, $nombreBodega) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAbusquedaAvanzadaInventario (?, ?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($descripcion), SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreCategoria),SQLSRV_PARAM_IN), array($esRepuesto, SQLSRV_PARAM_IN),
        array(utf8_decode($nombreBodega),SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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

//Busqueda avanzada de activos, todo los campos se pueden poner un inputs,
//excepto el estado, que es mejor ponerlo en un combo
function busquedaAvanzadaActivos($placa, $codigoEstado, $nombreCategoria, $marca, $nombreUsuario, $correoUsuario) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAbusquedaAvanzadaActivos (?, ?, ?, ?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($codigoEstado, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreCategoria),SQLSRV_PARAM_IN), array(utf8_decode($marca), SQLSRV_PARAM_IN),
        array(utf8_decode($nombreUsuario),SQLSRV_PARAM_IN), array($correoUsuario,SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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


//Obtiene todos los activos asociados a un usuario
function obtenerActivosUsuario($correoUsuarioAsociado) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerActivosUsuario (?) }";
    $params = array(array($correoUsuarioAsociado, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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

//Asociar un activo a un tiquete que no este desechado
function asociarTiqueteActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante, $codigoTiquete) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAasociarTiqueteActivo (?, ?, ?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN), array($codigoTiquete, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } if ($men == 2) {
        return 2;  //No se puede asociar un tiquete a un activo desechado
    } if ($men == 3) {
        return 3;  //La asociación ya fue realizada
    } if ($men == 4) {
        return 4;  //No se puede asociar un activo a un tiquete calificado
    }
       
    return ''; //agregado correctamente
}


//Desasociar un activo a un tiquete que no este desechado
function desasociarTiqueteActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante, $codigoTiquete) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAdesasociarTiqueteActivo (?, ?, ?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreUsuarioCausante), SQLSRV_PARAM_IN), array($codigoTiquete, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ha ocurrido un error
    } if ($men == 3) {
        return 3;  //La asociación ya fue realizada
    } if ($men == 4) {
        return 4;  //No se puede asociar un activo a un tiquete calificado
    }
       
    return ''; //agregado correctamente
}


//Obtiene todos los activos asociados a un tiquete
function obtenerActivosAsociadosTiquete($codigoTiquete) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerActivosAsociadosTiquete (?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
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


//Obtiene un activo filtrado por placa
function obtenerActivosFiltradosPlaca($placa) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerActivosFiltradosPlaca (?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los activos';
    }
    $activo;
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $activo = crearActivo($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $activo;
}


 //Obtiene un articulo del inventario filtrado por codigoArticulo y codigoBodega
function obtenerArticuloFiltradoCodigoBodega($codigoArticulo, $codigoBodega) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerArticuloFiltradoCodigoBodega (?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($codigoBodega, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener el inventario';
    }
    $pasivo;
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $pasivo = crearInventario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $pasivo;
}


//Obtiene todos los estados para los filtros 
function obtenerEstadosEquipoParaFiltrar() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerEstadosEquipoParaFiltrar }";
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql);
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


//Agregar una categoria
function agregarCategoria($nombreCategoria, $esRepuesto) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarCategoria (?, ?, ?) }";
    $params = array(array(utf8_decode($nombreCategoria), SQLSRV_PARAM_IN),
        array($esRepuesto, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //Ya existe ese nombre de categoria
    } else if ($men == 2) {
        return 2;  //Ha ocurrido un error
    }
    return ''; //agregado correctamente
}


//Eliminar una categoria
function eliminarCategoria($codigoCategoria) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarCategoria (?, ?) }";
    $params = array(array($codigoCategoria, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //La categoria ha eliminar no existe
    } else if ($men == 3) {
        return 3;  //La categoria tiene un activo o articulo del inventario asociado
    }
    return ''; //eliminado correctamente
}


//Obtiene los detalles de movimientos de un articulo del inventario filtrado por un rango de fechas
function obtenerDetalleArticuloInventarioFiltrado($codigoArticulo, $codigoBodega, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerDetalleArticuloInventarioFiltrado (?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($codigoBodega, SQLSRV_PARAM_IN),
        array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN));
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


//Obtiene el historial de un activo filtrado por un rango de fechas
function obtenerHistorialActivosFijosFiltrado($placa, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerHistorialActivosFijosFiltrado (?, ?, ?) }";
    $params = array(array($placa, SQLSRV_PARAM_IN), array($fechaInicio, SQLSRV_PARAM_IN), 
        array($fechaFinal, SQLSRV_PARAM_IN));
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


//Obtener la ultima fecha de movimientos de salidas o entradas de un articulo del inventario
//para reunirlo con la informacion de los reportes de inventario
//El efecto es un entero, si se envia 1, entonces el retorna la ultima fecha de ingreso
//si es otro, entonces se retorna la ultima fecha de egreso
function obtenerFechaUltimoEfectoInventario($codigoArticulo, $efecto) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerFechaUltimoEfectoInventario (?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array($efecto, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener la fecha';
    }
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        if($efecto == 1){
            $fecha = $row['fechaUltimoIngreso'];
        } else {
            $fecha = $row['fechaUltimoEgreso'];
        }
    }
    sqlsrv_free_stmt($getMensaje);
    return $fecha;
}


//Para llenar la tabla de reportes de inventario solo hay que llamar a esta funcion con los 
//datos que se ingresan en el filtro
function obtenerReportesInventario($codigoArticulo, $descripcion, $nombreCategoria) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAreporteDeInventario (?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($descripcion), SQLSRV_PARAM_IN), 
        array(utf8_decode($nombreCategoria),SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los reportes';
    }
    $reportes = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $reportes[] = crearReporteInventario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $reportes;
}

//Para llenar la tabla de reportes de movimientos solo hay que llamar a esta funcion con los 
//datos que se ingresan en el filtro
function obtenerReporteDeMovimientos($codigoArticulo, $nombreCategoria, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAreporteDeMovimientos (?, ?, ?, ?) }";
    $params = array(array($codigoArticulo, SQLSRV_PARAM_IN), array(utf8_decode($nombreCategoria),SQLSRV_PARAM_IN),
        array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los reportes';
    }
    $reportes = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $reportes[] = crearReporteDeMovimientos($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $reportes;
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
    $proveedor = utf8_encode($row['proveedor']);
    $marca = utf8_encode($row['marca']);
    return new Inventario($codigoArticulo, $descripcion, $costo, $categoria, $estado, $cantidad, $bodega, $proveedor, $marca);
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
    $numeroOrdenDeCompra = $row['numeroOrdenDeCompra'];
    $direccionOrdenDeCompra = $row['direccionOrdenDeCompra'];
    $codigoTiquete = $row['codigoTiquete'];
    return new Detalle($codigoDetalle, $codigoArticulo, $copiaCantidadInventario, $cantidadEfecto,
            $costo, $fecha, $estado, $efecto, $bodega, $comentarioUsuario, $correoUsuarioCausante,
            $nombreUsuarioCausante, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete);
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

function crearReporteInventario($row) {
    $codigoArticulo = $row['codigoArticulo'];
    $descripcion = utf8_encode($row['descripcion']);
    $categoria = crearCategoria($row);
    $cantidad = $row['cantidad'];  
    $fechaUltimoIngreso = obtenerFechaUltimoEfectoInventario($codigoArticulo, 1);  //El 1 es el valor para entradas
    $fechaUltimoEgreso = obtenerFechaUltimoEfectoInventario($codigoArticulo, 2);  //Cualquier otro valor es para salidas
    return new ReporteInventario($codigoArticulo, $descripcion, $categoria, $cantidad, $fechaUltimoIngreso, $fechaUltimoEgreso);
}

function crearReporteDeMovimientos($row) {
    $codigoArticulo = $row['codigoArticulo'];
    $descripcion = utf8_encode($row['descripcion']);
    $categoria = crearCategoria($row);
    $cantidadInventario = $row['copiaCantidadInventario'];
    $cantidadEfecto = $row['cantidadEfecto'];
    $costo = $row['costo'];
    $fecha = $row['fecha'];
    $efecto = $row['efecto'];
    
    if($efecto === 'Salida'){
        $cantidadEfecto = $cantidadEfecto * -1;
    }
    $costo = number_format($costo, 2, '.', '');
    return new ReporteDeMovimientos($codigoArticulo, $descripcion, $categoria, $cantidadInventario, $cantidadEfecto, $costo, $fecha, $efecto);
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
//    echo $tema->obtenerProveedor() . '<br />';
//    echo $tema->obtenerMarca() . '<br />';
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


//$mensaje = agregarArticuloInventario('765','Portatil Lenovo', '30', 2, 'Activo', 2, 2, 'La compu de la jefa ya llegó', 
//        'nubeblanca1997@outlook.com', 'Tatiana Corrales', 'Apartamento de Tati', 'Lenovo', 5627, 'C:direccion/relativa', null);
//
//echo $mensaje;


//$mensaje = aumentarCantidadInventario('987', 5, 'Son muchos teléfonos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 9021, 'C:diferente/direccion/', 4);
//
//echo $mensaje;

//$mensaje = agregarLicencia('2020/01/01', '1234-1234-1234-1234', 'YO XD', 'Vea ust! Es un sistema de tiquetes', '456', 
//        'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//
//echo $mensaje;

//$mensaje = asociarRepuesto('10', '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 'B6');
//echo $mensaje;

//$mensaje = agregarActivo('11', 'CorreoSospechoso@gmail.com', 'Ali Al Shaez', '444', 1, 'T67Y8', 'Inspiron', '2018/04/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante', null);
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

//$usuarios = obtenerDetalleArticuloInventario('987', 3);
//
//foreach ($usuarios as $tema) {   
//    echo $tema->obtenerCodigoArticulo() . '<br />';
//    echo $tema->obtenerComentarioUsuario() . '<br />';
//    echo $tema->obtenerBodega()->obtenerNombreBodega() . '<br />';
//    echo $tema->obtenerNumeroOrdenDeCompra() . '<br />';
//    echo $tema->obtenerDireccionOrdenDeCompra() . '<br />';
//    echo $tema->obtenerCodigoTiquete() . '<br />';
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

//$mensaje = eliminarLicencia('2830-7253-UR46-HBFT', '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//echo $mensaje;

//$mensaje = eliminarRepuesto('Parlante', '567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//echo $mensaje;

//$mensaje = asociarUsuarioActivo('678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 'nubeblanca1997@outlook.com', 'Shimosutki Kanshikan',
//        'Relaciones Internacionales', 'Tsunemori Akane');
//echo $mensaje;

//$mensaje = eliminarUsuarioActivo('678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales');
//echo $mensaje;

//$pasivos = busquedaAvanzadaInventario('', '', '', '', 'peru');
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

//echo 'Activos' . '<br />';
//$activos = busquedaAvanzadaActivos('', '', '', '', 'cri', '');
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

//$activos = obtenerActivosUsuario('nubeblanca1997@outlook.com');
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

//$mensaje = asociarTiqueteActivo('567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 10);
//echo $mensaje;

//$mensaje = desasociarTiqueteActivo('567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 10);
//echo $mensaje;

//$activos = obtenerActivosAsociadosTiquete(10);
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


//$pasivo = obtenerArticuloFiltradoCodigoBodega("10", 1);
//   
//    echo $pasivo->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $pasivo->obtenerCategoria()->obtenerEsRepuesto() . '<br />';
//    echo $pasivo->obtenerDescripcion() . '<br />';
//    echo $pasivo->obtenerEstado(). '<br />'; 
//    echo $pasivo->obtenerCosto() . '<br />';
//    echo $pasivo->obtenerCantidad() . '<br />';
//    echo $pasivo->obtenerBodega()->obtenerNombreBodega() . '<br />';
//    echo $pasivo->obtenerProveedor() . '<br />';
//    echo $pasivo->obtenerMarca() . '<br />';
//    echo '<br />';


//$activo = obtenerActivosFiltradosPlaca("567");
//  
//    echo $activo->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $activo->obtenerPlaca() . '<br />';
//    echo $activo->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $activo->obtenerProveedor() . '<br />';
//    echo $activo->obtenerMarca() . '<br />';
//    echo $activo->obtenerNombreUsuarioAsociado() . '<br />';
//    echo $activo->obtenerCorreoUsuarioAsociado() . '<br />';
//    echo '<br />';



//$estados = obtenerEstadosEquipoParaFiltrar();
//
//foreach ($estados as $tema) {   
//    echo $tema->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerCodigoEstado() . '<br />';
//    echo '<br />';
//}

//$mensaje = agregarCategoria("Moden", 0);
//echo $mensaje;

//$mensaje = eliminarCategoria(15);
//echo $mensaje;

//$fecha = obtenerFechaUltimoEfectoInventario('987', 2);
//echo $fecha->format('d-m-Y H:i');

//$reportes = obtenerReportesInventario('987','','');
//
//foreach ($reportes as $tema) {   
//    echo $tema->obtenerCodigoArticulo() . '<br />';
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCantidad() . '<br />';
//    echo $tema->obtenerFechaUltimoIngreso()->format('d-m-Y H:i') . '<br />';
//    echo $tema->obtenerFechaUltimoEgreso()->format('d-m-Y H:i') . '<br />';
//    echo '<br />';
//}

//$reportes = obtenerReporteDeMovimientos('987','','2018/01/01', '2018/04/28');
//
//foreach ($reportes as $tema) {   
//    echo $tema->obtenerCodigoArticulo() . '<br />';
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCantidadInventario() . '<br />';
//    echo $tema->obtenerCantidadEfecto() . '<br />';
//    echo $tema->obtenerCosto() . '<br />';
//    echo $tema->obtenerFecha()->format('d-m-Y H:i') . '<br />';
//    echo $tema->obtenerEfecto() . '<br />';
//    echo '<br />';
//}