<?php

function cabeceraTablaPasivos() {
    echo "<th>Código</th>"
    . "<th>Descripción</th>"
    . "<th>Categoría</th>"
    . "<th>Tipo</th>"
    . "<th>Bodega</th>"
    . "<th>+</th>"
    . "<th>Cantidad</th>"
    . "<th>-</th>"
    . "<th>Ver</th>"
    . "<th>Historial</th>";
}

function cabeceraTablaActivos() {
    echo "<th>Placa</th>"
    . "<th>Categoría</th>"
    //  . "<th>Estado</th>"
    . "<th>Usuario_asociado</th>"
    . "<th>Fecha de salida de inventario </th>"
    . "<th>Repuesto</th>"
    . "<th>Licencia</th>"
    . "<th>Ver</th>"
    . "<th>Historial</th>";
}

function cuerpoTablaActivos($activos) {
    foreach ($activos as $act) {
        echo '<tr >';
        echo '<td >' . $act->obtenerPlaca() . '</td>';
        echo '<td>' . $act->obtenerCategoria()->obtenerNombreCategoria() . '</td>';
        //      echo '<td>' . $act->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $act->obtenerNombreUsuarioAsociado() . '</td>';
        // $fechaIngeso = $act->obtenerFechaIngresoSistema();
        $fechaSalida = $act->obtenerFechaSalidaInventario();
        if ($fechaSalida != null) {
            $fechaSalida = date_format($act->obtenerFechaSalidaInventario(), 'd/m/Y');
            echo '<td>' . $fechaSalida . '</td>';
        }
        echo '<td><button onclick = "cargarPanelRepuestos(\'' . $act->obtenerPlaca() . '\',this)" class="btn btn-warning btn-circle btn" ><i class="glyphicon glyphicon-plus"></i></button></td>';
        echo '<td><button onclick = "cargarPanelLicencias(\'' . $act->obtenerPlaca() . '\',this)" class="btn btn-primary btn-circle btn" ><i class="glyphicon glyphicon-plus"></i></button></td>';
        echo '<td><button onclick = "cargarPanelActivos(\'' . $act->obtenerPlaca() . '\',this)" class="btn btn-info btn-circle btn" ><i class="glyphicon glyphicon-eye-open"></i></button></td>';
        echo '<td><a href = "../vista/HistorialInventario.php?pagina=1&dispositivo=' . $act->obtenerPlaca() . ' "><button onclick = "cargarHistorial(2)" class="btn btn-warning btn-circle btn" ><i class="glyphicon glyphicon-list-alt"></i></button></a></td>';
        echo '</tr>';
    }
}

function cuerpoTablaPasivos($inventario) {
    foreach ($inventario as $act) {
        echo '<tr>';
        echo '<td>' . $act->obtenerCodigoArticulo() . '</td>';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerCategoria()->obtenerNombreCategoria() . '</td>';
        if ($act->obtenerCategoria()->obtenerEsRepuesto() == "1") {
            echo '<td>Repuesto</td>';
        } else {
            echo '<td>Activo</td>';
        }
        echo '<td>' . $act->obtenerBodega()->obtenerNombreBodega() . '</td>';

        echo '<td>';
        if (($act->obtenerCantidad() > 0 && $act->obtenerCategoria()->obtenerEsRepuesto() == "0")) {
            echo '<a href="../vista/AgregarActivos.php?codigoArticulo=' . $act->obtenerCodigoArticulo() . '&categoriaCodigo=' . $act->obtenerCategoria()->obtenerCodigoCategoria() . '&categoria=' . $act->obtenerCategoria()->obtenerNombreCategoria() . '&descripcion=' . $act->obtenerDescripcion() . '"><button  class="btn btn-danger btn-circle btn" ><i class="glyphicon glyphicon-minus"></i></button></a>';
        } else {
            echo '<button disabled class="btn btn-danger btn-circle btn" ><i class="glyphicon glyphicon-minus"></i></button>';
        }
        echo '</td>';
        echo '<td>'
        . '<span>' . $act->obtenerCantidad() . '</span>';
        echo '</td>'
        . '<td>'
        . '<button onclick = "cargarPanelSumarInventario(\'' . $act->obtenerCodigoArticulo() . '\',\'' . $act->obtenerBodega()->obtenerCodigoBodega() . '\',this)"  class="btn btn-success btn-circle btn" ><i class="glyphicon glyphicon-plus"></i></button>';
        '</td>';
        echo '<td><button onclick = "cargarPanelPasivos(\'' . $act->obtenerCodigoArticulo() . '\',\'' . $act->obtenerBodega()->obtenerCodigoBodega() . '\',this)"   class="btn btn-info btn-circle btn" ><i class="glyphicon glyphicon-eye-open"></i></button></td>';
        echo '<td><a href = "../vista/HistorialInventario.php?pagina=2&bodega=' . $act->obtenerBodega()->obtenerCodigoBodega() . '&dispositivo=' . $act->obtenerCodigoArticulo() . ' "><button class="btn btn-warning btn-circle btn" ><i class="glyphicon glyphicon-list-alt"></i></button></a></td>';

        echo '</tr>';
    }
}

