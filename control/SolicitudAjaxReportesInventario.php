<?php

require ("../modelo/ProcedimientosPermisos.php");
require ("../modelo/ProcedimientosInventario.php");
require_once ("../control/AdministrarReportesInventario.php");

if (isset($_POST['codigoI'])) {
    $codigoArticulo = $_POST['codigoI'];
    $descripcion = $_POST['descripcion'];
    $nombreCategoria = $_POST['categoria'];
    $reportesInvetantario = obtenerReportesInventario($codigoArticulo, $descripcion, $nombreCategoria);
    echo cuerpotablaInvetario($reportesInvetantario);

    // echo json_encode($data);
}
if (isset($_POST['codigoM'])) {
    $codigoArticulo = $_POST['codigoM'];
    $nombreCategoria = $_POST['categoria'];
    $fechaInicio = $_POST['fechaI'];    
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio  . $mes  . $dia;
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . $mes .  $dia;   
    $reportesMovimientos = obtenerReporteDeMovimientos($codigoArticulo, $nombreCategoria, $fechaInicio, $fechaFinal);
   echo cuerpotablaMovimiento($reportesMovimientos);
}

