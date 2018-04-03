<?php
function historialInfoTiquetes($historial, $dispositivo) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-12"><h1>Historial del tiquete</h1> </span></div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Información general del tiquete</h3></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Código del tiquete: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Clasificación: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Descripción: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Usuario solicitante: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Responsable a cargo: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-2">Prioridad: </span><span class=" col-md-10"> </span></div> ' .
        '       </div>  ' .
                        '       <div class="row"> ' .
        '           <div><h3>Historial del tiquete</h3></div> ' .
        '       </div>  ' .                
        '   </div>  ';
        foreach ($historial as $his) {
           // historialInformacionInventario($his);
        }
        echo ' </div></div>  ';
    }
}


function historialInformacionInventario($historial) {
    echo
    '<div class = "col-md-12" >' .
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



function buscarDispositivoInventario($dispositivo, $codigo) {
    foreach ($dispositivo as $act) {
        if ($act->obtenerCodigoArticulo() == $codigo) {
            return $act;
        }
    }
    return null;
}

function buscarDispositivoActivoFijo($dispositivo, $codigo) {
    foreach ($dispositivo as $act) {
        if ($act->obtenerPlaca() == $codigo) {
            return $act;
        }
    }
    return null;
}