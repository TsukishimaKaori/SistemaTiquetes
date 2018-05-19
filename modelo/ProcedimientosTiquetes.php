<?php

require_once '../modelo/ProcedimientosPermisos.php';
require_once '../modelo/Estado.php';
require_once '../modelo/Tematica.php';
require_once '../modelo/Tiquete.php';
require_once '../modelo/Usuario.php';
require_once '../modelo/Comentario.php';
require_once '../modelo/Prioridad.php';
require_once '../modelo/Historial.php';
require_once '../modelo/ReporteCumplimientoPorArea.php';
require_once '../modelo/ReporteTiquetesIngresadosPorClasificacion.php';
require_once '../modelo/ReporteCantidadDeTiquetesMensuales.php';
require_once '../modelo/ReporteCalificacionesPorArea.php';
require_once '../modelo/ReporteCalificacionesPorResponsable.php';
require_once '../modelo/ReporteCantidadTiquetesPorEstado.php';

//Obtiene todas las area almacenadas en la tabla Area
function obtenerAreas() {
    $conexion = Conexion::getInstancia();
    $men = -1;
    $tsql = "{call PAobtenerAreas (?) }";
    $params = array(array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($men == 1) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener las áreas';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearArea($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $rows;
}

//Agrega un área a la tabla Area, hay que enviarle el nombre de área
function agregarArea($nomArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarArea (?, ?) }";
    $params = array(array($nomArea, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        //'Ya existe un área con el nombre ' . $nomArea;
        return 1;
    } else if ($men == 2) {
        //Ha ocurrido un error';
        return 2;
    }
    return '';
}

//Inactiva un área de la tabla Area, hay que enviarle el codigo de área
function inactivarArea($codiArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAinactivarArea (?, ?) }";
    $params = array(array($codiArea, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el área a inactivar';
    } else if ($men == 3) {
        return 'Ha ocurrido un error al inactivar el área';
    }
    return '';
}

//Activa un área de la tabla Area, hay que enviarle el codigo de área
function activarArea($codiArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactivarArea (?, ?) }";
    $params = array(array($codiArea, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el área a activar';
    } else if ($men == 3) {
        return 'Ha ocurrido un error al activar el área';
    }
    return '';
}

//Obtener todo el árbol de temáticas activas
function obtenerTematicasCompletasActivas() {
    $rows = obtenerTematicasPadreActivas();
    $rowsHijas = array();
    foreach ($rows as $padre) {
        $codPadre = $padre->obtenerCodigoTematica();
        $rowsHijas = array_merge($rowsHijas, obtenerTematicasHijasActivas($codPadre));
    }
    $rows = array_merge($rows, $rowsHijas);
    return $rows;
}

//Eliminar un área de la tabla Area, hay que enviarle el codigo de área
function eliminarArea($codiArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarArea (?, ?) }";
    $params = array(array($codiArea, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        // return 'Ha ocurrido un error al eliminar el área';
        return 1;
    } else if ($men == 3) {
        //return 'El área tiene clasificaciones o tiquetes asociados';
        return 3;
    }
    return '';
}

//Obtener el area asociada a una tematica de primer nivel
function obtenerAreaAsociadaTematica($codTema) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerAreaAsociadaClasificacion (?) }";
    $params = array(array($codTema, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == false) {
        return 'Ha ocurrido un error';
    }
    $area;
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $area = crearArea($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $area;
}

function actualizarAreaAsociadaTematica($codiArea, $codiTema) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarAreaAsociadaClasificacion (?, ?, ?) }";
    $params = array(array($codiArea, SQLSRV_PARAM_IN), array($codiTema, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'La clasificación es de segundo nivel' . '<br >'
                . 'solo se pueden asociar clasificaciones de primer nivel';
    } else if ($men == 2) {
        return 'El código de área no es válido';
    }
    return '';
}

//Agrega un tiquete a la tabla Tiquete, se le envía una temática de segundo nivel,
//la fecha se debe enviar en formato año-mes-día (XXXX-XX-XX)
//Retorna el codigo del tiquete recien creado o un mensaje de error
function agregarTiquete($usuarioIngresaTiquete, $codiTema, $fechaCotizado, $descripcion) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $usuario = consumirMetodoUno($usuarioIngresaTiquete);   //Tomar estos datos del session
    $tsql = "{call PAagregarTiquete (?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($usuarioIngresaTiquete, SQLSRV_PARAM_IN), array($codiTema, SQLSRV_PARAM_IN),
        array($fechaCotizado, SQLSRV_PARAM_IN), array(utf8_decode($descripcion), SQLSRV_PARAM_IN),
        array(utf8_decode($usuario->obtenerNombreUsuario()), SQLSRV_PARAM_IN),
        array(utf8_decode($usuario->obtenerDepartamento()), SQLSRV_PARAM_IN),
        array(utf8_decode($usuario->obtenerJefatura()), SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($men == -2 || $getMensaje == FALSE) {
        sqlsrv_free_stmt($getMensaje);
        return 'No se ha podido crear el tiquete';
    }
    $codigoTiquete;
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $codigoTiquete = $row['codigoTiquete'];
    }
    sqlsrv_free_stmt($getMensaje);
    return $codigoTiquete;
}

//Obtiene un responsable filtrado por el codigo de responsable
//Para ser utilizado al momento de obtener tiquetes
function obtenerResponsableCodigoResponsable($codRespon) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerResponsableCodigoResponsable (?)}";
    $params = array(array($codRespon, SQLSRV_PARAM_IN));
    $getResponsable = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getResponsable == FALSE) {
        return 'Ha ocurrido un error';
    }
    $responsable;
    while ($row = sqlsrv_fetch_array($getResponsable, SQLSRV_FETCH_ASSOC)) {
        $responsable = crearResponsable($row);
    }
    sqlsrv_free_stmt($getResponsable);
    return $responsable;
}

