<?php

require_once ("../control/UsuarioLogueado.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarTiquetesCreados.php");
session_start();
$r = $_SESSION['objetoUsuario'];

//if ($r == 'Ha ocurrido un error' || $r == null) {
//    //$r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//    $r = obtenerResponsable('dannyalfvr97@gmail.com'); //coordinador
//}


if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $correo = $r->obtenerCorreo();
    $Tiquetes = obtenerTiquetesPorUsuario($correo);
    agregarInformacion($Tiquetes, $codigo);
}

if (isset($_POST['adjuntos'])) {
    $codTiquete = $_POST['adjuntos'];
    $comentarios = obtenerHistorialComentariosCompleto($codTiquete);
    agregarComentarios($comentarios, $r);
}

if (isset($_POST['comentario'])) {
    $codigoT = $_POST['Mycodigo'];
    agregarAdjuntoComentario($codigoT, $r);
    $comentarios = obtenerHistorialComentariosCompleto($codigoT);
    $coment = $_POST['comentario'];
    agregarComentarios($comentarios, $r);
}
if (isset($_POST['fechaSolicitada'])) {
    $codTiquete = $_POST['codigoFechaSolicitada'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $nuevaFechaSolicitada = $_POST['fechaSolicitada'];
    $dia = substr($nuevaFechaSolicitada, 0, 2);
    $mes = substr($nuevaFechaSolicitada, 3, 2);
    $anio = substr($nuevaFechaSolicitada, 6, 4);
    //  $nuevaFechaSolicitada = $anio . '-' . $dia . '-' . $mes;
    $nuevaFechaSolicitada = $anio . '-' . $mes . '-' . $dia;
    actualizarFechaSolicitada($codTiquete, $nuevaFechaSolicitada, $correoUsuarioCausante, $nombreUsuarioCausante);
}



if (isset($_POST['AsignarTiquetes'])) {   
   $codTiquete=$_POST['AsignarTiquetes'];
    $codigoEmpleado = $_POST['codioResponsable'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();    
   $mensaje=asignarTiquete($codTiquete, $codigoEmpleado, $correoUsuarioCausante, $nombreUsuarioCausante);
    if($mensaje!=''){
    echo 'error';    
    }
}

if (isset($_POST['IniciarTiquetes'])) {
    $data = json_decode($_POST['IniciarTiquetes']);
    echo var_dump($data);
    $tamanioDatos = count($data);
    $explicacion = $data[0];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    for ($i = 1; $i < $tamanioDatos; $i++) {
        $codTiquete = $data[$i];
        ponerTiqueteEnProceso($codTiquete, $explicacion, $correoUsuarioCausante, $nombreUsuarioCausante);
    }
}



if (isset($_POST['tabla'])) {
    $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
    $responsables = obtenerResponsablesAsignar($codigoArea);
    if ($_POST['tabla'] == 'Creados') {
        $correo = $r->obtenerCorreo();
        $misTiquetes = obtenerTiquetesPorUsuario($correo);
        cuerpoTablaMistiquetesCreados($misTiquetes, 1,$responsables);
    }
    if ($_POST['tabla'] == 'PorAsignar') {   
        $codigoRol = $r->obtenerRol()->obtenerCodigoRol();          
        $tiquetesPorAsignar = obtenerTiqueteBandejaPorAsinar($codigoRol, $codigoArea);
        
        cuerpoTablaMistiquetesCreados($tiquetesPorAsignar, 2,$responsables);
    }

    if ($_POST['tabla'] == 'Asignados') {
        $codigoEmpleado = $r->obtenerCodigoEmpleado();
        $misTiquetesAsignados = obtenerTiquetesAsignados($codigoEmpleado);
        cuerpoTablaMistiquetesCreados($misTiquetesAsignados, 3,$responsables);
    }
//    if ($_POST['tabla'] == 'TodosLosTiquetes') {
//        $todosLosTiquetes = obtenerTodosLosTiquetes();
//        cuerpoTablaMistiquetesCreados($todosLosTiquetes, 4);
//    }
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
    $responsables = obtenerResponsablesAsignar($codigoArea);


    if ($mitabla == "Creados") {
        $correo = $r->obtenerCorreo();
        $todosLosTiquetes = tiquetesPorUsuarioAvanzada($correo, $fechaInicio, $fechaFinal, $codigosEstados);
        cuerpoTablaMistiquetesCreados($todosLosTiquetes, 1,$responsables);
    }
    if ($mitabla == "Asignados") {
        $codigo = $r->obtenerCodigoEmpleado();
        $todosLosTiquetes = tiquetesAsignadosAvanzada($codigo, $fechaInicio, $fechaFinal, $codigosEstados);
        cuerpoTablaMistiquetesCreados($todosLosTiquetes, 3,$responsables);
    }
    if ($mitabla == "TodosLosTiquetes") {
        $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
        $codigoRol = $r->obtenerRol()->obtenerCodigoRol();
        $todosLosTiquetes = busquedaAvanzadaGeneral($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol);
        cuerpoTablaMistiquetesCreados($todosLosTiquetes, 4,$responsables);
    }
}

if (isset($_POST['botones'])) {
    agregabotones($_POST['botones']);
}


// <editor-fold defaultstate="collapsed" desc="Calificar">
if (isset($_POST['codigoCalificar'])) {
    $codTiquete = $_POST['codigoCalificar'];
    $justificacion = $_POST['justificacion'];
    $calificacion = $_POST['calificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje=calificarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante, $calificacion);
    echo $mensaje;
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Filtros">
if (isset($_POST['filtros'])) {
    $filtros = $_POST['filtros'];
    $mitabla = $_POST['mitabla'];
    if ($filtros == 'true') {
        filtros($mitabla);
    } else {
        echo'';
    }
}
// </editor-fold>