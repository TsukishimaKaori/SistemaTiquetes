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
    . "<th>Usuario asociado</th>"
    . "<th>Antigüedad</th>"
    . "<th>Fecha de salida </th>";
}

function cabeceraTablaLicencias() {
    echo "<th>Descripción</th>"
    . "<th>Proveedor</th>"
    . "<th>Cantidad en uso</th>"
    . "<th>Cantidad total</th>"
    . "<th>fecha de vencimiento </th>";
}

function cabeceraTablaRepuestos() {
    echo "<th>Descripcion</th>"
    . "<th>Código Repuesto</th>"
    . "<th>Cantidad en uso</th>"
    . "<th>Cantidad total</th>";
}

function cuerpoTablaActivos($activos) {
    foreach ($activos as $act) {
        echo '<tr onclick = "cargarPanelActivos(' . $act->obtenerPlaca() . ')">';
        echo '<td>' . $act->obtenerTipo()->obtenerNombreTipo() . '</td>';
        echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerPlaca() . '</td>';
        echo '<td>' . $act->obtenerCorreoUsuarioAsociado() . '</td>';
        $fechaIngeso = $act->obtenerFechaIngresoSistema();
        $fechaSalida = $act->obtenerFechaSalidaInventario();
        if ($fechaIngeso != null) {
            $fechaIngeso = date_format($act->obtenerFechaIngresoSistema(), 'd/m/Y');
            echo '<td>' . $fechaIngeso . '</td>';
        }
        if ($fechaSalida != null) {
            $fechaSalida = date_format($act->obtenerFechaIngresoSistema(), 'd/m/Y');
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
        echo '<tr onclick = "cargarPanelLicencias(' . $act->obtenerCantidadEnUso() . ')">'; //no agarra la clave del producto
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
        echo '<tr onclick = "cargarPanelRepuestos(' . $act->obtenerCodigoRepuesto() . ')">';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerCodigoRepuesto() . '</td>';
        echo '<td>' . $act->obtenerCantidadEnUso() . '</td>';
        echo '<td>' . $act->obtenerCantidadTotal() . '</td>';
        echo '</tr>';
    }
}

function panelActivos($activos, $codigo) {
    $listaActivos = buscarDispositivo($activos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h5>Especificaciones de activos</h5></div>'
    . '     <div class="panel-body container-fluid">';

    echo '      <div class="row">'
    . '             <h5 class="col-md-6 ">Placa</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerPlaca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Tipo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerTipo()->obtenerNombreTipo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Antiguedad</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerEsNuevo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Estado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerEstado()->obtenerNombreEstado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Serie</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerSerie() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Proveedor</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerProveedor() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Modelo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerModelo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Marca</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerMarca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Fecha de ingreso al sistema</h5> ';
    $fechaIngeso = $listaActivos->obtenerFechaIngresoSistema();
    if ($fechaIngeso != null) {
        $fechaIngeso = date_format($listaActivos->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngeso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Fecha de salida de inventario</h5> ';
    $fechaSalida = $listaActivos->obtenerFechaSalidaInventario();
    if ($fechaSalida != null) {
        $fechaSalida = date_format($listaActivos->obtenerFechaSalidaInventario(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaSalida . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Expira garantía</h5> ';
        $fechaExpira = $listaActivos->obtenerFechaExpiraGarantia();
    if ($fechaExpira != null) {
        $fechaExpira = date_format($listaActivos->obtenerFechaExpiraGarantia(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaExpira . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Precio</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerPrecio() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Nombre usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerNombreUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Correo usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerCorreoUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Departamento usuario asociado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaActivos->obtenerDepartamentoUsuarioAsociado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Jefatura Usuario asociado</h5> '
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
    . ' <div class="panel-heading"><h5>Especificaciones de activos</h5></div>'
    . '     <div class="panel-body container-fluid">';

    echo '      <div class="row">'
    . '             <h5 class="col-md-6 ">Placa</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerPlaca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Tipo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerTipo()->obtenerNombreTipo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Antiguedad</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerEsNuevo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Estado</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerEstado()->obtenerNombreEstado() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Serie</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerSerie() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Proveedor</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerProveedor() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Modelo</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerModelo() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Marca</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerMarca() . '</h5></div>'
    . '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Fecha de ingreso al sistema</h5> ';
    $fechaIngeso = $listaPasivos->obtenerFechaIngresoSistema();
    if ($fechaIngeso != null) {
        $fechaIngeso = date_format($listaPasivos->obtenerFechaIngresoSistema(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaIngeso . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Fecha desechado</h5> ';
    $fechaDesechado = $listaPasivos->obtenerFechaDesechado();
    if ($fechaDesechado != null) {
        $fechaDesechado = date_format($listaPasivos->obtenerFechaDesechado(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaDesechado . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Expira garantía</h5> ';
        $fechaExpira = $listaPasivos->obtenerFechaExpiraGarantia();
    if ($fechaExpira != null) {
        $fechaExpira = date_format($listaPasivos->obtenerFechaExpiraGarantia(), 'd/m/Y');
        echo '<div class="col-md-6"><h5>' . $fechaExpira . '</h5></div>';
    } else {
        echo '<div class="col-md-6"><h5>Fecha no registrada</h5></div>';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '             <h5 class="col-md-6 ">Precio</h5> '
    . '             <div class="col-md-6"><h5>' . $listaPasivos->obtenerPrecio() . '</h5></div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelLicencias($licencias) {
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h5>Especificaciones de licencias</h5></div>'
    . '     <div class="panel-body container-fluid">'
    . '         <div class="row">'
    . '             <div class="col-md-3"></div>'
    . '             <div class="col-md-9"></div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function panelRepuestos($repuestos,$codigo) {
    $listaRepuestos = buscarRepuesto($repuestos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h5>Especificaciones de repuestos</h5></div>'
    . '     <div class="panel-body container-fluid">'
    . '         <div class="row">'
    . '             <div class="col-md-3"></div>'
    . '             <div class="col-md-9"></div>'
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