//Obtiene un listado de tiquetes que pertenezcan al correo que se envia
function obtenerTiquetesPorUsuario($correo) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesPorUsuario (?) }";
    $params = array(array($correo, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Obtiene un listado de tiquetes que pertenezcan al correo que se envia filtrado por el 
//estado
function obtenerTiquetesPorUsuarioFiltrados($correo, $codigoEstado, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesPorUsuarioFiltrados (?, ?, ?, ?) }";
    $params = array(array($correo, SQLSRV_PARAM_IN), array($codigoEstado, SQLSRV_PARAM_IN),
        array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Para llenar la bandeja de búsqueda avanzada de mis tiquetes se debe llamar a esta función, se le debe enviar
//un array con todos estados seleccionados, la fecha de creacion inicial y la final
function tiquetesPorUsuarioAvanzada($correo, $fechaInicio, $fechaFinal, $codigosEstados) {
    $tiquetes = array();
    if ($codigosEstados == null) {
        $tiquetes = array_merge($tiquetes, obtenerTiquetesPorUsuarioFiltrados($correo, '', $fechaInicio, $fechaFinal));
    } else {
        foreach ($codigosEstados as $codigo) {
            $tiquetes = array_merge($tiquetes, obtenerTiquetesPorUsuarioFiltrados($correo, $codigo, $fechaInicio, $fechaFinal));
        }
    }
    return $tiquetes;
}

//Obtiene el listado completo de estados
function obtenerEstados() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerEstados }";
    $getEstado = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getEstado == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $estados = array();
    while ($row = sqlsrv_fetch_array($getEstado, SQLSRV_FETCH_ASSOC)) {
        $estados[] = crearEstado($row);
    }
    sqlsrv_free_stmt($getEstado);
    return $estados;
}

//Obtener las temáticas padre activas
function obtenerTematicasPadreActivas() {
    $conexion = Conexion::getInstancia();
    $tsql = "exec PAobtenerClasificacionesPadreActivas";
    $getTematicas = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getTematicas == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getTematicas, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearTematica($row);
    }
    sqlsrv_free_stmt($getTematicas);
    return $rows;
}

//Obtener todas las temáticas padre 
function obtenerTematicasPadreCompletas() {
    $conexion = Conexion::getInstancia();
    $tsql = "exec PAobtenerClasificacionesPadreCompletas";
    $getTematicas = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getTematicas == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getTematicas, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearTematica($row);
    }
    sqlsrv_free_stmt($getTematicas);
    return $rows;
}

//Obtiene las tematicas hijas activas 
function obtenerTematicasHijasActivas($codPadre) {
    $conexion = Conexion::getInstancia();
    $tsql = "{ call PAobtenerClasificacionesHijasActivas (?) }";
    $params = array(array($codPadre, SQLSRV_PARAM_IN));
    $getTematicas = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTematicas == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getTematicas, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearTematica($row);
    }
    sqlsrv_free_stmt($getTematicas);
    return $rows;
}

//Obtiene todas las tematicas hijas  
function obtenerTematicasHijasCompletas($codPadre) {
    $conexion = Conexion::getInstancia();
    $tsql = "{ call PAobtenerClasificacionesHijasCompletas (?) }";
    $params = array(array($codPadre, SQLSRV_PARAM_IN));
    $getTematicas = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTematicas == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getTematicas, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearTematica($row);
    }
    sqlsrv_free_stmt($getTematicas);
    return $rows;
}

//Activa una temática de la tabla Tematica, hay que enviarle el código de temática
function activarTematica($codiTemaP) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactivarClasificacion (?, ?) }";
    $params = array(array($codiTemaP, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe la clasificación a activar';
    } else if ($men == 3) {
        return 'Ha ocurrido un error al activar la clasificación';
    }
    return '';
}

//Inactiva una temática de la tabla Tematica, hay que enviarle el código de temática
function inactivarTematica($codiTemaP) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAinactivarClasificacion (?, ?) }";
    $params = array(array($codiTemaP, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe la clasificación a inactivar';
    } else if ($men == 3) {
        return 'Ha ocurrido un error al inactivar la clasificación';
    }
    return '';
}

//Agrega una tematica padre a la tabla Tematica, hay que enviarle la descripcion y el codigo de area a asociar
function agregarTematicaPadre($descTema, $codArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarClasificacionPadre (?, ?, ?) }";
    $params = array(array($descTema, SQLSRV_PARAM_IN), array($codArea, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 1;  //return 'Ya existe una clasificación con la descripción ' . $descTema;
    } else if ($men == 2) {
        return 2; //return 'No existe el área a asociar';
    } else if ($men == 3) {
        return 3;  // return 'Ha ocurrido un error';
    }
    return 4; //agregado correctamente
}

//Agrega una tematica hija a la tabla Tematica, hay que enviarle la descripcion y el codigo del padre
function agregarTematicaHija($descTema, $codPadre) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarClasificacionHija (?, ?, ?) }";
    $params = array(array($descTema, SQLSRV_PARAM_IN), array($codPadre, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 2) {
        //return 'Ya existe una clasificación con la descripción ' . $descTema;
        return 2;
    } else if ($men == 2) {
        //return 'Ha ocurrido un error';
        return 2;
    } else if ($men == 4) {
        //return 'No se ha encontrado el padre';
        return 4;
    }
    return 1;
}

//Actualiza la descripcion una tematica de la tabla Tematica, hay que enviarle la descripcion y el codigo de la tematica
function actualizarDescripcionTematica($codTema, $descTema) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarDescripcionClasificacion (?, ?, ?) }";
    $params = array(array($codTema, SQLSRV_PARAM_IN), array($descTema, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        // return 'No existe la temática a actualizar';
        return 1;
    } else if ($men == 2) {
        // return 'Ya existe una temática con la descripción ' . $descTema;
        return 2;
    } else if ($men == 3) {
        //return 'Ha ocurrido un error';
        return 3;
    }
    return '';
}

//Actualiza el padre de una tematica de la tabla Tematica, hay que enviarle el 
//codigo de la tematica y el codigo del padre a cambiar
function actualizarPadreTematica($codTema, $codPadre) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarPadreClasificacion (?, ?, ?) }";
    $params = array(array($codTema, SQLSRV_PARAM_IN), array($codPadre, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe la clasificación a actualizar, la misma no está activa o es un padre';
    } else if ($men == 2) {
        return 'La clasificación a asignar como padre no es válida';
    } else if ($men == 3) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Agrega un adjunto o comentario a la tabla HistorialTiquete, hay que enviarle el codigo del tiquete
//si se envia un comentario se guarda, si se envia '', entonces se genera un comentario en la base,
function agregarAdjunto($codTiquete, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante, $direccionAdjunto) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAagregarAdjunto (?, ?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($comentarioUsuario), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($direccionAdjunto, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el tiquete al que se quiere adjuntar';
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Actualiza un área a la tabla Area, hay que enviarle el código de área y el nuevo nombre de área
function actualizarArea($codArea, $nomArea) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarArea (?, ?, ?) }";
    $params = array(array($codArea, SQLSRV_PARAM_IN), array($nomArea, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el área ha actualizar';
    } else if ($men == 2) {
        return 'Ya existe un área con el nombre ' . $nomArea;
    } else if ($men == 3) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Eliminar una temática de la tabla Tematica, hay que enviarle el código de temática
function eliminarTematica($codiTema) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAeliminarClasificacion (?, ?) }";
    $params = array(array($codiTema, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        //return 'No existe la clasificación a eliminar';
        return 1;
    } else if ($men == 2) {
        return 2;
        // return 'Ha ocurrido un error al eliminar la clasificación';
    }
    return 3;
}

//Obtiene adjuntos por tiquete
function obtenerAdjuntosTiquete($codTiquete) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerAdjuntosTiquete (?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == false) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener los adjuntos';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $rows[] = $row['aclaracionSistema'];
    }
    sqlsrv_free_stmt($getMensaje);
    return $rows;
}

