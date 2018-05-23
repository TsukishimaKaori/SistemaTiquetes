<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosInventario.php");
        require_once ("../control/AdministrarReportesInventario.php");
        ?>
        <link rel="stylesheet" href="../recursos/css/reportesInventario.css" />
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link href="../recursos/bootstrap/css/bootstrap-select.min.css" rel="stylesheet"/>

    </head>
    <body>   
        <?php
        require ("../vista/Cabecera.php");
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 14)) {
                echo "<script>location.href='../vista/Error.php'</script>";
            } else {
                $areas = obtenerAreas();
                ?> 
                <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <div class="container-fluid">
                    <div class="row">

                        <!--Reporte inventario-->
                        <div class="col-md-6">
                            <div id="graficoRendimientoPorAreaTematica" class="panel panel-default grafico">
                                <div class="container-fluid">
                                    <h3>Reporte de inventario</h3>
                                    <div class="row "> &nbsp;</div>
                                    <div class="row filtros">  

                                        <div class="col-md-3" style="padding-left: 2%;">
                                            <h5>Código </h5>
                                            <div class = "form-group  " id = "datetimepickerAreasI">
                                                <input id = "codigoI" name ="filtro-fecha-i" type="text" class="form-control " >

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Descripción </h5> 
                                            <div class = "form-group  " id = "datetimepickerAreasF">
                                                <input id = "descripcionI" name ="filtro-fecha-f" type="text" class="form-control">
                                            </div> 
                                        </div>                                                                     
                                        <div class="col-md-3" >
                                            <h5>Categoria</h5> 
                                            <div class = "form-group">
                                                <?php
                                                $Categoria = obtenerCategorias();
                                                selectTipos($Categoria, 1)
                                                ?>   
                                            </div> 
                                        </div> 
                                        <div class=" col-md-2">
                                            <h5>&nbsp;</h5>
                                            <button  title="Buscar" type="button" class="btn btn-info" onclick="FiltrarInventario();"><i class="glyphicon glyphicon-search"></i> Filtrar</button>
                                        </div>  

                                    </div>  
                                    <div class="row">
                                        <div style = "">
                                            <div  class="table table-hover table-responsive ">                   
                                                <table id='tablaInventario' class = "tablaReportes table table-hover">                
                                                    <thead>
                                                        <tr >
                                                            <th >Codigo</th>
                                                            <th >Descripcion</th>   
                                                            <th >Categoria</th>
                                                            <th >Existencias</th>
                                                            <th >Fecha ultimo ingreso</th>
                                                            <th >Fecha ultimo egreso</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody  id = "tbodyInventario">  
                                                        <?php
                                                        $Categoria = obtenerCategorias();
                                                        $nombreCategoria = $Categoria[0]->obtenerNombreCategoria();
                                                        $reportesInvetantario = obtenerReportesInventario("", "", $nombreCategoria);
                                                        cuerpotablaInvetario($reportesInvetantario);
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
                        <div class="col-md-6">
                            <div id="graficoRendimientoPorArea" class="panel panel-default grafico" >
                                <div class="container-fluid">
                                    <h3>Reporte de movimientos</h3>
                                    <div class="row"> &nbsp;</div>
                                    <div class="row ">  
                                        <div class="col-md-3" style="padding-left: 2%;">
                                            <h5>Código</h5>
                                            <div class = "form-group" id = "datetimepickerAreasI">
                                                <input id = "codigoM" name ="filtro-fecha-i" type="text" class="form-control " >

                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <h5>Categoria</h5>  
                                            <div class = "form-group">
                                                <?php
                                                selectTipos($Categoria, 2)
                                                ?> 
                                            </div>
                                        </div> 
                                        <div class="  col-md-3">
                                            <h5>Fecha inicio</h5>
                                            <div class = "form-group input-group date" id = "datetimepickerAreasI">
                                                <input id = "fechaI" name ="filtro-fecha-i" type="text" class="form-control " value='01/01/2006'>
                                                <span class="input-group-addon btn-info"  onclick="document.getElementById('fechaI').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>  
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Fecha final</h5> 
                                            <div class = "form-group input-group date" id = "datetimepickerAreasF">
                                                <input id = "fechaF" name ="filtro-fecha-f" type="text" class="form-control " value="<?php echo fechaHoy(); ?>">
                                                <span class="input-group-addon btn-info"   onclick="document.getElementById('fechaF').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>  
                                            </div>
                                        </div> 
                                    </div> 

                                    <div class="row filtros">
                                        <div class="col-md-offset-4 col-md-4">
                                             <button  title="Buscar" type="button" class="btn btn-info" onclick="filtrarMovimiento();"><i class="glyphicon glyphicon-search"></i> Filtrar</button>
                                        </div>   
                                    </div> 
                                    <div class="row">
                                        <div>
                                            <div  class="table table-hover table-responsive ">                   
                                                <table id='tablaMovimiento' class = "tablaReportes table table-hover">                
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Efecto</th>   
                                                            <th>Codigo</th>
                                                            <th>Descripción</th>
                                                            <th>Categoria</th>
                                                            <th>Unidades</th>
                                                            <th>Saldo</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody  id = "tbodyMovimiento">  
                                                        <?php
                                                        $reportesMovimientos = obtenerReporteDeMovimientos("", $nombreCategoria, "20060712", "20180504");
                                                        cuerpotablaMovimiento($reportesMovimientos);
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  

                                </div>  
                            </div>
                        </div>
                        <!--GRAFICO LINEAL-->


                    </div>
                </div>
                <script>var correoUsuario = '<?php echo $r->obtenerCorreo(); ?>';</script>
                <script src="../recursos/bootstrap/js/es.js"></script>
                <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>   
                <script src="../recursos/chartJS/Chart.bundle.js"></script>
                <script src="../recursos/chartJS/utils.js"></script> 
                <script src="../recursos/js/ReportesInventario.js"></script>
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
