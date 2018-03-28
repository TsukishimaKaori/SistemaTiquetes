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
    echo "<th>Placa</th>"
    . "<th>Categoría</th>"
    . "<th>Estado</th>"
    . "<th>Usuario_asociado</th>"
    . "<th>Fecha de salida de inventario </th>";
}

function cuerpoTablaActivos($activos) {
    foreach ($activos as $act) {
        echo '<tr onclick = "cargarPanelActivos(' . $act->obtenerPlaca() . ')">';
        echo '<td>' . $act->obtenerPlaca() . '</td>';
        echo '<td>' . $act->obtenerCategoria()->obtenerNombreCategoria() . '</td>';
        echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerNombreUsuarioAsociado() . '</td>';
        // $fechaIngeso = $act->obtenerFechaIngresoSistema();
        $fechaSalida = $act->obtenerFechaSalidaInventario();
        if ($fechaSalida != null) {
            $fechaSalida = date_format($act->obtenerFechaSalidaInventario(), 'd/m/Y');
            echo '<td>' . $fechaSalida . '</td>';
        }
        echo '</tr>';
    }
}

function cuerpoTablaPasivos($inventario) {
    foreach ($inventario as $act) {
        echo '<tr>';
        echo '<td>' . $act->obtenerCodigoArticulo() . '</td>';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerCategoria()->obtenerNombreCategoria() . '</td>';
        echo '<td>' . $act->obtenerEstado() . '</td>';
        echo '<td>' .
        '<a href="../vista/AgregarInventario.php"><button  class="btn btn-danger btn-circle btn" ><i class="glyphicon glyphicon-minus"></i></button></a>' .
        '<span>&nbsp &nbsp</span><span>' . $act->obtenerCantidad() . '</span><span>&nbsp &nbsp</span>' .
        '<button onclick = "cargarPanelSumarInventario(' . $act->obtenerCodigoArticulo() . ')"  class="btn btn-success btn-circle btn" ><i class="glyphicon glyphicon-plus"></i></button>'
        . '</td>';
        echo '<td><button onclick = "cargarPanelPasivos(' . $act->obtenerCodigoArticulo() . ')"   class="btn btn-info btn-circle btn" ><i class="glyphicon glyphicon-eye-open"></i></button></td>';
        echo '</tr>';
    }
}

function panelActivos($activos, $codigo) {
    $listaActivos = buscarDispositivoActivoFijo($activos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de activos</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Placa: </span><span class=" col-md-8">' . $listaActivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Categoría: </span><span class=" col-md-8">' . $listaActivos->obtenerCategoria()->obtenerNombreCategoria() . ' </span></div> '
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
    $fechaDesechado = $listaActivos->obtenerFechaDesechado();
    if ($fechaDesechado != null) {
        $fechaDesechado = date_format($listaActivos->obtenerFechaDesechado(), 'd/m/Y');
        echo '<div><span class="col-md-4 titulo-inventario">Fecha desechado: </span><span class=" col-md-8">' . $fechaDesechado . ' </span></div> ';
    } else {
        echo '<div><span class="col-md-4 titulo-inventario">Fecha desechado: </span><span class=" col-md-8">Fecha no registrada </span></div> ';
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
    $listaPasivos = buscarDispositivoInventario($pasivos, $codigo);
    echo
    '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de inventario</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Código: </span><span class=" col-md-8">' . $listaPasivos->obtenerCodigoArticulo() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Descripción: </span><span class=" col-md-8">' . $listaPasivos->obtenerDescripcion() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Categoría: </span><span class=" col-md-8">' . $listaPasivos->obtenerCategoria()->obtenerNombreCategoria() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Estado: </span><span class=" col-md-8">' . $listaPasivos->obtenerEstado() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Cantidad: </span><span class=" col-md-8">' . $listaPasivos->obtenerCantidad() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Costo: </span><span class=" col-md-8">' . $listaPasivos->obtenerCosto() . ' </span></div> '
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
            <label class="control-label col-md-3" for="bodega">Bodega:</label>
            <div class="col-md-9">
                <input class="form-control" id="bodega" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="comentario">Comentario:</label>
            <div class="col-md-9">
                <textarea class="form-control" id="comentario" required></textarea>
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

function panelSumarAInventario($inventarios,$codigo) {
    $inventario = buscarDispositivoInventario($inventarios, $codigo);
    echo'<div type = "hidden" class="panel panel-default">'
    . '<div class="panel-heading"><h3>Sumar a inventario</h3></div>'
    . '<div class="panel-body container-fluid">';
    echo'<div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="codigo-suma">Código:</label>
            <div class="col-md-9">
                  <span>'.$inventario->obtenerCodigoArticulo().'</span>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <label class="control-label col-md-3">Descrición:</label>
            <div class="col-md-9">
                  <span>'.$inventario->obtenerDescripcion().'</span>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="cantidad-suma">Cantidad:</label>
            <div class="col-md-9">
                <input class="form-control" id="cantidad-suma" type="number" required>
            </div>
        </div> 
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="bodega-suma">Bodega:</label>
            <div class="col-md-9">
                <input class="form-control" id="bodega-suma" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="comentario-suma">Comentario:</label>
            <div class="col-md-9">
                <textarea class="form-control" id="comentario-suma" required></textarea>
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
        if ($act->obtenerPlaca()== $codigo) {
            return $act;
        }
    }
    return null;
}
