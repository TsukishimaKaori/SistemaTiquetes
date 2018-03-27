<?php

function cabeceraTablaPasivos() {
    echo "<th>Tipo</th>"
    . "<th>Antigüedad</th>"
    . "<th>Estado</th>"
    . "<th>Placa</th>"
    . "<th>Fecha de ingreso</th>";
}

function cabeceraTablaActivos() {
    echo "<th>Tipo</th>"
    . "<th>Estado</th>"
    . "<th>Placa</th>"
    . "<th>Usuario_asociado</th>"
    . "<th>Fecha de salida de inventario </th>";
}

function cabeceraTablaLicencias() {
    echo "<th>Descripción</th>"
    . "<th>Proveedor</th>"
    . "<th>Cantidad en uso</th>"
    . "<th>Cantidad total</th>"
    . "<th>Fecha de vencimiento </th>";
}

function cabeceraTablaRepuestos() {
    echo "<th>Código</th>"
    . "<th>Descripción</th>"
    . "<th>Cantidad en uso</th>"
    . "<th>Cantidad total</th>";
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
        echo '<tr onclick = "cargarPanelPasivos(' . $act->obtenerPlaca() . ')">';
        echo '<td>' . $act->obtenerTipo()->obtenerNombreTipo() . '</td>';
        echo '<td>' . $act->obtenerEsNuevo() . '</td>';
        echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerPlaca() . '</td>';
        $fechaIngeso = $act->obtenerFechaIngresoSistema();
        if ($fechaIngeso != null) {
            $fechaIngeso = date_format($act->obtenerFechaIngresoSistema(), 'd/m/Y');
            echo '<td>' . $fechaIngeso . '</td>';
        }
        echo '</tr>';
    }
}

function cuerpoTablaLicencias($licencias) {
    foreach ($licencias as $act) {
        $clave =$act->obtenerClaveDeProducto() ;
        echo '<tr onclick = "cargarPanelLicencias(\''.$clave.'\')">'; //no agarra la clave del producto
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerProveedor() . '</td>';
        echo '<td>' . $act->obtenerCantidadEnUso() . '</td>';
        echo '<td>' . $act->obtenerCantidadTotal() . '</td>';
        $fechaVencimiento = $act->obtenerFechaDeVencimiento();
        if ($fechaVencimiento != null) {
            $fechaVencimiento = date_format($act->obtenerFechaDeVencimiento(), 'd/m/Y');
            echo '<td>' . $fechaVencimiento . '</td>';
        }
        echo '</tr>';
    }
}

function cuerpoTablaRepuestos($repuestos) {
    foreach ($repuestos as $act) {
        echo '<tr onclick = "cargarPanelRepuestos(\'' . $act->obtenerCodigoRepuesto() . '\')">';
        echo '<td>' . $act->obtenerCodigoRepuesto() . '</td>';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';        
        echo '<td>' . $act->obtenerCantidadEnUso() . '</td>';
        echo '<td>' . $act->obtenerCantidadTotal() . '</td>';
        echo '</tr>';
    }
}

function panelActivos($activos, $codigo) {
    $listaActivos = buscarDispositivo($activos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de activos</h3></div>'
    . '     <div class="panel-body container-fluid">';

    echo '      <div class="row">'
    . '             <h5 class="col-md-6 titulo">Placa</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerPlaca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Tipo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerTipo()->obtenerNombreTipo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Antiguedad</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerEsNuevo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Estado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerEstado()->obtenerNombreEstado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Serie</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerSerie() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Proveedor</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerProveedor() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Modelo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerModelo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Marca</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerMarca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Fecha de ingreso al sistema</h5> ';
    $fechaIngeso = $listaActivos->obtenerFechaIngresoSistema();
    if ($fechaIngeso != null) {
        $fechaIngeso = date_format($listaActivos->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngeso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Fecha de salida de inventario</h5> ';
    $fechaSalida = $listaActivos->obtenerFechaSalidaInventario();
    if ($fechaSalida != null) {
        $fechaSalida = date_format($listaActivos->obtenerFechaSalidaInventario(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaSalida . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Expira garantía</h5> ';
    $fechaExpira = $listaActivos->obtenerFechaExpiraGarantia();
    if ($fechaExpira != null) {
        $fechaExpira = date_format($listaActivos->obtenerFechaExpiraGarantia(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaExpira . '</h5></div>';
    } else {
        echo '<div class="col-md-6 titulo"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Precio</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerPrecio() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Nombre usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerNombreUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Correo usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerCorreoUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Departamento usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerDepartamentoUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Jefatura Usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerJefaturaUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelPasivos($pasivos, $codigo) {
    $listaPasivos = buscarDispositivo($pasivos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de pasivos</h3></div>'
    . '     <div class="panel-body container-fluid">';

    echo '      <div class="row">'
    . '             <h5 class="col-md-6 titulo">Placa</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerPlaca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Tipo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerTipo()->obtenerNombreTipo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Antiguedad</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerEsNuevo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Estado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerEstado()->obtenerNombreEstado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Serie</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerSerie() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Proveedor</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerProveedor() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Modelo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerModelo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Marca</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerMarca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Fecha de ingreso al sistema</h5> ';
    $fechaIngeso = $listaPasivos->obtenerFechaIngresoSistema();
    if ($fechaIngeso != null) {
        $fechaIngeso = date_format($listaPasivos->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngeso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Fecha desechado</h5> ';
    $fechaDesechado = $listaPasivos->obtenerFechaDesechado();
    if ($fechaDesechado != null) {
        $fechaDesechado = date_format($listaPasivos->obtenerFechaDesechado(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaDesechado . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Expira garantía</h5> ';
    $fechaExpira = $listaPasivos->obtenerFechaExpiraGarantia();
    if ($fechaExpira != null) {
        $fechaExpira = date_format($listaPasivos->obtenerFechaExpiraGarantia(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaExpira . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Precio</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerPrecio() . '</h5></div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelLicencias($licencias,$codigo) {
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
    $fechaIngreso= $listaLicencias->obtenerFechaIngresoSistema();
    if ($fechaIngreso != null) {
        $fechaIngreso = date_format($listaLicencias->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngreso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
echo  '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 titulo">Descripcion</h5> ';
    $fechaVencimiento= $listaLicencias->obtenerFechaDeVencimiento();
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
