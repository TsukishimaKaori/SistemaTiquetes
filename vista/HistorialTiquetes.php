<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        require ("../control/AdministrarHistorialTiquetes.php");
        ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <script  type="text/javascript" src="../recursos/js/HistorialTiquetes.js"></script> 
        <link href="../recursos/css/historialTiquetes.css" rel="stylesheet"/>  
    </head>
    <body>           
        <?php
        require ("../vista/Cabecera.php");
        if (isset($_GET['fechaInicioFiltros'])) {
            $fechaI = $_GET['fechaInicioFiltros'];
            $fechaF = $_GET['fechaFinalizacionFiltros'];
            $nuevo = $_GET['nuevo'];
            $asignado = $_GET['asignado'];
            $reasignacion = $_GET['reasignacion'];
            $proceso = $_GET['proceso'];
            $anulado = $_GET['anulado'];
            $finalizado = $_GET['finalizado'];
            $calificado = $_GET['calificado'];
            $paginaPrincipal = $_GET['paginaPrincipal'];

            if (isset($_GET['codigoFiltroG'])) {
                $codigoFiltroG = $_GET['codigoFiltroG'];
                $nombreSG = $_GET['nombreSG'];
                $correoSG = $_GET['correoSG'];
                $nombreRG = $_GET['nombreRG'];
                $correoRG = $_GET['correoRG'];
                echo "<input type = 'hidden' id = 'codigoFiltroG' value = '" . $codigoFiltroG . "'></input>";
                echo "<input type = 'hidden' id = 'nombreSG' value = '" . $nombreSG . "'></input>";
                echo "<input type = 'hidden' id = 'correoSG' value = '" . $correoSG . "'></input>";
                echo "<input type = 'hidden' id = 'nombreRG' value = '" . $nombreRG . "'></input>";
                echo "<input type = 'hidden' id = 'correoRG' value = '" . $correoRG . "'></input>";
            }
//$criteriosDeFiltrado = array();
            $criterios = array();
            $criteriosDeFiltrado = [$nuevo, $asignado, $reasignacion, $proceso, $anulado, $finalizado, $calificado];
            $contador = 1;
            foreach ($criteriosDeFiltrado as $criterio) {
                if ($criterio == 'true') {
                    $criterios[] = $contador;
                }
                $contador = $contador + 1;
            }
            echo "<input type = 'hidden' id = 'filtroFechaI' value = '" . $fechaI . "'></input>";
            echo "<input type = 'hidden' id = 'filtroFechaF' value = '" . $fechaF . "'></input>";
            echo "<input type = 'hidden' id = 'filtroNuevo' value = '" . $nuevo . "'></input>";
            echo "<input type = 'hidden' id = 'filtroAsignado' value = '" . $asignado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroReasignado' value = '" . $reasignacion . "'></input>";
            echo "<input type = 'hidden' id = 'filtroProceso' value = '" . $proceso . "'></input>";
            echo "<input type = 'hidden' id = 'filtroAnulado' value = '" . $anulado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroFinalizado' value = '" . $finalizado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroCalificado' value = '" . $calificado . "'></input>";
            echo "<input type = 'hidden' id = 'paginaPrincipal' value = '" . $paginaPrincipal . "'></input>";
        }
        if (isset($_GET['tiquete']) && isset($_GET['pagina'])) {
            $codigoTiquete = $_GET['tiquete'];
            $codigoPagina = $_GET['pagina'];
            if (isset($_GET['paginaRegreso'])) {
                $paginaRegreso = $_GET['paginaRegreso'];
            } else {
                $paginaRegreso = 0;
            }
            echo "<input type = 'hidden' id = 'codigoPagina' value = '" . $codigoPagina . "'></input>";
            echo "<input type = 'hidden' id = 'codigoTique' value = '" . $codigoTiquete . "'></input>";

            echo "<input type = 'hidden' id = 'paginaRegreso' value = '" . $paginaRegreso . "'></input>";
            /* CodigoPagina corresponde a la pagina de donde se envia la solicitud
             * COdigoPagina = 1: Solicitud enviada desde TiquetesCreados
             * COdigoPagina = 2: Solicitud enviada desde AsginarTiquetes
             * COdigoPagina = 3: Solicitud enviada desde TiquetesCreados
             * COdigoPagina = 4: Solicitud enviada desde TodosLosTiquetes
             */
        }
        ?>  
        <section id = "seccionInfoTiquete" class ="container-fluid ocultarTiquetes"> 
            <div class="row"> 
                <div class="col-md-1 " >
                    <button  onclick="retornarABandejaDesdeHistorial();" title="Regresar" type="button" class="btn btn-info " data-toggle="modal" data-target=""><i class="glyphicon glyphicon-arrow-left"></i></button>
                </div>                            
            </div>
            <br>
              
            <div id = "divHistorialTiquete" class="row divHistorialTiquete divHistorialTiqueteHeader">
                <div class="col-md-5 " >  
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <span class="col-md-7"><h4>Historial del tiquete <?php echo $codigoTiquete ?></h4></span>                        
                                <span class="col-md-5 boton-filtrar">
                                    <button data-toggle="collapse" data-target="#indicadores" class="btn btn-info">Filtro indicadores</button>
                                </span>
                            </div>
                        </div>
                        <div id = "indicadores"class = "container-fluid collapse indicadorCheck">
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador1" class="form-check-input checkRemover" type="checkbox"  value="4">
                                    <label class="form-check-label" for="indicador1">Asigna responsable</label>                                
                                </div>
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador2" class="form-check-input checkRemover" type="checkbox" value="7">
                                    <label class="form-check-label" for="opcIndicador2">Cambio de clasificación</label>
                                </div>                         
                            </div>
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador3" class="form-check-input checkRemover" type="checkbox" id="indicador3" value="5">
                                    <label class="form-check-label" for="opcIndicador3">Cambio de fecha solicitada</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador4" class="form-check-input checkRemover" type="checkbox"  value="8">
                                    <label class="form-check-label" for="opcIndicador4">Cambio de prioridad</label>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador5" class="form-check-input checkRemover" type="checkbox"  value="2">
                                    <label class="form-check-label" for="opcIndicador5">Comentario o adjunto</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador6" class="form-check-input checkRemover" type="checkbox"value="6">
                                    <label class="form-check-label" for="opcIndicador6">Edita las horas trabajadas</label>
                                </div>
                            </div>
                            <div class="row">          
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador7" class="form-check-input checkRemover" type="checkbox" value="1">
                                    <label class="form-check-label" for="opcIndicador7">Enviado a reasignar</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador8" class="form-check-input checkRemover" type="checkbox" value="3">
                                    <label class="form-check-label" for="opcIndicador8">Genera contrato</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador9" class="form-check-input checkRemover" type="checkbox" value="9">
                                    <label class="form-check-label" for="opcIndicador9">Puesto en proceso</label>
                                </div>                                                    
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador10" class="form-check-input checkRemover" type="checkbox" value="10">
                                    <label class="form-check-label" for="opcIndicador10">Tiquete anulado</label>
                                </div>
                            </div>
                            <div class="row">         
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador11" class="form-check-input checkRemover" type="checkbox" value="12">
                                    <label class="form-check-label" for="opcIndicador11">Tiquete calificado</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador12" class="form-check-input checkRemover" type="checkbox"value="11">
                                    <label class="form-check-label" for="opcIndicador12">Tiquete finalizado</label>
                                </div>                                
                            </div> 
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador14" class="form-check-input checkRemover" type="checkbox" value="13">
                                    <label class="form-check-label" for="opcIndicador14">Cambio de fecha de entrega</label>
                                </div>   
                                <div class="form-check col-md-6">
                                    <input id = "opcIndicador15" class="form-check-input checkRemover" type="checkbox" value="13">
                                    <label class="form-check-label" for="opcIndicador15">Enviado a reprocesar</label>
                                </div>  
                            </div>                            
                            <div class="row">                                 
                                <div class="form-check col-md-7">
                                    <input id = "opcIndicador13" class="form-check-input checkRemover" type="checkbox" value="13">
                                    <label class="form-check-label" for="opcIndicador13">Mostrar todos</label>
                                </div>
                                <div class="col-md-2 boton-filtrar" style="padding: 1%;">
                                    <button class="btn btn-success" onclick ='filtroIndicadores()' >Filtrar búsqueda</button>
                                </div>
                            </div>
                        </div>
                        <div id = "cuerpoHistorialTiquete" class="panel-body cuerpo-panel" >   </div>
                    </div>
                </div>  
                <div id ="cuerpoHistorialInformacion"  class="col-md-7 " > </div>           
            </div>            
        </section>
    </body>
</html>


