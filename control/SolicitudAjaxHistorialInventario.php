<?php

require ("../control/AdministrarHistorialInventario.php");
require ("../modelo/ProcedimientosInventario.php");
// <editor-fold defaultstate="collapsed" desc="Filtros">
if (isset($_POST['filtros'])) {
    $filtros = $_POST['filtros'];
    if ($filtros == 'true') {
        filtrosArticulos();
    } else {
        echo'';
    }
}

if (isset($_POST['codigoDispositivoInventario'])) {
    $codigoArticulo = $_POST['codigoDispositivoInventario'];
    $codigoBodega = $_POST['bodega'];
    $fechaInicio = $_POST['fechaI'];
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    $historial = obtenerDetalleArticuloInventarioFiltrado($codigoArticulo, $codigoBodega, $fechaInicio, $fechaFinal);
    if (count($historial) != 0) {
        historialInformacionInventarioPorElemento($historial);
    }else {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    }
}


if (isset($_POST['codigoDispositivoActivos'])) {
    $placa = $_POST['codigoDispositivoActivos'];
    $fechaInicio = $_POST['fechaI'];
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    $historial = obtenerHistorialActivosFijosFiltrado($placa, $fechaInicio, $fechaFinal);
      if (count($historial) != 0) {
          historialInformacionActivoPorElemento($historial);
    }else {
        echo '<h2 class="col-md-12 "  style = "color:black; text-align:center">No hay resultados que mostrar</h2> ';
    }
    
}

// </editor-fold>


