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
        echo '<tr onclick = "cargarPanelLicencias(' . $act->obtenerClaveDeProducto() . ')">';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerProveedor() . '</td>';
        echo '<td>' . $act->obtenerCantidadEnUso() . '</td>';
        echo '<td>' . $act->obtenerCantidadTotal() . '</td>';
        $fechaVencimiento = $act->obtenerFechaDeVencimiento();
        if ($fechaVencimiento != null) {
            $fechaVencimiento = date_format($act->obtenerFechaIngresoSistema(), 'd/m/Y');
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

function panelActivos() {
    echo
    '<div id = "" type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading">Especificaciones</div>'
    . ' <div class="panel-body">'
    . '</div>'
    . '</div>';
}

function panelPasivos() {
    
}

function panelLicencias() {
    
}

function panelRepuestos() {
    
}
