<?php

//function listadoTiquetes($tiquetes) {
//    $tamanio = count($tiquetes);
//    if ($tamanio == 0) {
//        echo '<h2 class="col-md-12 ">No hay resultados que mostrar</h2> ';
//    } else {
//        foreach ($tiquetes as $tiquete) {
//            tiqueteHistorial($tiquete);
//        }
//    }
//}
//
//function fechaFinal(){
//    $hoy = getdate();
//    $anio = $hoy["year"];
//    $mes = $hoy["mon"];
//    if ($mes < 10) {
//        $mes = "0" . $mes;
//    }
//    $dia = $hoy["mday"];
//    if ($dia < 10) {
//        $dia = "0" . $dia;
//    }
//    $fecha = $dia . "/" . $mes . "/" . $anio;
//    
//    echo ' <div class = "form-group input-group date" id = "datetimepicker2">
//           <input id = "filtroFechaFinal" name ="filtroFechaFinal" type="text" class="form-control" value ="'.$fecha.'" >
//             <span class="input-group-addon btn btn-info"  for="filtroFechaFinal">
//            <i class="glyphicon glyphicon-calendar"></i>
//            </span>  
//            </div>';   
//}
//
//function tiqueteHistorial($tiquete) {
//    echo'  <div id = "' . $tiquete->obtenerCodigoTiquete() . '" class="panelTiqueteHistorial panel panel-default" onclick="mostrarHistorialTiquete(this);">' .
//    '   <div class="panel-heading panelTiqueteHistorialCabecera">' .
//    '       <div class="row"> ' .
//    '           <h5 class="col-md-5 ">Código tiquete:</h5> ' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . $tiquete->obtenerCodigoTiquete() . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '   </div>' .
//    '   <div class="panel-body">' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Nombre del Solicitante:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . $tiquete->obtenerNombreUsuarioIngresaTiquete() . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Correo del Solicitante:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . $tiquete->obtenerCodigoUsuarioIngresaTiquete() . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Nombre del Responsable:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>';
//    if ($tiquete->obtenerResponsable() != null) {
//        echo $tiquete->obtenerResponsable()->obtenerNombreResponsable();
//    } else {
//        echo "No hay responsable asignado";
//    }
//    echo '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Correo del Responsable:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>';
//    if ($tiquete->obtenerResponsable() != null) {
//        echo $tiquete->obtenerResponsable()->obtenerCorreo();
//    } else {
//        echo "No hay responsable asignado";
//    }
//    echo '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Descripcion de la clasificación:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . $tiquete->obtenerTematica()->obtenerDescripcionTematica() . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Descripcion del tiquete:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . $tiquete->obtenerDescripcion() . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '       <div class="row "> ' .
//    '           <h5 class="col-md-5 ">Fecha de creación:</h5>' .
//    '           <div class=" col-md-7">' .
//    '               <h5>' . date_format($tiquete->obtenerFechaCreacion(), 'd-m-Y ') . '</h5>' .
//    '           </div> ' .
//    '       </div>  ' .
//    '   </div>  ' .
//    '</div>';
//}

function historialInfoTiquetes($historial, $codigoTiquete) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        foreach ($historial as $his) {
            historialInfoTiquete($his, $codigoTiquete);
        }
    }
}

function descripcionIndicador($codigoIndicador) {
    $indicadores = array(
        1 => "Enviado a reasignar",
        2 => "Comentario y/o documento adjunto",
        3 => "Genera contrato",
        4 => "Asigna responsable",
        5 => "Cambio de fecha solicitada",
        6 => "Edita las horas trabajadas",
        7 => "Cambio de clasificación",
        8 => "Cambio de prioridad",
        9 => "Puesto en proceso",
        10 => "Tiquete anulado",
        11 => "Tiquete finalizado",
        12 => "Tiquete calificado",
        13 => "Cambio de fecha de entrega",
        14 => "Enviado a reprocesar"
    );
    return $indicadores[$codigoIndicador];
}

function historialInfoTiquete($historial, $codigoTiquete) {
    
   // echo  "<input type = 'hidden' class = 'indicadorh5' id = ".$historial->obtenerCodigoIndicador()." >";
    echo ' <div id = "historialTiquetes" onclick = "cargarHistorialInformacion('.$codigoTiquete.','.$historial->obtenerCodigoHistorial().')" class="panelTiqueteHistorial panel panel-default divHistorial' . $historial->obtenerCodigoIndicador() . '">' .
    '   <div class="panel-heading panelTiqueteHistorialCabecera col-md-12">' .
            
    '       <div class="row"> ' .
    '           <h5 class="col-md-4 ">Código indicador </h5> ' .
    '           <div class=" col-md-2">' .
    '               <h5 class = "indicadorh5">' .  $historial->obtenerCodigoIndicador() . '</h5>' .
    '           </div> ' .
    '            <h5 class="col-md-6 ">'. descripcionIndicador($historial->obtenerCodigoIndicador()) .'</h5> ' .
    '       </div>  ' .
         
    '   </div>  ' .
    
    '<div class="panel-body" >' ;
    if ($historial->obtenerComentarioUsuario() != "") {
        echo '   <div class="row"> ' .
        '           <h5 class="titulo-Indicador col-md-3 ">Comentario del usuario causante:</h5> ' .
        '           <div class=" col-md-9">' .
        '               <h5>' . $historial->obtenerComentarioUsuario() . '</h5>' .
        '           </div> ' .
        '       </div>  ';
    }
    echo ' <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-3 ">Aclaración del sistema:</h5> ' .
    '           <div class=" col-md-9">' .
    '               <h5>' . $historial->obtenerAclaracionSistema() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .

    '</div>' .
    '   </div>';

}

function historialInformacionTiquete($historial, $codigoTiquete) {
    
    echo ' <div   class = "panel panel-info">' .
    '   <div class="panel-heading col-md-12">' .
    '       <div class="row"> ' .
    '           <h5 class="col-md-3 ">Código historial:</h5> ' .
    '           <div class=" col-md-1">' .
    '               <h5>' . $historial->obtenerCodigoHistorial() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '   </div>  ' .
    '<div class="panel-body" >' .
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Código del indicador:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5 >' . $historial->obtenerCodigoIndicador() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Nombre del indicador:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5>' . descripcionIndicador($historial->obtenerCodigoIndicador()) . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Correo del causante:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5>' . $historial->obtenerCorreoUsuarioCausante() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Nombre del causante:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5>' . $historial->obtenerNombreUsuarioCausante() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Correo del responsable:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5>' . $historial->obtenerCorreoResponsable() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Nombre del responsable:</h5> ' .
    '           <div class=" col-md-6">' .
    '               <h5>' . $historial->obtenerNombreResponsable() . '</h5>' .
    '           </div> ' .
    '       </div>  ' ;
 

    if ($historial->obtenerComentarioUsuario() != "") {
        echo ' <div class="row"> ' .
        '           <h5 class="titulo-Indicador col-md-4 ">Comentario del usuario causante:</h5> ' .
        '           <div class=" col-md-6">' .
        '               <h5>' . $historial->obtenerComentarioUsuario() . '</h5>' .
        '           </div> ' .
        '       </div>  ';
    }
    echo '  <div class="row"> ' .
    '           <h5 class="titulo-Indicador col-md-4 ">Aclaración del sistema:</h5> ' .
    '           <div class=" col-md-8">' .
    '               <h5>' . $historial->obtenerAclaracionSistema() . '</h5>' .
    '           </div> ' .
    '       </div>  ' .

    '</div>' .
               '       </div>  ' .
    '   </div>';
    
}
