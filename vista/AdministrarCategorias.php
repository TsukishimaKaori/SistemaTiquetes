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

        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 4)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <section class ="container-fluid">
                    <div class="row">                  
                        <div class="col-md-offset-3 col-md-5">
                            <h3>Categorías</h3> 
                        </div>   
                        <div class="col-md-1  ">  
                            <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarCategoria"><i class="glyphicon glyphicon-plus"></i></button>
                            <!--<button type="button" class="btn btn-danger btn-circle btn-xl" data-toggle="modal" data-target="#modalEliminarSubTematica"><i class="glyphicon glyphicon-minus"></i></button>-->
                        </div>
                    </div>   
                    <div><br><br></div>
                    <div class = "row">
                        <div class="col-md-offset-3 col-md-9">
                        <span class="funkyradio-success funkyradio">
                            <input type="radio" name = 'radio' id="radio1" value="radio1" onchange="clickeado(this)"  />
                            <label for="radio1">Repuestos</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                          <span class="funkyradio-success  funkyradio">
                            <input type="radio" name = 'radio' id="radio3" value="radio3" onchange="clickeado(this)"  />
                            <label for="radio3">No Repuestos</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <span class="funkyradio-success funkyradio">
                            <input type="radio" name = 'radio' id="radio2" value="radio2" onchange="clickeado(this)" checked />
                            <label for="radio2">Todos</label>
                        </span>
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
                            </div>
                        </div>                    
                    </div>
                </section>        

                <!-----------------Inicio de las ventanas modales---------------------->
                <!-----------------Ventana agregar subtematica------------------------->
                <div id="modalAgregarCategoria" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nueva categoría</h4>
                            </div>                 
                            <div class="modal-body">                                                               
                                <h4 class="modal-title">Nombre de categoría </h4> 
                                <div class="form-group">                                                     
                                    <input id = 'valorInputCategoria' type = "text" class="form-control" placeholder="Categoría" required></input>
                                </div> 
                                <div class="form-check">
                                    <input id = "esRepuesto"type="checkbox" class="form-check-input" id="">
                                    <label class="form-check-label" for="esRepuesto">Es repuesto</label>
                                 </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hiddenAgregarSubTematica" value="hiddenAgregarSubTematica">
                                <button type="button" class="btn btn-success" onclick="categoriaAgregar(this)"> Guardar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>                 
                        </div>
                    </div>
                </div>

                <!----------------------- Ventana eliminar subtemática ---------------->
                <div id="modalEliminarCategoria" class="modal fade" role="dialog">
                    <div class="modal-dialog ">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminar categoría </h4>
                            </div>                    
                            <div class="modal-body">
                                <div id = "descripcionEliminarCategoria"></div>
                            </div>
                            <div class="modal-footer">                        
                                <button type="button" class="btn btn-success" onclick="eliminarCategoria(this);"> Eliminar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>                 
                        </div>                 
                    </div>
                </div>

                <?php
                notificacion();
            }
        }
        ?>
        
    </body>
</html>

