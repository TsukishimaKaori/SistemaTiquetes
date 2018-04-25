<html> 
    <head>   
        <meta charset="UTF-8">
        <?php
        require ("../modelo/Tematica.php");
        require ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AdministrarAgregarActivos.php");
        require ("../control/AlertasConfirmaciones.php");
        require ("../modelo/Cliente.php");
        ?>

        <link href="../recursos/css/AgregarActivos.css" rel="stylesheet"/>     
        <script  type="text/javascript" src="../recursos/js/AgregarActivos.js"></script> 
    </head>
    <body onload="CargarPagina()">
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
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
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-md-4" for="placa">'
                        . 'Código del equipo:</label><span id="codigoA" class=" col-md-8">' . $codigoArticulo . ' </span>  </div>';
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-md-4" for="placa">Descripción :</label>'
                        . '<span class=" col-md-8">' . $descripcionEquipo . ' </span> </div>';
                        echo'<div class="form-group  col-md-11"><label class="control-label  col-md-4" for="placa">Categoría :</label>'
                        . '<span class=" col-md-8" id="categoriaA" >' . $Categoria . ' </span> </div>';
                        ?>
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="placa">Placa:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="placa" type="text" required>
                            </div>
                        </div>                   
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="Usuarios">Usuario:</label>
                            <div class="col-md-10">
                                <?php
                                $responsables = consumirMetodoDos();
                                selectTiposActivos($responsables);
                                ?>
                            </div>
                        </div>                            
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="serie">Serie:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="serie" type="text" required>
                            </div>
                        </div>                         
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="modelo">Modelo:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="modelo" type="text" required>
                            </div>
                        </div>                         
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="fechaE">Expiración de garantía:</label>
                            <div class="col-md-10">
                                <div class='input-group date' id='datetimepicker1'>

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
                        </div>
                        <div class="form-group col-md-11">
                            <label class="control-label col-md-2" for="tiquete">codigo tiquete:</label>
                            <div class="col-md-10">
                                <div class="input-group date">
                                    <input type="text" class="form-control"  id="tiquete"   >
                                    <span class="input-group-addon  btn-info" id="tiquete" onclick="tiqueteActivo()" >
                                        <span class="glyphicon glyphicon-th-list"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="gafete">serie del docking:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="docking" type="text" required>
                            </div>
                        </div>
                        <div class="form-group  col-md-11">
                            <label class="control-label col-md-2" for="Asociado">el equipo cuenta con:</label>
                            <div class="col-md-10">
                                <textarea class="form-control" rows="3"  name="comentario" cols="2" id="Asociado"></textarea>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 "  >
                            <h5>Licencias: </h5>
                            <div class="list-group list-group-horizontal" id="divLicencias">

                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 "  >
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
                                <label class="control-label col-md-2" for="comboRepuestos">Repuestos:</label>
                                <button type='button' class='close' aria-label='Close' onclick='eliminarAgregarRepuestos()'> <span aria-hidden='true'>&times;</span></button>
                                <div class="col-md-10">
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
            <div class="modal-dialog modal-md">                
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
        <div id="modalaTiquetes" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >                
                <div class="modal-content" id="cuerpoModalToquetes">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Filtros tiquetes</h4>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="panel panel-primary"> 
                            <div class="panel-body">  
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <h5>Código:</h5>
                                        </div>                                     
                                        <div class="col-lg-2">
                                            <input class="form-control" id="codigoFiltro" >
                                        </div>
                                        <div class="col-lg-2"> 
                                            <h5>Correo Solicitante:</h5>
                                        </div>                                   
                                        <div class="col-lg-2">
                                            <input class="form-control" id="CorreoSFiltro" >
                                        </div>

                                        <div class="col-lg-2">
                                            <h5>Nombre Solicitante:</h5> 
                                        </div>
                                        <div class="col-lg-2">
                                            <input class="form-control" id="NombreSFiltro">
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-lg-2"> 
                                            <h5>Correo Responsable:</h5>
                                        </div>                                   
                                        <div class="col-lg-2">
                                            <input class="form-control" id="CorreoRFiltro" >
                                        </div>
                                        <div class="col-lg-2">
                                            <h5>Nombre Responsable:</h5> 
                                        </div>
                                        <div class="col-lg-2">
                                            <input class="form-control" id="NombreRFiltro">
                                        </div>

                                        <div class="col-lg-2">
                                            <h5>Fecha de inicio:</h5>
                                        </div>                                     
                                        <div class="col-lg-2  ">
                                            <div class = "form-group input-group date" id = "datetimepicker1">
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
                                                echo'<input id = "fechafiltroI" name ="filtro-fecha" type="text" class="  form-control" value="' . $fecha . '">
                                                <span class="input-group-addon btn btn-info"  for="filtro-fecha" onclick="document.getElementById(\'fechafiltroI\').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>';
                                                ?>
                                            </div>
                                        </div> 
                                    </div> 

                                    <div class="row">                                   

                                        <div class="col-lg-2">
                                            <h5>Fecha de final:</h5>
                                        </div>                                     
                                        <div class="col-lg-2  ">
                                            <div class = "form-group input-group date" id = "datetimepicker2">
                                                <?php
                                                echo'<input id = "fechafiltroF" name ="filtro-fecha" type="text" class="form-control" value="' . $fecha . '" >
                                                <span class="input-group-addon btn btn-info"  for="filtro-fecha" onclick="document.getElementById(\'fechafiltroF\').focus()">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-1  ">
                                            <h5>Estados:</h5>
                                        </div>
                                        <div class="col-lg-7  ">
                                            <?php
                                            $estados1 = obtenerEstados();
                                            comboEstadosActivos($estados1);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">&nbsp;</div>
                                    <div class="col-lg-12 form-group input-group boton-filtrar">
                                        <button class="btn btn-success" onclick="filtrartiquetesAjax()">Filtrar búsqueda</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <table class = "table tablasTiquetes table-responsive table-hover" id="tablaTiquetesA">
                            <thead>
                                <tr>                                            
                                    <th>Cod</th> 
                                    <th class ="thDescripcion">Descripción</th>
                                    <th>Solicitante</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Fecha entrega</th>
                                    <th>Calificación</th>                                    

                                </tr>                             
                            </thead>
                            <tbody id = "tbody-tablaTiquetesA"> 

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        confirmacion("confirmarAsociar", "¿Desea asociar  el equipo?", "agregarActivoAjax();", "");
        alerta("errorFormulario", "Faltan espacios por llenar", "");
        ?>
    </body>
</html>