function obtenerAreaActiva() {
    $conexion = Conexion::getInstancia();
    $men = -1;
    $tsql = "{call PAobtenerAreasActivas (?) }";
    $params = array(array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($men == 1) {
        sqlsrv_free_stmt($getMensaje);
        return 'Ha ocurrido un error al obtener las áreas';
    }
    $rows = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $rows[] = crearArea($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $rows;
}

function obtenerHistorialComentariosCompleto($codTiquete) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerHistorialComentariosCompleto (?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        return 'Ha ocurrido un error';
    }
    $comentarios = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $comentarios[] = crearComentario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $comentarios;
}

function obtenerComentariosFiltradosFecha($codTiquete, $fechaInicial, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerComentariosFiltradosFecha (?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($fechaInicial, SQLSRV_PARAM_IN),
        array($fechaFinal, SQLSRV_PARAM_IN));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getMensaje == FALSE) {
        return 'Ha ocurrido un error';
    }
    $comentarios = array();
    while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {
        $comentarios[] = crearComentario($row);
    }
    sqlsrv_free_stmt($getMensaje);
    return $comentarios;
}

//Permite asignar un responsable a un tiquete, hay que enviar el codigo del tiquete, el codigo de empleado
//del responsable, el correo y el nombre del usuario que esta en el sistema
function asignarTiquete($codTiquete, $codigoEmpleado, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAasignarTiquete (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($codigoEmpleado, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el tiquete que se quiere asignar';
    } else if ($men == 2) {
        return 'El responsable ha asignar no es un usuario válido';
    } else if ($men == 3) {
        return 'Ha ocurrido un error';
    }
    return '';
}

function actualizarEnviaCorreoEstado($codigoEstado, $enviaCorreos) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarEnviaCorreoEstado (?, ?, ?) }";
    $params = array(array($codigoEstado, SQLSRV_PARAM_IN), array($enviaCorreos, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el estado a actualizar';
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    }
    return '';
}

function actualizarFechaSolicitada($codTiquete, $nuevaFechaSolicitada, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarFechaSolicitada (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($nuevaFechaSolicitada, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el tiquete que se quiere actualizar';
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Obtiene todos los empleados activos de TI filtrados por area para asignar a un tiquete
function obtenerResponsablesAsignar($codigoArea) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerResponsablesAsignar (?)}";
    $params = array(array($codigoArea, SQLSRV_PARAM_IN));
    $getResponsable = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getResponsable == FALSE) {
        return 'Ha ocurrido un error';
    } $responsables = array();
    while ($row = sqlsrv_fetch_array($getResponsable, SQLSRV_FETCH_ASSOC)) {
        $responsables[] = crearResponsable($row);
    }
    sqlsrv_free_stmt($getResponsable);
    return $responsables;
}

