<?php

require_once '../modelo/Conexion.php';
require_once '../modelo/Permiso.php';
require_once '../modelo/Area.php';
require_once '../modelo/Rol.php';
require_once '../modelo/Responsable.php';

function consultarPermisos() {      //Lista el codigo y descripción de todos los permisos de la base
    $conexion = Conexion::getInstancia();

    $tsql = "exec PAconsultarPermisos";
    $getPermisos = sqlsrv_query($conexion->getConn(), $tsql);

    if ($getPermisos == FALSE) {
        return 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getPermisos, SQLSRV_FETCH_ASSOC)) {

        $codigo = $row['codigoPermiso'];
        $descripcion = utf8_encode($row['descripcionPermiso']);
        $rows[] = new Permiso($codigo, $descripcion);
    }
    sqlsrv_free_stmt($getPermisos);
    return $rows;
}

function verificarPermiso($codiR, $codiP) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAverificarRolPermiso (?, ?)}";
    $params = array(array($codiR, SQLSRV_PARAM_IN), array($codiP, SQLSRV_PARAM_IN));
    $getRolPermisos = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getRolPermisos == FALSE) {
        return 'Ha ocurrido un error';
    }
    $respuesta = FALSE;
    $contador = 0;
    while ($row = sqlsrv_fetch_array($getRolPermisos, SQLSRV_FETCH_ASSOC)) {
        $contador++;
    }
    if ($contador == 1) {
        $respuesta = TRUE;
    }
    sqlsrv_free_stmt($getRolPermisos);
    return $respuesta;
}

function consultarRoles() {      //Lista el codigo y nombre de todos los roles de la base
    $conexion = Conexion::getInstancia();

    $tsql = "exec PAconsultarRoles";
    $getRoles = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getRoles == FALSE) {
        return 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getRoles, SQLSRV_FETCH_ASSOC)) {

        $codigo = $row['codigoRol'];
        $nombre = utf8_encode($row['nombreRol']);
        $rows[] = new Rol($codigo, $nombre);
    }
    sqlsrv_free_stmt($getRoles);
    return $rows;
}

//Obtiene un empleado filtrado por el correo
function obtenerResponsable($correoEmp) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerResponsable (?)}";
    $params = array(array($correoEmp, SQLSRV_PARAM_IN));
    $getResponsable = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getResponsable == FALSE) {
        return 'Ha ocurrido un error';
    }
    $responsable;
    while ($row = sqlsrv_fetch_array($getResponsable, SQLSRV_FETCH_ASSOC)) {
        $responsable = crearResponsable($row);
    }
    sqlsrv_free_stmt($getResponsable);
    return $responsable;
}

//Obtiene todos los empleados activos de TI 
function obtenerResponsables() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerResponsables }";
    $getResponsable = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getResponsable == FALSE) {
        return 'Ha ocurrido un error';
    } $responsables = array();
    while ($row = sqlsrv_fetch_array($getResponsable, SQLSRV_FETCH_ASSOC)) {
        $responsables[] = crearResponsable($row);
    }
    sqlsrv_free_stmt($getResponsable);
    return $responsables;
}

//Obtiene los permisos que tiene asociados un rol
//Retorna un listado de código de permisos
function obtenerPermisosAsignadosRol($codiRol) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerPermisosAsignadosRol (?) }";
    $params = array(array($codiRol, SQLSRV_PARAM_IN));
    $getCodPermisos = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getCodPermisos == FALSE) {
        return 'Ha ocurrido un error';
    }
    $codPermisos = array();
    while ($row = sqlsrv_fetch_array($getCodPermisos, SQLSRV_FETCH_ASSOC)) {
        $codPermisos[] = $row['codigoPermiso'];
    }
    sqlsrv_free_stmt($getCodPermisos);
    return $codPermisos;
}

//Acción para actualizar el rol de un usuario
//En caso de no haber podido actualizar, devuelve un mensaje de error 
//que debe ser mostrado el pantalla                                          
function actualizarRolResponsable($codiRol, $codiEmp) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarRolResponsable (?, ?, ?) }";
    $params = array(array($codiRol, SQLSRV_PARAM_IN), array($codiEmp, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ha ocurrido un error con la actualización de ' . $codiEmp;
    } else if ($men == 2) {
        return 'No existe un empleado con el código ' . $codiEmp;
    }
    return '';
}