function cuerpoTablaLicencias($licencias) {
    foreach ($licencias as $act) {
        echo '<tr id="' . $act->obtenerClaveDeProducto() . '" >';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        echo '<td>' . $act->obtenerClaveDeProducto() . '</td>';
        echo '<td>' . $act->obtenerProveedor() . '</td>';
        $fechaSalida = $act->obtenerFechaDeVencimiento();
        if ($fechaSalida != null) {
            $fechaSalida = date_format($act->obtenerFechaDeVencimiento(), 'd/m/Y');
            echo '<td>' . $fechaSalida . '</td>';
        }
        $fechaAsociado = $act->obtenerFechaAsociado();
        if ($fechaAsociado != null) {
            $fechaAsociado = date_format($act->obtenerFechaAsociado(), 'd/m/Y');
            echo '<td>' . $fechaAsociado . '</td>';
        }
        echo '<td><button type="button" class="btn btn-danger" onclick="eliminarLicencia(\'' . $act->obtenerClaveDeProducto() . '\')">
      <span class="glyphicon glyphicon-remove"></span>
    </button></td>';
        echo '</tr>';
    }
}

function cuerpoTablaRepuestos($repuestos) {
    foreach ($repuestos as $act) {
        echo '<tr id="' . $act->obtenerDescripcion() . '">';
        echo '<td>' . $act->obtenerDescripcion() . '</td>';
        $fechaAsociado = $act->obtenerFechaAsociado();
        if ($fechaAsociado != null) {
            $fechaAsociado = date_format($act->obtenerFechaAsociado(), 'd/m/Y');
            echo '<td>' . $fechaAsociado . '</td>';
        }
        echo '<td><button type="button" class="btn btn-danger" onclick="eliminarRepuesto(\'' . $act->obtenerDescripcion() . '\')">
      <span class="glyphicon glyphicon-remove"></span>
    </button></td>';
        echo '</tr>';
    }
}

function cuerpoTablaContratos($contratos) {
    foreach ($contratos as $act) {
        $descripcion = explode("/", $act);
        echo '<tr >';
        echo '<td><a href="' . $act . '" target="_blank"><span class="glyphicon glyphicon-file"/>' . $descripcion[3] . '</a></td>';
        echo '</tr>';
    }
}