//Obtiene los tiquetes en estado Nuevo o Devuelto, para asignar a un responsable
//los tiquetes se filtra por el area a la que pertenece la persona asignadora
function obtenerTiquetesPorAsignarArea($area) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesPorAsignarArea (?) }";
    $params = array(array($area, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Obtiene todos los tiquetes en estado de Nuevo o Devuelto, para asignar a un responsable
//No tiene filtro porque se cargan para el administrador
function obtenerTiquetesPorAsignarTodos() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesPorAsignarTodos }";
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Obtiene los tiquetes para rellenar la bandeja de tiquetes sin asignar,
//diferencia entre si el asignador es un administrador o no para saber
//si cargar todos los tiquetes o solo los tiquetes que pertenezcan al area
//del asignador
function obtenerTiqueteBandejaPorAsinar($codigoRol, $codigoArea) {
    if ($codigoRol == 1) {
        return obtenerTiquetesPorAsignarTodos();
    } else {
        return obtenerTiquetesPorAsignarArea($codigoArea);
    }
}

function actualizarHorasTrabajadas($codTiquete, $nuevasHorasTrabajadas, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarHorasTrabajadas (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($nuevasHorasTrabajadas, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el tiquete que se quiere actualizar';
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    } else if ($men == 3) {
        return 'El tiquete no se encuentra en proceso';
    }
    return '';
}

function actualizarClasificacionTiquete($codTiquete, $codigoNuevaClasificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarClasificacionTiquete (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($codigoNuevaClasificacion, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men == 1) {
        return 'No existe el tiquete que se quiere actualizar';
    } else if ($men == 2) {
        return 'Ha ocurrido un error';
    }
    return '';
}

//Obtiene los tiquetes asignados a la persona cuyo codigo se envia por parametro, filtrados por estado
//asignado o en proceso
function obtenerTiquetesAsignados($codigoEmpleado) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesAsignados (?) }";
    $params = array(array($codigoEmpleado, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Obtiene los tiquetes asignados a la persona cuyo codigo se envia por parametro, ademas filtra
//por el codigo de estado enviado.
function obtenerTiquetesAsignadosFiltrados($codigoEmpleado, $codigoEstado, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesAsignadosFiltrados (?, ?, ?, ?) }";
    $params = array(array($codigoEmpleado, SQLSRV_PARAM_IN), array($codigoEstado, SQLSRV_PARAM_IN),
        array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Para llenar la bandeja de búsqueda avanzada de tiquetes asignados se debe llamar a esta función, se le debe enviar
//un array con todos estados seleccionados
function tiquetesAsignadosAvanzada($codigoEmpleado, $fechaInicio, $fechaFinal, $codigosEstados) {
    $tiquetes = array();
    if ($codigosEstados == null) {
        $tiquetes = array_merge($tiquetes, obtenerTiquetesAsignadosFiltrados($codigoEmpleado, '', $fechaInicio, $fechaFinal));
    } else {
        foreach ($codigosEstados as $codigo) {
            $tiquetes = array_merge($tiquetes, obtenerTiquetesAsignadosFiltrados($codigoEmpleado, $codigo, $fechaInicio, $fechaFinal));
        }
    }
    return $tiquetes;
}

//Cambia el estado de un tiquete a Espera reasignación, por lo que el tiquete devulve a la bandeja de Por Asignar,
//necesita que se envie una justificación, que es un comentario del responsable
function enviarAReasignarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAenviarAReasignarTiquete (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($justificacion), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete que se quiere enviar a reasignar';
        // 2 -> 'No se permite enviar a reasignar el tiquete';
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Cambia el estado de un tiquete a En proceso
//necesita que se envie una explicación, que es un comentario del responsable
function ponerTiqueteEnProceso($codTiquete, $fechaEntrega, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAponerTiqueteEnProceso (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($fechaEntrega, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete que se quiere poner en proceso';
        // 2 -> 'No se permite poner el tiquete en proceso';
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Cambia el estado de un tiquete a Anulado
//necesita que se envie una justificacion, que es un comentario del responsable
function anularTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAanularTiquete (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($justificacion), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete que se quiere anular';
        // 2 -> 'No se permite anular el tiquete';
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Cambia el estado de un tiquete a Finalizado
//necesita que se envie una justificacion, que es un comentario del responsable
function finalizarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAfinalizarTiquete (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($justificacion), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete que se quiere anular';
        // 2 -> 'No se permite finalizar el tiquete';
        // 3 -> 'Ha ocurrido un error';
        // 4 -> 'Las horas trabajadas se encuentran en 0';
    } else {
        return '';
    }
}

//Cambia el estado de un tiquete a Calificado
//necesita que se envie una justificacion, que es un comentario del responsable
function calificarTiquete($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante, $calificacion) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAcalificarTiquete (?, ?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($justificacion), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($calificacion, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete que se quiere anular';
        // 2 -> 'No se permite calificar el tiquete';
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Obtiene el listado completo de las prioridades
function obtenerPrioridades() {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerPrioridades }";
    $getEstado = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getEstado == FALSE) {
        echo 'Ha ocurrido un error';
    }
    $prioridades = array();
    while ($row = sqlsrv_fetch_array($getEstado, SQLSRV_FETCH_ASSOC)) {
        $prioridades[] = crearPrioridad($row);
    }
    sqlsrv_free_stmt($getEstado);
    return $prioridades;
}

function actualizarPrioridad($codTiquete, $nuevoCodigoPrioridad, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarPrioridad (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($nuevoCodigoPrioridad, SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete ha actualizar';
        // 2 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Obtiene los tiquetes asignados a la persona cuyo codigo se envia por parametro
function obtenerTiquetesHistorial($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiquetesHistorial (?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN), array($correoSolicitante, SQLSRV_PARAM_IN),
        array($nombreSolicitante, SQLSRV_PARAM_IN), array($correoResponsable, SQLSRV_PARAM_IN),
        array($nombreResponsable, SQLSRV_PARAM_IN), array($fechaInicio, SQLSRV_PARAM_IN),
        array($fechaFinal, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 1;
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Obtiene el historial del codigo de tiquete que se envia
function obtenerHistorial($codigoTiquete) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerHistorial (?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN));
    $getHistorial = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getHistorial == FALSE) {
        return 'Ha ocurrido un error';
    } $historial = array();
    while ($row = sqlsrv_fetch_array($getHistorial, SQLSRV_FETCH_ASSOC)) {
        $historial[] = crearHistorial($row);
    }
    sqlsrv_free_stmt($getHistorial);
    return $historial;
}

//Obtiene los tiquetes de la búsqueda avanzada para el administrador
function busquedaAvanzadaTiquetes($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigoEstado) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAbusquedaAvanzadaTiquetes (?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN), array($correoSolicitante, SQLSRV_PARAM_IN),
        array($nombreSolicitante, SQLSRV_PARAM_IN), array($correoResponsable, SQLSRV_PARAM_IN),
        array($nombreResponsable, SQLSRV_PARAM_IN), array($fechaInicio, SQLSRV_PARAM_IN),
        array($fechaFinal, SQLSRV_PARAM_IN), array($codigoEstado, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Para llenar la bandeja de búsqueda avanzada del administrador se debe llamar a esta función, se le debe enviar
//un array con todos estados seleccionados, si no se selecciona ningún estado, entonces enviar un null
function busquedaAvanzadaPrincipal($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados) {
    $tiquetes = array();
    if ($codigosEstados == null) {
        return busquedaAvanzadaTiquetes($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, '');
    } else {
        foreach ($codigosEstados as $codigo) {
            $tiquetes = array_merge($tiquetes, busquedaAvanzadaTiquetes($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigo));
        }
        return $tiquetes;
    }
}

//Obtiene los tiquetes de la búsqueda avanzada para los coordinadores
function busquedaAvanzadaTiquetesArea($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigoEstado, $codigoArea) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAbusquedaAvanzadaTiquetesArea (?, ?, ?, ?, ?, ?, ?, ?, ?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN), array($correoSolicitante, SQLSRV_PARAM_IN),
        array($nombreSolicitante, SQLSRV_PARAM_IN), array($correoResponsable, SQLSRV_PARAM_IN),
        array($nombreResponsable, SQLSRV_PARAM_IN), array($fechaInicio, SQLSRV_PARAM_IN),
        array($fechaFinal, SQLSRV_PARAM_IN), array($codigoEstado, SQLSRV_PARAM_IN),
        array($codigoArea, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}

//Para llenar la bandeja de búsqueda avanzada de los coordinadores se debe llamar a esta función, se le debe enviar
//un array con todos estados seleccionados, si no se selecciona ningún estado, entonces enviar un null
//además se envía el código del área del coordinador
function busquedaAvanzadaPrincipalArea($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea) {
    $tiquetes = array();
    if ($codigosEstados == null) {
        return busquedaAvanzadaTiquetesArea($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, '', $codigoArea);
    } else {
        foreach ($codigosEstados as $codigo) {
            $tiquetes = array_merge($tiquetes, busquedaAvanzadaTiquetesArea($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigo, $codigoArea));
        }
        return $tiquetes;
    }
}

//Función principal para llenar la bandeja de búsqueda avanzada, además de los filtros se debe enviar
//el código de área y el código de rol del usuario que hace la búsqueda
function busquedaAvanzadaGeneral($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol) {
    if ($codigoRol == 1) {
        return busquedaAvanzadaPrincipal($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados);
    } else {
        return busquedaAvanzadaPrincipalArea($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea);
    }
}


//Actualizar la fecha de entrega del tiquete, debe incluir una justificación
function actualizarFechaEntrega($codTiquete, $nuevaFechaEntrega, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAactualizarFechaEntrega (?, ?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array($nuevaFechaEntrega, SQLSRV_PARAM_IN),
        array(utf8_decode($justificacion), SQLSRV_PARAM_IN), array($correoUsuarioCausante, SQLSRV_PARAM_IN),
        array($nombreUsuarioCausante, SQLSRV_PARAM_IN), array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete ha actualizar';
        // 2 -> 'El tiquete no se encuentra en proceso'
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}

//Enviar un tiquete finalizado a reprocesar, debe incluir una justificación.
//Solo se ve en la bandeja de mis tiquetes
function enviarAReprocesar($codTiquete, $justificacion, $correoUsuarioCausante, $nombreUsuarioCausante) {
    $men = -1;
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAenviarAReprocesar (?, ?, ?, ?, ?) }";
    $params = array(array($codTiquete, SQLSRV_PARAM_IN), array(utf8_decode($justificacion), SQLSRV_PARAM_IN),
        array($correoUsuarioCausante, SQLSRV_PARAM_IN), array($nombreUsuarioCausante, SQLSRV_PARAM_IN),
        array($men, SQLSRV_PARAM_OUT));
    $getMensaje = sqlsrv_query($conexion->getConn(), $tsql, $params);
    sqlsrv_free_stmt($getMensaje);
    if ($men != -1) {
        return $men;
        // 1 -> 'No existe el tiquete ha actualizar';
        // 2 -> 'El tiquete no se encuentra finalizado'
        // 3 -> 'Ha ocurrido un error';
    } else {
        return '';
    }
}
//Obtiene un tiquete filtrado por el código de tiquete
function obtenerTiqueteFiltradoCodigo($codigoTiquete) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerTiqueteFiltradoCodigo (?) }";
    $params = array(array($codigoTiquete, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquete;
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquete = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquete;
}


//Obtiene los datos para llenar el grafico de barras
function reporteCumplimientoPorArea($fechaInicio, $fechaFinal) {
    $reportes = array();
    $areas = obtenerAreaActiva();
    foreach ($areas as $a){
        
        $conexion = Conexion::getInstancia();
        $tsql = "{call PAreporteCumplimientoPorArea (?, ?, ?) }";
        $params = array(array($a->obtenerCodigoArea(), SQLSRV_PARAM_IN), array($fechaInicio, SQLSRV_PARAM_IN),
            array($fechaFinal, SQLSRV_PARAM_IN));
        $getReporte = sqlsrv_query($conexion->getConn(), $tsql, $params);
        if ($getReporte == FALSE) {
            return 'Ha ocurrido un error';
        } 
        while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
            $reportes[] = crearReporteCumplimientoPorArea($row);
        }
        sqlsrv_free_stmt($getReporte);
    }
    return $reportes;
}


//Obtiene el codigo de las clasificaciones filtradas por area
function obtenerClasificacionesPorArea($codigoArea) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAobtenerClasificacionesPorArea (?) }";
    $params = array(array($codigoArea, SQLSRV_PARAM_IN));
    $getReporte = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getReporte == FALSE) {
        return 'Ha ocurrido un error';
    } 
    $codigos = array();
    while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
        $codigos[] = $row['codigoClasificacion'];
    }
    sqlsrv_free_stmt($getReporte);
    return $codigos;
}


//Obtiene los datos para llenar el grafico de pie
function obtenerReporteTiquetesIngresadosPorClasificacion($codigoArea, $fechaInicio, $fechaFinal) {
    $reportes = array();
    $codigosCla = obtenerClasificacionesPorArea($codigoArea);
    foreach ($codigosCla as $a){
        
        $conexion = Conexion::getInstancia();
        $tsql = "{call PAreporteTiquetesIngresadosClasificacion (?, ?, ?) }";
        $params = array(array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN), 
            array($a, SQLSRV_PARAM_IN));
        $getReporte = sqlsrv_query($conexion->getConn(), $tsql, $params);
        if ($getReporte == FALSE) {
            return 'Ha ocurrido un error';
        } 
        while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
            $reportes[] = crearReporteTiquetesIngresadosPorClasificacion($row);
        }
        sqlsrv_free_stmt($getReporte);
    }
    return $reportes;
}


//Obtiene los datos para llenar el grafico de lineas
function obtenerReporteCantidadDeTiquetesMensuales($annio) {
    $reportes = array();
    
    //Se usa el i como los 12 meses del annio
    for($i = 1; $i < 13; $i++){
        
        $conexion = Conexion::getInstancia();
        $tsql = "{call PAcantidadDeTiquetesAtendidosMensualmente (?, ?) }";
        $params = array(array($annio, SQLSRV_PARAM_IN), array($i, SQLSRV_PARAM_IN));
        $getReporte = sqlsrv_query($conexion->getConn(), $tsql, $params);
        if ($getReporte == FALSE) {
            return 'Ha ocurrido un error';
        } 
        while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
            $reportes[] = crearReporteCantidadDeTiquetesMensuales($row);
        }
        sqlsrv_free_stmt($getReporte);
    }
    return $reportes;
}


//Obtiene un listado de tiquetes que se encuentren En proceso, Nuevo, Asignado o Vencido
function reporteTiquetesEnEstados($estado) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAreporteTiquetesEnEstados (?) }";
    $params = array(array($estado, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}


//Obtiene una lista con las areas de TI y el promedio de calificaciones de cada una
function reportePromedioCalificacionesPorArea() {

    $conexion = Conexion::getInstancia();
    $tsql = "{call PApromedioCalificacionesPorArea }";
    $getReporte = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getReporte == FALSE) {
        return 'Ha ocurrido un error';
    } 
    $reporte = array();
    while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
        $reporte[] = crearReporteCalificacionesPorArea($row);
    }
    sqlsrv_free_stmt($getReporte);
    
    return $reporte;
}


//Obtiene una lista con las responsables de TI y el promedio de calificaciones de cada uno por area de TI
function reportePromedioCalificacionesPorResponsables($codigoArea) {

    $conexion = Conexion::getInstancia();
    $tsql = "{call PApromedioCalificacionesPorResponsables (?) }";
    $params = array(array($codigoArea, SQLSRV_PARAM_IN));
    $getReporte = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getReporte == FALSE) {
        return 'Ha ocurrido un error';
    } 
    $reporte = array();
    while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
        $reporte[] = crearReporteCalificacionesPorResponsable($row);
    }
    sqlsrv_free_stmt($getReporte);
    
    return $reporte;
}


