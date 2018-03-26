<?php

require_once ("../control/AdministrarTablaInventario.php");
require ("../modelo/ProcedimientosInventario.php");
if (isset($_POST['codigoActivo'])) {
    $codigo = $_POST['codigoActivo'];
    $activos = obtenerEquiposActivos();
    panelActivos($activos,$codigo);
}

if (isset($_POST['codigoPasivo'])) {
    $codigo = $_POST['codigoPasivo'];
    $pasivos = obtenerEquiposPasivos();
    panelPasivos($pasivos,$codigo);
}

if (isset($_POST['codigoLicencia'])) {
      $codigo = $_POST['codigoLicencia'];
    $licencias = obtenerLicencias();
    panelLicencias($licencias,$codigo);
}

if (isset($_POST['codigoRepuesto'])) {
    $codigo = $_POST['codigoRepuesto'];
    $repuestos = obtenerRepuestos();
    panelRepuestos($repuestos,$codigo);
}