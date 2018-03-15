<?php

function comboTematicas($tematicas, $combo) {
    if ($combo == 'comboTematicasAgregar') {
        echo '<select class="form-control" id = "comboAgregarSubTematicas" >';
    } else if ($combo == 'comboTematicas') {
        echo '<select id = "comboTematicas" class="form-control" onchange = "tematicaSeleccionada(this);">';
    } else if ($combo == 'comboTematicasModificar') {
        echo '<select id = "comboTematicasModificar" class="form-control" >';
    }
    foreach ($tematicas as $tematica) {
        echo '<option  value="' . $tematica->obtenerDescripcionTematica() . '">' . $tematica->obtenerDescripcionTematica() . '</option>';
    }
    echo '</select>';
}

function cuerpoTablaSubTematicas($tematicas, $actual) {
//    if (isset($_POST['tematicaSeleccionada'])) {
//        $actual = $_POST['tematicaSeleccionada'];
//    }
    if ($actual == 'initCuerpoTematicas') {
        $codPadre = $tematicas[0]->obtenerCodigoTematica();
        $subtematicas = obtenerTematicasHijasCompletas($codPadre);
    } else {
        $subtematicas = $tematicas;
    }
    $i = 0;
    $contador = 1;

    foreach ($subtematicas as $tema) {
        echo '<tr><td>' . $tema->obtenerDescripcionTematica() . '</td>';
        echo '<td>';
        if ($tema->obtenerActivo() == 1) {  //Activo o inactivo           
            echo' <label class="btn btn-success" onclick="cambiarActivoSubTematica(this);" >Activo</label>';
            echo' <input type="hidden" name = "' . $tema->obtenerCodigoTematica() . '" id="' . $tema->obtenerCodigoTematica() . '" value="1">';
        } else {
            echo'  <label class="btn btn-danger" onclick="cambiarActivoSubTematica(this);" >Inactivo</label>';
            echo' <input type="hidden"  name = "act' . $tema->obtenerCodigoTematica() . '" id="' . $tema->obtenerCodigoTematica() . '" value="0">';
        }
        echo '</td>';
        echo '<td>';
        echo' <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal"  onclick = "modificarSubtematicaModal(this);"  ><i class=" glyphicon glyphicon-pencil"></i></button>';
        echo '</td>';
        echo '<td>';
        echo' <button type="button" class="btn btn-danger btn-circle btn-xl" onclick = "eliminarSubtematicaModal(this);" data-toggle="modal"  ><i class=" glyphicon glyphicon-minus"></i></button>';
        echo '</td>';
        echo '</tr>';
        $contador++;
        $i = $i + 1;
    }
}

function cambiarTematicasActivas($tematicas, $nombre, $activa) {
    $codiTematica = tematicaSeleccionada($tematicas, $nombre);
    $activa == 0 ? inactivarTematica($codiTematica) : activarTematica($codiTematica);
}

function tematicaSeleccionada($tematicas, $actual) {
    foreach ($tematicas as $tematica) {
        if ($tematica->obtenerDescripcionTematica() == $actual) {
            $a = $tematica->obtenerCodigoTematica(); ///////////cambiar
        }
    }
    return $a != null ? $a : $tematicas[0]->obtenerCodigoTematica(); //si no hay ninguna tematica, el agarra el codigo de la tematica en la posicion 0
}

//Retorna el codigo de la tematica. Recibe el nombre de la tematica
function tematicaSeleccionado($tematicas, $actual) {
    foreach ($tematicas as $tem) {
        if ($tem->obtenerDescripcionTematica() == $actual) {
            $a = $tem->obtenerCodigoTematica();
        }
    }
    return $a != null ? $a : $tematicas[0]->obtenerCodigoTematica(); //si no hay ningun rol, el agarra el codigo del rol en la posicion 0
}
