<?php

require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosInventario.php");
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
    $repuestos = json_decode($_POST['Repuestos']);
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();

    $codigoArticulo = $_POST["codigo"];
    $placa = $_POST['placa'];
    $correoUsuarioAsociado = $_POST['usuarioA'];
    $serie = $_POST['serie'];
    $proveedor = $_POST['provedor'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $codigoCategoria = $_POST['codigoC'];
    $fechaExpiraGarantia = $_POST['fechaE'];

    $usuario = obtenerDatosUsuario($correoUsuarioAsociado);
    $nombreUsuarioAsociado = $usuario->obtenerNombreUsuario();
    $departamentoUsuarioAsociado = $usuario->obtenerDepartamento();
    $jefaturaUsuarioAsociado = $usuario->obtenerJefatura();

    agregarActivo($codigoArticulo, $correoUsuarioCausante, $nombreUsuarioCausante, "", $placa, $codigoCategoria, $serie, $proveedor, $modelo, $marca, $fechaExpiraGarantia, $correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado);

    foreach ($licencias as $licencia) {
        $fechaDeVencimiento = $licencia[0];
        $claveDeProducto = $licencia[1];
        $proveedor = $licencia[2];
        $descripcion = $licencia[3];
        agregarLicencia($fechaDeVencimiento, $claveDeProducto, $proveedor, $descripcion, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    }
    foreach ($repuestos as $repuesto) {
        $codigoArticulo=$repuesto[0];
        asociarRepuesto($codigoArticulo, $placa, $correoUsuarioCausante, $nombreUsuarioCausante, "");
    }
}
?>


