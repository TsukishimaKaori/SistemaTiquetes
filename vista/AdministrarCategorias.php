<!DOCTYPE html>
<html> 
    <head>       
        <?php require_once ("../control/ArchivosDeCabecera.php"); 
         require ("../modelo/ProcedimientosInventario.php"); 
         require ("../control/AlertasConfirmaciones.php"); ?>
        <?php require_once ("../control/AdministrarTablaCategorias.php"); ?>
        <script  type="text/javascript" src="../recursos/js/AdministrarCategorias.js"></script>        
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?> 
        <?php
        $categorias =  obtenerCategorias();
        require_once ("../modelo/ProcedimientosPermisos.php");
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 4)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
                <section class ="container-fluid">
                    <div class="row">                  
                        <div class="col-md-offset-3 col-md-5">
                            <h4>Categorías</h4> 
                        </div>   
                        <div class="col-md-1  ">  
                            <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarSubTematica"><i class="glyphicon glyphicon-plus"></i></button>
                            <!--<button type="button" class="btn btn-danger btn-circle btn-xl" data-toggle="modal" data-target="#modalEliminarSubTematica"><i class="glyphicon glyphicon-minus"></i></button>-->
                        </div>
                    </div>   
                    <div><br></div>
                    <div class = "row">
                        <div class="funkyradio-success col-md-2 funkyradio col-md-offset-6">
                            <input type="radio" name = 'radio' id="radio1" value="radio1" onchange="clickeado(this)"  />
                            <label for="radio1">Repuestos</label>
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
                                            <th>Código categoría</th>
                                            <th>Nombre categoría</th> 
                                            <th>Es repuesto</th>
                                            <th>Eliminar</th>                                          
                                        </tr>
                                    </thead>
                                    <tbody id ='cuerpoTablaTematica'  > 
                                        <?php
                                        cuerpoTablaCategorias($categorias);
                                        ?>
                                    </tbody>
                                </table>                             
                                <input id ="inputHiddenTematicas" type="hidden" name="inputHiddenTematicas" value="inputHiddenTematicas"/>
                            </div>
                        </div>                    
                    </div>
                </section>        

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

                <?php
            }
        }
        ?>
        
    </body>
</html>

