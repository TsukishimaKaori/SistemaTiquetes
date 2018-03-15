<?php

require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarTablaRolUsuario.php");
session_start();
$r = $_SESSION['objetoUsuario'];

//if ($r == 'Ha ocurrido un error' || $r == null) {
//    // $r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//    $r = obtenerResponsable('dannyalfvr97@gmail.com'); //coordinador
//}

if (isset($_POST['activos'])) {

    if ($_POST['activos'] == 'todos') {
        $responsa = obtenerResponsablesCompletos();
    } else {
        $responsa = obtenerResponsables();
    }
    $roles = consultarRoles();
    $areas = obtenerAreaActiva();
    tablaRolesUsuarios($r, $responsa, $roles, $areas);
}

if (isset($_POST['tipo'])) {
    $activos = $_POST['activo'];
    if ($activos == 'true') {
        $responsa = obtenerResponsables();
    } else {
        $responsa = obtenerResponsablesCompletos();
    }
    $tipo = $_POST['tipo'];
    $codigo = $_POST['codigo'];
    $nuevo = $_POST['nuevo'];
    if ($tipo == "area") {
        $mensaje = actualizarAreas($responsa, $nuevo, $codigo);
    } else if ($tipo == "activacion") {
        $mensaje = desactivarEmpleados($responsa, $nuevo, $codigo);
    } else {
        $mensaje = actualizarPermisos($responsa, $nuevo, $codigo);
    }
    if ($mensaje == null) {
        $roles = consultarRoles();
        $areas = obtenerAreas();
        if ($activos == 'true') {
            $responsa = obtenerResponsables();
        } else {
            $responsa = obtenerResponsablesCompletos();
        }
        tablaRolesUsuarios($r, $responsa, $roles, $areas);
    } else {

        echo 'error';
    }
}

if (isset($_POST['codigoU'])) {
    $activos = $_POST['activo'];
    $mensaje = nuevoresponsable();
    if ($mensaje == null) {
        $roles = consultarRoles();
        $areas = obtenerAreas();
        if ($activos == 'true') {
            $responsa = obtenerResponsables();
        } else {
            $responsa = obtenerResponsablesCompletos();
        }
        tablaRolesUsuarios($r, $responsa, $roles, $areas);
    } else {

        echo 'error';
    }
}
?>

