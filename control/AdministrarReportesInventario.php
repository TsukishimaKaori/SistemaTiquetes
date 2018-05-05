<?php

 function cuerpotablaInvetario($reportesInvetntario){ 
     foreach ($reportesInvetntario as $reporte) {
         echo'<tr>';
               echo  '<td>'.$reporte->obtenerCodigoArticulo().'</td>';
              echo   '<td>'.$reporte->obtenerDescripcion().'</td>';
               echo  '<td>'.$reporte->obtenerCategoria()->obtenerNombreCategoria().'</td>';
               echo  '<td>'.$reporte->obtenerCantidad().'</td>';
               echo  '<td>'.date_format($reporte->obtenerFechaUltimoIngreso(), 'd/m/Y') .'</td>';
              echo   '<td>'.date_format($reporte->obtenerFechaUltimoEgreso(), 'd/m/Y').'</td>';
        echo '</tr>';
     }       
     
 }
 
 function cuerpotablaMovimiento($reportesMovimientos){
    foreach ($reportesMovimientos as $reporte) {
         echo'<tr>';
               echo  '<td>'.date_format($reporte->obtenerFecha(), 'd/m/Y').'</td>';
              echo   '<td>'.$reporte->obtenerEfecto().'</td>';
               echo  '<td>'.$reporte->obtenerCodigoArticulo().'</td>';
                echo  '<td>'.$reporte->obtenerDescripcion().'</td>';
               echo  '<td>'.$reporte->obtenerCategoria()->obtenerNombreCategoria().'</td>';
               echo  '<td>'.$reporte->obtenerCantidadEfecto().'</td>';
              echo  '<td>'.$reporte->obtenerCosto().'</td>';
        echo '</tr>';
     }  
 }
function fechaHoy() {
    $hoy = getdate();
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10) {
        $mes = "0" . $mes;
    }
    $dia = $hoy["mday"];
    if ($dia < 10) {
        $dia = "0" . $dia;
    }
    $fecha = $dia . "/" . $mes . "/" . $anio;
    return $fecha;
}

function selectTipos($categorias,$numero) {
    if($numero==1){
    echo'<select id = "categoriaI" class="selectpicker form-control" data-size="5" data-live-search="true">';
    }else {
     echo'<select id = "categoriaM" class="selectpicker form-control  " data-size="5" data-live-search="true">';   
    }
    foreach ($categorias as $cat) {
        echo'<option data-tokens="' . $cat->obtenerNombreCategoria() . '" value = "' . $cat->obtenerNombreCategoria() . '">' . $cat->obtenerNombreCategoria() . '</option>';
    }
    echo'</select>';
}