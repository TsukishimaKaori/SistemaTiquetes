<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");

        require_once ("../control/AdministrarReportesTiquetes.php");
        ?>


        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="../recursos/css/reportesTiquetes.css" />
    </head>
    <body>   
        <?php
        require ("../vista/Cabecera.php");
        $areas = obtenerAreas();
        ?> 
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                   
                    <div class="col-md-6">
                    <!--GRAFICO PIE-->
                        <div id="graficoRendimientoPorAreaTematica" class="panel panel-default grafico">
                            <div class="container-fluid">
                                <h3>Clasificaciones atendidas por área</h3>
                                <div class="row"> &nbsp;</div>
                                <div class="row">  

                                    <div class=" col-md-offset-1 col-md-3">
                                        <h5>Fecha inicio</h5>
                                        <div class = "form-group input-group date" id = "datetimepickerAreasI">
                                            <input id = "fechaI" name ="filtro-fecha-i" type="text" class="form-control " value='01/01/2006'>
                                            <span class="input-group-addon btn-info"  onclick="document.getElementById('fechaI').focus()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div>
                                    </div>
                                    <div class=" col-md-3">
                                        <h5>Fecha final</h5> 
                                        <div class = "form-group input-group date" id = "datetimepickerAreasF">
                                            <input id = "fechaF" name ="filtro-fecha-f" type="text" class="form-control " value="<?php echo fechaHoy(); ?>">
                                            <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaF').focus()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div>
                                    </div>                                                                     
                                    <div class="col-md-3" >
                                        <h5>Área</h5>  
                                        <?php comboAreas($areas); //envair un id  ?>                                        
                                    </div> 
                                    <div class=" col-md-1">
                                        <h5>&nbsp;</h5>
                                        <button  title="Buscar" type="button" class="btn btn-info" onclick="graficoAreas();"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>                                    
                                </div>  

                                <div class="row">
                                    <div class="panel-body"> <canvas id="chart-area"></canvas></div>
                                </div>  
                                <div class="row">
                                    <div  class="table table-hover table-responsive ">                   
                                        <table class = "table table-hover">                
                                            <thead>
                                                <tr >
                                                    <th style="text-align: center;">Clasificación</th>
                                                    <th style="text-align: center;">Total tiquetes atendidos</th>                                          
                                                </tr>
                                            </thead>
                                            <tbody  id = "tbodySolicitudClasificacionPorArea">  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                  
                            </div> 
                        </div>
                    <!--Calificaciones por área-->
                    <div id="" class="panel panel-default"  >
                            <div class="container-fluid">
                                <h3>Reporte de calificaciones de empleados por área</h3>
                                <div class="row"> &nbsp;</div>                                   
                                <div class="row">
                                    <div  class="table table-hover table-responsive ">                   
                                        <table class = "table table-hover">                
                                            <thead>
                                                <tr>     
                                                    <th>Ene</th>
                                                    <th>Feb</th>   
                                                    <th>Mar</th>
                                                    <th>Abr</th>
                                                    <th>May</th>
                                                </tr>
                                            </thead>
                                            <tbody  id = "tbodyGraficoCalificaciones">                                                                                       
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>                                     
                        </div>
                    </div>                  
                    
                    <!--GRAFICO Barras-->
                    <div class="col-md-6">
                        <div id="graficoRendimientoPorArea" class="panel panel-default grafico" >
                            <div class="container-fluid">
                                <h3>Cumplimiento por área</h3>
                                <div class="row"> &nbsp;</div>
                                <div class="row">                        
                                    <div class=" col-md-2">
                                        <h5>Fecha inicio</h5>                                         
                                    </div>                        
                                    <div class="col-md-3" >
                                        <div class = "form-group input-group date" id = "">
                                            <input id = "fechaIGraficoBarras" type="text" class="form-control " value="01/01/2006">
                                            <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaIGraficoBarras').focus()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div> 
                                    </div> 
                                    <div class="col-md-2">
                                        <h5>Fecha final</h5> 
                                    </div>                        
                                    <div class="col-md-3" >
                                        <div class = "form-group input-group date" id = "">
                                            <input id = "fechaFGraficoBarras" type="text" class="form-control " value="<?php echo fechaHoy(); ?>">
                                            <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaFGraficoBarras').focus()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div> 
                                    </div> 
                                    <div class=" col-md-1">                                      
                                        <button  title="Buscar" type="button" class="btn btn-info" onclick="graficoRendimientoPorArea();"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>  
                                </div>  
                                <div class="row">                                    
                                    <div class="panel-body"> <canvas id="canvas"></canvas> </div>            
                                </div>
                                <div class="row">
                                    <div  class="table table-hover table-responsive ">                   
                                        <table class = "table table-hover">                
                                            <thead>
                                                <tr>
                                                    <th>Área</th>
                                                    <th>Tiquetes cumplidos</th>   
                                                    <th>Tiquetes atendidos</th> 
                                                </tr>
                                            </thead>
                                            <tbody  id = "tbodyGraficoBarras">  

                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>  
                        </div>
                    </div>
                    <!--GRAFICO LINEAL-->
                    <div class="col-md-6">
                        <div id="" class="panel panel-default grafico"  >
                            <div class="container-fluid">
                                <h3>Reporte de cantidad de tiquetes mensuales</h3>
                                <div class="row"> &nbsp;</div>
                                <div class="row">                        
                                    <div class="col-md-offset-4 col-md-1">
                                        <h4>Año</h4> 
                                    </div>                        
                                    <div class="col-md-3" >
                                        <div class = "form-group input-group date" id = "datetimepickerAnio">
                                            <input onchange = "graficoSolicitudesAtendidasPorAnio();" id = "datepickerAnio" type="text" class="form-control " value="<?php echo anioActual(); ?>" >
                                            <span class="input-group-addon btn-info"   onclick="document.getElementById('datepickerAnio').focus()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div>  
                                    </div> 
                                </div>  
                                <div class="row">                                    
                                    <div class="panel-body"> <canvas id="chart-area3" ></canvas></div>  
                                </div>      
                                <div class="row">
                                    <div  class="table table-hover table-responsive ">                   
                                        <table class = "table table-hover">                
                                            <thead>
                                                <tr>     
                                                    <th>Ene</th>
                                                    <th>Feb</th>   
                                                    <th>Mar</th>
                                                    <th>Abr</th>
                                                    <th>May</th>
                                                    <th>Jun</th>
                                                    <th>Jul</th>
                                                    <th>Ago</th>
                                                    <th>Set</th>
                                                    <th>Oct</th>
                                                    <th>Nov</th>
                                                    <th>Dic</th>
                                                </tr>
                                            </thead>
                                            <tbody  id = "tbodyGraficoLineas">                                                                                       
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>                                     
                        </div>
                    </div>

                </div> 
            </div>
        </div>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>   
        <script src="../recursos/chartJS/Chart.bundle.js"></script>
        <script src="../recursos/chartJS/utils.js"></script> 
        <script src="../recursos/js/ReportesTiquetes.js"></script>
    </body>
</html>