//Obtiene todos los tiquetes del sistema por un rango de fechas
function reporteTodosLosTiquetesFecha($fechaInicio, $fechaFinal) {
    $conexion = Conexion::getInstancia();
    $tsql = "{call PAreporteTodosLosTiquetesFecha (?, ?) }";
    $params = array(array($fechaInicio, SQLSRV_PARAM_IN), array($fechaFinal, SQLSRV_PARAM_IN));
    $getTiquete = sqlsrv_query($conexion->getConn(), $tsql, $params);
    if ($getTiquete == FALSE) {
        return 'Ha ocurrido un error';
    } $tiquetes = array();
    while ($row = sqlsrv_fetch_array($getTiquete, SQLSRV_FETCH_ASSOC)) {
        $tiquetes[] = crearTiquete($row);
    }
    sqlsrv_free_stmt($getTiquete);
    return $tiquetes;
}


//Para llenar el grafico de cantidad de tiquetes por estado, se ven Nuevo, Asignado, En proceso y Vencido
function reporteCantidadTiquetePorEstados() {

    $conexion = Conexion::getInstancia();
    $tsql = "{call PAreporteCantidadTiquetePorEstados }";
    $getReporte = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getReporte == FALSE) {
        return 'Ha ocurrido un error';
    } 
    $reporte = array();
    while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
        $reporte[] = crearReporteCantidadTiquetesPorEstado($row);
    }
    
    $tsql = "{call PAreporteCantidadTiqueteVencidos }";
    $getReporte = sqlsrv_query($conexion->getConn(), $tsql);
    if ($getReporte == FALSE) {
        return 'Ha ocurrido un error';
    } 
    while ($row = sqlsrv_fetch_array($getReporte, SQLSRV_FETCH_ASSOC)) {
        $reporte[] = crearReporteCantidadTiquetesPorEstado($row);
    }
    sqlsrv_free_stmt($getReporte);
    
    return $reporte;
}

