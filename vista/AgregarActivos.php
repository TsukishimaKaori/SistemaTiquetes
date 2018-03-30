<html> 
    <head>   
        <meta charset="UTF-8">
        <?php require ("../modelo/Tematica.php"); ?>
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require ("../control/AdministrarAgregarActivos.php"); ?>
        <?php
        echo '<link href="../recursos/css/AgregarActivos.css" rel="stylesheet"/>';
        ?>
        <script  type="text/javascript" src="../recursos/js/AgregarActivos.js"></script> 
    </head>
    <body >

        <?php
        require ("../vista/Cabecera.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>

        <div class="container " >
            <div class="row">
                <div class="col-md-8 col-md-offset-2" > 
                    <form  id ="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" >

                        <h1> Asociar Equipo </h1>

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="placa">Placa:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="placa" type="text" required>
                            </div>
                        </div>

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="estado">Estado:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="estado" type="text" required>
                            </div>
                        </div>  


                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="usuario">Usuario:</label>
                            <div class="col-sm-10">
                                <?php
                                $responsables = obtenerResponsables();
                                selectTiposActivos($responsables);
                                ?>
                            </div>
                        </div>  

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="serie">Serie:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="serie" type="text" required>
                            </div>
                        </div> 
                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="provedor">Provedor:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="provedor" type="text" required>
                            </div>
                        </div> 
                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="modelo">Modelo:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="modelo" type="text" required>
                            </div>
                        </div> 

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-3" for="fechaE">Expiracion de garantia:</label>
                            <div class='input-group date col-sm-9' id='datetimepicker1'>
                                <?php
                                $hoy = getdate();
                                $anio = $hoy["year"];
                                $mes = $hoy["mon"];
                                if ($mes < 10)
                                    $mes = "0" . $mes;
                                $dia = $hoy["mday"];
                                if ($dia < 10)
                                    $dia = "0" . $dia;
                                $fecha = $dia . "/" . $mes . "/" . $anio;
                                echo '  <input type="text" class="form-control " name="fechaE" id="fechaE" value="' . $fecha . '">';

                                echo'   <span class="input-group-addon btn btn-info" id="Efecha" onclick="document.getElementById(\'fechaE\').focus()" >
                                    <span class="glyphicon glyphicon-calendar" ></span>
                                </span>';
                                ?>                             
                            </div>
                        </div>
                        <div class="form-group  col-md-11" id="divLicencias">
                          <h5>Licencias: </h5>
                        </div> 
                        <div class="form-group  col-md-11" id="divRepuestos">
                            <h5>Repuestos: </h5>
                        </div>            
                        <div class="form-group  col-md-11">
                            <button type="button" class="btn  btn-primary" onclick="FormularioLicencia()">Agregar Licencia</button> 
                            <button type="button" class="btn  btn-primary" onclick="FormularioRepuesto()">Agregar Repuesto</button> 
                        </div>
                        <div id="divAgregar">

                        </div>
                        <button type="button" class="btn btn-success col-md-offset-4" > Guardar </button>
                        <button type="reset" class="btn btn-danger ">Cancelar</button> 
                    </form>

                </div> 
            </div>
        </div>

    </body>

</html>

