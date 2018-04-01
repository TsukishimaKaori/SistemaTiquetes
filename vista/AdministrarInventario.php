<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>
        <script src="../recursos/js/AdministrarInventario.js"></script> 
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link href="../recursos/css/inventario.css" rel="stylesheet"/>         
         <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>  
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

        <?php  notificacion();?>

    </body>
</html>
