<?php

require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosInventario.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarAgregarActivos.php");
require ("../modelo/Cliente.php");
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
    $categoria=$_POST['categoria'];
    $correoUsuarioAsociado = $_POST['usuarioA'];
    $serie = $_POST['serie'];
   // $proveedor = $_POST['provedor'];
    $modelo = $_POST['modelo'];
   // $marca = $_POST['marca'];
    $codigoCategoria = $_POST['codigoC'];
    $fechaExpiraGarantia = $_POST['fechaE'];
    $docking=$_POST['docking'];
    $asociados=$_POST['Asociado'];
    
    $codigoTiquete=$_POST['tiquete'];
    if($codigoTiquete==''){
        $codigoTiquete=null;
    }
    $fechaExpiraGarantia=explode("/", $fechaExpiraGarantia);
    $fechaExpiraGarantia=$fechaExpiraGarantia[2].$fechaExpiraGarantia[1].$fechaExpiraGarantia[0];
    $usuario = consumirMetodoUno($correoUsuarioAsociado);
    $gafete=$usuario->obtenerCodigoEmpleado();
    $nombreUsuarioAsociado = $usuario->obtenerNombreUsuario();
    $departamentoUsuarioAsociado = $usuario->obtenerDepartamento();
    $jefaturaUsuarioAsociado = $usuario->obtenerJefatura();
  
    $mensajeA = agregarActivo($codigoArticulo, $correoUsuarioCausante, $nombreUsuarioCausante, $placa, $codigoCategoria, $serie, $modelo, $fechaExpiraGarantia, $correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado, $codigoTiquete);
    $mensajeL = "nada";
    $mensajeR = "nada";
    if ($mensajeA == '') {
        foreach ($licencias as $licencia) {
            if ($mensajeL == '' || $mensajeL == "nada") {
                $fechaDeVencimiento = $licencia[0];
                $fechaDeVencimiento=explode("/", $fechaDeVencimiento);
                $fechaDeVencimiento=$fechaDeVencimiento[2].$fechaDeVencimiento[1].$fechaDeVencimiento[0];
                $claveDeProducto = $licencia[1];
                $proveedor = $licencia[2];
                $descripcion = $licencia[3];
                $mensajeL = agregarLicencia($fechaDeVencimiento, $claveDeProducto, $proveedor, $descripcion, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
            }
        }
        foreach ($repuestos as $repuesto) {
            if ($mensajeR == '' || $mensajeR == "nada") {
                $codigoArticulo = $repuesto[0];
                $mensajeR = asociarRepuesto($codigoArticulo, $placa, $correoUsuarioCausante, $nombreUsuarioCausante, "");
            }
        }
    }
    $direccionAdjunto="No";
    if ($mensajeA == '') {
        $direccionAdjunto = generarPdf($placa,$nombreUsuarioCausante,$nombreUsuarioAsociado,$categoria,$marca,$modelo,$docking,$asociados,$gafete);
        adjuntarContrato($placa, $direccionAdjunto, $correoUsuarioCausante, $nombreUsuarioCausante);
    }
    echo $mensajeA . "'" . $mensajeL . "'" . $mensajeR . "'".$direccionAdjunto."'";
}

if (isset($_POST['codigoFiltro'])) {
    $mitabla = $_POST['mitabla'];
    $codigoTiquete = $_POST['codigoFiltro'];
    $correoSolicitante = $_POST['correoS'];
    $nombreSolicitante = $_POST['nombreS'];
    $correoResponsable = $_POST['correoR'];
    $nombreResponsable = $_POST['nombreR'];
    $fechaInicio = $_POST['fechaI'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    $codigosEstados = $_POST['estados'];
    $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
    $codigoRol = $r->obtenerRol()->obtenerCodigoRol();
    $todosLosTiquetes = busquedaAvanzadaGeneral($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol);
    cuerpoTablaMistiquetesActivos($todosLosTiquetes, 4);
}
?>


