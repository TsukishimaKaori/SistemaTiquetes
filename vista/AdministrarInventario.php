<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>   
        <script src="../recursos/js/AdministrarInventario.js"></script>   
        <link href="../recursos/css/inventario.css" rel="stylesheet"/> 
        <?php
        require ("../control/AdministrarTablaInventario.php");
        require ("../modelo/ProcedimientosInventario.php");
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
        <input id = 'tabInventario' type="hidden" value ='<?php echo $tab ?>' >
        <div class="container-fluid">
            <div class="row">                
                <div class="col-md-7">
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
                                                <tbody>
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
                                <div class="col-md-offset-10">                    
                                    <a href="../vista/AgregarInventario.php">   <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>   </a>      
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
                                                <?php cabeceraTablaActivos(); ?>                                 
                                            </thead>
                                            <tbody>
                                                <?php cuerpoTablaActivos($activos); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-5">                   
                    <section id = "panelInformacionInventario"></section>
                </div>
            </div>
        </div>
    </body>
</html>
