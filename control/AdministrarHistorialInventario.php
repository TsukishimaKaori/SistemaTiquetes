<?php

function historialInventario($historial, $dispositivo) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-12"><h1>Registro de movimientos del artículo</h1> </span></div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Información general del dispositivo en inventario</h3></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Código del dispositivo: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCodigoArticulo() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Categoría: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCategoria()->obtenerNombreCategoria() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Descripción: </span><span class=" col-md-9">' . $dispositivo->obtenerDescripcion() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Costo: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCosto() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9">' . $dispositivo->obtenerBodega() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Cantidad actual en inventario: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCantidad() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><h3>Movimientos del dispositivo</h3></div> ' .
        '       </div>  ' .
        '   </div>  ';
        foreach ($historial as $his) {
            historialInformacionInventario($his);
        }
        echo ' </div></div>  ';
    }
}

function historialInformacionInventario($historial) {
    echo
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Fecha del movimiento:</span><span class=" col-md-9"> ' . date_format($historial->obtenerFecha(), 'd/m/Y ') . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Código del detalle: </span><span class=" col-md-9" > ' . $historial->obtenerCodigoDetalle() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Movimiento registrado: </span><span class=" col-md-9"><b> ' . $historial->obtenerEfecto() . '</b></span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Cantidad de dispositivos afectados : </span><span class=" col-md-9"><b> ' . $historial->obtenerCantidadEfecto() . '</b></span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Cantidad registrada después del movimiento:</span><span class=" col-md-9"> ' . $historial->obtenerCopiaCantidadInventario() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Costo: </span><span class=" col-md-9"> ' . $historial->obtenerCosto() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Estado: </span><span class=" col-md-9"> ' . $historial->obtenerEstado() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9"> ' . $historial->obtenerBodega() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Correo del usuario causante: </span><span class=" col-md-9"> ' . $historial->obtenerCorreoUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Nombre del usuario causante: </span><span class=" col-md-9"> ' . $historial->obtenerNombreUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Comentario del causante: </span><span class=" col-md-9"> ' . $historial->obtenerComentarioUsuario() . '</span></div> ' .
    '       </div>  ';
    echo '</div><div class = "col-md-12">&nbsp</div><div class = "col-md-12">&nbsp</div>';
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




function historialActivos($historial, $dispositivo) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-12"><h1>Registro de movimientos del artículo</h1> </span></div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Información general del dispositivo en inventario</h3></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Código del dispositivo: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCodigoArticulo() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Categoría: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCategoria()->obtenerNombreCategoria() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Descripción: </span><span class=" col-md-9">' . $dispositivo->obtenerDescripcion() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Costo: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCosto() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9">' . $dispositivo->obtenerBodega() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Cantidad actual en inventario: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCantidad() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><h3>Movimientos del dispositivo</h3></div> ' .
        '       </div>  ' .
        '   </div>  ';
        foreach ($historial as $his) {
            historialInformacionActivo($his);
        }
        echo ' </div></div>  ';
    }
}

function historialInformacionActivo($historial) {
    echo
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Fecha del movimiento:</span><span class=" col-md-9"> ' . date_format($historial->obtenerFecha(), 'd/m/Y ') . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Código del detalle: </span><span class=" col-md-9" > ' . $historial->obtenerCodigoDetalle() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Movimiento registrado: </span><span class=" col-md-9"><b> ' . $historial->obtenerEfecto() . '</b></span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Cantidad de dispositivos afectados : </span><span class=" col-md-9"><b> ' . $historial->obtenerCantidadEfecto() . '</b></span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Cantidad registrada después del movimiento:</span><span class=" col-md-9"> ' . $historial->obtenerCopiaCantidadInventario() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Costo: </span><span class=" col-md-9"> ' . $historial->obtenerCosto() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Estado: </span><span class=" col-md-9"> ' . $historial->obtenerEstado() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9"> ' . $historial->obtenerBodega() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Correo del usuario causante: </span><span class=" col-md-9"> ' . $historial->obtenerCorreoUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Nombre del usuario causante: </span><span class=" col-md-9"> ' . $historial->obtenerNombreUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Comentario del causante: </span><span class=" col-md-9"> ' . $historial->obtenerComentarioUsuario() . '</span></div> ' .
    '       </div>  ';
    echo '</div><div class = "col-md-12">&nbsp</div><div class = "col-md-12">&nbsp</div>';
}


