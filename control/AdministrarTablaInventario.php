<?php

function cabeceraTablaPasivos() {
    echo "<th>Código</th>"
    . "<th>Descripción</th>"
    . "<th>Categoría</th>"
    . "<th>Estado</th>"
    . "<th>Cantidad</th>"
    . "<th>Ver</th>";
}

function cabeceraTablaActivos() {
    echo "<th>Tipo</th>"
    . "<th>Estado</th>"
    . "<th>Placa</th>"
    . "<th>Usuario_asociado</th>"
    . "<th>Fecha de salida de inventario </th>";
}

function cuerpoTablaActivos($activos) {
    foreach ($activos as $act) {
        echo '<tr onclick = "cargarPanelActivos(' . $act->obtenerPlaca() . ')">';
        echo '<td>' . $act->obtenerTipo()->obtenerNombreTipo() . '</td>';
        echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerPlaca() . '</td>';
        echo '<td>' . $act->obtenerNombreUsuarioAsociado() . '</td>';
        // $fechaIngeso = $act->obtenerFechaIngresoSistema();
        $fechaSalida = $act->obtenerFechaSalidaInventario();
//        if ($fechaIngeso != null) {
//            $fechaIngeso = date_format($act->obtenerFechaIngresoSistema(), 'd/m/Y');
//            echo '<td>' . $fechaIngeso . '</td>';
//        }
        if ($fechaSalida != null) {
            $fechaSalida = date_format($act->obtenerFechaSalidaInventario(), 'd/m/Y');
            echo '<td>' . $fechaSalida . '</td>';
        }
        echo '</tr>';
    }
}

function cuerpoTablaPasivos($pasivos) {
    foreach ($pasivos as $act) {
        echo '<tr>';
        echo '<td>' . $act->obtenerTipo()->obtenerNombreTipo() . '</td>';
        echo '<td>' . $act->obtenerEsNuevo() . '</td>';
        echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerPlaca() . '</td>';
        $fechaIngeso = $act->obtenerFechaIngresoSistema();
        echo '<td>' .
        '<button class="btn btn-danger btn-circle btn" ><i class="glyphicon glyphicon-minus"></i></button>' .
        '<span>'. $act->obtenerPlaca() .'</span>' .
        '<button onclick = "cargarPanelSumarInventario(' . $act->obtenerPlaca() . ')"  class="btn btn-success btn-circle btn" ><i class="glyphicon glyphicon-plus"></i></button>'
        . '</td>';
        echo '<td><button onclick = "cargarPanelPasivos(' . $act->obtenerPlaca() . ')"   class="btn btn-info btn-circle btn" ><i class="glyphicon glyphicon-eye-open"></i></button></td>';
        echo '</tr>';
    }
}

