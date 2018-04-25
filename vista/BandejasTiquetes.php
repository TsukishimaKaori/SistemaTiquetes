<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosPermisos.php"); ?>
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require ("../control/AdministrarTiquetesCreados.php"); ?>
        <?php require ("../control/AlertasConfirmaciones.php"); ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <link href="../recursos/css/bandejasTiquetes.css" rel="stylesheet"/> 

    </head>
    <body> 
        <script src="../recursos/js/TiquetesCreados.js"></script>    
        <?php
        require ("../vista/Cabecera.php");
        $correo = $r->obtenerCorreo();
        $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
        $codigoEmpleado = $r->obtenerCodigoEmpleado();
        $misTiquetes = obtenerTiquetesPorUsuario($correo);
        $misTiquetesAsignados = obtenerTiquetesAsignados($codigoEmpleado);
        $tiquetesPorAsignar = obtenerTiquetesPorAsignarArea($codigoArea);
         $responsables = obtenerResponsablesAsignar($codigoArea);
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        } else {
            $tab = 1;
        }
        ?> 
        <input id = 'tabBandejaTiquetes' type="hidden" value ='<?php echo $tab ?>' >
        <script>
            $(document).ready(function () {
                navActivoBandeja();
            });
        </script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <h1>Administrador de Tiquetes</h1>        
