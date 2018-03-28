<?php

require_once ("../control/AdministrarTablaInventario.php");
require ("../modelo/ProcedimientosInventario.php");
if (isset($_POST['codigoActivo'])) {
    $codigo = $_POST['codigoActivo'];
    $activos = obtenerActivosFijos();
    panelActivos($activos, $codigo);
}

if (isset($_POST['codigoPasivo'])) {
    $codigo = $_POST['codigoPasivo'];
    $inventario = obtenerInventario();
    panelPasivos($inventario, $codigo);
}

if (isset($_POST['codigoSumarInventario'])) {
    $codigo = $_POST['codigoSumarInventario'];
    $inventario = obtenerInventario();
    panelSumarAInventario($inventario,$codigo);
}


if (isset($_POST['codigoAgregarInventario'])) {
    $codigo = $_POST['codigoAgregarInventario'];
    panelAgregarInventario();
}
