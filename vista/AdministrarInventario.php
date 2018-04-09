<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>            
        <link href="../recursos/css/inventario.css" rel="stylesheet"/>      
        <script src="../recursos/bootstrap/js/es.js"></script>  
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>     
        <script src="../recursos/js/AdministrarInventario.js"></script>    
        <?php
        require ("../control/AdministrarTablaInventario.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AlertasConfirmaciones.php");
        ?>

    </head>
    <body>
        <?php
        require ("../vista/Cabecera.php");

        $activos = obtenerActivosFijos();
        $inventario = obtenerInventario();
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        } else {
            $tab = 1;
        }
        ?>

        <input id = 'nombreUsuario' type="hidden" value ='<?php echo $r->obtenerNombreResponsable() ?>' >
        <input id = 'correoUsuario' type="hidden" value ='<?php echo $r->obtenerCorreo() ?>' >

        <input id = 'tabInventario' type="hidden" value ='<?php echo $tab ?>' >
        <div class="container-fluid">
            <div >                
                <div id = "panelInformacionIzquierda">
                    <div id="tab-indice" class="tab">                        
                        <button id = "link-inventario" class="tablinks" onclick="abrir_tab_inventario(this, 'tab-inventario')" id="defaultOpen">Inventario</button>
                        <button id = "link-activos"  class="tablinks" onclick="abrir_tab_inventario(this, 'tab-activos')" >Activos fijos</button>                        
                    </div>                                   
                    <section id="tab-inventario" class="tabcontent">
                        <h2>Inventario</h2>
                        <div class="container-fluid">
                            <div class="row">                                                           
                                <div id ="" class="col-md-10"></div>                
                                <div class="row">                                             
                                    <div class="col-md-offset-10">                   
                                        <button onclick = "cargarPanelAgregarInventario()" type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>    
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-offset-12">&nbsp;</div>
                                </div>
                                <div class="row">                                
                                    <div class="col-md-12 ">
                                        <div class="table table-responsive">  
                                            <table class="table table-hover">
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
                                        <table class="table table-hover">
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
          <!--Ventana Repuestos asociadas-->
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
                    </div>                   
                </div>
            </div>
        </div> 
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
                                <label for="comment">justificacion</label>
                                <textarea class="form-control" rows="3"  name="justificacion" cols="2" id="justificacionEstado"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="cambiarEstadoAjax();" > Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelarEstado();" > cancelar</button>
                        </div>
                    </div>
                </div>
           </div>

        <?php notificacion(); 
        
        confirmacion("eliminarRepuesto", "¿Desea eliminar  el repuesto?", "eliminarRepuestoAjax();", ""); 
        confirmacion("eliminarLicencia", "¿Desea eliminar  la licencia?", "eliminarLicenciaAjax();", "");
        
        alerta("ErrorRepuesto", "Error al eliminar repuesto", "");
        alerta("ErrorLicencia", "Error al eliminar licencia", "");
        ?>

    </body>
</html>
