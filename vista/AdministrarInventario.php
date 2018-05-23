<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">

        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>            
        <link href="../recursos/css/inventario.css" rel="stylesheet"/>     
          
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <link href="../recursos/bootstrap/css/bootstrap-select.min.css" rel="stylesheet"/>
        <script src="../recursos/bootstrap/js/bootstrap-select.min.js"></script>  
<script src="../recursos/js/AdministrarInventario.js"></script>
        <?php
        require ("../control/AdministrarTablaInventario.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AlertasConfirmaciones.php");
        ?>
    </head>
    <body>
        <?php require ("../vista/Cabecera.php");
        if ($r) {
            
        ?>

        <?php
        $activos = obtenerActivosFijos();
        $inventario = obtenerInventario();
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        } else {
            $tab = 1;
        }
        if($tab==1 && !verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 10) ){       
                echo "<script>location.href='../vista/Error.php'</script>";
        }
         if($tab==2 && !verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 11) ){       
                echo "<script>location.href='../vista/Error.php'</script>";
        }
          
        
        ?>
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <input id = 'nombreUsuario' type="hidden" value ='<?php echo $r->obtenerNombreResponsable() ?>' >
        <input id = 'correoUsuario' type="hidden" value ='<?php echo $r->obtenerCorreo() ?>' >
        <input id = 'tabInventario' type="hidden" value ='<?php echo $tab ?>' >
        <!-- <div class="container-fluid">   -->
        <div class="container-fluid">  
            <div class="row">  
                <div id = "panelInformacionIzquierda">
                    <div id="filtros"class="col-md-8 ">
                        <div class="panel panel-primary">
                            <div class="panel-body filtrosVisible">
                                <div class="row">  
                                    <div class="form-group  col-md-4">
                                        <label class="control-label col-md-3" for="placaA">Placa:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="placaA" type="text">
                                        </div>
                                    </div>  
                                    <div class="form-group  col-md-4">
                                        <label class="control-label col-md-3" for="categoriaA">Categoría:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="categoriaA" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-group  col-md-4">
                                        <label class="control-label col-md-3" for="marcaA">Marca:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="marcaA" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group  col-md-4">
                                        <label class="control-label col-md-3" for="usuarioA">Usuario:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="usuarioA" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-group  col-md-4">
                                        <label class="control-label col-md-3" for="correoA">Correo:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" id="correoA" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-check col-md-4">                           
                                        <label class="control-label col-md-3" for="estadosA">Estado:</label>
                                        <div class="col-md-9">
                                            <?php
                                            $estados = obtenerEstadosEquipoParaFiltrar();
                                            selectEstado($estados);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-10">
                                        <button onclick = "filtrarActivos()" type="button" class="btn btn-success  btn-circle col-md-3" data-toggle="modal" > buscar </button> 
                                    </div>                       
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div id="tab-indice" class="tab"> 
                        <button onclick = "filtrar()" type="button"  class="tablinks" data-toggle="modal" ><i class="glyphicon glyphicon-wrench"></i>Filtrar búsqueda</button>
                        <?php
                        if(verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 11)){                      
                        echo'<button id = "link-inventario" class="tablinks" onclick="abrir_tab_inventario(this, \'tab-inventario\')" id="defaultOpen">Inventario</button>';
                        }
                        if(verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 10)){  
                        echo'<button id = "link-activos"  class="tablinks" onclick="abrir_tab_inventario(this, \'tab-activos\')" >Activos fijos</button>'; 
                        }
                       ?>
                    </div> 
                    <section id="tab-inventario" class="tabcontent">
                        <h2>Inventario</h2>
                        <div class="container-fluid">
                            <div class="row">                                                           
                                <div id ="" class="col-md-10"></div>                
                                <div class="row">                                             
                                    <div class="col-md-offset-10">                   
                                        <button onclick = "cargarPanelAgregarInventario()" type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i> Agregar</button>    
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-offset-12">&nbsp;</div>
                                </div>
                                <div class="row">                                
                                    <div class="col-md-12 ">
                                        <div class="table table-responsive">  
                                            <table class="table table-hover" id="tablaPasivos">
                                                <thead>
                                                    <?php cabeceraTablaPasivos(); ?>                                 
                                                </thead>
                                                <tbody id = "cuerpo-Tabla-Inventario">
                                                    <?php cuerpoTablaPasivos($inventario); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </section>
                    <section id="tab-activos" class="tabcontent tab-oculto">
                        <h2>Activos</h2>
                        <div class="container-fluid">
                            <div class="row"> 
                                <div class="col-md-offset-12">&nbsp;</div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover" id="tablaActivos">
                                            <thead>
                                                <?php cabeceraTablaActivos(); ?>                                 
                                            </thead>
                                            <tbody id = "cuerpo-Tabla-Activos">
                                                <?php cuerpoTablaActivos($activos); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>            
                <div  id = "panelInformacionDerecha" >                   
                    <section  id = "panelInformacionInventario"></section>
                </div>
            </div>
        </div>

        <!--Ventana Licencias asociadas-->
        <div id="modalLicencias" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id = 'tituloModalLicencias' class="modal-title"></h4>
                    </div>                  
                    <div class="modal-body">                              
                        <div  class="table table-responsive" >  
                            <table class = "table table-hover">  
                                <thead>                                   
                                <th>Descripción</th>
                                <th>Clave de producto</th>
                                <th>Proveedor</th>
                                <th>Fecha de vencimiento</th>
                                <th>Fecha asociado</th>   
                                <th>Eliminar</th> 
                                </thead>
                                <tbody id = "cuerpoTablaLicencias">                                           
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">                                                        
                        <button type="button" class="btn btn-success"   data-dismiss="modal">Aceptar</button>
                    </div>                   
                </div>
            </div>
        </div>  

        <!--Ventana Repuestos asociadas-->
        <div id="modalRepuestos" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id = "tituloModalRepuestos" class="modal-title"></h4>
                    </div>                  
                    <div class="modal-body">                              
                        <div  class="table table-responsive" >  
                            <table class = "table table-hover">  
                                <thead>                               
                                <th>Descripción</th>
                                <th>Fecha asociado</th>
                                <th>Eliminar</th>
                                </thead>
                                <tbody id = "cuerpoTablaRepuestos">                                           
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">                                                        
                        <button type="button" class="btn btn-success"   data-dismiss="modal">Aceptar</button>
                    </div>                   
                </div>
            </div>
        </div> 
        <!--Modal activos-->
        <div id="modalContratos" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id = "tituloModalContratos" class="modal-title"></h4>
                    </div>                  
                    <div class="modal-body">                              
                        <div  class="table table-responsive" >  
                            <table class = "table table-hover">  
                                <thead>                               
                                <th>Contrato</th>


                                </thead>
                                <tbody id = "cuerpoTablaContratos">                                           
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">                                                        
                        <button type="button" class="btn btn-success"   data-dismiss="modal">Aceptar</button>
                        <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalagregarAdjunto" >Adjuntar archivo</button><br><br>
                    </div>                   
                </div>
            </div>
        </div>
        <!-------------------------------------->
        <div id="cambiarEstado" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div style ="text-align: center" > 
                                <h4 id="EstadoMensaje"> </h4>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="justificacionEstado">Justificación</label>
                            <textarea class="form-control" rows="3"  cols="2" id="justificacionEstado"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="cambiarEstadoAjax();" > Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelarEstado();" > Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal adjuntar------------------>
        <div id="modalagregarAdjunto" class="modal fade" role="dialog">
            <div class="modal-dialog">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adjuntar archivo</h4>
                    </div>
                    <div class="modal-body">
                        <label for="archivo" class="btn btn-info btn-circle btn-xl" >Subir archivo</label>
                        <input id="archivo"  name="archivo" type="file" id="archivo" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation,
                               text/plain, application/pdf, image/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document
                               ,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  onchange="subirarchivoInventario(this);" />
                        <input type="text" name="archivo2"  readonly="readonly" class="form-control" id="Textarchivo" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"  data-dismiss="modal" onclick="enviarAdjunto();"> Adjuntar</button>
                            <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="cancelarAdjuntoInventario();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------->
        <div id="Filtros" class="modal fade" role="dialog">
            <div class="modal-dialog">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adjuntar archivo</h4>
                    </div>
                    <div class="modal-body">
                        <label for="archivo" class="btn btn-info btn-circle btn-xl" >Subir archivo</label>
                        <input id="archivo"  name="archivo" type="file" id="archivo" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation,
                               text/plain, application/pdf, image/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document
                               ,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  onchange="subirarchivoInventario(this);" />
                        <input type="text" name="archivo2"  readonly="readonly" class="form-control" id="Textarchivo" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"  data-dismiss="modal"> Guardar</button>
                            <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="cancelarAdjuntoInventario();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modalaTiquetes" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >                
                <div class="modal-content" id="cuerpoModalToquetes">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Filtros tiquetes</h4>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="panel panel-primary"> 
                            <div class="panel-body">  
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <h5>Código:</h5>
                                        </div>                                     
                                        <div class="col-lg-2">
                                            <input class="form-control" id="codigoFiltro" >
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h5>Correo Solicitante:</h5>
                                        </div>                                   
                                        <div class="col-lg-2">
                                            <input class="form-control" id="CorreoSFiltro" >
                                        </div>

                                        <div class="col-lg-2">
                                            <h5>Nombre Solicitante:</h5> 
                                        </div>
                                        <div class="col-lg-2">
                                            <input class="form-control" id="NombreSFiltro">
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-lg-2"> 
                                            <h5>Correo Responsable:</h5>
                                        </div>                                   
                                        <div class="col-lg-2">
                                            <input class="form-control" id="CorreoRFiltro" >
                                        </div>
                                        <div class="col-lg-2">
                                            <h5>Nombre Responsable:</h5> 
                                        </div>
                                        <div class="col-lg-2">
                                            <input class="form-control" id="NombreRFiltro">
                                        </div>

                                        <div class="col-lg-2">
                                            <h5>Fecha de inicio:</h5>
                                        </div>                                     
                                        <div class="col-lg-2  ">
                                            <div class = "form-group input-group date" id = "datetimepicker1">
                                                <?php
                                                $hoy = getdate();
                                                $anio = $hoy["year"];
                                                $mes = $hoy["mon"];
                                                if ($mes < 10)
                                                    $mes = "0" . $mes;
                                                $dia = $hoy["mday"];
                                                if ($dia < 10)
                                                    $dia = "0" . $dia;
                                                $fecha = $dia . "/" . $mes . "/" . $anio;
                                                echo'<input id = "fechafiltroI" name ="filtro-fecha" type="text" class="  form-control" value="' . $fecha . '">
                                                <span class="input-group-addon btn btn-info"  for="filtro-fecha" onclick="document.getElementById(\'fechafiltroI\').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>';
                                                ?>
                                            </div>
                                        </div> 
                                    </div> 

                                    <div class="row">                                   

                                        <div class="col-lg-2">
                                            <h5>Fecha de final:</h5>
                                        </div>                                     
                                        <div class="col-lg-2  ">
                                            <div class = "form-group input-group date" id = "datetimepicker2">
                                                <?php
                                                echo'<input id = "fechafiltroF" name ="filtro-fecha" type="text" class="form-control" value="' . $fecha . '" >
                                                <span class="input-group-addon btn btn-info"  for="filtro-fecha" onclick="document.getElementById(\'fechafiltroF\').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-1  ">
                                            <h5>Estados:</h5>
                                        </div>
                                        <div class="col-lg-7  ">
                                            <?php
                                            $estados1 = obtenerEstados();
                                            comboEstados($estados1);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">&nbsp;</div>
                                    <div class="col-lg-12 form-group input-group boton-filtrar">
                                        <button class="btn btn-success" onclick="filtrartiquetesAjax()">Filtrar búsqueda</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <table class = "table tablasTiquetes  table-hover" id="tablaTiquetesI">
                            <thead>
                                <tr>                                            
                                    <th>Cod</th> 
                                    <th class ="thDescripcion">Descripción</th>
                                    <th>Solicitante</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Fecha entrega</th>
                                    <th>Calificación</th>                                    

                                </tr>                             
                            </thead>
                            <tbody id = "tbody-tablaTiquetesI"> 

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------------ModalAsociarACtivo----------------->
        <div id="AsociarACtivo" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div style ="text-align: center"> 
                                <h4>¿Esta seguro de asociar este activo?"</h4>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="comment">Docking:</label>
                            <input class="form-control" id="dockingAsociar"></input>
                        </div>
                        <div class="form-group">
                            <label for="comment">el equipo cuenta con:</label>
                            <textarea class="form-control" rows="3"  name="justificacion" cols="2" id="asociadosAsociar"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="asignarActivoAjax()" > Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick=" cancelarasignarActivo();" > Cancelar</button>
                    </div>
                </div>
            </div>
        </div
        <!----------------------agregarAdjunto-------------------------->

        <!------------------------------------>
        <div id="modalagregarAdjunto" class="modal fade" role="dialog">
            <div class="modal-dialog">                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adjuntar archivo</h4>
                    </div>
                    <div class="modal-body">
                        <label for="archivo" class="btn btn-info btn-circle btn-xl" >Subir archivo</label>
                        <input id="archivo"  name="archivo" type="file" id="archivo" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation,
                               text/plain, application/pdf, image/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document
                               ,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  onchange="subirarchivo(this);" />
                        <input type="text" name="archivo2"  readonly="readonly" class="form-control" id="Textarchivo" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"  data-dismiss="modal"> Guardar</button>
                            <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="cancelarAdjunto();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--                        <----------------------------------->
        <?php
        notificacion();

        confirmacion("eliminarRepuesto", "¿Desea eliminar  el repuesto?", "eliminarRepuestoAjax();", "");
        confirmacion("eliminarLicencia", "¿Desea eliminar  la licencia?", "eliminarLicenciaAjax();", "");
        confirmacion("eliminarUsuario", "¿Esta seguro de desasociar este activo?", "eliminarUsuarioAjax();", "");

        alerta("ErrorRepuesto", "Error al eliminar repuesto", "");
        alerta("ErrorLicencia", "Error al eliminar licencia", "");
     
            }
        ?>
    </body>

</html>

