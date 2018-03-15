<?php
require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarTablaCreartiquete.php");
$tematicas = obtenerTematicasCompletasActivas();
session_start();
$r = $_SESSION['objetoUsuario'];
//if ($r == 'Ha ocurrido un error' || $r == null) {
//     //$r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//    $r = obtenerResponsable('dannyalfvr97@gmail.com'); //coordinador
//}


if (isset($_POST["nombre"])) {
    $mensaje = guardartiquete($r,$tematicas);
    if($mensaje!=''){
    echo 'error';
    
    }
}
?>
