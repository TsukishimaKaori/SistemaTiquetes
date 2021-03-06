<?php

function comboAreas($areas) {
    echo '<select class="form-control" id = "comboAreasReportes" onchange = "" >';
    foreach ($areas as $area) {
        echo '<option  id = "' . $area->obtenerCodigoArea() . '"value="' . $area->obtenerCodigoArea() . '">' . $area->obtenerNombreArea() . '</option>';
    }
    echo '</select>';
}

function comboAnios($anios) {
    echo '<select class="form-control" id = "comboAnios" onchange = "" >';
    echo '<option  id = "" value="" selected>2015</option>';
    echo '<option  id = "" value="">2016</option>';
    echo '<option  id = "" value="">2017</option>';
    echo '<option  id = "" value="">2018</option>';
    echo '<option  id = "" value="">2019</option>';
    echo '<option  id = "" value="">2020</option>';
    // foreach ($areas as $area) {
    // echo '<option  id = "'.$area->obtenerCodigoArea().'"value="' . $area->obtenerNombreArea() . '">' . $area->obtenerNombreArea() . '</option>';
    // }
    echo '</select>';
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

function anioActual() {
    $hoy = getdate();
    $anio = $hoy["year"];
    return $anio;
}

function reportesCalificacionesPorArea($calificaciones) {
    foreach ($calificaciones as $califica) {
        echo '<tr>';
        echo '<td id = "codigoAreaCalificacion">' . $califica->obtenerCodigoArea() . '</td>';
        echo '<td id = "nombreAreaCalificacion">' . $califica->obtenerNombreArea() . '</td>';
        echo '<td>' . $califica->obtenerPromedioCalificiones() . '</td>';
        echo '<td><button onclick = "abrirModalCalificacionesEmpleados();" class = "btn btn-info"><i class = "glyphicon glyphicon-eye-open"></i></button></td>';
        echo '</tr>';
    }
}
