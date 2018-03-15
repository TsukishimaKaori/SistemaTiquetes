<!DOCTYPE html>
<html> 
    <head>         
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>   
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require_once ("../control/AdministrarTablasAreasTematicas.php"); ?>
        <?php require_once ("../control/SolicitudAjaxAreasTematicas.php"); ?> 
        <?php require ("../control/AlertasConfirmaciones.php"); ?>
        <?php
        $areas = obtenerAreas();

        //$todasAreas = obtenerAreas();
        $tematicasNivel1 = obtenerTematicasPadreCompletas();
        $tematicasCompletasActivas = obtenerTematicasCompletasActivas();
        ?> 
        <script  type="text/javascript" src="../recursos/js/AdministrarAreasTematicas.js"></script>
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?> 
        <?php
        require_once ("../modelo/ProcedimientosPermisos.php");
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 3)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
                <form action = "AdministracionAreasTematicas.php" method ="POST">
                    <section class ="container-fluid">
                        <div class="row">                  
                            <div class="col-md-offset-3 col-md-1">
                                <h4>Áreas</h4> 
                            </div>
                            <div class="col-md-2 " >
                                <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarArea"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-circle btn-xl" data-toggle="modal" data-target="#modalEliminarArea"><i class="glyphicon glyphicon-minus"></i></button>
                                <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalAreaActiva" ><i class=" glyphicon glyphicon-pencil"></i></button>
                            </div>
                            <div class="col-md-1 col-md-offset-1">   
                                <h4>Clasificación</h4>
                            </div>
                            <div class="col-md-1 ">  
                                <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarTematica"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                        </div>
                        <div><br></div>
                        <div class = "row">
                            <div class="funkyradio-success col-md-1 funkyradio col-md-offset-7">
                                <input type="radio" name = 'radio' id="radio1" value="radio1" onchange="clickeado(this)"  />
                                <label for="radio1">Activos</label>
                            </div>
                            <div class="funkyradio-success funkyradio col-md-1">
                                <input type="radio" name = 'radio' value="radio2" id="radio2" value="todos" onchange="clickeado(this)" checked />
                                <label for="radio2">Todos</label>
                            </div>
                        </div>
                    </section>
                    <section class ="container-fluid">
                        <div class="row"> 
                            <div class="col-md-6 col-md-offset-3">
                                <div  class="table table-hover table-responsive ">                   
                                    <table class = " tablasInfo table table-hover">                
                                        <thead>
                                            <tr>
                                                <th>Clasificación</th>
                                                <th>Área</th>
                                                <th>Activo</th>
                                                <th>Editar clasificación</th>
                                            </tr>
                                        </thead>
                                        <tbody  id = "cuerpoTablaTematicasNivel1"> 
                                            <?php
                                            cuerpoTablaTematicasNivel1($tematicasNivel1, $areas);
                                            ?> 
                                        </tbody>
                                    </table>                             
                                    <input id ="inputHiddenTematicas" type="hidden" name="inputHiddenTematicas" value="inputHiddenTematicas"/>
                                </div>
                            </div>                    
                        </div>
                    </section>
                </form> 

                <!-----------Inicio de las ventanas modales---------------------------->
                <!---------------------Ventana agregar área---------------------------->
                <div id="modalAgregarArea" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header ">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nueva Área </h4>
                            </div>                   
                            <form name ="modalAgregarArea" action = "../vista/AdministrarAreasTematicas.php" method ="POST">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nombre del área</label>
                                        <input id = 'inputAgregarArea' type = "text" name = "agregarArea" class="form-control" placeholder="Área" required></input>
                                    </div>                             
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hiddenAgregarArea" value="hiddenAgregarArea">
                                    <button type="button" class="btn btn-success" onclick="validacionAgregarArea(this)"> Guardar</button>
                                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!---------------------- Ventana eliminar área ------------------------>
                <div id="modalEliminarArea" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header ">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminar área </h4>
                            </div>                          
                                <div class="modal-body">
                                    <div class="form-group">                                                     
                                        <?php comboAreas($areas, 'comboAreas'); ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hiddenEliminarArea" value="hiddenEliminarArea">
                                    <button type="button" class="btn btn-success" onclick="enviarCambiosAreas(this)">Eliminar</button>
                                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                                </div>
                    
                        </div>                 
                    </div>
                </div>
                <!---------------------------Modificar área -------------------------->
                <div id="modalModificarArea" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modifcar Área </h4>
                            </div>                                 
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nuevo nombre del área</label>
                                    <input id = 'inputModificarArea' type = "text" name = "agregarArea" class="form-control" placeholder="Área" required></input>
                                </div>                             
                            </div>
                            <div class="modal-footer">                            
                                <button type="button" class="btn btn-success" onclick="modificarArea(this)"> Guardar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div> 

                <!--------------- Ventana areas activas o inactivas ------------------->
                <div id="modalAreaActiva" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header ">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modificar áreas</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class = " table table-responsive">
                                        <table class = "table table-hover">
                                            <thead>
                                            <th>Área</th>
                                            <th>Activo</th>
                                            <th>Editar área</th>
                                            </thead>
                                            <tbody>
                                                <?php tablaAreasActivas($areas); ?>
                                            </tbody>                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal"  > Aceptar</button>                            
                            </div>       
                        </div>                 
                    </div>
                </div>

                <!--------------------Ventana agregar temática------------------------->
                <div id="modalAgregarTematica" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nueva clasificación </h4>
                            </div>                   
                            <form name ="modalAgregarTematica" action = "../vista/AdministrarAreasTematicas.php" method ="POST">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Área de la nueva clasificación</label>
                                        <?php comboAreas($areas, 'comboAreasAgregarTematicas'); ?>
                                    </div> 
                                    <div class="form-group">
                                        <label>Nombre de la clasificación</label>
                                        <input id = 'inputAgregarTematica' type = "text" name = "agregarTematica" class="form-control" placeholder="Clasificación" required></input>
                                    </div>  

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hiddenAgregarTematica" value="hiddenAgregarTematica">
                                    <button type="button" class="btn btn-success" onclick="validacionAgregarTematica(this)"> Guardar</button>
                                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  

                <!--------------Ventana modificar nombre de la temática---------------->
                <div id="modalModificarTematica" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modifcar clasificación </h4>
                            </div>     
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nuevo nombre de la clasificación</label>
                                    <input id = 'inputModificarTematica' type = "text" class="form-control" required></input>
                                </div>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="modificarTematica(this)"> Guardar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php
            }
        }
        ?>
        <?php
        $redireccion = "location.href = '../vista/AdministrarAreasTematicas.php'";
        alerta("errorGeneral", "Se ha producido un error", "");
        alerta("alertaNombreClasificacionNoValido", "La clasificación ingresada no es válida", ""); //usada
        alerta("alertaNombreClasificacionExistente", "La clasificación ingresada ya existe", ""); //usada
        alerta("alertaClasificacionAgregada", "La clasificación ha sido agregada correctamente", $redireccion); //usada
        alerta("alertaNombreAreaNoValido", "El área ingresada no es válida", ""); //usado
        alerta("alertaNombreAreaValido", "Área ingresada correctamente", $redireccion); //usado
        alerta("alertaNombreAreaExistente", "Ya existe un área con el nombre ingresado", "");
        alerta("alertaEditarActivo", "La clasificación inactiva no puede ser editada", ""); //Preguntar si lo vamos a dejar asi o no
        alerta("alertaEditarNombreClasificacion", "Ya existe una clasificación con el nombre ingresado", ""); //usada
        alerta("alertaEliminarAreaRestringido", "El área no puede ser eliminada ya que posee usuarios o tematicas asociadas", "");//usado
        alerta("alertaEliminarAreaValido", "El área ha sido eliminada", $redireccion); //usado
        confirmacion("confirmarCambioActivoTematica", "¿Desea cambiar el estado de actividad?", "cambiarActivoTematicaConfirmado(this)", ""); //usada
        confirmacion("confirmarCambioAreaTablaTematica", "¿Desea cambiar el área de la clasificación?", "cambiarAreaTematicaTablaConfirmado(this)", "cambiarAreaTematicaTablaCancelado(this)");  //usada
        confirmacion("confirmarEliminarArea", "¿Desea eliminar el área seleccionada?", "eliminarArea(this)", ""); //usada
        confirmacion("confirmarEditarAreaActiva", "¿Desea modifcar el estado de actividad del área seleccionada?", "cambiarActivoConfirmacion(this)", "");
        ?>;      
    </body>
</html>
