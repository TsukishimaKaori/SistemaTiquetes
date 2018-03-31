<?php
require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarAgregarActivos.php");
$tematicas = obtenerTematicasCompletasActivas();
session_start();
$r = $_SESSION['objetoUsuario'];
//if ($r == 'Ha ocurrido un error' || $r == null) {
//     //$r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//    $r = obtenerResponsable('dannyalfvr97@gmail.com'); //coordinador
//}


if (isset($_POST["Licencias"])) {  
    $licencias = json_decode($_POST['Licencias']);  
    $repuestos= json_decode($_POST['Repuestos']);  
    $placa=$_POST['placa'];
    $usuarioA=$_POST['usuarioA'];
    $serie=$_POST['serie'];
    $provedor=$_POST['provedor'];
    $modelo=$_POST['modelo'];
    $marca=$_POST['marca'];
//    agregarActivo($codigoArticulo, $correoUsuarioCausante, $nombreUsuarioCausante,
//            $bodega, $placa, $codigoCategoria, $serie, $proveedor, $modelo, $marca, 
//            $fechaExpiraGarantia, $correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado);
}
?>


