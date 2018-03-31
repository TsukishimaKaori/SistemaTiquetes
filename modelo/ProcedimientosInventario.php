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
        array($serie, SQLSRV_PARAM_IN), array($proveedor, SQLSRV_PARAM_IN),
        array($modelo, SQLSRV_PARAM_IN), array($marca, SQLSRV_PARAM_IN),
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
    $bodega = utf8_encode($row['bodega']);
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
    $nombreBodega = utf8_encode($row['nombreBodega']);
    return new Bodega($nombreBodega);
}

//$pasivos = obtenerInventario();
//
//foreach ($pasivos as $tema) {   
//    echo $tema->obtenerCategoria()->obtenerNombreCategoria() . '<br />';
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerEstado(). '<br />'; 
//    echo $tema->obtenerCosto() . '<br />';
//    echo $tema->obtenerCantidad() . '<br />';
//    echo $tema->obtenerBodega() . '<br />';
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


$bodegas = obtenerBodegas();

foreach ($bodegas as $tema) {   
    echo $tema->obtenerNombreBodega() . '<br />';
    echo '<br />';
}