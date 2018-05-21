<?php
  require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        require_once ("../control/AdministrarReporteTiquetesFecha.php");
if (isset($_POST['fechaI'])) {
    $fechaInicio = $_POST['fechaI'];
    $fechaFinal = $_POST['fechaF'];   
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . $mes . $dia;
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . $mes . $dia;
    $tiquetes = reporteTodosLosTiquetesFecha($fechaInicio, $fechaFinal);
    cuerpoTablaMistiquetesReporte($tiquetes);

    // echo json_encode($data);
}

