<?php

require_once ("../control/UsuarioLogueado.php");
require_once ("../control/AlertasConfirmaciones.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../control/AdministrarTablaInformacionTiquetes.php");
session_start();
$r = $_SESSION['objetoUsuario'];

//if ($r == 'Ha ocurrido un error' || $r == null) {
//    //$r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//    $r = obtenerResponsable('dannyalfvr97@gmail.com'); //coordinador
//}
// <editor-fold defaultstate="collapsed" desc="CLASIFICACION DE TIQUETES">
if (isset($_POST['codigoClasificacion'])) {
    $tematicas = obtenerTematicasCompletasActivas();
    $codTiquete = $_POST['codigoClasificacion'];
    $codigoNuevaClasificacion = $_POST['Clasificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    foreach ($tematicas as $Tematica) {
        if ($codigoNuevaClasificacion == $Tematica->obtenerDescripcionTematica()) {
            $codigoNuevaClasificacion = $Tematica->obtenerCodigoTematica();
            break;
        }
    }
    actualizarClasificacionTiquete($codTiquete, $codigoNuevaClasificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
}

if (isset($_POST['tiqueteExiste'])) {
    $codigo = $_POST['tiqueteExiste'];
    $codigoPagina = $_POST['codigoPagina'];
    $tiquetes = listaTiquetesCargar($codigoPagina, $r);
    $tiquete = tiquete($tiquetes, $codigo);
    if ($tiquete == null) {
        echo'No';
    } else {
        echo'Si';
    }
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="FECHA SOLICITADA">
if (isset($_POST['fechaSolicitada'])) {
    $codTiquete = $_POST['codigoFechaSolicitada'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $nuevaFechaSolicitada = $_POST['fechaSolicitada'];
    $dia = substr($nuevaFechaSolicitada, 0, 2);
    $mes = substr($nuevaFechaSolicitada, 3, 2);
    $anio = substr($nuevaFechaSolicitada, 6, 4);
    $nuevaFechaSolicitada = $anio . '-' . $mes . '-' . $dia;
    actualizarFechaSolicitada($codTiquete, $nuevaFechaSolicitada, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="FECHA entrada">
if (isset($_POST['codigoFechaEntrega'])) {
    $codTiquete = $_POST['codigoFechaEntrega'];
    $justificacion = $_POST['justificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $nuevaFechaSolicitada = $_POST['fechaEntrega'];
    $dia = substr($nuevaFechaSolicitada, 0, 2);
    $mes = substr($nuevaFechaSolicitada, 3, 2);
    $anio = substr($nuevaFechaSolicitada, 6, 4);
    $nuevaFechaSolicitada = $anio . '-' . $mes . '-' . $dia;
    actualizarFechaEntrega($codTiquete, $nuevaFechaSolicitada, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="COMENTARIOS Y ADJUNTOS">
// carga los adjuntos
if (isset($_POST['adjuntos'])) {
    $codTiquete = $_POST['adjuntos'];
    $comentarios = obtenerHistorialComentariosCompleto($codTiquete);
    agregarComentarios($comentarios, $r);
    //$correoAgregaAdjunto =$r->obtenerCorreo();
//    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
//     $subject ="Sistema de tiquetes: Nuevo documento adjuntado";
//     $message = $nombreUsuarioCausante."ha adjuntado un archivo";
//     $correoUsuarioAsignado = ""; //mandar el usuario que creo el tiquete**********************
    //enviarCorreo($correoUsuarioAsignado,$subject,$message);   
}

// agrega comentarios
if (isset($_POST['comentario'])) {
    $codigoT = $_POST['Mycodigo'];
    agregarAdjuntoComentario($codigoT, $r);
    $comentarios = obtenerHistorialComentariosCompleto($codigoT);
    $coment = $_POST['comentario'];
    agregarComentarios($comentarios, $r);
//    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
//    $subject ="Sistema de tiquetes: Nuevo comentario";
//    $message = $nombreUsuarioCausante."ha realizado un comentario";
//    $correoUsuarioAsignado = ""; //mandar el usuario que creo el tiquete**********************
    //enviarCorreo($correoUsuarioAsignado,$subject,$message);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="HORAS TRABAJADAS">
//// cambiar horas trabajadas
if (isset($_POST['horasTrabajadas'])) {
    $codTiquete = $_POST['codigoTiquete'];
    $nuevasHorasTrabajadas = $_POST['horasTrabajadas'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    actualizarHorasTrabajadas($codTiquete, $nuevasHorasTrabajadas, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="CONTROLES NAVEGACION ANTERIOR SIGUIENTE">
if (isset($_POST['anterior'])) {
    $anterior = $_POST['anterior'];
    $tiqueteActual = $_POST['codigoTiquete'];
    $codigoPagina = $_POST['codigoPagna'];
    $fechaI = $_POST['fechaI'];
    $fechaF = $_POST['fechaF'];
    $nuevo = $_POST['nuevo'];
    $asignado = $_POST['asignado'];
    $reasignado = $_POST['reasignado'];
    $proceso = $_POST['proceso'];
    $anulado = $_POST['anulado'];
    $finalizado = $_POST['finalizado'];
    $calificado = $_POST['calificado'];
    if (isset($_POST['codigoFiltroG'])) {
        $codigoFiltroG = $_POST['codigoFiltroG'];
        $nombreSG = $_POST['nombreSG'];
        $correoSG = $_POST['correoSG'];
        $nombreRG = $_POST['nombreRG'];
        $correoRG = $_POST['correoRG'];
    }
    $criterios = array();
    $criterios = [$nuevo, $asignado, $reasignado, $proceso, $anulado, $finalizado, $calificado];
    if ($codigoPagina == 4) {
        $codigoTiquete = tiqueteMostrarAnterior($codigoPagina, $r, $tiqueteActual, $fechaI, $fechaF, $criterios, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG);
    } else {
        $codigoTiquete = tiqueteMostrarAnterior($codigoPagina, $r, $tiqueteActual, $fechaI, $fechaF, $criterios, "", "", "", "", "");
    }
}

if (isset($_POST['siguiente'])) {
    $siguiente = $_POST['siguiente'];
    $tiqueteActual = $_POST['codigoTiquete'];
    $codigoPagina = $_POST['codigoPagna'];
    $fechaI = $_POST['fechaI'];
    $fechaF = $_POST['fechaF'];
    $nuevo = $_POST['nuevo'];
    $asignado = $_POST['asignado'];
    $reasignado = $_POST['reasignado'];
    $proceso = $_POST['proceso'];
    $anulado = $_POST['anulado'];
    $finalizado = $_POST['finalizado'];
    $calificado = $_POST['calificado'];
    if (isset($_POST['codigoFiltroG'])) {
        $codigoFiltroG = $_POST['codigoFiltroG'];
        $nombreSG = $_POST['nombreSG'];
        $correoSG = $_POST['correoSG'];
        $nombreRG = $_POST['nombreRG'];
        $correoRG = $_POST['correoRG'];
    }
    $criterios = array();
    $criterios = [$nuevo, $asignado, $reasignado, $proceso, $anulado, $finalizado, $calificado];
    if ($codigoPagina == 4) {
        $codigoTiquete = tiqueteMostrarSiguiente($codigoPagina, $r, $tiqueteActual, $fechaI, $fechaF, $criterios, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG);
    } else {
        $codigoTiquete = tiqueteMostrarSiguiente($codigoPagina, $r, $tiqueteActual, $fechaI, $fechaF, $criterios, "", "", "", "", "");
    }

    //tiqueteMostrarSiguiente($codigoPagina, $r, $tiqueteActual, $fechaI, $fechaF, $criterios);
}


if (isset($_POST['comboPaginas'])) {
    $tiqueteActual = $_POST['codigoTiquete'];
    $codigoPagina = $_POST['codigoPagna'];
    $criterios = '';
    $fechaI = '';
    $fechaF = '';
    $nuevo = '';
    $asignado = '';
    $reasignacion = '';
    $proceso = '';
    $anulado = '';
    $finalizado = '';
    $calificado = '';
    $codigoFiltroG = '';
    $nombreSG = '';
    $correoSG = '';
    $nombreRG = '';
    $correoRG = '';
    if (isset($_POST['$fechaI'])) {
        $fechaI = $_POST['$fechaI'];
        $fechaF = $_POST['$fechaF'];
        $nuevo = $_POST['$nuevo'];
        $asignado = $_POST['asignado'];
        $reasignacion = $_POST['$reasignacion'];
        $proceso = $_POST['proceso'];
        $anulado = $_POST['anulado'];
        $finalizado = $_POST['finalizado'];
        $calificado = $_POST['calificado'];

        if (isset($_POST['codigoFiltroG'])) {
            $codigoFiltroG = $_POST['codigoFiltroG'];
            $nombreSG = $_POST['nombreSG'];
            $correoSG = $_POST['correoSG'];
            $nombreRG = $_POST['nombreRG'];
            $correoRG = $_POST['correoRG'];
        }
//$criteriosDeFiltrado = array();
        $criterios = array();
        $criteriosDeFiltrado = [$nuevo, $asignado, $reasignacion, $proceso, $anulado, $finalizado, $calificado];
        $contador = 1;
        foreach ($criteriosDeFiltrado as $criterio) {
            if ($criterio == 'true') {
                $criterios[] = $contador;
            }
            $contador = $contador + 1;
        }
    }
    if ($codigoPagina == 4) {                     
                     $tiquetes = listaTiquetesCargarTodos($codigoPagina, $r, $fechaI, $fechaF, $criterios,$codigoFiltroG,$nombreSG,$correoSG,$nombreRG,$correoRG);
                } else {
                    $tiquetes = listaTiquetesCargar($codigoPagina, $r, $fechaI, $fechaF, $criterios);
                }
    tiqueteMostrarComboPaginas($codigoPagina, $r,$tiquetes);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="ASIGNACION RESPONSABLE">
if (isset($_POST['codigoAsignado'])) {
    $codTiquete = $_POST['codigoAsignado'];
    $codigoEmpleado = $_POST['Asignado'];
    $nombreEmpleadoAsignado = $_POST['nombreEmpleadoAsignado'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
    asignarTiquete($codTiquete, $codigoEmpleado, $correoUsuarioCausante, $nombreUsuarioCausante);
    $responsables = obtenerResponsablesAsignar($codigoArea);
    foreach ($responsables as $responsable) {
        if ($responsable->obtenerCodigoEmpleado() == $codigoEmpleado) {
            $correoUsuarioAsignado = $responsable->obtenerCorreo();
        }
    }
    $subject = "Nuevo tiquete asignado";
    $message = $nombreUsuarioCausante . " le ha asignado un nuevo tiquete";
    enviarCorreo($correoUsuarioAsignado, $subject, $message);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="PRIORIDAD">
if (isset($_POST['codigoPrioridad'])) {
    $codigoPrioridad = $_POST['codigoPrioridad'];
    $codTiquete = $_POST['codigoTiquete'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    actualizarPrioridad($codTiquete, $codigoPrioridad, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="reasignar ">
if (isset($_POST['codigoReasignar'])) {
    $codTiquete = $_POST['codigoReasignar'];
    $justificacion = $_POST['justificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $resutlado=  enviarAReasignarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
    echo $resultado;
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="en proceso ">
if (isset($_POST['codigoEnProceso'])) {
    $codTiquete = $_POST['codigoEnProceso'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $dia = substr($fechaEntrega, 0, 2);
    $mes = substr($fechaEntrega, 3, 2);
    $anio = substr($fechaEntrega, 6, 4);  
    $fechaEntrega = $anio . $mes  . $dia;
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    ponerTiqueteEnProceso($codTiquete, $fechaEntrega, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Anular">
if (isset($_POST['codigoAnular'])) {
    $codTiquete = $_POST['codigoAnular'];
    $justificacion = $_POST['justificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    anularTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Finalizar">
if (isset($_POST['codigoFinalizar'])) {
    $codTiquete = $_POST['codigoFinalizar'];
    $justificacion = $_POST['justificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $respuesta = finalizarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
    if($respuesta != ''){
        echo -1;
    }
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Reprocesar">
if (isset($_POST['codigoReprocesar'])) {
    $codTiquete = $_POST['codigoReprocesar'];
    $justificacion = $_POST['justificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    enviarAReprocesar($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Calificar">
if (isset($_POST['codigoCalificar'])) {
    $codTiquete = $_POST['codigoCalificar'];
    $justificacion = $_POST['justificacion'];
    $calificacion = $_POST['calificacion'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    calificarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante, $calificacion);
}   
// </editor-fold>
