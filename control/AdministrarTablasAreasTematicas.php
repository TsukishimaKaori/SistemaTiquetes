<?php

$areas = obtenerAreas();//obtiene las areas activas
//$todasAreas = obtenerAreas(); //obtiene todas las areas
$mensaje = 'null';
$bandera = 0;

//-------------------------Carga los combos de áreas---------------------------
//Carga combo de selectores Modal
function comboAreas($areas, $combo) {
    opcionesSelect($combo); //arma la cabecera del select
    foreach ($areas as $area) { //Rellena los combos relacionados con las areas
        // if ($combo == 'comboAreas') {
        opcionesSeleccion($area, "");
        //} 
    }
    echo '</select>';
}

// Carga los combos de areas de la tabla de nivel1
function comboAreasTabla($areas, $tematica, $combo) {
    opcionesSelect($combo);
    foreach ($areas as $area) {
        if ($combo == 'comboAreasParaTematicas') { //Rellena el combo de la tabla tematicas de nivel1
            $tem = $tematica->obtenerCodigoTematica();
            $actual = obtenerAreaAsociadaTematica($tem)->obtenerNombreArea();
            opcionesSeleccion($area, $actual);
        }
    }
    echo '</select>';
}

//Creación de la cabecera de los comboBox.
function opcionesSelect($combo) {
    if ($combo == 'comboAreas') {
        echo '<select class="form-control" name ="' . $combo . '" id="' . $combo . '" >';
    } else if ($combo == 'comboAreasParaTematicas') {
        echo '<select class="form-control" onclick="guardarAnterior(this);" onchange="cambiarSeleccionAreaTablaNivel1(this);">';
    } else if ($combo == 'comboAreasAgregarTematicas') {
        echo '<select class="form-control " name ="' . $combo . '" id="' . $combo . '">';
    }
}

//Creación de las opciones de los comboBox.
function opcionesSeleccion($area, $actual) {
    if ($area->obtenerNombreArea() == $actual) {
        echo '<option  value="' . $area->obtenerNombreArea() . '" selected>' . $area->obtenerNombreArea() . '</option>';
    } else {
        echo '<option  value="' . $area->obtenerNombreArea() . '">' . $area->obtenerNombreArea() . '</option>';
    }
}

//Retorna el codigo del area. Recibe el nombre del area
function areaSeleccionada($areas, $actual) {
    foreach ($areas as $area) {
        if ($area->obtenerNombreArea() == $actual) {
            $a = $area->obtenerCodigoArea(); ///////////cambiar
        }
    }
    return $a != null ? $a : $areas[0]->obtenerCodigoArea(); //si no hay ningun rol, el agarra el codigo del rol en la posicion 0
}

function obtenerAreasActivas($areas) {
    foreach ($areas as $area) {
        if ($areas->obtenerAreaActiva() == 1) {
            $areasActivas[] = $area;
        }
    }
    return $areasActivas;
}

//Funcion que lista las areas  (llamada desde SolicitudAjaxUuariosRoles)
function tablaAreasActivas($todasAreas) {
    $contador = 1;
    foreach ($todasAreas as $area) {
        echo '<tr>';
        echo '<td>' . $area->obtenerNombreArea() . '</td>';
        echo '<td>';
        if ($area->obtenerAreaActiva() == 1) {  //Activo o inactivo           
            echo' <label for="act' . $contador . '" class="btn btn-success" onclick="cambiarActivo(this);"> Activo </label>';
            echo' <input type="hidden" name = "' . $area->obtenerCodigoArea() . '" id="' . $area->obtenerCodigoArea() . '" value="1">';
        } else {
            echo'  <label for="act' . $contador . '" class="btn btn-danger" onclick="cambiarActivo(this);"> Inactivo </label>';
            echo' <input type="hidden"  name = "act' . $area->obtenerCodigoArea() . '" id="' . $area->obtenerCodigoArea() . '" value="0">';
        }
        $contador++;
        echo '</td>';
        echo '<td>';
        echo' <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" onclick="validacionModificarArea(this);" ><i class=" glyphicon glyphicon-pencil"></i></button>';
        echo '</td>';
        echo '</tr>';
    }
}