function panelActivos($listaActivos, $estadosSiguentes, $responsables) {
    echo
    '<div type = "hidden" class="informacion-dispositivos panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de activos</h3></div>'
    . '     <div class="panel-body container-fluid">'
    . '        <div class="col-md-12">'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Placa: </span><span  id="placa" class=" col-md-8">' . $listaActivos->obtenerPlaca() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Categoría: </span><span class=" col-md-8">' . $listaActivos->obtenerCategoria()->obtenerNombreCategoria() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Estado: </span><span class=" col-md-8">';
    echo estadosSiguientes($listaActivos->obtenerEstado(), $estadosSiguentes, $listaActivos->obtenerPlaca());
    echo '</span> </div> '
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
    . '         <div class="row">';
    if ($responsables == null) {
        echo '           <div><span class="col-md-4 titulo-inventario">Usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerNombreUsuarioAsociado() . ' </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Correo usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerCorreoUsuarioAsociado() . ' </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Departamento usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerDepartamentoUsuarioAsociado() . ' </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Jefatura Usuario asociado: </span><span class=" col-md-8">' . $listaActivos->obtenerJefaturaUsuarioAsociado() . ' </span></div> ';
    } else {
        echo '           <div><span class="col-md-4 titulo-inventario">Usuario asociado: </span><span class=" col-md-8">';
        echo selectUsuariosActivos($responsables);
        echo ' </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Correo usuario asociado: </span><span class=" col-md-8"> Sin asignar  </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Departamento usuario asociado: </span><span class=" col-md-8">Sin asignar </span></div> '
        . '         </div>'
        . '         <div class="row">'
        . '           <div><span class="col-md-4 titulo-inventario">Jefatura Usuario asociado: </span><span class=" col-md-8"> Sin asignar</span></div> ';
    }
    echo '         </div>'
    . '         <div class="row">'
    . '           <span ><button  onclick = "obtenerRepuestos(' . $listaActivos->obtenerPlaca() . ');" data-target="#modalRepuestos" data-toggle="modal" class="btn btn-warning btn-circle " ><i class="glyphicon glyphicon-list"></i> Repuestos</button></span> '
    . '           <span ><button onclick = "obtenerLicencias(' . $listaActivos->obtenerPlaca() . ');" data-toggle="modal" class="btn btn-primary btn-circle " ><i class="glyphicon glyphicon-list"></i> Licencias</button></span> '
    . '           <span ><button onclick = "obtenerContratos(' . $listaActivos->obtenerPlaca() . ');" data-toggle="modal" class="btn btn-info btn-circle " ><i class="glyphicon glyphicon-list"></i> Contratos</button></span> ';
    if ($responsables == null) {
        echo '           <span ><button onclick = "eliminarUsuario();" data-toggle="modal" class="btn btn-danger btn-circle  " ><i class="glyphicon glyphicon-remove"></i> Desasociar</button></span> ';
    }
    echo '         </div>'
    . '         </div>'
    . '     </div>'
    . ' </div>'
    . '</div>';
}

function estadosSiguientes($estadoActual, $estadosSiguentes, $placa) {
    echo '<select class="form-control" onfocus="estadoAnterior();" onchange="cambiarEstado(\'' . $placa . '\')" id="estadosSiguentes">';
    echo '<option value="' . $estadoActual->obtenerCodigoEstado() . '" selected>' . $estadoActual->obtenerNombreEstado() . '  </option>';
    foreach ($estadosSiguentes as $estado) {
        echo '<option value="' . $estado->obtenerCodigoEstado() . '" >' . $estado->obtenerNombreEstado() . '</option>';
    }
    echo '</select>';
}

function selectUsuariosActivos($responsables) {
    echo '<select class="selectpicker form-control" data-size="5" data-live-search="true"  onchange="asignarActivo();" id="Usuarios">';
    echo '<option data-tokens="Sin asignar" value="-1" selected >Sin asigna </option>';
    foreach ($responsables as $responsable) {
        echo '<option data-tokens="' . $responsable->obtenerNombreUsuario() . '" value="' . $responsable->obtenerCorreo() . '" >' . $responsable->obtenerNombreUsuario() . '</option>';
    }
    echo '</select>';
}