function insertarPermisoRol($codiRol, $codiPer) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAinsertarPermisoRol (?, ?, ?) }";
    $params = array(array($codiRol, SQLSRV_PARAM_IN), array($codiPer, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ha ocurrido un error';
    }
    return '';
}

function eliminarPermisoRol($codiRol, $codiPer) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarPermisoRol (?, ?, ?) }";
    $params = array(array($codiRol, SQLSRV_PARAM_IN), array($codiPer, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ha ocurrido un error';
    } else if ($men == 2) {
        return 'El rol ' . $codiRol . ' y el permiso ' . $codiPer . ' no están relacionados';
    }
    return '';
}

//Agrega un rol a la tabla Rol, hay que enviarle el nombre del rol
function agregarRol($nomRol) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarRol (?, ?) }";
    $params = array(array($nomRol, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ya existe un rol con el nombre ' . $nomRol;
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Elimina un rol de la tabla Rol, hay que enviarle el codigo de rol
function eliminarRol($codiRol) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarRol (?, ?) }";
    $params = array(array($codiRol, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ha ocurrido un error al eliminar el rol';
    } else if ($men == 3) {
        return 'El rol tiene permisos o usuarios asociados';
    }
    return '';
}

//Agrega un responsable a la tabla Responsable
//Hay que enviar el código de rol, el código de empleado,
//el nombre del empleado, el código de área y el correo
function agregarResponsable($codRol, $codEmp, $nombre, $codArea, $corr) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarResponsable (?, ?, ?, ?, ?, ?) }";
    $params = array(array($codRol, SQLSRV_PARAM_IN), array($codEmp, SQLSRV_PARAM_IN),
        array($nombre, SQLSRV_PARAM_IN), array($codArea, SQLSRV_PARAM_IN),
        array($corr, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'Ya existe un usuario con ese código ' . $codEmp;
    } else if ($men == 2) {
        return 'Ha ocurrido un error al agregar el usuario';
    }
    return '';
}

//Cambiar el loginActivo de la tabla Responsable a 0,
//para dejar un empleado como inactivo
//Hay que enviar el codigo del empleado
function inactivarResponsable($codEmp) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAinactivarResponsable (?, ?) }";
    $params = array(array($codEmp, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe un usuario con el código ' . $codEmp;
    } else if ($men == 2) {
        return 'Ha ocurrido un error al inactivar el usuario';
    }
    return '';
}

//Actualiza los valores de un responsable de la tabla Responsable,
//Hay que enviarle todos los atributos de la clase responsable
function actualizarResponsable($codEmp, $nombre, $login, $codArea, $codRol, $corr) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarResponsable (?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codEmp, SQLSRV_PARAM_IN), array($nombre, SQLSRV_PARAM_IN), array($login, SQLSRV_PARAM_IN),
        array($codArea, SQLSRV_PARAM_IN), array($codRol, SQLSRV_PARAM_IN),
        array($corr, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe un usuario con el código ' . $codEmp;
    } else if ($men == 2) {
        return 'Ha ocurrido un error con la actualización del usuario';
    }
    return '';
}

//Obtiene todos los responsables que se relacionan con el rol
//ingresado por parametros
function obtenerResponsablesAsignadosRol($codRol) {
    $conexion = Conexion::getInstancia();
    $men = 0;
    $tsql = "{call PAobtenerResponsablesAsignadosRol (?, ?) }";
    $params = array(array($codRol, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($men == 1) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los responsables';
    }
    $responsables = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $responsables[] = crearResponsable($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $responsables;
}

function crearResponsable($row) {
    $codigoArea = $row['codigoArea'];
    $nombreArea = utf8_encode($row['nombreArea']);
    $activo = $row['activo'];
    $codigoRol = $row['codigoRol'];
    $nombreRol = utf8_encode($row['nombreRol']);
    $codigoEmpleado = utf8_encode($row['codigoEmpleado']);
    $nombreResponsable = utf8_encode($row['nombreResponsable']);
    $loginActivo = $row['loginActivo'];
    $correo = utf8_encode($row['correo']);
    $rol = new Rol($codigoRol, $nombreRol);
    $area = new Area($codigoArea, $nombreArea, $activo);
    return new Responsable($codigoEmpleado, $nombreResponsable, $loginActivo, $area, $rol, $correo);
}

//Obtiene todos los empleados activos o inactivos de TI
function obtenerResponsablesCompletos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerResponsablesCompletos }";
    $getResponsable = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getResponsable == FALSE) {
        return 'Ha ocurrido un error';
    } $responsables = array();
    while ($row = sqlsrv_fetch_array($getResponsable, SQLSRV_FETCH_ASSOC)) {
        $responsables[] = crearResponsable($row);
    }
    sqlsrv_free_stmt($getResponsable);
    return $responsables;
}

