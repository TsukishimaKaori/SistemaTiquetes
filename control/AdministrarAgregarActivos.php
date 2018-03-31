<?php
// <editor-fold defaultstate="collapsed" desc="Formulario">
function selectTiposActivos($responsables){      
        echo '<select class="selectpicker form-control" data-size="5" data-live-search="true"  id="Usuarios">';
    
    foreach ($responsables as $responsable) {
        echo '<option data-tokens="'. $responsable->obtenerNombreUsuario().'" value="' . $responsable->obtenerCorreo() . '" >' . $responsable->obtenerNombreUsuario() . '</option>';
    }
    echo '</select>';
}

function selectRepuestos($repuestos){
        echo '<select class="selectpicker form-control" data-size="5" data-live-search="true" multiple id="comboRepuestos">';
   
    foreach ($repuestos as $repuesto) {
        echo '<option  data-tokens="'. $repuesto->obtenerDescripcion().'" value="' . $repuesto->obtenerCodigoArticulo().'" >' . $repuesto->obtenerDescripcion(). '</option>';
    }
   
    echo '</select>';
    



}
// </editor-fold>