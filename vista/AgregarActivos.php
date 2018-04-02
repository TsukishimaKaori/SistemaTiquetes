<html> 
    <head>   
        <meta charset="UTF-8">
        <?php require ("../modelo/Tematica.php"); ?>
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosInventario.php"); ?>
        <?php require ("../control/AdministrarAgregarActivos.php"); ?>
        <?php require ("../control/AlertasConfirmaciones.php"); ?>

        <link href="../recursos/css/AgregarActivos.css" rel="stylesheet"/>     
        <script  type="text/javascript" src="../recursos/js/AgregarActivos.js"></script> 
    </head>
    <body onload="CargarPagina()">

        <?php
        require ("../vista/Cabecera.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <link href="../recursos/bootstrap/css/bootstrap-select.min.css" rel="stylesheet"/>
        <script src="../recursos/bootstrap/js/bootstrap-select.min.js"></script>  

        <?php
        if (isset($_GET["codigoArticulo"])) {
            $codigoArticulo = $_GET["codigoArticulo"];
            $Categoria = $_GET["categoria"];
            $descripcionEquipo = $_GET["descripcion"];
            $CategoriaCodigo = $_GET["categoriaCodigo"];
            echo"<input type = 'hidden' id = 'codigoC' value = '" . $CategoriaCodigo . "'>";
        }
        ?>
        <div class="container " >
            <h1> Asociar equipo a usuario </h1>
            <form  >
                <div class="row" >
                    <div class="panel-heading col-md-offset-1"><h3>Detalles</h3></div>
                    <div id="panelInformacionDerecha"  class="panel-body col-md-offset-1"> 

                        <?php
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-sm-4" for="placa">'
                        . 'Código del equipo:</label><span id="codigoA" class=" col-md-8">' . $codigoArticulo . ' </span>  </div>';
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-sm-4" for="placa">Descripción :</label>'
                        . '<span class=" col-md-8">' . $descripcionEquipo . ' </span> </div>';
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-sm-4" for="placa">Categória :</label>'
                        . '<span class=" col-md-8" >' . $Categoria . ' </span> </div>';
                        ?>
                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="placa">Placa:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="placa" type="text" required>
                            </div>
                        </div>                   
                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="Usuarios">Usuario:</label>
                            <div class="col-sm-10">
                                <?php
                                $responsables = obtenerUsuariosParaAsociar();
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
                            <label class="control-label col-sm-2" for="provedor">Proveedor:</label>
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
                            <label class="control-label col-sm-2" for="marca">Marca:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="marca" type="text" required>
                            </div>
                        </div>  
                        <div class="  form-group  col-md-11">
                            <label class="control-label col-sm-3" for="fechaE">Expiración de garantía:</label>
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
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "  >
                            <h5>Licencias: </h5>
                            <div class="list-group list-group-horizontal" id="divLicencias">

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "  >
                            <h5>Repuestos: </h5>
                            <div class="list-group list-group-horizontal" id="divRepuestos">

                            </div>
                        </div>

                        <div class="form-group  col-md-11">
                            <button type="button" class="btn  btn-primary" onclick="FormularioLicencia()">Agregar Licencia</button> 
                            <button type="button" class="btn  btn-primary" onclick="FormularioRepuesto()">Agregar Repuesto</button> 
                        </div>
                        <div id="divAgregarRepuesto" class="form-group  col-md-11 divagregar">
                            <div class="form-group  col-md-11">
                                <label class="control-label col-sm-2" for="comboRepuestos">Repuestos:</label>
                                <button type='button' class='close' aria-label='Close' onclick='eliminarAgregarRepuestos()'> <span aria-hidden='true'>&times;</span></button>
                                <div class="col-sm-10">
                                    <?php
                                    $repuestos = obtenerRepuestosParaAsociar();
                                    selectRepuestos($repuestos);
                                    ?>
                                </div>
                            </div>
                            <button  id='aplicar' type='button' class='btn btn-success col-md-offset-2'  onclick='AgregarRepuesto()' > Aplicar </button>
                        </div>
                        <div id="divAgregar" class="form-group  col-md-11 divagregar">                                                  

                        </div>

                        <button type="button" class="btn btn-success col-md-offset-4" onclick="agregarActivo()" > Asociar equipo </button>
                        <button type="reset" class="btn btn-danger ">Cancelar</button> 
                    </div>
                </div>
            </form>

        </div>
          <div id="errorInfo" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div class="" style ="text-align: center" id="errorDiv"> 
                             
                            </div> 
                        </div>
                     </div>
                    <div class="modal-footer">
                        <button type="button" id="aceptar" class="btn btn-danger" data-dismiss="modal" > Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        confirmacion("confirmarAsociar", "¿Desea asociar  el equipos?", "agregarActivoAjax();", ""); 
        alerta("errorFormulario", "Faltan espacios por llenar", "");
        ?>
    </body>
</html>