function panelPasivos($listaPasivos) {
    echo
    '<div type = "hidden" class=" informacion-dispositivos panel panel-default">'
    . ' <div class="panel-heading"><h3>Especificaciones de inventario</h3></div>'
    . '     <div class="panel-body container-fluid ">'
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
    . '           <div><span class="col-md-4 titulo-inventario">Bodega: </span><span class=" col-md-8">' . $listaPasivos->obtenerBodega()->obtenerNombreBodega() . ' </span></div> '
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

function panelAgregarInventario($categorias, $bodegas) {
    echo '<div type = "hidden" class="panel panel-default">'
    . ' <div class="panel-heading"><h3>Agregar a inventario</h3></div>'
    . '     <div class="panel-body">';
    echo'<div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="codigo">Código:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(1)" class="form-control" id="codigo" type="text" required>
            </div>
        </div>        
        <div class="form-group  col-md-12 ">
            <label class="control-label col-md-3" for="tipo">Categoría:</label>
            <div class="col-md-9">';
    selectTipos($categorias);
    echo'</div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="descripcion">Descripción:</label>
            <div class="col-md-9">
                <input onfocus = "foco(2)" class="form-control" id="descripcion" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="estado">Estado:</label>
            <div class="col-md-9">
                <input onfocus = "foco(3)" class="form-control" id="estado" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="cantidad">Cantidad:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(4)" class="form-control" id="cantidad" min="1" type="number" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="costo">Costo unitario:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(5)" class="form-control" id="costo" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="provedor">Proveedor:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(10)" class="form-control" id="provedor" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="marca">Marca:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(9)" class="form-control" id="marca" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="orden">orden de compra:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(8)" class="form-control" id="orden" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="tiquete">codigo tiquete:</label>
            <div class="col-md-9">
              <div class="input-group date">
              <input type="text" class="form-control col-md-5"  id="tiquete"   >
                 <span class="input-group-addon  btn-info" id="tiquete" onclick="tiquete()" >
                                    <span class="glyphicon glyphicon-th-list"></span>
                </span
                </div>
            </div>
        </div>
        </div>          
        <div class="form-group  col-md-12 ">
            <label class="control-label col-md-3" for="bodega">Bodega:</label>
            <div class="col-md-9">';
    selectBodegas($bodegas);
    echo'</div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="comentario">Comentario:</label>
            <div class="col-md-9">
                <textarea onfocus = "foco(7)" class="form-control" id="comentario" required></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button onclick = "agregarInventario();" class="btn btn-success btn-circle " ><i></i>Guardar</button>     
                <button onclick = "limpiarFormularioInventario();" class="btn btn-danger btn-circle " ><i></i>Borrar</button> 
                  <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalagregarAdjunto" >Adjuntar orden de compra</button> 
            </div>
        </div>';
    echo'</div>'
    . ' </div>'
    . '</div>';
}

function selectTipos($categorias) {
    echo'<select id = "categoria" class="form-control">';
    foreach ($categorias as $cat) {
        echo'<option value = "' . $cat->obtenerCodigoCategoria() . '">' . $cat->obtenerNombreCategoria() . '</option>';
    }
    echo'</select>';
}

function selectRepuestos($repuestos) {
    echo'<select id = "repuestosSelect" class="form-control">';
    foreach ($repuestos as $cat) {
        echo'<option value = "' . $cat->obtenerCodigoArticulo() . '">' . $cat->obtenerDescripcion() . '</option>';
        // echo '<input type = "hidden" id = bodega"'.$cat->obtenerCodigoArticulo().'" value = "'.$cat->obtenerBodega().'">';
    }
    echo'</select>';
}

function selectBodegas($bodegas) {
    echo'<select id = "bodega" class="form-control">';
    foreach ($bodegas as $cat) {
        echo'<option value = "' . $cat->obtenerCodigoBodega() . '">' . $cat->obtenerNombreBodega() . '</option>';
        // echo '<input type = "hidden" id = bodega"'.$cat->obtenerCodigoArticulo().'" value = "'.$cat->obtenerBodega().'">';
    }
    echo'</select>';
}

function panelSumarAInventario($inventario, $codigo) {
    //  $inventario = buscarDispositivoInventario($inventarios, $codigo);
    echo'<div type = "hidden" class="panel panel-default">'
    . '<div class="panel-heading"><h3>Sumar a inventario</h3></div>'
    . '<div class="panel-body">';
    echo'<div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="codigoSuma">Código:</label>
            <div class="col-md-9">
                  <span id="codigoSuma">' . $inventario->obtenerCodigoArticulo() . '</span>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <label class="control-label col-md-3" for="descripcion-suma">Descrición:</label>
            <div class="col-md-9">
                  <span id="descripcion-suma">' . $inventario->obtenerDescripcion() . '</span>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="cantidad-suma">Cantidad:</label>
            <div class="col-md-9">
                <input onfocus = "focoSuma(1)" class="form-control" id="cantidad-suma" min="1" type="number" required>
            </div>
        </div>        
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="comentario-suma">Comentario:</label>
            <div class="col-md-9">
                <textarea onfocus = "focoSuma(3)" class="form-control" id="comentario-suma" required></textarea>
            </div>
        </div>        
        <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button onclick = "agregarInventarioSuma();" class="btn btn-success btn-circle btn" ><i></i>Guardar</button>     
                <button onclick = "limpiarFormularioInventarioSuma();" class="btn btn-danger btn-circle btn" ><i></i>Borrar</button>                         
            </div>
        </div>';
    echo '</div>'
    . ' </div>'
    . '</div>';
}

function panelAgregarRepuesto($dispositivo, $repuestos, $codigo) {

    echo'<div type = "hidden" class="panel panel-default">'
    . '<div class="panel-heading"><h3>Asociar repuesto</h3></div>'
    . '<div class="panel-body">
                <div class="form-group col-md-12">
            <label class="control-label col-md-12">Categoría del dispositivo: ' . $dispositivo->obtenerCategoria()->obtenerNombreCategoria() . '</label>
        </div>  
        <div class="form-group col-md-12">
            <label class="control-label col-md-12">Código del dispositivo: ' . $dispositivo->obtenerPlaca() . '</label>
        </div>   
    <div class="form-group  col-md-12">
            <label class="control-label col-md-12" >Información del repuesto </label>
        </div>';
    echo'<div class="form-group  col-md-12 ">
            <label class="control-label col-md-3" for="tipo">Repuesto a asociar:</label>
            <div class="col-md-9">';
    selectRepuestos($repuestos);
    echo'</div>
            <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button onclick = "asociarRepuestos(' . $dispositivo->obtenerPlaca() . ');" class="btn btn-success btn-circle btn" ><i></i>Asociar</button>     
           </div>
        </div>
    </div>    
  </div>';
}

function panelAgregarLicencia($dispositivo, $codigo) {

    echo'<div type = "hidden" class="panel panel-default">'
    . '<div class="panel-heading"><h3>Asociar licencia</h3></div>'
    . '<div class="panel-body">';
    echo'<div class="form-group  col-md-12">
            <label class="control-label col-md-5" for="categoriaRepuesto">Equipo asociado: </label>
            <div class="col-md-7">
                  <span id="categoriaRepuesto">' . $dispositivo->obtenerCategoria()->obtenerNombreCategoria() . '</span>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <label class="control-label col-md-5" for="codigoRepuesto">Código del Equipo : </label>
            <div class="col-md-7">
                  <span id="codigoRepuesto">' . $dispositivo->obtenerPlaca() . '</span>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <label class="control-label col-md-12" >Información de la licencia </label>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="descripcion-licencia">Descripción:</label>
            <div class="col-md-9">
                <input  onfocus = "focoAsociarLicencia(1);" class="form-control" id="descripcion-licencia" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="clave-producto-licencia">Clave de producto:</label>
            <div class="col-md-9">
                <input  onfocus = "focoAsociarLicencia(2);"  class="form-control" id="clave-producto-licencia" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="proveedor-licencia">Proveedor:</label>
            <div class="col-md-9">
                <input onfocus = "focoAsociarLicencia(3);"  class="form-control" id="proveedor-licencia" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label onfocus = "focoAsociarLicencia(4);"  class="control-label col-md-3" for="vencimiento-licencia">Fecha de vencimiento:</label>
            <div class="col-md-9">               
                <div class="input-group date" id="datetimepicker1">';
    $hoy = getdate();
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10)
        $mes = "0" . $mes;
    $dia = $hoy["mday"];
    if ($dia < 10)
        $dia = "0" . $dia;
    $fecha = $dia . "/" . $mes . "/" . $anio;
    echo '<input type="text" class="form-control col-md-5" id="vencimiento-licencia" value="' . $fecha . '">
                    <span class="input-group-addon  btn-info" onclick="document.getElementById(\'vencimiento-licencia\').focus()">
                        <span class="glyphicon glyphicon-calendar"></span>                            
                    </span>                              
                </div>
            </div>
        </div>  
        <div class="form-group col-md-12">           
            <div class="col-md-12">
                <button onclick = "agregarLicenciaEquipo(' . $codigo . ');" class="btn btn-success btn-circle btn" ><i></i>Guardar</button>     
                <button onclick = "limpiarFormularioLicencia();" class="btn btn-danger btn-circle btn" ><i></i>Borrar</button>                         
            </div>
        </div>
    </div>'
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
        if ($act->obtenerPlaca() == $codigo) {
            return $act;
        }
    }
    return null;
}

