<?php

function historialInventario($historial, $dispositivo) {
    $tamanio = count($historial);
    if ($tamanio == 0) {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    } else {
        echo ' <div   class = "panel panel-info">' .
        '   <div class="panel-heading col-md-12">' .
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
        '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9">' . $dispositivo->obtenerBodega()->obtenerNombreBodega() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Cantidad actual en inventario: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCantidad() . ' </span></div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Movimientos del dispositivo</h3></div> ' .
        '       </div>  ' .
        '   </div>  ';

        echo '<div id = "panelFiltrado">';
        historialInformacionInventarioPorElemento($historial);
        echo '</div>';

        echo ' </div></div>  ';
    }
}

function historialInformacionInventarioPorElemento($historial) {
    foreach ($historial as $his) {
        historialInformacionInventario($his);
    }
}

function historialInformacionInventario($historial) {

    if ($historial->obtenerEfecto() == "Entrada") {
        echo '<div class = "col-md-12 panel panel-success" >';
    } else {
        echo '<div class = "col-md-12 panel panel-danger" >';
    }
    echo'     <div class="row"> ' .
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
    '           <div><span class="titulo-Indicador col-md-3">Bodega: </span><span class=" col-md-9"> ' . $historial->obtenerBodega()->obtenerNombreBodega() . '</span></div> ' .
    '       </div>  ';
    $codigoTiqute = $historial->obtenerCodigoTiquete();
    if ($codigoTiqute != "") {
        echo '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Código del tiquete asociado: </span><span class=" col-md-9"><a href="../vista/AdministrarInformacionTiquetes.php?tiquete=' . $codigoTiqute . '&pagina=5&bodega=' . $historial->obtenerBodega()->obtenerCodigoBodega() . '&dispositivo=' . $_GET['dispositivo'] . '&paginaAnterior=2"><button class = "btn btn-success"><span class="glyphicon glyphicon-file"></span>Tiquete asociado ' . $codigoTiqute . '</button></a></span></div> ' .
        '       </div>  ';
    }
    echo '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Númer orden de compra: </span><span class=" col-md-9"> ' . $historial->obtenerNumeroOrdenDeCompra() . '</span></div> ' .
    '       </div>  ';
    if ($historial->obtenerDireccionOrdenDeCompra() != "") {
        echo '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Adjunto orden de compra: </span><span class=" col-md-9"> <a href="' . $historial->obtenerDireccionOrdenDeCompra() . '" target="_blank"><button class = "btn btn-info"><span class="glyphicon glyphicon-file"></span>Orden de compra</button></a></span></div> ' .
        '       </div>  ';
    }
    echo '       <div class="row"> ' .
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
        '           <div><span class="titulo-Indicador col-md-12"> </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><h3>Información general del activo fijo</h3></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Placa: </span><span class=" col-md-9"> ' . $dispositivo->obtenerPlaca() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Categoría: </span><span class=" col-md-9"> ' . $dispositivo->obtenerCategoria()->obtenerNombreCategoria() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Estado: </span><span class=" col-md-9">' . $dispositivo->obtenerEstado()->obtenerNombreEstado() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Serie: </span><span class=" col-md-9"> ' . $dispositivo->obtenerSerie() . '</span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Proveedor: </span><span class=" col-md-9">' . $dispositivo->obtenerProveedor() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Modelo: </span><span class=" col-md-9"> ' . $dispositivo->obtenerModelo() . ' </span></div> ' .
        '       </div>  ' .
        '       <div class="row"> ' .
        '           <div><span class="titulo-Indicador col-md-3">Marca: </span><span class=" col-md-9"> ' . $dispositivo->obtenerMarca() . ' </span></div> ' .
        '       </div>  ' .
        '   </div>  ' .
        '<div class="panel-body" >' .
        '   <div class="col-md-12">' .
        '       <div class="row"> ' .
        '           <div><h3>Movimientos del activo fijo</h3></div> ' .
        '       </div>  ' .
        '   </div>  ';

        echo '<div id = "panelFiltradoActivos">';
        historialInformacionActivoPorElemento($historial);
        echo '</div>';

        echo ' </div></div>  ';
    }
}

