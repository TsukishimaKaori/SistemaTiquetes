<?php
require_once ("../control/AdministrarTablaInventario.php");

if (isset($_POST['codigoActivo'])) {
    panelActivos();
}

if (isset($_POST['codigoPasivo'])) {
    panelPasivos();
}

if (isset($_POST['codigoLicencia'])) {
    panelLicencias();
}

if (isset($_POST['codigoRepuesto'])) {
    panelRepuestos();
}