function selectEstado($estados) {
    echo '<select class="form-control" id="estadosA">';
    foreach ($estados as $estados) {
        echo '<option  value="' . $estados->obtenerCodigoEstado() . '" >' . $estados->obtenerNombreEstado() . '</option>';
    }
    echo '</select>';
}

function comboEstados($estados) {
    foreach ($estados as $estado) {
        echo'<label class="checkbox-inline"><input type="checkbox" id="estado-' . $estado->obtenerCodigoEstado() . '" value="' . $estado->obtenerCodigoEstado() . '">' . $estado->obtenerNombreEstado() . '</label>';
    }
}

function cuerpoTablaMistiquetesInventario($Tiquetes, $codigoPestana) {
    $cont = 1;
    foreach ($Tiquetes as $tique) {
        echo '<tr onclick="elegirTiquete(\''.$tique->obtenerCodigoTiquete().'\')" data-toggle="tooltip" title="' . substr($tique->obtenerDescripcion(), 0, 70) . '..." data-placement="top"  style = "text-align:center";>';
//        if($codigoPestana == 2) {
//            echo '<td value ="' . $tique->obtenerCodigoTiquete() . '">'
//            . '<input type = "checkbox" id = "check' . $tique->obtenerCodigoTiquete() . '"></td>';
//        }
        echo '<td>' . $tique->obtenerCodigoTiquete() . '</td>';
        echo '<td>' . $tique->obtenerTematica()->obtenerDescripcionTematica() . '</td>';
        echo '<td>' . $tique->obtenerNombreUsuarioIngresaTiquete() . '</td>';
        if ($tique->obtenerResponsable() == null) {
            echo '<td>Por asignar</td>';
        } else {
            echo '<td>' . $tique->obtenerResponsable()->obtenerNombreResponsable() . '</td>';
        }
        echo '<td>' . $tique->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $tique->obtenerPrioridad()->obtenerNombrePrioridad() . '</td>';

        $fechaE = date_format($tique->obtenerFechaEntrega(), 'd/m/Y');
        if ($fechaE != "") {
            echo '<td style= "text-align:center;">' . $fechaE . '</td>';
        } else {
            echo '<td style= "text-align:center; " >Fecha no asignada</td>';
        }

        calificacion( $tique, $cont++);
       
        echo '</tr>';
    }
}

