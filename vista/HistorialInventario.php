<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AdministrarHistorialInventario.php");
        require ("../control/AlertasConfirmaciones.php");
        ?>  
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <link href="../recursos/css/historialTiquetes.css" rel="stylesheet"/>  
        <script  type="text/javascript" src="../recursos/js/HistorialInventario.js"></script> 
    </head>
    <body>           
        <?php
        require ("../vista/Cabecera.php");
        if (isset($_GET['pagina'])) {
            $codigoPagina = $_GET['pagina'];
            $codigoDispositivo = $_GET['dispositivo'];

            if ($codigoPagina == 2) {
                $dispositivo = obtenerInventario();
                $bodega = $_GET['bodega'];
                $disp = obtenerArticuloFiltradoCodigoBodega($codigoDispositivo, $bodega);
                $historial = obtenerDetalleArticuloInventario($codigoDispositivo, $bodega);
                echo "<input type = 'hidden' id = 'bodega' value ='" . $bodega . "'>";
            } else if ($codigoPagina == 1) {
                $dispositivo = obtenerActivosFijos();
                $disp = obtenerActivosFiltradosPlaca($codigoDispositivo);
                $historial = obtenerHistorialActivosFijos($codigoDispositivo);
            }
        } else {
            $codigoPagina = 0;
        }
        echo "<input type = 'hidden' id = 'pagina' value ='" . $codigoPagina . "'>";

        echo "<input type = 'hidden' id = 'codigoDispositivo' value ='" . $codigoDispositivo . "'>";
        ?>  

        <section id = "seccionInventario" class ="container-fluid"> 
            <div class="row"> 
                <div class="col-md-2 " >
                    <?php
                    $direccion = "../vista/AdministrarInventario.php?tab=$codigoPagina";
                    echo '<a href =' . $direccion . '>
                        <button  onclick="" title="Regresar" type="button" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></button>
                    </a>';
                    echo ' </div> ';
                    if ($codigoPagina == 2) {
                        echo '    <div  class = "col-md-8"  ><h3>Registro de movimientos del artículo</h3></div>';
                    } else if ($codigoPagina == 1) {
                        echo '<div  class = "col-md-8"  ><h3>Registro de movimientos del activo</h3></div>';
                    }
                    ?>
                    <div  class = "col-md-2" style="text-align: right;"> 
                        <a>
                            <button type="button" class="btn btn-info" onclick="filtrosInventario()" >
                                <i class="glyphicon glyphicon-wrench"></i> &nbsp; Filtrar búsqueda</button>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div id="Filtros"></div>
                </div>
                <br>            

                <div class="row">
                    <div id = "cuerpoHistorialInventario" class="panel-body cuerpo-panel" >
<?php
if ($codigoPagina == 2) {
    historialInventario($historial, $disp);
} else if ($codigoPagina == 1) {
    historialActivos($historial, $disp);
}

notificacion();
?>
                    </div>  
                </div> 
        </section>
    </body>
</html>


