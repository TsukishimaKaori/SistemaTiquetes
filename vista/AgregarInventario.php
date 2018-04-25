<html> 
    <head>   
        <meta charset="UTF-8">
        <?php require ("../modelo/Tematica.php"); ?>
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require ("../control/AdministrarAgregarInventario.php"); ?>
        <?php
        echo '<link href="../recursos/css/AgregarInventario.css" rel="stylesheet"/>';
        ?>
        <script  type="text/javascript" src="../recursos/js/AgregarInventario.js"></script> 
    </head>
    <?php
    if (isset($_GET['for'])) {
        $for = $_GET['for'];
    } else {
        $for = 1;
    }
    ?>
    <body onload="fechas(<?php $for ?>)">
<div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <?php
        require ("../vista/Cabecera.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>


        <div class="container " id="">
            <div class="row">
                <div class="col-md-8 col-md-offset-2" > 
                    <form  id ="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" >
                        <div id="Inventario">

                            <?php
                            if ($for == 1) {
                                FormularioDispositivos();
                            } else if ($for == 2) {
                                FormularioLicencias();
                            } else {
                                FormularioRepuestos();
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-11" id="divfechaC">
                            <label class="control-label col-sm-3" for="fechaC"> Fecha compra </label>
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
                                echo '  <input type="text" class="form-control " name="fecha" id="fechaC" value="' . $fecha . '">';

                                echo'   <span class="input-group-addon btn btn-info" id="Efecha">
                                    <span class="glyphicon glyphicon-calendar" onclick="document.getElementById(\'fechaC\').focus()" ></span>
                                </span>';
                                ?>                             
                            </div>
                        </div>
                        <div class="form-group col-md-11" id="divfechaV">
                            <label class="control-label col-sm-3" for="fechaV"> Fecha de vencimiento </label>
                            <div class='input-group date col-sm-9' id='datetimepicker2'>
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
                                echo '  <input type="text" class="form-control " name="fecha" id="fechaV" value="' . $fecha . '">';
                                echo'                          
                                <span class="input-group-addon btn btn-info" id="Efecha">
                                    <span class="glyphicon glyphicon-calendar" onclick="document.getElementById(\'fechaV\').focus()" ></span>
                                </span> '
                                ?>    
                            </div>
                        </div>


                        <div class="Midiv">    
                            <button type="button" class="btn btn-info btn-circle btn-xl " data-toggle="modal" data-target="#modalagregarAdjunto" >Adjuntar archivo</button><br><br>
                            <button type="button" class="btn btn-success" > Agregar </button>
                            <button type="reset" class="btn btn-danger">Cancelar</button> 
                        </div>                                    
                    </form>

                </div> 
            </div>
        </div>

    </body>

</html>
