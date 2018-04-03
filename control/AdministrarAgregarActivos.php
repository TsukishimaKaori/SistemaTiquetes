<?php

require('../recursos/pdf/fpdf.php');

// <editor-fold defaultstate="collapsed" desc="Formulario">

function selectTiposActivos($responsables) {
    echo '<select class="selectpicker form-control" data-size="5" data-live-search="true"  id="Usuarios">';

    foreach ($responsables as $responsable) {
        echo '<option data-tokens="' . $responsable->obtenerNombreUsuario() . '" value="' . $responsable->obtenerCorreo() . '" >' . $responsable->obtenerNombreUsuario() . '</option>';
    }
    echo '</select>';
}

function selectRepuestos($repuestos) {
    echo '<select class="selectpicker form-control" data-size="5" data-live-search="true" multiple id="comboRepuestos">';

    foreach ($repuestos as $repuesto) {
        echo '<option  data-tokens="' . $repuesto->obtenerDescripcion() . '" value="' . $repuesto->obtenerCodigoArticulo() . '" >' . $repuesto->obtenerDescripcion() . '</option>';
    }

    echo '</select>';
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Contrato">
function generarPdf($placa) {
    $hoy = getdate();
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10)
        $mes = "0" . $mes;
    $dia = $hoy["mday"];
    if ($dia < 10)
        $dia = "0" . $dia;
    $fecha = $dia . "'" . $mes . "'" . $anio;
    
    $pdf = new FPDF();

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, utf8_decode('¡Contrato!'));
    $nombre=$placa."'".$fecha.".pdf";
    $url = "../adjuntos/contratos/".$nombre;
    $pdf->Output("F", $url);
    return $url;
}

// </editor-fold>