function calificacion($tiquete, $cont) {
    $califiacion = $tiquete->obtenerCalificacion();    
    if ($califiacion != null) {
        echo '<td class = "rating">';
        if ($califiacion == 5) {
            echo '<input type="radio" value="5" checked Disabled /><label  title="Excelente">5 stars</label>';
        } else {
            echo '<input type="radio"  value="5"  Disabled /><label  title="Excelente">5 stars</label>';
        }
        if ($califiacion == 4) {
            echo '<input type="radio"  value="4" checked Disabled/><label  title="Muy Bueno">4 stars</label>';
        } else {
            echo '<input type="radio"  value="4" Disabled/><label  title="Muy Bueno">4 stars</label>';
        }
        if ($califiacion == 3) {
            echo '<input type="radio"  value="3" checked Disabled/><label " title="Bueno">3 stars</label>';
        } else {
            echo '<input type="radio"  value="3" Disabled/><label  title="Bueno">3 stars</label>';
        }
        if ($califiacion == 2) {
            echo '<input type="radio"  value="2" checked Disabled/><label  title="Regular">2 stars</label>';
        } else {
            echo '<input type="radio"  value="2" Disabled/><label  title="Regular">2 stars</label>';
        }
        if ($califiacion == 1) {
            echo '<input type="radio"  value="1" checked Disabled/><label title="Deficiente">1 star</label>';
        } else {
            echo '<input type="radio"  value="1" Disabled/><label title="Deficiente">1 star</label>';
        }

        echo '</td>';
    } else {
        echo '<td class = "rating2">' .
        '<input type="radio"  value="5"/><label  title="Excelente">5 stars</label>' .
        '<input type="radio"  value="4" /><label  title="Muy Bueno">4 stars</label>' .
        '<input type="radio"  value="3"  /><label  title="Bueno">3 stars</label>' .
        '<input type="radio"  value="2" /><label  title="Regular">2 stars</label>' .
        '<input type="radio" value="1" /><label  title="Deficiente">1 star</label>' .
        '</td>';
    }
}