function cambiarAreasActivas($areas, $nombre, $activa) {
    $codiArea = areaSeleccionada($areas, $nombre);
    $activa == 0 ? inactivarArea($codiArea) : activarArea($codiArea);
}

function cambiarTematicasActivas($tematicas, $nombre, $activa) {
    $codiTematica = tematicaSeleccionada($tematicas, $nombre);
    $activa == 0 ? inactivarTematica($codiTematica) : activarTematica($codiTematica);
}

//------------------Fin metodos relacionado con areas---------------------------
//Carga combo de tematicas
function comboTematicas($tematicas) {
    echo '<select id = "eliminarPorComboTematicas" class="form-control">';
    foreach ($tematicas as $tematica) {
        echo '<option  value="' . $tematica->obtenerDescripcionTematica() . '">' . $tematica->obtenerDescripcionTematica() . '</option>';
    }
    echo '</select>';
}

//Creacion del cuerpo de la tabla de tematicas activos o inactivos
function cuerpoTablaTematicasNivel1($tematicas, $areas) {
    foreach ($tematicas as $tema) {
        echo '<tr>';
        echo '<td>' . $tema->obtenerDescripcionTematica() . '</td>';
        echo '<td>';
        comboAreasTabla($areas, $tema, "comboAreasParaTematicas");
        echo '</td>';
        echo '<td>';
        if ($tema->obtenerActivo() == 1) {  //Activo o inactivo           
            echo' <label class="btn btn-success" onclick="cambiarActivoTematica(this);" >Activo</label>';
            echo' <input type="hidden" name = "' . $tema->obtenerCodigoTematica() . '" id="' . $tema->obtenerCodigoTematica() . '" value="1">';
        } else {
            echo'  <label class="btn btn-danger" onclick="cambiarActivoTematica(this);" >Inactivo</label>';
            echo' <input type="hidden"  name = "act' . $tema->obtenerCodigoTematica() . '" id="' . $tema->obtenerCodigoTematica() . '" value="0">';
        }
        echo '</td>';
        echo '<td>';
        echo' <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" onclick = "validacionModifcarTematica(this);" ><i class=" glyphicon glyphicon-pencil"></i></button>';
        echo '</tr>';
    }
}

//Retorna el codigo de la tematica. Recibe el nombre de la tematica
function tematicaSeleccionada($tematicas, $actual) {
    foreach ($tematicas as $tematica) {
        if ($tematica->obtenerDescripcionTematica() == $actual) {
            $a = $tematica->obtenerCodigoTematica(); ///////////cambiar
        }
    }
    return $a != null ? $a : $tematicas[0]->obtenerCodigoTematica(); //si no hay ninguna tematica, el agarra el codigo de la tematica en la posicion 0
}

//Funcion que actualiza el area de la tematica seleccionada
function actualizarAreaAsociadaTematicas($area, $areas, $tematica, $tematicas) {
    $codiTema = tematicaSeleccionada($tematicas, $tematica);
    $codiArea = areaSeleccionada($areas, $area);
    actualizarAreaAsociadaTematica($codiArea, $codiTema);
}

//---------------------POST con forms------------------------------------


function alertas() {
    global $bandera;
    global $mensaje;
    //Para el agregar areas
    if ($bandera == 1) { // 1: Trata de agregar un area que ya existe
        echo "<script> alert('" . $mensaje . "'); </script>";
    } else if ($bandera == 2) { //2: Agrega el area correctamente
        echo "<script> alert('Área agregada correctamente '); </script>";
    }
    //Para el eliminar roles
    else if ($bandera == 3) { //2: No permite eLimina el area correctamente
        echo "<script> alert('" . $mensaje . "'); </script>";
    } else if ($bandera == 4) { //2: Elimina el area correctamente
        echo "<script> alert('Area eliminada correctamente'); </script>";
    }
    $bandera = 0;
}
