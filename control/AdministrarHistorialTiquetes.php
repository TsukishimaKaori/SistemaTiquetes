<?php

function historialInfoTiquetes($historial, $tiquete) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Información general del tiquete</h3></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Código del tiquete: </span><span class=" col-md-10"> ' . $tiquete->obtenerCodigoTiquete() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Clasificación: </span><span class=" col-md-10"> ' . $tiquete->obtenerTematica()->obtenerDescripcionTematica() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Descripción: </span><span class=" col-md-10"> ' . $tiquete->obtenerDescripcion() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Usuario solicitante: </span><span class=" col-md-10"> ' . $tiquete->obtenerNombreUsuarioIngresaTiquete() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Responsable a cargo: </span><span class=" col-md-10"> ' . $tiquete->obtenerResponsable()->obtenerNombreResponsable() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Prioridad: </span><span class=" col-md-10"> ' . $tiquete->obtenerPrioridad()->obtenerNombrePrioridad() . '</span></div> ' .
        '       </div>  ' .     
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Historial del tiquete</h3></div> ' .
        '       </div>  ' .                
        '   </div>  ';
        foreach ($historial as $his) {
            historialInformacionTiquete($his);
        }
        echo ' </div></div>  ';
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

function historialInformacionTiquete($historial) {
    echo
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Indicador: </span><span class=" col-md-10" > ' . $historial->obtenerFechaHora() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Indicador: </span><span class=" col-md-10" > ' . descripcionIndicador($historial->obtenerCodigoIndicador()) . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-2">Correo del causante:</span><span class=" col-md-10"> ' . $historial->obtenerCorreoUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Nombre del causante:</span><span class=" col-md-10"> ' . $historial->obtenerNombreUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Correo del responsable: </span><span class=" col-md-10"> ' . $historial->obtenerCorreoResponsable() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-2">Nombre del responsable: </span><span class=" col-md-10"> ' . $historial->obtenerNombreResponsable() . '</span></div> ' .
    '       </div>  ';

    if ($historial->obtenerComentarioUsuario() != "") {
        echo '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Comentario del usuario causante:</span><span class=" col-md-10"> ' . $historial->obtenerComentarioUsuario() . '</span></div> ' .
        '       </div>  ';
    }
    echo '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Aclaración del sistema:</span><span class=" col-md-10"> ' . $historial->obtenerAclaracionSistema() . '</span></div> ' .
    '       </div>  ';

    echo '  <div class="row"> ' .
    '           <div class=" col-md-12">&nbsp</div> ' .
    '       </div>  ';


    echo '</div>';
}