function crearTiquete($row) {
    $codigoTiquete = $row['codigoTiquete'];
    $usuarioIngresaTiquete = utf8_encode($row['usuarioIngresaTiquete']);
    $estado = crearEstado($row);
    $responsable = obtenerResponsableCodigoResponsable($row['codigoResponsable']);
    $area = crearArea($row);
    $tematica = crearTematica($row);
    $fechaCreacion = $row['fechaCreacion'];
    $fechaFinalizado = $row['fechaFinalizado'];
    $fechaCalificado = $row['fechaCalificado'];
    $fechaCotizado = $row['fechaSolicitado'];
    $fechaEnProceso = $row['fechaEnProceso'];
    $fechaEntrega = $row['fechaEntrega'];
    $descripcion = utf8_encode($row['descripcion']);
    $calificacion = $row['calificacion'];
    $horasTrabajadas = $row['horasTrabajadas'];
    $nombreUsuario = utf8_encode($row['nombreUsuarioSolicitante']);
    $departamentoUsuarioSolicitante = utf8_encode($row['departamentoUsuarioSolicitante']);
    $jefaturaUsuarioSolicitante = utf8_encode($row['jefaturaUsuarioSolicitante']);
    $prioridad = crearPrioridad($row);
    return new Tiquete($codigoTiquete, $usuarioIngresaTiquete, $nombreUsuario, $estado, $responsable, $area, $tematica, $fechaCreacion, $fechaFinalizado, $fechaCalificado, $fechaCotizado, $fechaEnProceso, $descripcion, $calificacion, $horasTrabajadas, $departamentoUsuarioSolicitante, $jefaturaUsuarioSolicitante, $prioridad, $fechaEntrega);
}

function crearEstado($row) {
    $codigoEstado = $row['codigoEstado'];
    $nombreEstado = utf8_encode($row['nombreEstado']);
    $enviaCorreos = $row['enviaCorreos'];
    return new Estado($codigoEstado, $nombreEstado, $enviaCorreos);
}

function crearArea($row) {
    $codigo = $row['codigoArea'];
    $nombre = utf8_encode($row['nombreArea']);
    $activo = $row['activo'];
    return new Area($codigo, $nombre, $activo);
}

function crearTematica($row) {
    $codigoT = $row['codigoClasificacion'];
    $descripcionT = utf8_encode($row['descripcionClasificacion']);
    $codigoPadre = $row['codigoPadre'];
    $activo = $row['activo'];
    return new Tematica($codigoT, $descripcionT, $codigoPadre, $activo);
}

function crearComentario($row) {
    $comentarioUsuario = utf8_encode($row['comentarioUsuario']);
    $fechaHora = $row['fechaHora'];
    $nombreUsuarioCausante = utf8_encode($row['nombreUsuarioCausante']);
    $direccionAdjunto = utf8_encode($row['direccionAdjunto']);
    $correo = utf8_encode($row['correoUsuarioCausante']);
    return new Comentario($nombreUsuarioCausante, $fechaHora->format('d-m-Y H:i'), $comentarioUsuario, $direccionAdjunto, $correo);
}

function crearPrioridad($row) {
    $codigoPrioridad = $row['codigoPrioridad'];
    $nombrePrioridad = utf8_encode($row['nombrePrioridad']);
    return new Prioridad($codigoPrioridad, $nombrePrioridad);
}

function crearHistorial($row) {
    $codigoHistorial = $row['codigoHistorial'];
    $codigoIndicador = $row['codigoIndicador'];
    $comentarioUsuario = utf8_encode($row['comentarioUsuario']);
    $fechaHora = $row['fechaHora'];
    $correoUsuarioCausante = utf8_encode($row['correoUsuarioCausante']);
    $nombreUsuarioCausante = utf8_encode($row['nombreUsuarioCausante']);
    $correoResponsable = utf8_encode($row['correo']);
    $nombreResponsable = utf8_encode($row['nombreResponsable']);
    $aclaracionSistema = utf8_encode($row['aclaracionSistema']);
    return new Historial($codigoHistorial, $codigoIndicador, $comentarioUsuario, $fechaHora->format('d-m-Y H:i'), $correoUsuarioCausante, $nombreUsuarioCausante, $correoResponsable, $nombreResponsable, $aclaracionSistema);
}

