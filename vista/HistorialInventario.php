<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AdministrarHistorialInventario.php");
        ?>  
        <link href="../recursos/css/historialTiquetes.css" rel="stylesheet"/>  
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
            } else if ($codigoPagina == 1) {
                $dispositivo = obtenerActivosFijos();
                $disp = obtenerActivosFiltradosPlaca($codigoDispositivo);
                $historial = obtenerHistorialActivosFijos($codigoDispositivo);
            }
        } else {
            $codigoPagina = 0;
        }
        ?>  
        <section id = "seccionInventario" class ="container-fluid"> 
            <div class="row"> 
                <div class="col-md-1 " >
                    <?php
                    $direccion = "../vista/AdministrarInventario.php?tab=$codigoPagina";
                    echo '<a href =' . $direccion . '>
                        <button  onclick="" title="Regresar" type="button" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></button>
                    </a>';
                    ?>
                </div>                            
            </div>
            <br> 
            <div id = "cuerpoHistorialInventario" class="panel-body cuerpo-panel" >
                <?php
                if ($codigoPagina == 2) {
                    historialInventario($historial, $disp);
                } else if ($codigoPagina == 1) {
                    historialActivos($historial, $disp);
                }   
                
                
                
                
                ?>
            </div>            
        </section>
    </body>
</html>


