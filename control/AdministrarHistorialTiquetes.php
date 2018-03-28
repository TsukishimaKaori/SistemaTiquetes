<?php

function historialInfoTiquetes($historial, $codigoTiquete) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
        '       <div class="row"> ' .
        '           <h5 class="col-md-3 ">Código historial:</h5> ' .
        '           <div class=" col-md-1">' .
        '               <h5></h5>' .
        '           </div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >';
        foreach ($historial as $his) {
            historialInformacionTiquete($his, $codigoTiquete);
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

function historialInformacionTiquete($historial, $codigoTiquete) {
    echo
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-2">Código del indicador: </span><span class=" col-md-10"> ' . $historial->obtenerCodigoIndicador() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-2">Nombre del indicador: </span><span class=" col-md-10" > ' . descripcionIndicador($historial->obtenerCodigoIndicador()) . '</span></div> ' .
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