function crearReporteCumplimientoPorArea($row) {
    $nombreArea = utf8_encode($row['nombreArea']);
    $totalCumplidas = $row['totalCumplidas'];
    $totalAtendidos = $row['totalAtendidos'];
    return new ReporteCumplimientoPorArea($nombreArea, $totalCumplidas, $totalAtendidos);
}

function crearReporteTiquetesIngresadosPorClasificacion($row){
    $descripcionClasificacion = utf8_encode($row['descripcionClasificacion']);
    $cantidadClasificacion = $row['cantidadClasificacion'];
    return new ReporteTiquetesIngresadosPorClasificacion($descripcionClasificacion, $cantidadClasificacion);
}

function crearReporteCantidadDeTiquetesMensuales($row){
    $mes = $row['mes'];
    $cantidadMensuales = $row['cantidadMensuales'];
    return new ReporteCantidadDeTiquetesMensuales($mes, $cantidadMensuales);
}

function crearReporteCalificacionesPorArea($row){
    $codigoArea = $row['codigoArea'];
    $nombreArea = utf8_encode($row['nombreArea']);
    $promedioCalificaciones = $row['promedioCalificaciones'];
    $promedioCalificaciones = number_format($promedioCalificaciones, 1, '.', '');
    return new ReporteCalificacionesPorArea($codigoArea, $nombreArea, $promedioCalificaciones);
}

function crearReporteCalificacionesPorResponsable($row){
    $nombreResponsable = utf8_encode($row['nombreResponsable']);
    $promedioCalificaciones = $row['promedioCalificaciones'];
    $promedioCalificaciones = number_format($promedioCalificaciones, 1, '.', '');
    return new ReporteCalificacionesPorResponsable($nombreResponsable, $promedioCalificaciones);
}

function crearReporteCantidadTiquetesPorEstado($row){
    $nombreEstado = utf8_encode($row['nombreEstado']);
    $cantidad = $row['cantidad'];
    return new ReporteCantidadTiquetesPorEstado($nombreEstado, $cantidad);
}

//$mensaje2 = inactivarArea('1');
//if($mensaje2 == ''){
//    echo 'Inactivado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = activarArea('1');
//if($mensaje2 == ''){
//    echo 'Activado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//
//$tematicas = obtenerTematicasCompletasActivas();
//
//foreach ($tematicas as $tema) {   
//    echo $tema->obtenerCodigoTematica() .'  ' . $tema->obtenerDescripcionTematica().'  ' . $tema->obtenerActivo() .'<br />'; 
//    
//}

//$mensaje2 = eliminarArea(7);
//if($mensaje2 == ''){
//    echo 'Eliminado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$ar = obtenerAreaAsociadaTematica(1);
//  
//    echo $ar->obtenerCodigoArea() .'  ' . $ar->obtenerNombreArea().'<br />'; 
//    

//$mensaje2 = actualizarAreaAsociadaTematica(78, 1);
//if($mensaje2 == ''){
//    echo 'Asociado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}


//$mensaje2 = agregarTiquete('nubeblanca1997@outlook.com', 14, '08/12/2017', 'Probar que se creen tiquetes enteros');
//    echo $mensaje2;


//$tiquetes = obtenerTiquetesPorUsuario('nubeblanca1997@outlook.com');
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() .'  ' . $tema->obtenerCodigoUsuarioIngresaTiquete(). ' '
//            . $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//}

//$estados = obtenerEstados();
//
//foreach ($estados as $esta) {   
//    echo $esta->obtenerCodigoEstado() .'  ' . $esta->obtenerNombreEstado().'  ' . $esta->obtenerEnviaCorreos().'<br />'; 
//    
//}

//$tematicas = obtenerTematicasHijasCompletas(1);
//
//foreach ($tematicas as $tema) {   
//    echo $tema->obtenerCodigoTematica() .'  ' . $tema->obtenerDescripcionTematica().'  ' . $tema->obtenerActivo() .'<br />'; 
//    
//}

//$mensaje2 = activarTematica(4);
//if($mensaje2 == ''){
//    echo 'Activado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = inactivarTematica(4);
//if($mensaje2 == ''){
//    echo 'Inactivado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = agregarTematicaPadre('Asesoria', 1);
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = agregarTematicaHija('Asesoria de integridades', 18);
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = actualizarDescripcionTematica(18, 'VencimientOExcel');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = actualizarPadreTematica(18, 22);
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = agregarAdjunto(4, 'Comentario hecho por mi', 'nubeblanca1997@outlook.com', 'C:/algun/lugar/archivitote.txt');
//if($mensaje2 == ''){
//    echo 'Agregado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = actualizarArea(2, 'Patatas');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = eliminarTematica(19);
//if($mensaje2 == ''){
//    echo 'Eliminado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$adjuntos = obtenerAdjuntosTiquete(1);
//
//foreach ($adjuntos as $adjunto) {   
//    echo $adjunto .'<br />'; 
//    
//}    

//$mensaje2 = asignarTiquete(2, '787t', 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Asignado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = actualizarFechaSolicitada(2, '2018-09-15', 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$responsa = obtenerResponsablesAsignar(1);
//
//foreach ($responsa as $respo) {   
//    echo $respo->obtenerCodigoEmpleado() .'  ' . $respo->obtenerNombreResponsable(). ' ' . $respo->obtenerArea()->obtenerNombreArea(). ' ' . $respo->obtenerRol()->obtenerNombreRol() .'  ' . $respo->obtenerCorreo(). '<br />';    
//}

//$tiquetes = obtenerTiqueteBandejaPorAsinar(1, 3);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() .'  ' . $tema->obtenerCodigoUsuarioIngresaTiquete(). ' '
//            . $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerPrioridad()->obtenerNombrePrioridad() . '<br />';
//}

//$mensaje2 = actualizarHorasTrabajadas(1, 17, 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = actualizarClasificacionTiquete(1, 14, 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}


//$tiquetes = obtenerTiquetesAsignados('1b65');
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() .'  ' . $tema->obtenerCodigoUsuarioIngresaTiquete(). ' '
//            . $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//}


