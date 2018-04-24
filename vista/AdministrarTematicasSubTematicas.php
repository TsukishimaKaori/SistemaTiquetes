<!DOCTYPE html>
<html> 
    <head>       
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>   
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require_once ("../control/AdministrarTablasSubTematicasTematicas.php"); ?>
        <?php require ("../control/AlertasConfirmaciones.php"); ?>
        <?php
        $tematicasNivel1 = obtenerTematicasPadreCompletas();
        $tematicasCompletasActivas = obtenerTematicasCompletasActivas();
        ?>

        <script  type="text/javascript" src="../recursos/js/AdministrarTematicasSubTematicas.js"></script>        
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?> 
        <?php
        require_once ("../modelo/ProcedimientosPermisos.php");
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 4)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
 
                <section class ="container-fluid">
                  
                    <div class="row">                  
                        <div class="col-md-offset-3 col-md-1">
                            <h4>Clasificación</h4> 
                        </div>
                        <div class="col-md-3" >
                            <?php comboTematicas($tematicasNivel1, 'comboTematicas'); //envair un id ?> 
                        </div>  
                        <div class="col-md-1 ">   
                            <h4>Tema</h4>
                        </div>
                        <div class="col-md-1  ">  
                            <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarSubTematica"><i class="glyphicon glyphicon-plus"></i></button>
                            <!--<button type="button" class="btn btn-danger btn-circle btn-xl" data-toggle="modal" data-target="#modalEliminarSubTematica"><i class="glyphicon glyphicon-minus"></i></button>-->
                        </div>
                    </div>   
                    <div><br></div>
                    <div class = "row">
                        <div class="funkyradio-success col-md-1 funkyradio col-md-offset-7">
                            <input type="radio" name = 'radio' id="radio1" value="radio1" onchange="clickeado(this)"  />
                            <label for="radio1">Activos</label>
                        </div>
                        <div class="funkyradio-success funkyradio col-md-1">
                            <input type="radio" name = 'radio' id="radio2" value="radio2" onchange="clickeado(this)" checked />
                            <label for="radio2">Todos</label>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6 col-md-offset-3">
                            <div   class="table">                   
                                <table class = "table tablasInfo table-hover">                
                                    <thead>
                                        <tr>
                                            <th>Tema</th>
                                            <th>Activo</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id ='cuerpoTablaTematica'  > 
                                        <?php
                                        cuerpoTablaSubTematicas($tematicasNivel1, "initCuerpoTematicas");
                                        ?>
                                    </tbody>
                                </table>                             
                                <input id ="inputHiddenTematicas" type="hidden" name="inputHiddenTematicas" value="inputHiddenTematicas"/>
                            </div>
                        </div>                    
                    </div>
                </section>        
         <div id="cargandoImagen" style = "  text-align: right; margin-bottom:0px;"><img  style = "widh:50px; height: 50px; display: none " src="../recursos/img/cargando2.gif"/></div>
                <!-----------------Inicio de las ventanas modales---------------------->
                <!-----------------Ventana agregar subtematica------------------------->
                <div id="modalAgregarSubTematica" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nuevo tema</h4>
                            </div>                 
                            <div class="modal-body">
                                <h4 class="modal-title">Clasificación padre </h4>
                                <div class="form-group">  
                                    <?php comboTematicas($tematicasNivel1, 'comboTematicasAgregar'); //enviar un id ?> 
                                </div> 
                                <h4 class="modal-title">Nuevo tema </h4> 
                                <div class="form-group">                                                     
                                    <input id = 'valorInputSubTematica' type = "text" class="form-control" placeholder="Clasificación" required></input>
                                </div>                       
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hiddenAgregarSubTematica" value="hiddenAgregarSubTematica">
                                <button type="button" class="btn btn-success" onclick="subtematicasAgregar(this)"> Guardar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>                 
                        </div>
                    </div>
                </div>

                <!----------------------- Ventana eliminar subtemática ---------------->
                <div id="modalEliminarSubTematica" class="modal fade" role="dialog">
                    <div class="modal-dialog ">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminar tema </h4>
                            </div>                    
                            <div class="modal-body">
                                <div id = "descripcionEliminarSubtematica"></div>
                            </div>
                            <div class="modal-footer">                        
                                <button type="button" class="btn btn-success" onclick="eliminarSubtematica(this);"> Eliminar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>                 
                        </div>                 
                    </div>
                </div>

                <!----------------------- Ventana modificar subtemática --------------->
                <div id="modalModifcarSubTematica" class="modal fade" role="dialog">
                    <div class="modal-dialog ">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modificar tema </h4>
                            </div>                    
                            <div class="modal-body">
                                <div class="form-group">  
                                    <label>Nuevo padre del tema </label>                           
                                    <?php comboTematicas($tematicasNivel1, 'comboTematicasModificar'); // ?> 
                                </div>

                                <div class="form-group">  
                                    <label>Nuevo nombre del tema </label> 
                                    <input type = text class="form-control" id = "descripcionModificarSubtematica"></input>
                                </div>
                            </div>
                            <div class="modal-footer">                        
                                <button type="button" class="btn btn-success" onclick="modificarSubTematica(this);"> Guardar</button>
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
        $redireccion = "location.href = '../vista/AdministrarTematicasSubTematicas.php'";
        alerta("errorGeneral", "Se ha producido un error", "");
        alerta("alertaNombreTemaNoValido", "El tema ingresado no es válido", "");
        alerta("alertaNombreTemaExistente", "El tema ingresado ya existe", "");
        alerta("alertaSubTematicaEliminada", "El tema ha sido eliminado", $redireccion);
        alerta("alertaSubTematicaNoEliminada", "El tema no puede ser eliminado ya que posee tiquetes asociados", $redireccion);
        alerta("alertaSubTemaAgregada", "El tema ha sido agregado correctamente", $redireccion); //usada
        alerta("alertaEditarNombreSubtematicaFallido", "El nombre ingresado no es válido", ""); //usada
        alerta("alertaEditarNombreSubtematicaRepetido", "Ya existe un tema con el nombre ingresado", ""); //usada
        alerta("alertaEditarNombreSubtematicaInactivo", "Los temas inactivos no pueden ser editados", ""); //usada
        confirmacion("confirmarCambioActivoSubTematica", "¿Desea cambiar el estado de actividad?", "cambiarActivoSubTematicaConfirmado(this)", ""); //USADO
        ?>;          
    </body>
</html>

