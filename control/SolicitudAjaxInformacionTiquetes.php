<?php

require_once ("../control/UsuarioLogueado.php");
require_once ("../control/AlertasConfirmaciones.php");
require ("../modelo/ProcedimientosTiquetes.php");
require ("../modelo/ProcedimientosInventario.php");
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
    if (isset($_POST['fechaI'])) {
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $nuevo = $_POST['nuevo'];
        $asignado = $_POST['asignado'];
        $reasignacion = $_POST['reasignado'];
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
        $tiquetes = listaTiquetesCargarTodos($codigoPagina, $r, $fechaI, $fechaF, $criterios, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG);
    } else {
        $tiquetes = listaTiquetesCargar($codigoPagina, $r, $fechaI, $fechaF, $criterios);
    }
    tiqueteMostrarComboPaginas($codigoPagina, $r, $tiquetes);
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
    $resutlado = enviarAReasignarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante);
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
    $fechaEntrega = $anio . $mes . $dia;
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
    if ($respuesta != '') {
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
// <editor-fold defaultstate="collapsed" desc="Asociar equipo">
if (isset($_POST['filtrarActivo'])) {
    $placa = $_POST['filtrarActivo'];
    $nombreCategoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $nombreUsuario = $_POST['usuario'];
    $correoUsuario = $_POST['correo'];
    $codigoEstado = $_POST['estado'];
    $activos = busquedaAvanzadaActivos($placa, $codigoEstado, $nombreCategoria, $marca, $nombreUsuario, $correoUsuario);
    if ($activos === 'Ha ocurrido un error al obtener los activos') {
        echo'Error';
    } else {
        cuerpoTablaActivosTiquetes($activos);
    }
}

if (isset($_POST['asociarPlaca'])) {
    $placa = $_POST['asociarPlaca'];
    $codigoTiquete = $_POST['codigoTiquete'];
    $activos = obtenerActivosAsociadosTiquete($codigoTiquete);
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = '';
    if ($activos[0] != null) {
        $mensaje = desasociarTiqueteActivo($activos[0]->obtenerPlaca(), $correoUsuarioCausante, $nombreUsuarioCausante, $codigoTiquete);
    }
    if ($mensaje == '') {
        $mensaje = asociarTiqueteActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante, $codigoTiquete);
    }
    echo $mensaje;
}

if (isset($_POST['desasociarPlaca'])) {
    $placa = $_POST['desasociarPlaca'];
    $codigoTiquete = $_POST['codigoTiquete'];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = desasociarTiqueteActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante, $codigoTiquete);
    echo $mensaje;
}


// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="infotiquete">
if (isset($_POST['extra'])) {

    if (isset($_POST['tiquete']) && isset($_POST['pagina'])) {
        $codigoTiquete = $_POST['tiquete'];
        $codigoPagina = $_POST['pagina'];
        echo"<input type = 'hidden' id = 'codigoPagina' value = '" . $codigoPagina . "'></input>";
        echo "<input type = 'hidden' id = 'codigoTique' value = '" . $codigoTiquete . "'></input>";
        /* CodigoPagina corresponde a la pagina de donde se envia la solicitud
         * COdigoPagina = 1: Solicitud enviada desde TiquetesCreados
         * COdigoPagina = 2: Solicitud enviada desde AsginarTiquetes
         * COdigoPagina = 3: Solicitud enviada desde TiquetesCreados
         * COdigoPagina = 4: Solicitud enviada desde TodosLosTiquetes
         */
    }


    if ($codigoPagina != 1) {
        if ($codigoPagina == 2) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 6)) {
                header('Location: ../vista/Error.php');
            }
        }
        if ($codigoPagina == 3) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 7)) {
                header('Location: ../vista/Error.php');
            }
        }
        if ($codigoPagina == 4) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 8)) {
                header('Location: ../vista/Error.php');
            }
        }
    }

    $tiquete = obtenerTiqueteFiltradoCodigo($codigoTiquete);

    echo' <h3 style = "text-align: center;">Administrador de tiquetes</h3>'
    . ' <section class ="container-fluid"> '
    . ' <div class="row"> '
    . ' <div class="col-md-4 " >'
    . '<button  onclick="retornarABandeja();" title="Regresar" type="button" class="btn btn-info " data-toggle="modal" data-target=""><i class="glyphicon glyphicon-arrow-left"></i></button>'
    . ' </div>'
    . ' <div class="  col-md-1" style="text-align: right;">'
    . ' <button title="Tiquete anterior" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick="tiqueteAnterior();"><i class="glyphicon glyphicon-triangle-left"></i></button>'
    . '</div>'
    . ' <div class=" col-md-2">';
    echo descripcionPagina($codigoPagina, $r);

    echo'  </div>'
    . '<div class="col-md-1"> '
    . ' <button  title="Siguiente Tiquete" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick=" tiqueteSiguiente();"><i class="glyphicon glyphicon-triangle-right"></i></button>'
    . ' </div>'
    . '</div>'
    . '<div class="row">';
    echo codigoPagina($codigoPagina);
    echo' <br>'
    . ' </div> '
    . '  </section>'
    . ' <section id = "seccionInfoTiquete" class ="container-fluid ocultarTiquetes">'
    . ' <div class="row">'
    . '<div class="col-md-6">  ';
    echo panelDeCabecera($tiquete);
    echo'<div class="panel-heading panel-success">'
    . ' <div class="row">'
    . ' <div class="col-md-3 encabezado">'
    . '<h5 class="panel-title" value = "<?php codigoTiquete($tiquete); ?>">Codigo: ';
    echo codigoTiquete($tiquete) . '</h5> '
    . ' </div>'
    . '<div class="col-md-6 encabezado encabezadoDescripcion" >'
    . '<h5 class="panel-title">';
    echo descripcionTematica($tiquete) . '</h5>'
    . '</div>'
    . '<div class="col-md-3 encabezado encabezadoDescripcion" >'
    . ' <button class = "btn btn-warning" onclick ="mostrarHistorialTiquetes();"><i class = "glyphicon glyphicon-list-alt"> Historial</i></button>'
    . '</div>'
    . '</div>'
    . '</div>'
    . ' <div class="panel-body">'
    . ' <div class="row"> <h4 class="col-md-3">Solicitante:</h4></div>'
    . '<div class="row ">'
    . '<h5 class="col-md-3 ">Nombre:</h5> '
    . '<div class=" col-md-8">'
    . '<h5> ';
    echo nombreSolicitante($tiquete) . '</h5>'
    . '</div> '
    . ' </div>'
    . ' <div class="row "> '
    . ' <h5 class="col-md-3 ">Correo:</h5>'
    . ' <div class=" col-md-8">'
    . ' <h5>';
    echo correoSolicitante($tiquete) . '</h5>'
    . ' </div> '
    . ' </div> '
    . '<div class="row ">'
    . '<h5 class="col-md-3 ">Jefatura:</h5>'
    . '<div class="col-md-8">'
    . '<h5>';
    echo jefaturaSolicitante($tiquete) . '</h5>'
    . ' </div> '
    . ' </div>'
    . '<div class="row "> '
    . ' <h5 class="col-md-3 ">Departamento:</h5> '
    . '<div class="col-md-8">'
    . ' <h5>';
    echo departamentoSolicitante($tiquete) . '</h5>'
    . ' </div> '
    . ' </div> '
    . '<div class="row "><h4 class="col-md-3">Responsable:</h4> </div>'
    . '<div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class="col-md-8">'
    . '<h5>';
    echo nombreResponsable($tiquete) . '</h5>'
    . ' </div> 
                                </div> 
                                <div class="row ">
                                    <h5 class="col-md-3 ">Correo:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php correoResponsable($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3 ">Horas trabajadas:</h5> 
                                    <div class=" col-md-8">'
    . '<h5>';
    echo horasTrabajadas($tiquete, $codigoPagina) . '</h5>'
    . '</div>       
                                </div>

                                <div class="row "><h4 class="col-md-3 ">Tiquetes:</h4> </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Código:</h5> 
                                    <div class="col-md-8">'
    . ' <h5 id ="codigoTiquete">';
    echo codigoTiquete($tiquete) . '</h5>'
    . '</div> 
                                </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Área:</h5> 
                                    <div class="col-md-8">'
    . '<h5>';
    echo areaTiquete($tiquete) . '</h5>'
    . '</div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Clasificación:</h5> 
                                    <div class=" col-md-8">'
    . ' <h5>';
    echo clasificacionTiquete($tiquete, $codigoPagina) . '</h5>'
    . ' </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Estado:</h5> 
                                    <div class="col-md-8">'
    . '<h5>';
    echo estadoTiquete($tiquete) . '</h5>'
    . '</div> 
                                </div>
                                <div class = "row">
                                    <h5 class = "col-md-3">Prioridad:</h5>';
    $prioridades = obtenerPrioridades();
    echo prioridadTiquete($tiquete, $codigoPagina, $prioridades);

    echo'</div>'
    . '<div class="row ">
                                    <h5 class="col-md-3">Creado el:</h5> 
                                    <div class=" col-md-8">'
    . '<h5>';
    echo fechaCreacionTiquete($tiquete) . '</h5>'
    . '</div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Solicitado para:</h5> 
                                    <div class=" col-md-8">';
    echo $a = fechaSolicitudTiquete($tiquete, $codigoPagina);
    echo' </div>'
    . '</div>
                                <div class="row ">
                                    <h5 class="col-md-3">Fecha entrega:</h5> 
                                    <div class=" col-md-8">';
    echo $a = fechaEntregaTiquete($tiquete, $codigoPagina);
    echo' </div>'
    . ' </div>
                                <div class="row ">                            
                                    <h5 class="col-md-3">Fecha finalizado:</h5> 
                                    <div class=" col-md-8">'
    . '<h5>';
    echo fechaFinalizadoTiquete($tiquete) . '</h5>'
    . '</div> 
                                </div>';
    $activos = obtenerActivosAsociadosTiquete($tiquete->obtenerCodigoTiquete());
    $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();
    equipoAsociado($estado, $activos, $codigoPagina);
    echo'<div class="row ">
                                    <div><h5 class="col-md-12"> Descripción:</h5> </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="3"  id="descripcion" readonly="readonly">';
    echo descripcionTiquete($tiquete) . '</textarea>
                                    </div>
                                </div>  
                                <div class="row ">&nbsp;</div>
                                <div class="row ">';
    echo asignarResponsable($codigoPagina, $tiquete);
    echo'</div> '
    . '</div>

                            <div class="panel-footer"> 
                                <label style="font-size:16px">Calificación</label> ';
    echo mostrarCalificacion($codigoPagina, $tiquete);
    echo'</div>                              
                        </div>
                    </div>
                    <div class="col-md-6"> ';
    echo panelDeCabecera($tiquete);
    echo'<div class="panel-heading">
                            <h5 class="panel-title encabezado">Mensajes</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" id="comentarios" style ="height: 300px; overflow-y: auto; overflow-x: hidden;">  ';

    $listaComentariosPorTiquete = obtenerHistorialComentariosCompleto($codigoTiquete);
    echo obtenerComentariosCompleto($listaComentariosPorTiquete, $r);

    echo' </div>  
                            <div class="form-group">
                                <label for="comment">Agregar comentario</label>
                                <textarea class="form-control" rows="3"  name="comentario" cols="2" id="comentario"></textarea>
                            </div>
                            <div class="form-group">                                    
                                <input id="archivo"  name="archivo" type="file" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation,
                                       text/plain, application/pdf, image/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document
                                       ,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  onchange="subirarchivo(this);" />
                                <input type="hidden" name="archivo2"  readonly="readonly" class="form-control" id="Textarchivo" >
                            </div>
                        </div>
                        <div id ="comentario-panel-footer"class="panel-footer">
                            <button  title="Enviar" type="button" class="btn btn-success " data-toggle="modal" data-target="" onclick="agregarAdjuntoAJAX();">Enviar<i class="glyphicon glyphicon-triangle-right"></i></button>
                            <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="cancelarAdjunto();">Cancelar</button>
                        </div>                           
                    </div>
                </section>';
}
// </editor-fold>