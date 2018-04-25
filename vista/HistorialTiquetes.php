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
        <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>        
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
                <div class="col-md-2 " >
                    <button  onclick="retornarABandejaDesdeHistorial();" title="Regresar" type="button" class="btn btn-info " data-toggle="modal" data-target=""><i class="glyphicon glyphicon-arrow-left"></i></button>
                </div>                  
            </div>
            <br> 
            <div id = "cuerpoHistorialTiquete" class="panel-body cuerpo-panel" >   </div>
        </div>
    </div>  
    <div id ="cuerpoHistorialInformacion" class="col-md-7 " > </div>           
</div>            
</section>
</body>
</html>