//$mensaje2 = enviarAReasignarTiquete(4, 'No lo quiero', 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Tiquete enviado a reasignar'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = ponerTiqueteEnProceso(2, '2018-02-25', 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Tiquete puesto en proceso'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = finalizarTiquete(3, 'Terminadito! vea qué bonito', 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Tiquete finalizado'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$mensaje2 = calificarTiquete(2, 'No me parece que se deba calificar el duro trabajo de la gente', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 5);
//if($mensaje2 == ''){
//    echo 'Tiquete calificado'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$prioridades = obtenerPrioridades();
//
//foreach ($prioridades as $esta) {   
//    echo $esta->obtenerCodigoPrioridad() .'  ' . $esta->obtenerNombrePrioridad().'<br />'; 
//    
//}

//$mensaje2 = actualizarPrioridad(7, 3, 'nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Prioridad actualizado'.'<br />';
//}else{
//    echo $mensaje2;
//}

//$tiquetes = obtenerTiquetesHistorial('', 'nu', '', '',
//        'lu', '1997-08-02', '2018-02-07');
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() .'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//
//}

//$tiquetes = obtenerHistorial(2);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerCodigoHistorial() .'<br />'; 
//    echo $tema->obtenerCodigoIndicador() . '<br />';
//    echo $tema->obtenerComentarioUsuario() . '<br />';
//    echo $tema->obtenerCorreoResponsable() . '<br />';
//    echo $tema->obtenerNombreUsuarioCausante() . '<br />';
//    echo $tema->obtenerCorreoResponsable() . '<br />';
//    echo $tema->obtenerNombreResponsable() . '<br />';
//    echo $tema->obtenerFechaHora() . '<br />';
//    echo $tema->obtenerAclaracionSistema() . '<br />';
//}

//$codigosEstados = array();
//$codigosEstados[] = 1;
//$codigosEstados[] = 4;
//$codigosEstados[] = 7;
//$tiquetes = busquedaAvanzdaPrincipal('', 'be', '', '',
//        'lu', '1995-01-01', '2018-02-11', $codigosEstados);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCodigoUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//
//}

//$mensaje2 = actualizarFechaEntrega(2, '2018-09-15', 'Pues no se me ocurre ninguna excusa','nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}


//$codigosEstados = array();
//$codigosEstados[] = 2;
//$codigosEstados[] = 4;
//$codigosEstados[] = 7;
//$tiquetes = tiquetesAsignadosAvanzada('12b3', '2011-02-20', '2018-02-23', $codigosEstados);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCodigoUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//    echo '<br />';
//}

//$codigosEstados = array();
//$codigosEstados[] = 2;
////$codigosEstados[] = 4;
////$codigosEstados[] = 7;
//$tiquetes = tiquetesPorUsuarioAvanzada('nubeblanca1997@outlook.com', '2011-02-20', '2018-02-23', $codigosEstados);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCodigoUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//    echo '<br />';
//}

//$mensaje2 = enviarAReprocesar(3, 'Sigue sin servir','nubeblanca1997@outlook.com', 'Cristina Cascante');
//if($mensaje2 == ''){
//    echo 'Actualizado correctamente'.'<br />';
//}else{
//    echo $mensaje2;
//}

//busquedaAvanzadaGeneral($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable,
      //  $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol)
//$codigosEstados = array();
//$codigosEstados[] = 1;
//$codigosEstados[] = 4;
//$codigosEstados[] = 7;
//$tiquetes = busquedaAvanzadaGeneral('', '', '', '',
//        '', '1995-01-01', '2018-02-24', null, 2, 2);
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCodigoUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerArea()->obtenerNombreArea() . '<br />';
//    echo '<br />';
//
//}

//$reportes = reporteCumplimientoPorArea('2018/01/01', '2018/04/29');
//
//foreach ($reportes as $r){
//    echo $r->obtenerNombreArea() . '<br />';
//    echo $r->obtenerTotalCalificadas() . '<br />';
//    echo $r->obtenerTotalAtendidas() . '<br />';
//}

//$codigos = obtenerClasificacionesPorArea(2);
//
//foreach ($codigos as $c){
//    echo $c . '<br />';
//}

//$reportes = obtenerReporteTiquetesIngresadosPorClasificacion(1, '2018/01/01', '2018/04/28');
//
//foreach ($reportes as $r){
//    echo $r->obtenerDescripcionClasificacion() . '<br />';
//    echo $r->obtenerCantidadClasificacion() . '<br />';
//}

//$reportes = obtenerReporteCantidadDeTiquetesMensuales('2018');
//
//foreach ($reportes as $r){
//    echo $r->obtenerMes() . '<br />';
//    echo $r->obtenerCantidadMensuales() . '<br />';
//}

//$tiquetes = reporteTiquetesEnEstados('En proceso');
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() . '<br />';
//    echo $tema->obtenerCodigoUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerFechaEntrega()->format('d-m-Y H:i') . '<br />';
//    echo '<br />';
//}

//$reportes = reportePromedioCalificacionesPorArea();
//
//foreach($reportes as $r){
//    echo $r->obtenerCodigoArea() . '<br />';
//    echo $r->obtenerNombreArea() . '<br />';
//    echo $r->obtenerPromedioCalificiones() . '<br />';
//}

//$reportes = reportePromedioCalificacionesPorResponsables(2);
//
//foreach($reportes as $r){
//    echo $r->obtenerNombreResponsable() . '<br />';
//    echo $r->obtenerPromedioCalificiones() . '<br />';
//}


//$tiquetes = reporteTodosLosTiquetesFecha('2018-04-19', '2018-05-19');
//
//foreach ($tiquetes as $tema) {   
//    echo $tema->obtenerDescripcion() .'  ' . $tema->obtenerCodigoUsuarioIngresaTiquete(). ' '
//            . $tema->obtenerEstado()->obtenerNombreEstado().'<br />'; 
//    echo $tema->obtenerNombreUsuarioIngresaTiquete() . '<br />';
//    echo $tema->obtenerDepartamentoUsuarioSolicitante() . '<br />';
//    echo $tema->obtenerJefaturaUsuarioSolicitante() . '<br />';
//}


//$reportes = reporteCantidadTiquetePorEstados();
//
//foreach($reportes as $r){
//    echo $r->obtenerNombreEstado() . '<br />';
//    echo $r->obtenerCantidad() . '<br />';
//}