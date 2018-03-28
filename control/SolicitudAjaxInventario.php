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

if (isset($_POST['codigoSumarInventario'])) {
    $codigo = $_POST['codigoSumarInventario'];
    panelSumarAInventario();
}


if (isset($_POST['codigoAgregarInventario'])) {
    $codigo = $_POST['codigoAgregarInventario'];
    panelAgregarInventario();
}
