<?php
function fechaHoy() {    
    $fecha =date("d/m/Y");
    return $fecha;
}
function cabecera() {
    echo ' <tr>                                            
        <th>Cod</th> 
        <th class ="thDescripcion">Clasificación</th>
        <th>Solicitante</th>
        <th>Responsable</th>
        <th>Estado</th>
        <th>Calificacíon</th>
        <th>Fecha creacíon</th>     
        <th>Fecha entrega</th>
        <th>Puesto en proceso</th>
        <th>Fecha Finalizado</th>
                                        
       
        </tr> ';
}

function cuerpoTablaMistiquetesReporte($tiquetes) {

    foreach ($tiquetes as $tique) {
        echo '<tr>';
        echo '<td>' . $tique->obtenerCodigoTiquete() . '</td>';
        echo '<td>' . $tique->obtenerTematica()->obtenerDescripcionTematica() . '</td>';
        echo '<td>' . $tique->obtenerNombreUsuarioIngresaTiquete() . '</td>';
        if ($tique->obtenerResponsable() == null) {
            echo '<td>Por asignar</td>';
        } else {
            echo '<td>' . $tique->obtenerResponsable()->obtenerNombreResponsable() . '</td>';
        }
      echo '<td>' . $tique->obtenerEstado()->obtenerNombreEstado() . '</td>';
      if($tique->obtenerCalificacion()!=null){
      echo '<td>' . $tique->obtenerCalificacion() . '</td>';
      }else{
         echo '<td>Sin calificar</td>'; 
      }
    
      echo '<td>' . date_format($tique->obtenerFechaCotizado(), 'd/m/Y'). '</td>';
      if($tique->obtenerFechaEntrega()!=null){
      echo '<td>' . date_format($tique->obtenerFechaEntrega(), 'd/m/Y'). '</td>';
      }
      else{
          echo '<td>Por asignar</td>';
      }
      if($tique->obtenerFechaEnProceso()!=null){
           echo '<td>' . date_format($tique->obtenerFechaEnProceso(), 'd/m/Y'). '</td>';
      }
      else{
          echo '<td>Por procesar</td>';
      }
      if($tique->obtenerFechaFinalizado()!=null){
           echo '<td>' . date_format($tique->obtenerFechaFinalizado(), 'd/m/Y'). '</td>';
      }
      else{
          echo '<td>Por finalizar</td>';
      }
      
   
        echo '</tr>';
    }
}
