<?php
// <editor-fold defaultstate="collapsed" desc="Formulario">
function selectTiposActivos($responsables){      
        echo '<select class="form-control" id="Usuarios">';
    echo '<option value="" selected>' .'Selecione un Usuario'. '</option>';
    foreach ($responsables as $responsable) {
        echo '<option value="' . $responsable->obtenerCodigoEmpleado() . '" >' . $responsable->obtenerNombreUsuario() . '</option>';
    }
    echo '</select>';
}

function selectRepuestos($repuestos){
        echo '<select class="selectpicker"  data-live-search="true" multiple id="comboRepuestos">';
   
    foreach ($repuestos as $repuesto) {
        echo '<option  data-tokens="'. $repuesto->obtenerDescripcion().'" value="' . $repuesto->obtenerCodigoArticulo().'" >' . $repuesto->obtenerDescripcion(). '</option>';
    }
   
    echo '</select>';
    



}
// </editor-fold>