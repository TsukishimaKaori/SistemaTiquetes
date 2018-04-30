<?php
require ("../modelo/ProcedimientosTiquetes.php");
//require ("../modelo/AdministrarReportesTiquetes.php");

if (isset($_POST['areasTematicasReportes'])) {
    $areasTematicasReportes = $_POST['areasTematicasReportes'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;    
    $data = obtenerReporteTiquetesIngresadosPorClasificacion($areasTematicasReportes, $fechaInicio, $fechaFinal);
    
    foreach ($data as $d){
        $arreglo[] =array ('descripcionClasificacion'=>$d->obtenerDescripcionClasificacion(), 'cantidadClasificacion'=>$d->obtenerCantidadClasificacion());
    }
    echo json_encode($arreglo);
   // echo json_encode($data);
}


if (isset($_POST['fechaInicioRendimientoPorArea'])) {
    $fechaInicio = $_POST['fechaInicioRendimientoPorArea'];
    $fechaFinal = $_POST['fechaFinalRendimientoPorArea'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;    
    $data = reporteCumplimientoPorArea($fechaInicio, $fechaFinal);
    foreach ($data as $d){
        $arreglo[] =array ('nombreArea'=>$d->obtenerNombreArea(), 'totalAtendidas'=>$d->obtenerTotalAtendidas(),'totalCalificadas'=>$d->obtenerTotalCalificadas() );
    }
    echo json_encode($arreglo);
   // echo json_encode($data);
}


if (isset($_POST['datepickerAnio'])) {
    $anio = $_POST['datepickerAnio'];

    $data =  obtenerReporteCantidadDeTiquetesMensuales($anio);
    foreach ($data as $d){
        $arreglo[] =array ('cantidadMensuales'=>$d->obtenerCantidadMensuales(), 'mes'=>$d->obtenerMes() );
    }
    echo json_encode($arreglo);
   // echo json_encode($data);
}