function historialInformacionActivoPorElemento($historial) {
    foreach ($historial as $his) {
        historialInformacionActivo($his);
    }
}

function historialInformacionActivo($historial) {
    echo
    '<div class = "col-md-12" >' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Fecha del movimiento:</span><span class=" col-md-9"> ' . date_format($historial->obtenerFechaHora(), 'd/m/Y ') . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Código del detalle: </span><span class=" col-md-9" > ' . $historial->obtenerCodigoHistorial() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Descripción del indicador: </span><span class=" col-md-9"><b> ' . $historial->obtenerDescripcionIndicador() . '</b></span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Correo del usuario causante : </span><span class=" col-md-9"> ' . $historial->obtenerCorreoUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div ><span class="titulo-Indicador col-md-3">Nombre del usuario causante:</span><span class=" col-md-9"> ' . $historial->obtenerNombreUsuarioCausante() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Correo del usuario asociado:  </span><span class=" col-md-9"> ' . $historial->obtenerCorreoUsuarioAsociado() . '</span></div> ' .
    '       </div>  ' .
    '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Nombre del usuario asociado:  </span><span class=" col-md-9"> ' . $historial->obtenerNombreUsuarioAsociado() . '</span></div> ' .
    '       </div>  ';
    if ($historial->obtenerComentarioUsuario() != "") {
        if ($historial->obtenerDescripcionIndicador() == "Adjunta documento") {
            echo '       <div class="row"> ' .
            '           <div><span class="titulo-Indicador col-md-3">Adjunto contrato: </span><span class=" col-md-9"> <a href="' . $historial->obtenerComentarioUsuario() . '" target="_blank"><button class = "btn btn-info"><span class="glyphicon glyphicon-file"></span>Contrato</button></a></span></div> ' .
            '       </div>  ';
        } else {
            echo '       <div class="row"> ' .
            '           <div><span class="titulo-Indicador col-md-3">Comentario del usuario causante:  </span><span class=" col-md-9"> ' . $historial->obtenerComentarioUsuario() . '</span></div> ' .
            '       </div>  ';
        }
    }
    echo '       <div class="row"> ' .
    '           <div><span class="titulo-Indicador col-md-3">Aclaración del sistema:  </span><span class=" col-md-9"> ' . $historial->obtenerAclaracionSistema() . '</span></div> ' .
    '       </div>  ';
    echo '</div><div class = "col-md-12">&nbsp</div><div class = "col-md-12">&nbsp</div>';
}

function filtroInventario($fecha) {
    echo'<div class="col-md-12">
        <div class="panel panel-primary"> 
            <div class="panel-body">  
                <div class="container-fluid">                              
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Fecha de inicio:</h5>
                        </div>                                     
                        <div class="col-md-2  ">
                            <div class = "form-group input-group date" id = "datetimepicker1">
                                <input id = "fechafiltroI" name ="filtro-fecha" type="text" class="  form-control" value="01/01/1950">
                                <span class="input-group-addon btn btn-info"  onclick="document.getElementById(\'fechafiltroI\').focus()" >
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>  
                            </div>
                        </div>
                  
                        <div class="col-md-2">
                            <h5>Fecha de final:</h5>
                        </div>                                     
                        <div class="col-md-2  ">
                            <div class = "form-group input-group date" id = "datetimepicker2">
                                <input id = "fechafiltroF" name ="filtro-fecha" type="text" class="form-control" value="' . $fecha . '" >
                                <span class="input-group-addon btn btn-info"  onclick="document.getElementById(\'fechafiltroF\').focus()">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>  
                            </div>
                        </div>  
                    </div>                    
                    <div class="col-md-offset-6 col-md-6 form-group input-group boton-filtrar">
                        <button class="btn btn-success" onclick="filtrarBusqueda()">Filtrar búsqueda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function filtrosArticulos() {
    //$estados = obtenerEstados();
    $hoy = getdate();
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10) {
        $mes = "0" . $mes;
    }
    $dia = $hoy["mday"];
    if ($dia < 10) {
        $dia = "0" . $dia;
    }
    $fecha = $dia . "/" . $mes . "/" . $anio;
    filtroInventario($fecha);
}
