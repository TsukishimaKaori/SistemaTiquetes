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
                                <div class="row "> &nbsp;</div>
                                <div class="row filtros">  
                                    <div class=" col-md-6">
                                        <div class="row">                                      
                                            <h4 class=" col-md-3">Estado </h4>
                                            <div class = "form-group col-md-6">
                                                <?php
                                                $estados = ['En proceso', 'Nuevo', 'Asignado', 'Vencido'];
                                                selectEstado($estados);
                                                ?> 
                                            </div>
                                            <div class="col-md-1">                                            
                                                <button  title="Buscar" type="button" class="btn btn-info" onclick="FiltrarTiquete();"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>
                                        </div>                                
                                    </div>  
                                    <div id="CantidadInfo" class=" col-md-6">
                                        <div class="row">
                                            <?php
                                            $tiquetes = reporteTiquetesEnEstados('En proceso');
                                            $cantidad = count($tiquetes);
                                            CantidadInfo($cantidad);
                                            ?>
                                        </div>  
                                    </div> 
                                </div>
                                <div class="row" >
                                    <div style = "padding: 2%">
                                        <div  class="table table-hover table-responsive " >                  
                                            <table id='tablaTiquetes' class = "tablaReportes table table-hover">                
                                                <thead>
                                                    <tr > 
                                                        <th style="text-align: center;">Cod</th>
                                                        <th style="text-align: center;">Clasificación</th>   
                                                        <th style="text-align: center;">Solicitante</th>
                                                        <th style="text-align: center;">Responsable</th>
                                                        <th style="text-align: center;">Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id = "tbodyTiquetes">  
                                                    <?php
                                                    cuerpoTablaReportes($tiquetes);
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  


                            </div> 
                        </div>
                    </div>
                    <!--Reporte Movimientos-->
                    <div class="col-md-6" id="infoTiquete">
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
        <script src="../recursos/js/jquery.base64.js"></script>
        <script src="../recursos/js/tableExport.js"></script>




    </body>
</html>

