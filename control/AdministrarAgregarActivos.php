<?php
// <editor-fold defaultstate="collapsed" desc="Formulario">
function selectTiposActivos($responsables){      
        echo '<select class="form-control" id="comboTodosResponsables">';
    echo '<option value="" selected>' .'Selecione un Usuario'. '</option>';
    foreach ($responsables as $responsable) {
        echo '<option value="' . $responsable->obtenerCodigoEmpleado() . '" >' . $responsable->obtenerNombreResponsable() . '</option>';
    }
    echo '</select>';
}

// </editor-fold>