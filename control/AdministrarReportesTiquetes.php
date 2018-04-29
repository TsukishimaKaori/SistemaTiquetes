<?php

function comboAreas($areas) {
    echo '<select class="form-control" id = "comboAreas" onchange = "" >';
    foreach ($areas as $area) {
  echo '<option  id = "'.$area->obtenerCodigoArea().'"value="' . $area->obtenerNombreArea() . '">' . $area->obtenerNombreArea() . '</option>';
    }
    echo '</select>';
}

