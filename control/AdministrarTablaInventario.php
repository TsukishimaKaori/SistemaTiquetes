<?php
require('../recursos/pdf/fpdf.php');
function cabeceraTablaPasivos() {
    echo "<th>Código</th>"
    . "<th>Descripción</th>"
    . "<th>Categoría</th>"
    . "<th>Tipo</th>"
    . "<th>Bodega</th>"
    . "<th>Salida</th>"
    . "<th>Cantidad</th>"
    . "<th>Entrada</th>"
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
    . '           <div><span class="col-md-4 titulo-inventario">Categoría: </span><span id="categoria" class="col-md-8">' . $listaActivos->obtenerCategoria()->obtenerNombreCategoria() . ' </span></div> '
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
    . '           <div><span class="col-md-4 titulo-inventario">Modelo: </span><span id="modelo" class=" col-md-8">' . $listaActivos->obtenerModelo() . ' </span></div> '
    . '         </div>'
    . '         <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Marca: </span><span id="marca" class=" col-md-8">' . $listaActivos->obtenerMarca() . ' </span></div> '
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
    . '           <div><span class="col-md-4 titulo-inventario">Costo unitario: </span><span class=" col-md-8">' . $listaPasivos->obtenerCosto() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Proveedor: </span><span class=" col-md-8">' . $listaPasivos->obtenerProveedor() . ' </span></div> '
    . '         </div>'
    . '        <div class="row">'
    . '           <div><span class="col-md-4 titulo-inventario">Marca: </span><span class=" col-md-8">' . $listaPasivos->obtenerMarca() . ' </span></div> '
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
            <label class="control-label col-md-3" for="orden">Orden de compra:</label>
            <div class="col-md-9">
                <input  onfocus = "foco(8)" class="form-control" id="orden" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="tiquete">Código tiquete:</label>
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
    echo'<select id = "categoria" class="selectpicker form-control" data-size="5" data-live-search="true">';
    foreach ($categorias as $cat) {
        echo'<option data-tokens="' . $cat->obtenerNombreCategoria() . '" value = "' . $cat->obtenerCodigoCategoria() . '">' . $cat->obtenerNombreCategoria() . '</option>';
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
            <label class="control-label col-md-3" for="descripcion-suma">Descripción:</label>
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
            <label class="control-label col-md-3" for="ordenS">Orden de compra:</label>
            <div class="col-md-9">
                <input  onfocus = "focoSuma(4)" class="form-control" id="ordenS" type="text" required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-3" for="tiquete">Código tiquete:</label>
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
                <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalagregarAdjunto" >Adjuntar orden de compra</button> 
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
        echo '<tr onclick="elegirTiquete(\'' . $tique->obtenerCodigoTiquete() . '\')" data-toggle="tooltip" title="' . substr($tique->obtenerDescripcion(), 0, 70) . '..." data-placement="top"  style = "text-align:center";>';
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

        calificacion($tique, $cont++);

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
// <editor-fold defaultstate="collapsed" desc="Contrato">
// <editor-fold defaultstate="collapsed" desc="MetodosHtml para el contrato">
class PDF_HTML extends FPDF
{
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}
// </editor-fold>
function generarPdf($placa,$nombreUsuarioCausante,$nombreUsuarioAsociado,$categoria,$marca,$modelo,$docking,$asociados,$gafete,$Cedula) {    
$pdf = new PDF_HTML();
// pagina 1
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$html =utf8_decode(' ');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(70, 10);
$pdf->Ln();
$html =utf8_decode('<b><u>PRÉSTAMO DE EQUIPO</u></b>');
$pdf->WriteHTML($html);
$pdf->Ln();
 $pdf->SetMargins(60, 10);
$pdf->Ln();
$html =utf8_decode('<b><u>BRITT SHARED SERVICES Y EL COLABORADOR</u></b>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$html =utf8_decode('<p align="justify">Nosotros,<b> BRITT SHARED SERVICES S.A.</b>, domiciliada en Barreal de Heredia, frente a Cenada, Eurocenter,'
                    .'  representada en este acto por <b>'.$nombreUsuarioCausante.'</b>, costarricense, mayor, administrador de '
                    .'  empresas,  portador de la cédula de identidad: <b>'.$Cedula.'</b>, en su condición de Secretario con facultades'
                    .'  de Represente Legal de la plaza Britt Shared Services Sociedad Anónima, inscrita al tomo: quinientos setenta y '
                    .'  uno, asiento: treinta y seis mil setecientos sesenta y los señores(a): <b>'.$nombreUsuarioAsociado.'</b>, portador de '
                    .'  numero de gafete en Britt: <b>'.$gafete.'</b> hemos acordado en suscribir el presente acuerdo de préstamo de Equipo'
                    .'  Portátil que se regirá por las siguientes cláusulas:'
                    .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$$Cuentacon="";
if($asociados!=""){
    $Cuentacon=    '</b>, equipo que cuenta con <b>'.$asociados.'</b>  mismo que se '
                   .'entrega en calidad de préstamo al señor(a) <b>'.$nombreUsuarioAsociado.'</b>, para que la utilice como su equipo de '
                   .'trabajo en la Compañía';
}
$html =utf8_decode('<p align="justify">'
                   .'<b><u>PRIMERA</u></b>: Britt Shared Services Sociedad Anónima es propietaria de <b>'.$categoria.'</b>   Marca:<b>'.$marca.'</b>, Modelo: <b>'.$modelo.'</b>, '
                   .'service tag laptop: <b>'.$placa.'</b>, serie del docking: <b>'.$docking.$Cuentacon
                   .'.</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                   .'Equipo que podrá utilizar bajo su absoluta discrecionalidad y sobre el cual se compromete a lo siguiente:'                   
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                    .'a)    El Equipo contará con el software instalado al inicio o con modificaciones única y exclusivamente '
                    . '     solicitadas al departamento de soporte de la compañía. Cualquier software distinto que se encuentre en el '
                    . '     equipo en cualquier auditoria al azar y que no cumpla con lo aquí establecido, se desinstalará de inmediato '
                    . '     sin previo aviso.'                   
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                    .'b)    El Equipo se entrega al señor(a): <b>'.$nombreUsuarioAsociado.'</b>, para uso laboral solamente, si se utiliza '
                    . 'para fines distintos a éste su único fin, como por ejemplo bajar, grabar o quemar información no apta '
                    . '(llámese pornografía, música, videos) o cualquier elemento que no tiene que ver en nada con la función o '
                    . 'actividad del señor(a) <b>'.$nombreUsuarioAsociado.'</b>, en Britt Shared Services Sociedad Anónima se retirará, '
                    . 'borrará y comunicará al jefe inmediato sobre la situación acontecida.'                 
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'c)    Se compromete el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, a no almacenar música, fotos, videos u otros'
                    . ' que atenten con el espacio disponible y que atente con el buen funcionamiento del equipo.'              
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SEGUNDA</u></b>: El Equipo se encontrará identificado mediante etiqueta con número de activo <b>'.$placa.'</b> durante todo el'
                     . ' plazo que se dé él contrato de préstamo. Las mismas deben permanecer en el equipo siempre; si por cualquier'
                     . ' motivo estas etiquetas se remueven o retiran del equipo dará como resultado a la terminación anticipada de este '
                     . 'contrato, debiendo el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, devolver a Britt Shared Services Sociedad Anónima '
                     . 'el equipo en forma inmediata.'          
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>TERCERA</u></b>: El plazo de este acuerdo será por todo el lapso que dure la relación contractual a partir del día de su'
                    . ' firmeza. Si en cualquier momento el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, deja de laborar para Britt Shared '
                    . 'Services Sociedad Anónima, por cualquier motivo, ya sea por despido o por renuncia, deberá de devolver el '
                    . 'equipo con sus respectivas licencias a Britt Shared Services Sociedad Anónima. Licencias adicionales, '
                    . 'adquiridas y otorgadas en virtud a su cargo dentro de la Compañía, por lo que en su defecto debe cancelar el valor'
                    . ' de éstas al momento de su salida.  '       
                   .'</p>');
$pdf->WriteHTML($html);
// pagina 2
$pdf->AddPage();
$html =utf8_decode(' ');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>CUARTA</u></b>: El señor(a): <b>'.$nombreUsuarioAsociado.'</b>, deberá cuidar este equipo como un buen padre de familia,'
                    . ' corriendo por su cuenta y riesgo cualquier daño que sufra la computadora por caso fortuito o fuerza mayor. Ambas '
                    . 'partes acuerdan que para que se aplique las circunstancias de eximentes el colaborador de la Compañía deberá '
                    . 'seguir el siguiente protocolo: '      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'En <b>caso de Robo o Pérdida</b> del Equipo, debe aportar:'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'1.    Fotocopia de la denuncia presentada ante el Organismo de Investigación Judicial (OIJ) u otra autoridad '
                    . 'judicial competente, donde se indique claramente como mínimo: fecha de siniestro, descripción exacta del '
                    . 'equipo robado y forma en que ocurrió el evento (en un plazo no mayor de 15 días hábiles), dar aviso'
                    . 'inmediato del suceso al Gerente de Seguridad para que el mismo este enterado de la gestión.'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'2.    Fotocopia del Acta de Inspección Ocular realizada por el Organismo de Investigación Judicial (OIJ) u otra '
                    . 'autoridad judicial competente.'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'Correrá por cuenta de la Compañía una vez verificado los puntos anteriores proceder a la reposición en caso de '
                    . 'robo o pérdida material o parcial del equipo objeto de préstamo. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>QUINTA:</u></b> Ninguna de las partes será responsable por incumplimiento o ejecución parcial del presente contrato en el '
                    . 'tanto en que ello se derive de caso fortuito o fuerza mayor, quedando excluidos de esta exoneración de '
                    . 'responsabilidad aquellos casos en los que no se haya guardado el deber de diligencia y el uso debido de la '
                    . 'máquina. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SEXTA:</u></b> Las partes aceptan que la ilegalidad, ineficacia, invalidez o nulidad de una o varias de las estipulaciones '
                    . 'del presente documento, declarada por autoridad judicial competente, no afectará la validez, legalidad o eficacia de '
                    . 'las disposiciones restantes.  '       
                               .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SETIMA:</u></b> El presente contrato refleja la voluntad de cada una de las partes, libremente expresada bajo los '
                    . 'principios de buena fe y responsabilidad en los negocios. Manifiestan las partes entender y aceptar como ciertas y '
                    . 'verdaderas todas las informaciones y datos incluidos en el presente contrato.   '       
                               .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>OCTAVA :</u></b> Para efectos de este contrato el señor(a):<b>'.$nombreUsuarioAsociado.'</b>, oirá notificaciones en la dirección '
                    . 'indicada al inicio de este documento y Britt Shared Services, oirá notificaciones en sus oficinas en Barreal de '
                    . 'Heredia, frente a Cenada, Eurocenter. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
 $fecha = FechaNombre(1); 
 $hora= FechaNombre(3); 
$html =utf8_decode('<p align="justify">'
                    .'Estando ambas partes de acuerdo se firma en Heredia, a las <b>'.$hora.'</b> horas del '
                    . '<b><u>'.$fecha.'</u></b>.'       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'____________________________                                                     __________________________'       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
      .'   '.$nombreUsuarioCausante.'	                                                                                 '. $nombreUsuarioAsociado      
                   .'</p>');
$pdf->WriteHTML($html);
    $fecha = FechaNombre(2);
    $nombre=$placa."-".$fecha.".pdf";
    $url = "../adjuntos/contratos/".$nombre;
    $pdf->Output("F", $url);
    return $url;
}

function FechaNombre($tipo){

     $hoy = getdate();    
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10)
        $mes = "0" . $mes;
    $dia = $hoy["mday"];
    $hora=$hoy["hours"];
    $minutos=$hoy["minutes"];
    $segundos=$hoy["seconds"];
    if ($dia < 10)
        $dia = "0" . $dia;
    if($tipo==2){
    $fecha = $dia . "-" . $mes . "-" . $anio;
    }else if($tipo==1){
        switch ($mes) {
            case 01:
                $mes="Enero";
                break;
             case 02:
                 $mes="Febrero";
                break;
            case 03:
                $mes="Marzo";
                break;
             case 04:
                 $mes="Abrir";
                break;
            case 05:
                $mes="Mayo";
                break;
             case 06:
                 $mes="Junio";
                break;
            case 07:
                $mes="Julio";
                break;
             case 08:
                 $mes="Agosto";
                break;
            case 09:
                $mes="Setiembre";
                break;
             case 10:
                 $mes="Octubre";
                break;
            case 11:
                $mes="Noviembre";
                break;
             case 12:
                 $mes="Diciembre";
                break;
            default:
                break;
        }
        $fecha = $dia . " de " . $mes . " del " . $anio;
    }else{
        $fecha=$hora.":".$minutos.":".$segundos;
    }
    return $fecha;
}

// </editor-fold>