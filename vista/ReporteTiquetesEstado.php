<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        require_once ("../control/AdministrarReporteTiquetesEstado.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link href="../recursos/bootstrap/css/bootstrap-select.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../recursos/css/reportesInventario.css" />
    </head>
    <body>   
        <?php
        require ("../vista/Cabecera.php");
         $areas = obtenerAreas();
        $calificaciones = reportePromedioCalificacionesPorArea();
        ?> 
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--Reporte inventario-->
                    <div class="col-md-6">
                          <div id="graficoRendimientoPorAreaTematica" class="panel panel-default grafico">
                            <div class="container-fluid">
                                <h3>Reporte de tiquetes por estado</h3>
                                <div class="row"> &nbsp;</div>
                                

                                <div class="row">
                                    <div class="panel-body"> <canvas id="chart-area"></canvas></div>
                                </div>  
                                <div class="row">
                                    <div  class="table table-hover table-responsive ">                   
                                        <table class = "table table-hover">                
                                            <thead>
                                                <tr >
                                                    <th style="text-align: center;">Estado</th>
                                                    <th style="text-align: center;">Total tiquetes </th>                                          
                                                </tr>
                                            </thead>
                                            <tbody  id = "tbodySolicitudClasificacionPorEstado">  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                  
                            </div> 
                        </div>
                    </div>
                    <!--Tabla de tiquetes-->
                    <div class="col-md-6" id="TablaTiquetes" >
                          
                    </div>
                </div> 
            </div>
        </div>
        
        <div class="modal fade" id="modalInfoTiquetes" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id ="tituloModalCalificaciones" class="modal-title"></h4>
                    </div>
                    <div class="modal-body" class="col-md-12" id="infoTiquete">
                        
                    </div>
                   
                </div>
            </div>
        </div>

        <script src="../recursos/bootstrap/js/es.js"></script>
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>   
        <script src="../recursos/chartJS/Chart.bundle.js"></script>
        <script src="../recursos/chartJS/utils.js"></script> 
        <script src="../recursos/js/ReporteTiquetesEstado.js"></script>
        <script src="../recursos/bootstrap/js/bootstrap-select.min.js"></script>  
        




    </body>
</html>

