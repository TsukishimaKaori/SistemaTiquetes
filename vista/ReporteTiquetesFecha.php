<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        require_once ("../control/AdministrarReporteTiquetesFecha.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link href="../recursos/bootstrap/css/bootstrap-select.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../recursos/css/reportesTiquetesFecha.css" />
    </head>
    <body>   
        <?php
        require ("../vista/Cabecera.php");
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 13)) {
                echo "<script>location.href='../vista/Error.php'</script>";
            } else {
                ?> 
                <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!--Reporte inventario-->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="container-fluid">
                                        <h3>Reporte de tiquetes por Fecha</h3>
                                        <div class="row"> &nbsp;</div>
                                        <div class="row">                        
                                            <div class=" col-md-2">
                                                <h5>Fecha inicio</h5>                                         
                                            </div>                        
                                            <div class="col-md-3" >
                                                <div class = "form-group input-group date" id = "">
                                                    <input id = "fechaI" type="text" class="form-control " value="01/01/2006">
                                                    <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaI').focus()">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>  
                                                </div> 
                                            </div> 
                                            <div class="col-md-2">
                                                <h5>Fecha final</h5> 
                                            </div>                        
                                            <div class="col-md-3" >
                                                <div class = "form-group input-group date" id = "">
                                                    <input id = "fechaF" type="text" class="form-control " value="<?php echo fechaHoy(); ?>">
                                                    <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaF').focus()">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>  
                                                </div> 
                                            </div> 
                                            <div class=" col-md-1">                                      
                                                <button  title="Buscar" type="button" class="btn btn-info" onclick="Filtrar();"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>  
                                        </div> 
                                        <div class="row table-responsive">
                                            <table class = "table tablasTiquetes table-hover" id="tablaMisTiquetes">
                                                <thead>
                                                    <?php cabecera(); ?>                                 
                                                </thead>
                                                <tbody id = "tbody-roles-usuariosCreados"> 
                                                    <?php
                                                    $tiquetes = reporteTodosLosTiquetesFecha("20060101", "20180606");
                                                    cuerpoTablaMistiquetesReporte($tiquetes);
                                                    ?>                    
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div> 
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
                <script>var correoUsuario = '<?php echo $r->obtenerCorreo(); ?>';</script>
                <script src="../recursos/bootstrap/js/es.js"></script>
                <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>   
                <script src="../recursos/chartJS/Chart.bundle.js"></script>
                <script src="../recursos/chartJS/utils.js"></script> 
                <script src="../recursos/js/ReporteTiquetesFecha.js"></script>
                <script src="../recursos/bootstrap/js/bootstrap-select.min.js"></script>  
                <script  type="text/javascript" src="../recursos/js/dataTables.buttons.min.js"></script> 
                <script  type="text/javascript" src="../recursos/js/jszip.min.js"></script>              
                <script  type="text/javascript" src="../recursos/js/buttons.html5.min.js"></script> 


                <?php
            }
        }
        ?>

    </body>
</html>



