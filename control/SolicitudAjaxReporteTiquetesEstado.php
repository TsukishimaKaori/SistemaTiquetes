<?php

require ("../modelo/ProcedimientosTiquetes.php");
require_once ("../control/AdministrarReporteTiquetesEstado.php");
if (isset($_POST['estado'])) {
    $estado = $_POST['estado'];
    $tiquetes = reporteTiquetesEnEstados($estado);
    $cantidad = count($tiquetes);
    $cantidadRespuesta = CantidadInfoAJAX($cantidad);
    echo tablaTiquetes($estado, $cantidad, $tiquetes);
}
if (isset($_POST['codigo'])) {
    $codigoTiquete = $_POST['codigo'];
    $tiquete = obtenerTiqueteFiltradoCodigo($codigoTiquete);
    detalleTiquete($tiquete);
}

if (isset($_POST['graficoPieTiquetesEstado'])) {
    $cantidad = reporteCantidadTiquetePorEstados();

    $arreglo[] = array('descripcion' => "Nuevo", 'cantidad' => buscarEstado($cantidad,"Nuevo"));


    $arreglo[] = array('descripcion' => "Asignado", 'cantidad' => buscarEstado($cantidad,"Asignado"));

    $arreglo[] = array('descripcion' => "En proceso", 'cantidad' => buscarEstado($cantidad,"En proceso"));

    $arreglo[] = array('descripcion' => "Vencido", 'cantidad' => buscarEstado($cantidad,"Vencido"));

    echo json_encode($arreglo);
}