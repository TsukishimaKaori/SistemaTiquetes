<?php

function selectEstado($estados) {
    echo'<select id = "estado" class="selectpicker form-control" data-size="5" data-live-search="true">';
    foreach ($estados as $est) {
        echo'<option data-tokens="' . $est . '" value = "' . $est . '">' . $est . '</option>';
    }
    echo'</select>';
}

function cuerpoTablaReportes($tiquetes) {

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
        echo '<td onclick="mostrarDetalleTIquetes(' . $tique->obtenerCodigoTiquete() . ');">' . '<button type="button" class="btn btn-info">
               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
        echo '</tr>';
    }
}

function cuerpoTablaReportesAjax($tiquetes) {
    $string = "";
    foreach ($tiquetes as $tique) {
        $string = $string . '<tr>';
        $string = $string . '<td>' . $tique->obtenerCodigoTiquete() . '</td>';
        $string = $string . '<td>' . $tique->obtenerTematica()->obtenerDescripcionTematica() . '</td>';
        $string = $string . '<td>' . $tique->obtenerNombreUsuarioIngresaTiquete() . '</td>';
        if ($tique->obtenerResponsable() == null) {
            $string = $string . '<td>Por asignar</td>';
        } else {
            $string = $string . '<td>' . $tique->obtenerResponsable()->obtenerNombreResponsable() . '</td>';
        }
        $string = $string . '<td onclick="mostrarDetalleTIquetes(' . $tique->obtenerCodigoTiquete() . ');">' . '<button type="button" class="btn btn-info">
               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
        $string = $string . '</tr>';
    }
    return $string;
}

function CantidadInfo($cantidad) {

    echo'  <h4>Cantidad de tiquetes: ' . $cantidad . ' </h4>';
}

function CantidadInfoAJAX($cantidad) {

    return '  <h4>Cantidad de tiquetes: ' . $cantidad . ' </h4>';
}

function detalleTiquete($tiquete) {
    echo'<div id="graficoRendimientoPorArea" class="panel panel-default grafico"  >
             <div class="container-fluid panel-heading">
                <h3>Detalle del tiquete</h3>
                <div class="row"> 
                    <div class="col-md-3 encabezado">
                       <h5 class="panel-title">Codigo: '.$tiquete->obtenerCodigoTiquete() .'</h5>                                        
                    </div>
                    <div class="col-md-6 encabezado encabezadoDescripcion" >
                        <h5 class="panel-title">'. descripcionTematica($tiquete) .'</h5>
                     </div>
                </div>
            </div> 
            <div class="panel-body">
             <div class="row"> <h4 class="col-md-3">Solicitante:</h4></div> 
                                <div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class=" col-md-8">
                                        <h5> ' . $tiquete->obtenerNombreUsuarioIngresaTiquete() . '</h5>
                                    </div> 
                                </div>
                                <div class="row "> 
                                    <h5 class="col-md-3 ">Correo:</h5> 
                                    <div class=" col-md-8">
                                        <h5>' . $tiquete->obtenerCodigoUsuarioIngresaTiquete() . '</h5>
                                    </div> 
                                </div> 
                                <div class="row "><h4 class="col-md-3">Responsable:</h4> </div>
                                <div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class="col-md-8">
                                        <h5>' . nombreResponsable($tiquete) . '</h5>
                                    </div> 
                                </div> 
                                <div class="row ">
                                    <h5 class="col-md-3 ">Correo:</h5> 
                                    <div class="col-md-8">
                                        <h5>' . correoResponsable($tiquete) . '</h5>
                                    </div> 
                                </div> 
                                <div class="row "><h4 class="col-md-3">información:</h4> </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Creado el:</h5> 
                                    <div class=" col-md-8">                                        
                                        <h5>'.fechaCreacionTiquete($tiquete).'</h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Solicitado para:</h5> 
                                    <div class=" col-md-8">'.
                 fechaSolicitudTiquete($tiquete, $codigoPagina)
                                   .' </div>
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Fecha entrega:</h5> 
                                    <div class=" col-md-8">'.
                 fechaEntregaTiquete($tiquete, $codigoPagina)
                                   .' </div>
                                </div> 
                                <div class="row ">
                                    <h5 class="col-md-3"> Descripción:</h5>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="3"  id="descripcion" readonly="readonly">'. descripcionTiquete($tiquete).' </textarea>
                                    </div>
                                </div>

         </div>'
    . '</div>';
}

function nombreResponsable($tiquete) {
    if ($tiquete->obtenerResponsable() != null) {
        return $tiquete->obtenerResponsable()->obtenerNombreResponsable();
    } else {
        return "No hay un responsable asignado";
    }
}

function correoResponsable($tiquete) {
    if ($tiquete->obtenerResponsable() != null) {
        return $tiquete->obtenerResponsable()->obtenerCorreo();
    }
}
function descripcionTematica($tiquete) {
    return $tiquete->obtenerTematica()->obtenerDescripcionTematica();
}
function descripcionTiquete($tiquete) {
    return $tiquete->obtenerDescripcion();
}
function fechaCreacionTiquete($tiquete) {
    return date_format($tiquete->obtenerFechaCreacion(), 'd/m/Y ');
}
function fechaSolicitudTiquete($tiquete, $codigoPagina) {

        return "<h5>" . date_format($tiquete->obtenerFechaCotizado(), 'd/m/Y') . "</h5>";
    
}

function fechaFinalizadoTiquete($tiquete) {
    if ($tiquete->obtenerFechaFinalizado() != null) {
        return'  <input  type="text" class="form-control" name="tematica" id="finalizado"  '
        . 'value="' . date_format($tiquete->obtenerFechaFinalizado(), 'd/m/Y ') . '" readonly="readonly">';
    } else
        return'Tiquete no finalizado aún';
}

function fechaEntregaTiquete($tiquete, $codigoPagina) {
    if ($tiquete->obtenerFechaEntrega() != null) {
        
            return "<h5>" . date_format($tiquete->obtenerFechaEntrega(), 'd/m/Y') . "</h5>";
        
    } else
        return'Sin fecha aún';
}