<div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <div id="exTab1" class="container" style="width: 100%;">
            <!--            -------------------------------------->         
            <div class="row" id="Filtros">
            </div> 
            <!---------------------------------------->
            <div class = "row" id="botones"> 
                <?php
                if ($tab == 1) {
                    agregabotones("Creados");
                } else if ($tab == 2) {
                    agregabotones("PorAsignar");
                } else if ($tab == 3) {
                    agregabotones("Asignados");
                } else if ($tab == 4) {
                    agregabotones("TodosLosTiquetes");
                }
                ?>
            </div>
            <!--------------------------------------------------->
            <div class = "row" id="Tablas"> 
                <div class = "col-md-12"> 
                    <ul  id ="miTabBandeja" class="nav nav-pills" >                
                        <li class="active bandeja-tab"  id ='liMisTiquetes'>
                            <a  href="#misTiquetes"  data-toggle="tab"  onclick=" actualizarTabla('Creados')">Mis tiquetes</a>
                        </li>
                        <?php
                        if ($r) {
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 6)) {
                                echo ' <li  id ="liAsignar" class ="bandeja-tab" ><a href="#tiquetesPorAsignar" data-toggle="tab"  onclick="actualizarTabla(\'PorAsignar\')">Tiquetes por asignar</a></li> ';
                            }
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 7)) {
                                echo '<li  id ="liAsignados" class ="bandeja-tab"><a href="#misTiquetesAsignados" data-toggle="tab" onclick="actualizarTabla(\'Asignados\')">Mis tiquetes asignados</a></li>';
                            }
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 8)) {
                                echo '<li  id ="liTodos" class ="bandeja-tab"><a href="#todosLosTiquetes" data-toggle="tab"  onclick="actualizarTabla(\'TodosLosTiquetes\')">Todos los tiquetes</a></li>';
                            }
                        }
                        ?> 
                    </ul>
                    <div id ='divBandejaTiquetes' class="tab-content clearfix" >
                        <div class="row"><br><br></div>
                        <section class="tab-pane active" id="misTiquetes">
                            <div class = " table table-responsive">
                                <table class = "table tablasTiquetes table-hover" id="tablaMisTiquetes">
                                    <thead>
                                        <?php cabecera(); ?>                                 
                                    </thead>
                                    <tbody id = "tbody-roles-usuariosCreados"> 
                                        <?php
                                        cuerpoTablaMistiquetesCreados($misTiquetes, 1,$responsables);
                                        ?>                    
                                    </tbody>
                                </table>
                            </div>                      

                        </section>

                        <?php
                        if ($r) {
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 6)) {
                                ?>
                                <section class="tab-pane" id="tiquetesPorAsignar" >
                                    <div class = " table table-responsive">
                                        <table class = "table tablasTiquetes table-hover" id="tablaTiquetesPorAsignar">
                                            <thead>
                                                <?php cabecera(); ?>                               
                                            </thead>
                                            <tbody id = "tbody-roles-usuariosPorAsignar" > 
                                                <?php
                                                cuerpoTablaMistiquetesCreados($tiquetesPorAsignar, 2,$responsables);
                                                ?>                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class ="container-fluid">
                                        <div class ="row">
                                            <div class="">
                                                <!-- <button class="btn btn-info" onclick = "asignarTiquete(this);">Asignar tiquete</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <?php
                            }
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 7)) {
                                ?> 
                                <section class="tab-pane" id="misTiquetesAsignados">
                                    <div class = " table table-responsive">
                                        <table class = "table tablasTiquetes table-hover" id="tablaMisTiquetesAsignados">
                                            <thead>
                                                <?php cabecera(); ?>                              
                                            </thead>
                                            <tbody id = "tbody-roles-usuariosAsignados"> 
                                                <?php
                                                cuerpoTablaMistiquetesCreados($misTiquetesAsignados, 3,$responsables);
                                                ?>                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class ="container-fluid">
                                        <div class ="row">
                                            <div class="">
                                                <!--   <button class="btn btn-success" onclick="IniciarTiquete()">En proceso</button>   -->
                                            </div> 
                                        </div>
                                    </div>
                                </section>  
                                <?php
                            }
                            if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 8)) { //cambiar el numero de permiso, id de la tabla numero de la tabla del cuerpo
                                ?>  
                                <section class="tab-pane" id="todosLosTiquetes" >
                                    <div class = " table table-responsive">
                                        <table class = "table tablasTiquetes table-hover" id="tablaTodoslosTiquetes">
                                            <thead>
                                                <?php cabecera(); ?>                             
                                            </thead>
                                            <tbody id = "tbody-roles-usuariosTodosLosTiquetes">                                                                   
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class ="container-fluid">
                                        <div class ="row">
                                            <div class="">
                                                <!--<button class="btn btn-success">Finalizar</button>-->
                                            </div> 
                                        </div>
                                    </div>
                                </section>  
                                <?php
                            }
                        }
                        ?>
                        <div class="row"><br><br></div>
                    </div>
                </div>   
            </div>
        </div>
        <div class="row"><br><br></div>

        <!----------------------------INICIO DE VENTANAS MODALES----------------------->
        <div id="modalAsignar" class="modal fade" role="dialog">
            <div class="modal-dialog ">                
                <div class="modal-content">  
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h4> Asignar tiquete a responsable</h4>
                    </div>
                    <div class="modal-body" id="Modal2">
                        <div class="row">  
                            <div class="" style ="text-align: center;" id=""> 
                                <label class="col-md-3" for="responsables">Responsables</label>
                                <div class="form-group col-md-6">                                     
                                    <?php
// $codigoArea1 = $r->obtenerArea()->obtenerCodigoArea();                                   
                                   
                                    comboResponsablesAsignar($responsables);
                                    ?>
                                </div>                                
                            </div> 
                        </div>
                        <div class="row">
                            <label class="form-group col-lg-10" for="responsables">
                                Nota: al asignar un tiquete este será dirigido a la bandeja de asignados del usuario, 
                                por lo que desaparecerá de la bandeja de tiquetes por asignar.
                            </label>
                        </div >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="asignarResponsableAjax();"  > Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"   > Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-------------------Justicacion finalizar----------------------------->
        <div id="ModalJustificacion" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div class="" style ="text-align: center" id="tiquete"> 
                                <h4 id="infoJusticiacion"></h4>                               
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="comment">Justificación</label>
                            <textarea class="form-control" rows="3"  name="justificacion" cols="2" id="justificacion"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="aceptarJustificacion" > Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"  id="cancelarJustificacion" > cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------>
        <!------------------------------------------------>
        <?php alerta("tiqueteNoSeleccionado", "Ningun tiquete seleccionado", "");
        notificacionBandeja();
        ?>

        <!----------------------------FINAL DE VENTANAS MODALES-------------------------> 

    </body>

</html>