function panelActivos($activos, $codigo) {
    $listaActivos = buscarDispositivo($activos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de activos</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Placa: </span><span class=" col-md-8">' . $listaActivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Tipo: </span><span class=" col-md-8">' . $listaActivos->obtenerTipo()->obtenerNombreTipo() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Estado: </span><span class=" col-md-8">' . $listaActivos->obtenerEstado()->obtenerNombreEstado() . '</span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Proveedor: </span><span class=" col-md-8">' . $listaActivos->obtenerProveedor() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Modelo: </span><span class=" col-md-8">' . $listaActivos->obtenerModelo() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Marca: </span><span class=" col-md-8">' . $listaActivos->obtenerMarca() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">';
    $fechaIngeso = $listaActivos->obtenerFechaIngresoSistema();
    if ($fechaIngeso != null) {
        $fechaIngeso = date_format($listaActivos->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div><span class="col-md-4 titulo-inventario">Ingreso al sistema: </span><span class=" col-md-8">' . $fechaIngeso . ' </span></div> ';
    } else {
        echo '<div><span class="col-md-4 titulo-inventario">Ingreso al sistema: </span><span class=" col-md-8">Fecha no registrada </span></div> ';
    }
    echo '</div>'
    . '<div class="row">';
    $fechaSalida = $listaActivos->obtenerFechaSalidaInventario();
    if ($fechaSalida != null) {
        $fechaSalida = date_format($listaActivos->obtenerFechaSalidaInventario(), 'd/m/Y');
        echo '<div><span class="col-md-4 titulo-inventario">Salida de inventario: </span><span class=" col-md-8">' . $fechaSalida . ' </span></div> ';
    } else {
        echo '<div><span class="col-md-4 titulo-inventario">Salida de inventario: </span><span class=" col-md-8">Fecha no registrada </span></div> ';
    }
    echo '     </div>'
    . '<div class="row">';
    $fechaExpira = $listaActivos->obtenerFechaExpiraGarantia();
    if ($fechaExpira != null) {
        $fechaExpira = date_format($listaActivos->obtenerFechaExpiraGarantia(), 'd/m/Y');
        echo '<div><span class="col-md-4 titulo-inventario">Expira garantía: </span><span class=" col-md-8">' . $fechaExpira . ' </span></div> ';
    } else {
        echo '<div><span class="col-md-4 titulo-inventario">Expira garantía: </span><span class=" col-md-8">Fecha no registrada </span></div> ';
    }
    echo '</div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Precio: </span><span class=" col-md-8">' . $listaActivos->obtenerPrecio() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerNombreUsuarioAsociado() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Correo usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerCorreoUsuarioAsociado() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Departamento usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerDepartamentoUsuarioAsociado() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Jefatura Usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerJefaturaUsuarioAsociado() . ' </span></div> '
    . '         </div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelPasivos($pasivos, $codigo) {
    $listaPasivos = buscarDispositivo($pasivos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de inventario</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Código: </span><span class=" col-md-8">' . $listaPasivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Descripción: </span><span class=" col-md-8">' . $listaPasivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Categoría: </span><span class=" col-md-8">' . $listaPasivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Estado: </span><span class=" col-md-8">' . $listaPasivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Cantidad: </span><span class=" col-md-8">' . $listaPasivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . ' </div>'
    . '</div>';
}

function panelAgregarInventario() {
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Agregar a inventario</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '       </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelSumarAInventario() {
echo'<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Sumar a inventario</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">hola'
    . '       </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';    
}

function panelAgregarActivoFijo() {
echo'<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Agregar activo Fijo</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">hola'
    . '       </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';    
}


function panelLicencias($licencias, $codigo) {
    $listaLicencias = buscarLicencias($licencias, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de licencias</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Descripcion</h5> '
    . '             <div class="col-md-6"><h5>' . $listaLicencias->obtenerDescripcion() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Clave de producto</h5> '
    . '             <div class="col-md-6"><h5>' . $listaLicencias->obtenerClaveDeProducto() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Cantidad en uso</h5> '
    . '             <div class="col-md-6"><h5>' . $listaLicencias->obtenerCantidadEnUso() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Cantidad total</h5> '
    . '             <div class="col-md-6"><h5>' . $listaLicencias->obtenerCantidadTotal() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Proveedor</h5> '
    . '             <div class="col-md-6"><h5>' . $listaLicencias->obtenerProveedor() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '         <h5 class="col-md-6 titulo">Fecha de ingreso al sistema</h5> ';
    $fechaIngreso = $listaLicencias->obtenerFechaIngresoSistema();
    if ($fechaIngreso != null) {
        $fechaIngreso = date_format($listaLicencias->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngreso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Descripcion</h5> ';
    $fechaVencimiento = $listaLicencias->obtenerFechaDeVencimiento();
    if ($fechaVencimiento != null) {
        $fechaVencimiento = date_format($listaLicencias->obtenerFechaDeVencimiento(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaVencimiento . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelRepuestos($repuestos, $codigo) {
    $listaRepuestos = buscarRepuesto($repuestos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de repuestos</h3></div>'
    . '     <div class="panel-body container-fluid">';
    echo '      <div class="row">'
    . '             <h5 class="col-md-6 titulo">Código Repuesto</h5> '
    . '             <div class="col-md-6"><h5>' . $listaRepuestos->obtenerCodigoRepuesto() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Cantidad en uso</h5> '
    . '             <div class="col-md-6"><h5>' . $listaRepuestos->obtenerCantidadEnUso() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Cantidad total</h5> '
    . '             <div class="col-md-6"><h5>' . $listaRepuestos->obtenerCantidadTotal() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Descripción</h5> '
    . '             <div class="col-md-6"><h5>' . $listaRepuestos->obtenerDescripcion() . '</h5></div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function buscarDispositivo($dispositivo, $codigo) {
    foreach ($dispositivo as $act) {
        if ($act->obtenerPlaca() == $codigo) {
            return $act;
        }
    }
    return null;
}

function buscarRepuesto($dispositivo, $codigo) {
    foreach ($dispositivo as $act) {
        if ($act->obtenerCodigoRepuesto() == $codigo) {
            return $act;
        }
    }
    return null;
}

function buscarLicencias($licencias, $codigo) {
    foreach ($licencias as $act) {
        if ($act->obtenerClaveDeProducto() == $codigo) {
            return $act;
        }
    }
    return null;
}