//Cambiar el loginActivo de la tabla Responsable a 1,
//para dejar un empleado como activo
//Hay que enviar el codigo del empleado
function activarResponsable($codEmp) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactivarResponsable (?, ?) }";
    $params = array(array($codEmp, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe un usuario con el código ' . $codEmp;
    } else if ($men == 2) {
        return 'Ha ocurrido un error al inactivar el usuario';
    }
    return '';
}



//$areas = obtenerAreas();
//foreach ($areas as $ar) {   
//    echo $ar->obtenerCodigoArea() . ' '. $ar->obtenerNombreArea() .'<br />'; 
//    
//}
//$n = eliminarPermisoRol(2, 3);
//$n = eliminarRol(7);
//echo $n;
//12o3
//echo actualizarResponsable('12o3', 'Danny Valerio', 1, 2, 3, 'docTorrance@shinning.com');

//$permisos = consultarPermisos();
//
//foreach ($permisos as $permiso) {   
//    echo $permiso->obtenerCodigoPermiso() .'  ' . $permiso->obtenerDescripcionPermiso().'<br />'; 
//    
//}
//
//$res = verificarPermiso(3, 1);
//
//
//if($res){
//    echo 'Permiso concedido'.'<br />';
//}else{
//    echo 'Permiso no concedido'.'<br />';
//}
//
//$roles = consultarRoles();
//
//foreach ($roles as $rol) {   
//    echo $rol->obtenerCodigoRol() .'  ' . $rol->obtenerNombreRol().'<br />'; 
//    
//}
//
//$resp = obtenerResponsable('nubeblanca1997@gmail.com');
//echo $resp->obtenerCodigoEmpleado() .'  ' . $resp->obtenerNombreResponsable(). ' ' . $resp->obtenerArea()->obtenerNombreArea(). ' ' . $resp->obtenerRol()->obtenerNombreRol() .'  ' . $resp->obtenerCorreo(). '<br />'; 
//
//$responsa = obtenerResponsablesCompletos();
//
//foreach ($responsa as $respo) {   
//    echo $respo->obtenerCodigoEmpleado() .'  ' . $respo->obtenerNombreResponsable(). ' ' . $respo->obtenerArea()->obtenerNombreArea(). ' ' . $respo->obtenerRol()->obtenerNombreRol() .'  ' . $respo->obtenerCorreo(). '<br />';    
//}
//
//$permisosRol = obtenerPermisosAsignadosRol(1);
//
//foreach ($permisosRol as $prol) {   
//    echo $prol.'<br />'; 
//    
//}
//
//$mensaje = actualizarRolResponsable(8, '12o3');
//if($mensaje == ''){
//    echo 'Actualizado correctamente' .'<br />';
//}else{
//    echo $mensaje;
//}
//
//$mensaje1 = insertarPermisoRol(9, 1);
//if($mensaje1 == ''){
//    echo 'Insertado correctamente'.'<br />';
//}else{
//    echo $mensaje1;
//}
//
//$mensaje3 = insertarPermisoRol(3, 1);
//if($mensaje3 == ''){
//    echo 'Insertado correctamente 2'.'<br />';
//}else{
//    echo $mensaje3;
//}
//
//$mensaje2 = eliminarPermisoRol(8, 1);
//if($mensaje2 == ''){
//    echo 'Eliminado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}
//$mensaje2 = agregarRol('Papeledor');
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}
//$mensaje2 = eliminarRol(5);
//if($mensaje2 == ''){
//    echo 'Eliminado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = agregarResponsable(2, '12b7', 'Tati Corrales', 1, 'tat@brittshop.com');
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}
//
//$mensaje2 = inactivarResponsable('12b4');
//if($mensaje2 == ''){
//    echo 'Inactivado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = agregarArea('De limpieza');
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = activarResponsable('12b4');
//if($mensaje2 == ''){
//    echo 'Activado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}