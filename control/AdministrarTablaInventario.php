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
        '<a href="../vista/AgregarInventario.php"><button  class="btn btn-danger btn-circle btn" ><i class="glyphicon glyphicon-minus"></i></button></a>' .
        '<span>' . $act->obtenerPlaca() . '</span>' .
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
    . '     <div class="panel-body container-fluid">';

    echo'
        <div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="codigo">Código:</label>
            <div class="col-sm-9">
                <input class="form-control" id="codigo" type="text" required>
            </div>
        </div>        
        <div class="form-group  col-md-12 ">
            <label class="control-label col-md-3" for="tipo">Categoría:</label>
            <div class="col-md-9">';
                selectTipos($tipos);
        echo'</div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="descripcion">Descripción:</label>
            <div class="col-md-9">
                <input class="form-control" id="descripcion" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="estado">Estado:</label>
            <div class="col-md-9">
                <input class="form-control" id="estado" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="cantidad">Cantidad:</label>
            <div class="col-md-9">
                <input class="form-control" id="cantidad" type="number" required>
            </div>
        </div>
        <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button class="btn btn-success btn-circle btn" ><i></i>Guardar</button>     
                <button class="btn btn-danger btn-circle btn" ><i></i>Borrar</button>                         
            </div>
        </div>';  
    echo'</div>'
    . ' </div>'
    . '</div>';
}

function selectTipos($tipos) {
    echo'<select class="form-control">';
    echo'<option>opciones</option>';
    foreach ($tipos as $tipo) {
        echo'<option>Categoria</option>';
    }
    echo'</select>';
}

function panelSumarAInventario() {
    echo'<div type = "hidden" class="panel panel-default">'
    . '<div class="panel-heading"><h3>Sumar a inventario</h3></div>'
    . '<div class="panel-body container-fluid">';
    echo'<div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="codigo-suma">Código:</label>
            <div class="col-md-9">
                  <span>11223</span>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <label class="control-label col-md-3">Descrición:</label>
            <div class="col-md-9">
                  <span>Moviles Samsung</span>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="cantidad-suma">Cantidad:</label>
            <div class="col-md-9">
                <input class="form-control" id="cantidad-suma" type="number" required>
            </div>
        </div> 
        <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button class="btn btn-success btn-circle btn" ><i></i>Guardar</button>     
                <button class="btn btn-danger btn-circle btn" ><i></i>Borrar</button>                         
            </div>
        </div>';   
    echo '</div>'
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
