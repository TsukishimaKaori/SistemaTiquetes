<?php

require ("../modelo/ProcedimientosTiquetes.php");
require_once ("../control/AdministrarReporteTiquetesEstado.php");
if (isset($_POST['estado'])) {
    $estado = $_POST['estado'];
    $tiquetes = reporteTiquetesEnEstados($estado);
    $cantidad = count($tiquetes);
    $cantidadRespuesta = CantidadInfoAJAX($cantidad);
    $tabla = cuerpoTablaReportesAjax($tiquetes);
    $respuesta = array("cantidad" => $cantidadRespuesta, "tiquetes" => $tabla);
    echo json_encode($respuesta);
}
if (isset($_POST['codigo'])) {
    $codigoTiquete = $_POST['codigo'];
    $tiquete = obtenerTiqueteFiltradoCodigo($codigoTiquete);
    detalleTiquete($tiquete);
}

