<!DOCTYPE html>

<html> 
    <head>       
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>   
        <?php require ("../modelo/ProcedimientosPermisos.php"); ?>        
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require_once ("../control/AdministracionTablas.php"); ?>
        <?php require ("../control/AlertasConfirmaciones.php"); ?>
        <?php
        $roles = consultarRoles();
        $permisos = consultarPermisos();
        ?>  
        <script type="text/javascript" src="../recursos/js/AdministracionRolesPermisosUsuarios.js"></script>
    </head>
    
    <body>
        <?php require ("../vista/Cabecera.php"); ?> 
        <?php
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 1)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <form id = 'formComboRoles' action = "../vista/AdministracionRolesPermisosUsuarios.php" method ="POST">
                    <section class ="container-fluid">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2"><h4>Roles</h4></div>
                            <div id ="divRoles" class="col-md-2">                    
                                <?php comboRolesModal($roles, 'comboRoles') ?> 
                            </div>                
                            <div class="col-md-2">                    
                                <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target="#modalAgregarRol"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-circle btn-xl" data-toggle="modal" onclick = 'eliminarRol(this);'><i class="glyphicon glyphicon-minus"></i></button>
                                <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalUsuarioRol" ><i class="glyphicon glyphicon-user"></i></button>
                            </div>
                        </div>
                    </section>
                    <section class ="container-fluid">
                        <div class="row"> 
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div  class="table table-responsive">                   
                                    <table class = "table tablasInfo table-hover">                
                                        <thead>
                                            <tr>
                                                <th>Permisos</th>
                                                <th>Activo</th>
                                            </tr>
                                        </thead>
                                        <tbody  id = "seccionPermisos">
                                            <?php cuerpoTablaPermisos($permisos, $roles); ?>                            
                                        </tbody>
                                    </table> 
                                    <button name = "checkEnviado"type="button" class="btn btn-success" onclick="enviarCambiosPermisos(this);"><i class="glyphicon glyphicon-floppy-disk"> Guardar</i></button>
                                    <input id ="inputHiddenPermisos" type="hidden" name="inputHiddenPermisos" value="inputHiddenPermisos">
                                </div>
                            </div>                    
                        </div>
                    </section>
                </form> 

                <!--Inicio de las ventanas modales-->
                <!--Ventana agregar rol-->
                <div id="modalAgregarRol" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nuevo Rol </h4>
                            </div>                   
                            <form name ="modalAgregarRol" action = "../vista/AdministracionRolesPermisosUsuarios.php" method ="POST">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nombre del rol</label>
                                        <input id = 'inputAgregarRol' type = "text" name = "agregarRol" class="form-control" placeholder="Nuevo rol" required></input>
                                    </div>                       
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hiddenAgregarRol" value="hiddenAgregarRol">
                                    <button type="button" class="btn btn-success" onclick="validacionAgregarRol(this)"> Guardar</button>
                                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Ventana eliminar rol-->
                <div id="modalEliminarRol" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminar Rol </h4>
                            </div>                   
                            <div class="modal-body">
                                <div class="form-group" id = 'rolAElminar'>                                                              
                                    <?php // comboRolesModal($roles, 'comboRolesModal');  ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="confimarcionEliminar(this)"> Eliminar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                            </div>                   
                        </div>                 
                    </div>
                </div>

                <!--Ventana usuario con rol-->
                <div id="modalUsuarioRol" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Usuarios asignados a roles </h4>
                            </div>                  
                            <div class="modal-body">
                                <?php comboRolesModal($roles, 'comboRolesUsuariosModal'); ?>  
                                <div  class="table table-responsive seccion-tabla-rol" >  
                                    <table class = "table table-hover">  
                                        <thead><th>Código de usuario</th><th>Usuario</th><th>Area</th></thead>
                                        <tbody id = "cuerpoTablaRolUsuario">
                                            <?php
                                            usuariosAsignadosRol($roles);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hiddenUsuarioRol" value="hiddenUsuarioRol">                           
                                <button type="button" class="btn btn-success"   data-dismiss="modal">Aceptar</button>
                            </div>                   
                        </div>
                    </div>
                </div>  

                <!--Confirmaciones y alertas eliminar-->
                <?php         
                $redireccion = "location.href = '../vista/AdministracionRolesPermisosUsuarios.php'";
                alerta("alertaEliminarRol", "El rol ha sido eliminado correctamente.", $redireccion);
                alerta("alertaEliminarRolFallido", "El rol seleccionado tiene permisos o usuarios asociados",$redireccion);
                alerta("alertaEliminarRolFallidoAdmin", "El rol Administrador no puede ser eliminado",$redireccion);
                alerta("alertaRolAgregado", "El rol ha sido agregado correctamente",$redireccion);
                alerta("alertaRolAgregarFallido", "El rol que desea agregar no es válido",""); 
                alerta("alertaRolAgregarRepetido", "Ya existe un rol con ese nombre","");
                confirmacion("confirmacionPermisosModificados", "¿Desea guardar los cambios?","confirmarPermisosModificados(this);",$redireccion); 
                alerta("alertaPermisosModificados", "Permisos modificados correctamente", $redireccion);
                
                ?>              
                <?php
            }
        }
        ?>
    </body>
</html>

