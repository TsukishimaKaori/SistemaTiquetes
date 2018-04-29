<?php

function comboAreas($areas) {
    echo '<select class="form-control" id = "comboAreas" onchange = "" >';
    foreach ($areas as $area) {
  echo '<option  id = "'.$area->obtenerCodigoArea().'"value="' . $area->obtenerNombreArea() . '">' . $area->obtenerNombreArea() . '</option>';
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


