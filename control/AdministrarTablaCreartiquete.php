<?php


$mensaje = "null";

function crearListatematicas($tematicas) {
    $vectematica = new ArrayObject();
    foreach ($tematicas as $Tematica) {
        if ($Tematica->obtenerCodigoPadre() == 0) {
            $vectematica[$count++] = $Tematica;
            $vectematica[$count++] = new ArrayObject();
        }
    } $count = 0;
    for ($i = 0; $i < count($vectematica); $i += 2) {
        foreach ($tematicas as $Tematica) {
            if ($Tematica->obtenerCodigoPadre() == $vectematica[$i]->obtenerCodigoTematica()) {
                $vectematica[$i + 1][$count++] = $Tematica;
            }
        }
        $count = 0;
    }


    return $vectematica;
}

function tematicasNivel1($listematicas) {
    $count = count($listematicas);
    for ($i = 0; $i < $count; $i += 2) {
        $nombreli = "toggleDemo" . $i;
        echo'<li class="list-group-item" id="primerNivel">
                        <a  data-toggle="collapse" data-target="#' . $nombreli . '" data-parent="#sidenav01" class="collapsed">
                            <label>' . $listematicas[$i]->obtenerDescripcionTematica() . ' </label>  <span class="caret pull-right"></span>
                        </a>
                        <div class="collapse" id="' . $nombreli . '" >
                            <ul class="nav nav-list">';
        subtematicas($listematicas[$i + 1]);
        echo' </ul>
                        </div>
                    </li>';
    }
}

function subtematicas($listematicas) {
    echo' <ul class = "nav nav-list">';
    $tematicasSize = count($listematicas);
    for ($i = 0; $i < $tematicasSize; $i++) {
        echo'<li class = "list-group-item " id="segundoNivel"><a onclick="actualizarTematica(this);" >' . $listematicas[$i]->obtenerDescripcionTematica() . '</a></li>';
    }
    echo'</ul>';
}

function guardartiquete($r,$tematicas) {
    $mensaje = 'error';
    $nombre = $_POST['nombre'];
    $miTematica = $_POST['clasificacion'];
    $fecha = $_POST['fecha'];
    $dia = substr($fecha, 0, 2);
    $mes = substr($fecha, 3, 2);
    $anio = substr($fecha, 6, 4);
   $fecha = $anio . '-' . $dia. '-' .$mes;
   //$fecha = $anio . '-' .$mes. '-'. $dia ;
    $cometario = $_POST['comentario'];
    $adjuno = '';
    $codigoT=null;
    if ($nombre == $r->obtenerNombreResponsable()) {
        $correoU = $r->obtenerCorreo();
        $nombreU= $r->obtenerNombreResponsable();
        foreach ($tematicas as $Tematica) {
            if ($miTematica == $Tematica->obtenerDescripcionTematica()) {
                $miTematica = $Tematica->obtenerCodigoTematica();
                $codigoT = agregarTiquete($correoU, $miTematica, $fecha, $cometario);
                break;
            }
        }
    }
    if ($codigoT != "No se ha podido crear el tiquete") {   
        $mensaje='';
        }
    
        if ($_FILES["archivo"] &&  $mensaje!= 'error') {
            $mensaje = 'error';
            $nombre_tmp = $_FILES["archivo"]["tmp_name"];
            // basename() puede evitar ataques de denegació del sistema de ficheros;
            // podría ser apropiado más validación/saneamiento del nombre de fichero
            $archivo = basename($_FILES["archivo"]["name"]);
            $adjuno = '..\\adjuntos\\' . $codigoT ."-". $archivo;
            move_uploaded_file($nombre_tmp, utf8_decode($adjuno));
            $mensaje = agregarAdjunto($codigoT, '', $correoU,$nombreU, $adjuno);
        }
    
    return $mensaje;
}

?>
