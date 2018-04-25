<!DOCTYPE html>

<html> 
    <head>
        <meta charset="UTF-8">
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosPermisos.php"); ?>
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require ("../control/AdministrarTablaRolUsuario.php"); ?>
        <?php echo '<link href="../recursos/css/rolesUsuarios.css" rel="stylesheet"/>'; ?>
          <script  type="text/javascript" src="../recursos/js/AdministrarRolesUsuarios.js"></script> 
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?>  
        <?php
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 2)) {
                header('Location: ../vista/Error.php');
            } else {
                ?>
              
             <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <h1> Administrar roles de usuario</h1>
                <div  class="container">                 
                    <form >
                        <div class="row">
                            <div class="col-md-2 " > 
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalagregarUsuario" >                           
                                    <i class="glyphicon glyphicon-user"></i><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="funkyradio-success col-md-3 funkyradio col-md-offset-4">
                                <input type="radio" name="radio" id="radio" value="activos" onchange="clickeado(this)" checked  />
                                <label for="radio">ver usuarios activos</label>
                            </div>
                            <div class="funkyradio-success col-md-3 funkyradio">
                                <input type="radio" name="radio" id="radio1" value="todos" onchange="clickeado(this)"  />
                                <label for="radio1">ver todos  los usuarios</label>
                            </div>


                        </div>
                        <div class = " table  table-responsive">
                            <table class = "table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código de empleado</th>
                                        <th>Nombre de empleado</th>
                                        <th>Área</th>
                                        <th>Rol</th>
                                        <th>Activo</th>
                                    </tr>
                                </thead>
                                <tbody id = "tbody-roles-usuarios"> 
                                    <?php
                                    $roles = consultarRoles();
                                    // $responsa = obtenerResponsablesCompletos();
                                    $responsa = obtenerResponsables();
                                    $areas = obtenerAreas();
                                    tablaRolesUsuarios($r, $responsa, $roles, $areas);
                                    ?>                    
                                </tbody>
                            </table>
                        </div>
                    </form>           
                </div>
                <!--modal--><!--        Modal crear Usuarios-->
                <div id="modalagregarUsuario" class="modal fade" role="dialog">
                    <div class="modal-dialog">                
                        <div class="modal-content">
                            <div style="text-align: center" class="modal-header">                               
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2> Nueva cuenta de responsable</h2>
                            </div>
                            <div class="modal-body">

                                <div class="row">    
                                    <div class="col-md-10 col-md-offset-1" id="tiquete"> 
                                        <form onsubmit="crearUsuarioAjax()">

                                            <div class="form-group">
                                                <label for="nombre">Nombre completo</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="codigoE"> Código Empleado </label>
                                                <input type="text" class="form-control" name="codigoU" id="codigoU" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email"> Correo Electrónico </label>
                                                <input type="email" class="form-control"  name="email" id="emailA" required >
                                                <div >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Area"> Area del responsable </label>
                                                <?php
                                                selectAreas($areas);
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol"> Rol del responsable </label>
                                                <?php
                                                selectRoles($roles);
                                                ?>
                                            </div>
                                            <button type="submit" class="btn btn-success"   > Crear</button>
                                            <button type="reset" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                                        </form>
                                    </div> 
                                </div>
                                <!--   <div class="modal-backdrop fade in"></div>-->
                                <!--    </body>-->
                            </div>
                        </div>
                    </div>
                </div>

                <div id="cambiarUsuario" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm ">                
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">    
                                    <div style ="text-align: center" id="Cambiartiquete"> 

                                    </div> 
                                </div>
                                <!--   <div class="modal-backdrop fade in"></div>-->
                                <!--    </body>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"  data-dismiss="modal" onclick="cambiarUsuarioAJAX()"> Aceptar</button>
                                <button type="button" class="btn btn-danger"  data-dismiss="modal" >Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="error" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm ">                
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">    
                                    <div style ="text-align: center" id="CambiarError"> 
                                        <h4> Algo salio mal</h4>
                                    </div> 
                                </div>
                                <!--   <div class="modal-backdrop fade in"></div>-->
                                <!--    </body>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"  data-dismiss="modal" > Aceptar</button>
                              
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



