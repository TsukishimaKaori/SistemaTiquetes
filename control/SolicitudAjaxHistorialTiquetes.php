<?php
require_once ("../modelo/ProcedimientosTiquetes.php");
require_once ("../control/AdministrarHistorialTiquetes.php");
if (isset($_POST['codigoTiqueteHistorial'])) {
    $codigoTiqueteHistorial = $_POST['codigoTiqueteHistorial'];    
    $correoSolicitante = $_POST['correoSolicitante'];
    $correoResponsable = $_POST['correoResponsable'];
    $filtroFecha = $_POST['filtroFecha'];
    $dia = substr($filtroFecha, 0, 2);
    $mes = substr($filtroFecha, 3, 2);
    $anio = substr($filtroFecha, 6, 4);
   // $fecha = $anio . '-' . $dia. '-' .$mes;
    $filtroFecha = $anio . '-' .$mes. '-'. $dia ;
    
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $nombreResponsable = $_POST['nombreResponsable'];
    $filtroFechaFinal = $_POST['filtroFechaFinal']; 
    $dia = substr($filtroFechaFinal, 0, 2);
    $mes = substr($filtroFechaFinal, 3, 2);
    $anio = substr($filtroFechaFinal, 6, 4);
    // $fecha = $anio . '-' . $dia. '-' .$mes;
    $filtroFechaFinal = $anio . '-' .$mes. '-'. $dia ;
    
//    $filtroFecha= '2018-01-01';
//    $filtroFechaFinal = '2018-02-08';    
    $tiquetes = obtenerTiquetesHistorial($codigoTiqueteHistorial, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $filtroFecha, $filtroFechaFinal);
    if ($tiquetes != 1) {
       listadoTiquetes($tiquetes);
    }else {
        echo 1;
    }   
}

if (isset($_POST['codigoInformacionTiqueteHistorial'])) {
     $codigoTiqueteHistorial = $_POST['codigoInformacionTiqueteHistorial'];    
     
     $historial = obtenerHistorial($codigoTiqueteHistorial); 
     if ($historial != 1) {
       historialInfoTiquetes($historial,$codigoTiqueteHistorial);
    }else {
        echo 1;
    }  
}



if (isset($_POST['codigoTiqueteInformacion'])) {
     $codigoTiqueteInformacion = $_POST['codigoTiqueteInformacion'];   
     $codigoIndicadorInformacion = $_POST['codigoIndicadorInformacion'];  
      $historial = obtenerHistorial($codigoTiqueteInformacion); 
     if ($historial != 1) {
      foreach($historial as $his){
         if($his->obtenerCodigoHistorial() == $codigoIndicadorInformacion){
             historialInformacionTiquete($his,$codigoTiqueteHistorial);
         }
     }       
    }else {
        echo 1;
    }  
}