<?php
require ("../modelo/ProcedimientosTiquetes.php");
// <editor-fold defaultstate="collapsed" desc="Administracion general de los tiquetes">
//Redirige a la pagina anterior de la que se dio click
//function retornarABandeja() {
//    
////    if ($codigoPagina == 1) {
////        echo "../vista/TiquetesCreados.php";
////    } else if ($codigoPagina == 2) {
////        echo "../vista/AsignarTiquetes.php";
////    } else if ($codigoPagina == 3) {
////        echo "../vista/TiquetesAsignados.php";
////    }
//    echo "../vista/BandejasTiquetes.php?tab=' . $codigoPagina . '";
//}

function codigoPagina($codigoPagina) {
    echo '<input id = "codigoPagina" type="hidden" value="' . $codigoPagina . '">';
}

//Descripcion de la pagina donde viene el tiquete
function listaTiquetesCargarTodos($codigoPagina, $r, $fechaI, $fechaF, $criteriosDeFiltrado, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG) {
    $fechaInicio = $fechaI;
    if ($fechaI != "") {
        $dia = substr($fechaInicio, 0, 2);
        $mes = substr($fechaInicio, 3, 2);
        $anio = substr($fechaInicio, 6, 4);
        $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    } else {
        $fechaInicio = "1950-01-01";
    }
    $fechaFinal = $fechaF;
    if ($fechaF != "") {
        $dia = substr($fechaFinal, 0, 2);
        $mes = substr($fechaFinal, 3, 2);
        $anio = substr($fechaFinal, 6, 4);
        $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    } else {
        $hoy = getdate();
        $anio = $hoy["year"];
        $mes = $hoy["mon"];
        if ($mes < 10) {
            $mes = "0" . $mes;
        }
        $dia = $hoy["mday"];
        if ($dia < 10) {
            $dia = "0" . $dia;
        }
        $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    }
    $codigosEstados = $criteriosDeFiltrado;
    if ($codigoPagina == 4) {
        $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
        $codigoRol = $r->obtenerRol()->obtenerCodigoRol();
        $tiquetes = busquedaAvanzadaGeneral($codigoFiltroG, $correoSG, $nombreSG, $correoRG, $nombreRG, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol);
        // $tiquetes = obtenerTodosLosTiquetes();
    }
    return $tiquetes;
}

function listaTiquetesCargar($codigoPagina, $r, $fechaI, $fechaF, $criteriosDeFiltrado) {
    $fechaInicio = $fechaI;
    if ($fechaI != "" && $fechaF != "") {
        $dia = substr($fechaInicio, 0, 2);
        $mes = substr($fechaInicio, 3, 2);
        $anio = substr($fechaInicio, 6, 4);
        $fechaInicio = $anio . '-' . $mes . '-' . $dia;

        $fechaFinal = $fechaF;
        $dia = substr($fechaFinal, 0, 2);
        $mes = substr($fechaFinal, 3, 2);
        $anio = substr($fechaFinal, 6, 4);
        $fechaFinal = $anio . '-' . $mes . '-' . $dia;

        $codigosEstados = $criteriosDeFiltrado;
        if ($codigoPagina == 1) {
            $correo = $r->obtenerCorreo();
            $tiquetes = tiquetesPorUsuarioAvanzada($correo, $fechaInicio, $fechaFinal, $codigosEstados);
            //$tiquetes = obtenerTiquetesPorUsuario($correo);
        } else if ($codigoPagina == 2) {
            $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
            $tiquetes = obtenerTiquetesPorAsignarArea($codigoArea);
        } else if ($codigoPagina == 3) {
            $codigoEmpleado = $r->obtenerCodigoEmpleado();
            $tiquetes = tiquetesAsignadosAvanzada($codigoEmpleado, $fechaInicio, $fechaFinal, $codigosEstados);
            // $tiquetes = obtenerTiquetesAsignados($codigoEmpleado);
        }
    } else {
        if ($codigoPagina == 1) {
            $correo = $r->obtenerCorreo();
            $tiquetes = obtenerTiquetesPorUsuario($correo);
        } else if ($codigoPagina == 2) {
            $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
            $tiquetes = obtenerTiquetesPorAsignarArea($codigoArea);
        } else if ($codigoPagina == 3) {
            $codigoEmpleado = $r->obtenerCodigoEmpleado();
            $tiquetes = obtenerTiquetesAsignados($codigoEmpleado);
        }
    }

    return $tiquetes;
}

//Muestra el tiquete anterior de la lista cargada
function tiqueteMostrarAnterior($codigoPagina, $r, $tiqueteActual, $fechaIn, $fechaFin, $criterios, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG) {
    $crit = array();
    $i = 1;
    foreach ($criterios as $c) {
        if ($c != "") {
            $crit[] = $i;
        }
        $i = $i + 1;
    }if ($codigoPagina == 4) {
        $tiquetes = listaTiquetesCargarTodos($codigoPagina, $r, $fechaIn, $fechaFin, $crit, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG);
    } else {
        $tiquetes = listaTiquetesCargar($codigoPagina, $r, $fechaIn, $fechaFin, $crit);
    }
    $tamanioTiquetes = count($tiquetes);
    for ($i = 0; $i < $tamanioTiquetes; $i++) {
        if ($tiquetes[$i]->obtenerCodigoTiquete() == $tiqueteActual && $i != 0) {
            $codigoTiquete = $tiquetes[$i - 1]->obtenerCodigoTiquete(); //cargo el div
            $respuesta = array("tiquete" => $codigoTiquete, "pagina" => $codigoPagina);
            echo json_encode($respuesta);
        } else if ($i == 0) {
//  return $tiquetes[$tamnioTiquetes-1]['codigoTiquete'];
// o mostrar title indicando que ya no hay mas atras
        }
    }
}

//Muestra el tiquete sigueinte de la lista cargada
function tiqueteMostrarSiguiente($codigoPagina, $r, $tiqueteActual, $fechaIn, $fechaFin, $criterios, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG) {
    $crit = array();
    $i = 1;
    foreach ($criterios as $c) {
        if ($c != "") {
            $crit[] = $i;
        }
        $i = $i + 1;
    }if ($codigoPagina == 4) {
        $tiquetes = listaTiquetesCargarTodos($codigoPagina, $r, $fechaIn, $fechaFin, $crit, $codigoFiltroG, $nombreSG, $correoSG, $nombreRG, $correoRG);
    } else {
        $tiquetes = listaTiquetesCargar($codigoPagina, $r, $fechaIn, $fechaFin, $crit);
    }
    //$tiquetes = listaTiquetesCargar($codigoPagina, $r, $fechaIn, $fechaFin, $crit);
    $tamanioTiquetes = count($tiquetes);
    for ($i = 0; $i < $tamanioTiquetes; $i++) {
        if ($tiquetes[$i]->obtenerCodigoTiquete() == $tiqueteActual && $i != $tamanioTiquetes - 1) {
            $codigoTiquete = $tiquetes[$i + 1]->obtenerCodigoTiquete(); //cargo el div
            $respuesta = array("tiquete" => $codigoTiquete, "pagina" => $codigoPagina);
            echo json_encode($respuesta);
        } else if ($i + 1 == $tamanioTiquetes) {
//  return $tiquetes[$tamnioTiquetes-1]['codigoTiquete'];
// o mostrar title indicando que ya no hay mas atras
        }
    }
}

function tiqueteMostrarComboPaginas($codigoPagina, $r, $tiquetes) {

    $tamanioTiquetes = count($tiquetes);
    if ($tamanioTiquetes != 0) {
        $codigoTiquete = $tiquetes[0]->obtenerCodigoTiquete(); //cargo el div
        $respuesta = array("tiquete" => $codigoTiquete, "pagina" => $codigoPagina);
    } else {
        $respuesta = array("tiquete" => "-1", "pagina" => "-1");
    }
    echo json_encode($respuesta);
}

function descripcionPagina($codigoPagina, $r) {

    if ($codigoPagina == 1 || $codigoPagina == 2 || $codigoPagina == 3) {
        echo '<select id ="comboPagina" class="form-control" onchange ="cambiarComboPagina(this);">';
        echo $codigoPagina == 1 ? "<option value ='1' selected>Mis tiquetes</option>" :
                "<option value ='1' >Mis tiquetes</option>";

        if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 6)) {
            echo $codigoPagina == 2 ? "<option value ='2' selected>Tiquetes por Asignar</option>" :
                    "<option value ='2' >Tiquetes por Asignar</option>";
        }
        if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 7)) {
            echo $codigoPagina == 3 ? "<option value ='3' selected>Tiquetes asignados</option>" :
                    "<option value ='3'>Tiquetes asignados</option>";
        }
        echo '</select>';
    } else if ($codigoPagina == 4) {
        if (verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 8)) { ///cambiar por el permiso faltante
            echo "<div style = 'text-align:center;'><h4 value ='4'>Todos los tiquetes</h4></div>";
        }
    }
}

function asignarResponsable($codigoPagina, $tiquete) {
    if ($codigoPagina == 1 && $tiquete->obtenerEstado()->obtenerCodigoEstado() == 6) {

        echo'<div class="col-md-12  encabezadoAsignar">';
        echo '<button class = "btn btn-info" onclick="Reprocesar();" >Reprocesar</button>'
        . '</div>';
    }
    if ($codigoPagina == 2) {
        echo'<div class="col-md-12  encabezadoAsignar">';
        echo '<button class = "btn btn-info" onclick="asignarUnTiquete(2);" >Asignar</button>'
        . '</div>';
    } else if ($codigoPagina == 3) {
        paginaAsignados($tiquete);
    } else if ($codigoPagina == 4) {
        paginaTodosTiquetes($tiquete);
    }
}

function paginaAsignados($tiquete) {
    $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();
    echo'<div class="col-md-12 encabezadoAsignar">';
    if ($estado == 4 || $estado == 2) {
        echo '<button class = "btn btn-success botones-tiquete" onclick="reasignar()">Enviar a reasignar</button>';
        echo '<button class = "btn btn-warning botones-tiquete" onclick="Anular()" id="anular" >Anular</button>';
    }
// echo'</div>'
// . '<div class="col-md-1 encabezadoAsignar">';
    if ($estado == 2) {
        echo '<button class ="btn btn-success botones-tiquete" onclick="enProceso()" >En proceso</button>';
    } else if ($estado == 4) {
        echo '<button class ="btn btn-warning botones-tiquete" onclick="Finalizar()"  >Finalizar</button>';
    }
    echo '</div>';
}

function paginaTodosTiquetes($tiquete) {
    $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();

    echo'<div class="col-md-12 encabezadoAsignar">';
    if ($estado != 5 && $tiquete->obtenerResponsable()==null ) {
        echo '<button class = "btn btn-info" onclick="asignarUnTiquete(4);" >Asignar</button>';
    }
    else{
        echo '<button class = "btn btn-success" onclick="asignarUnTiquete(4);" >reasignar </button>';
    }
    if ($estado == 4 || $estado == 2) {
        echo '<button class = "btn btn-warning botones-tiquete" onclick="Anular()" id="anular" >Anular</button>';
    }
    echo '</div>';
}

function comboResponsablesAsignar($responsables, $numero) {
    if ($numero == 2) {
        echo '<select class="form-control" id="comboResponsables">';
    } else if ($numero == 4) {
        echo '<select class="form-control" id="comboTodosResponsables">';
    }
    foreach ($responsables as $responsable) {
        echo '<option value="' . $responsable->obtenerCodigoEmpleado() . '" selected>' . $responsable->obtenerNombreResponsable() . '</option>';
    }
    echo '</select>';
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="CLASIFICACION DEL TIQUETE">
function crearListatematicas($tematicas) {
    $vectematica = new ArrayObject();
    foreach ($tematicas as $tematica) {
        if ($tematica->obtenerCodigoPadre() == 0) {
            $vectematica[$count++] = $tematica;
            $vectematica[$count++] = new ArrayObject();
        }
    } $count = 0;
    for ($i = 0; $i < count($vectematica); $i += 2) {
        foreach ($tematicas as $tematica) {
            if ($tematica->obtenerCodigoPadre() == $vectematica[$i]->obtenerCodigoTematica()) {
                $vectematica[$i + 1][$count++] = $tematica;
            }
        }
        $count = 0;
    }
    return $vectematica;
}

function tematicasNivel1($listematicas) {
    $count = count($listematicas);
    for ($i = 0; $i < $count; $i += 2) {
        $nombreli = "toggleDemo" . $i;
        echo'<li class="list-group-item" id="primerNivel">
                        <a  data-toggle="collapse" data-target="#' . $nombreli . '" data-parent="#sidenav01" class="collapsed">
                            <label>' . $listematicas[$i]->obtenerDescripcionTematica() . ' </label>  <span class="caret pull-right"></span>
                        </a>
                        <div class="collapse" id="' . $nombreli . '" >
                            <ul class="nav nav-list">';
        subtematicas($listematicas[$i + 1]);
        echo' </ul>
                        </div>
                    </li>';
    }
}

function subtematicas($listematicas) {
    echo' <ul class = "nav nav-list">';
    $tematicasSize = count($listematicas);
    for ($i = 0; $i < $tematicasSize; $i++) {
        echo'<li class = "list-group-item " id="segundoNivel"><a onclick="actualizarTematica(this);" >' . $listematicas[$i]->obtenerDescripcionTematica() . '</a></li>';
    }
    echo'</ul>';
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="INFORMACIOM DEL TIQUETE">
function tiquete($tiquetes, $codigo) {
    foreach ($tiquetes as $tiquete) {
        if ($tiquete->obtenerCodigoTiquete() == $codigo) {
            return $tiquete;
        }
    }
    return null;
}

function panelDeCabecera($tiquete) {
    if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 1) {
        echo ' <div class="panel panel-danger">';
    } else if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 2) {
        echo ' <div class="panel panel-warning">';
    } else if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 3) {
        echo ' <div class="panel panel-success">';
    }
}

function codigoTiquete($tiquete) {
    echo $tiquete->obtenerCodigoTiquete();
}

function descripcionTematica($tiquete) {
    echo $tiquete->obtenerTematica()->obtenerDescripcionTematica();
}

function nombreSolicitante($tiquete) {
    echo $tiquete->obtenerNombreUsuarioIngresaTiquete();
}

function correoSolicitante($tiquete) {
    echo $tiquete->obtenerCodigoUsuarioIngresaTiquete();
}

function jefaturaSolicitante($tiquete) {
    echo $tiquete->obtenerJefaturaUsuarioSolicitante();
}

function departamentoSolicitante($tiquete) {
    echo $tiquete->obtenerDepartamentoUsuarioSolicitante();
}

function nombreResponsable($tiquete) {
    if ($tiquete->obtenerResponsable() != null) {
        echo $tiquete->obtenerResponsable()->obtenerNombreResponsable();
    } else {
        echo "No hay un responsable asignado";
    }
}

function correoResponsable($tiquete) {
    if ($tiquete->obtenerResponsable() != null) {
        echo $tiquete->obtenerResponsable()->obtenerCorreo();
    }
}

function horasTrabajadas($tiquete, $codigoPagina) {
    if ($codigoPagina == 1 || $codigoPagina == 2 || $codigoPagina == 3  || $codigoPagina == 5 && $tiquete->obtenerEstado()->obtenerCodigoEstado() != 4) {
        echo $tiquete->obtenerHorasTrabajadas() != null ? $tiquete->obtenerHorasTrabajadas() : "0";
    } else if ($codigoPagina == 3) {
        echo horasTrabajadasModificable($tiquete);
    }
}

function horasTrabajadasModificable($tiquete) {
    $horas = $tiquete->obtenerHorasTrabajadas() != null ? $tiquete->obtenerHorasTrabajadas() : "0";
    echo '<div class="form-group col-md-12 input-group">
     <input onblur="CambiarHorastrabajadas()"; type="text" class="form-control" name="HorasT" id="HorasT" min="0"  
     value="' . $horas . '" >

     </div>';
}

function areaTiquete($tiquete) {
    echo $tiquete->obtenerArea()->obtenerNombreArea();
}

function clasificacionTiquete($tiquete, $codigoPagina) {
    if ($codigoPagina == 2 || $codigoPagina == 3 ) {
        echo '<div class = "col-md-12 form-group input-group">
            <input type="text" class="form-control" onBlur = "pierdeFoco();" name="clasificacion" id="clasificacionTiquete" 
            value="' . $tiquete->obtenerTematica()->obtenerDescripcionTematica() . '" >           
                <span onclick="ClasificacionesAsignar()";  title = "Modficar fecha de solicitud" class ="input-group-addon btn btn-info">
                    <span class="glyphicon glyphicon-th-list"></span>
                </span>    
            </div>';
    } else  {
        echo $tiquete->obtenerTematica()->obtenerDescripcionTematica();
    }
}

function estadoTiquete($tiquete) {
    echo $tiquete->obtenerEstado()->obtenerNombreEstado();
}

function prioridadTiquete($tiquete, $codigoPagina, $prioridades) { //aun no se que pagina puede modficar la prioridad
    if ($codigoPagina == 1 || $codigoPagina == 3 || $codigoPagina == 4|| $codigoPagina == 5) {
        echo '<div class = "col-md-2" style = "text-align:center; color:white">';
        if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 3) {
            echo '<div style = "background-color:#5CB85C;">';
        } else if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 2) {
            echo '<div style = "background-color:#F0AD4E;">';
        } else if ($tiquete->obtenerPrioridad()->obtenerCodigoPrioridad() == 1) {
            echo '<div style = "background-color:#D9534F;">';
        }
        echo '<h5>' . $tiquete->obtenerPrioridad()->obtenerNombrePrioridad() . '<h5>';
        echo '</div></div>';
    } else if ($codigoPagina == 2) {
        echo '<div class="col-md-8">';
        echo '<div class="col-md-12 form-group input-group">';
        echo '<select class="form-control"  onchange = "cambiarPrioridad(this)">';
        foreach ($prioridades as $p) {
            if ($p->obtenerCodigoPrioridad() == $tiquete->obtenerPrioridad()->obtenerCodigoPrioridad()) {
                echo '<option selected value ="' . $p->obtenerCodigoPrioridad() . '" >' . $p->obtenerNombrePrioridad() . '</option>';
            } else {
                echo '<option value ="' . $p->obtenerCodigoPrioridad() . '">' . $p->obtenerNombrePrioridad() . '</option>';
            }
        }
        echo '</select>' .
        '</div></div>';
    }
}

function descripcionTiquete($tiquete) {
    echo $tiquete->obtenerDescripcion();
}

function fechaCreacionTiquete($tiquete) {
    echo date_format($tiquete->obtenerFechaCreacion(), 'd/m/Y ');
}

function fechaSolicitudTiquete($tiquete, $codigoPagina) {

    if ($codigoPagina == 1) {
        echo '<div class="form-group input-group date" id="datetimepicker1"  >
    <input type="text"  class="datetimepicker form-control" name="cotizada" id="cotizada" onblur="CambiarFechaSolicitada()" onfocus="fechaAntigua()"
           value="' . date_format($tiquete->obtenerFechaCotizado(), 'd/m/Y') . '" >
    <span class="input-group-addon btn btn-info" id="fecha" onclick="document.getElementById(\'cotizada\').focus()"  >
        <span class="glyphicon glyphicon-calendar" ></span>
    </span>                              
</div>';
    } else {
        echo "<h5>" . date_format($tiquete->obtenerFechaCotizado(), 'd/m/Y') . "</h5>";
    }
}

function fechaFinalizadoTiquete($tiquete) {
    if ($tiquete->obtenerFechaFinalizado() != null) {
        echo'  <input  type="text" class="form-control" name="tematica" id="finalizado"  '
        . 'value="' . date_format($tiquete->obtenerFechaFinalizado(), 'd/m/Y ') . '" readonly="readonly">';
    } else
        echo'Tiquete no finalizado aún';
}

function fechaEntregaTiquete($tiquete, $codigoPagina) {
    if ($tiquete->obtenerFechaEntrega() != null) {
        if ($codigoPagina == 3) {
            echo '<div class="form-group input-group date" id="datetimepicker1"  >
    <input type="text"  class="datetimepicker form-control" name="cotizada" id="fechaEntregaC" onblur="CambiarFechaEntrega()" onfocus="fechaAntiguaEntrega()"
           value="' . date_format($tiquete->obtenerFechaEntrega(), 'd/m/Y') . '" >
    <span class="input-group-addon btn btn-info" id="fecha" onclick="document.getElementById(\'fechaEntregaC\').focus()"  >
        <span class="glyphicon glyphicon-calendar" ></span>
    </span>                              
</div>';
        } else {
            echo "<h5>" . date_format($tiquete->obtenerFechaEntrega(), 'd/m/Y') . "</h5>";
        }
    } else
        echo'Sin fecha aún';
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="CALIFICACION">
function mostrarCalificacion($codigoPagina, $tiquete) {
    $califiacion = $tiquete->obtenerCalificacion();
    $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();
    if ($califiacion != null) {
        echo '<div class = "rating">';
        if ($califiacion == 5) {
            echo '<input type="radio" id="star5" name="rating" value="5" checked disabled /><label for="star5" title="Excelente">5 stars</label>';
        } else {
            echo '<input type="radio" id="star5" name="rating" value="5"   disabled/><label for="star5" title="Excelente">5 stars</label>';
        }
        if ($califiacion == 4) {
            echo '<input type="radio" id="star4" name="rating" value="4" checked disabled/><label for="star4" title="Muy Bueno">4 stars</label>';
        } else {
            echo '<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="Muy Bueno">4 stars</label>';
        }
        if ($califiacion == 3) {
            echo '<input type="radio" id="star3" name="rating" value="3" checked disabled/><label for="star3" title="Bueno">3 stars</label>';
        } else {
            echo '<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="Bueno">3 stars</label>';
        }
        if ($califiacion == 2) {
            echo '<input type="radio" id="star2" name="rating" value="2" checked disabled/><label for="star2" title="Regular">2 stars</label>';
        } else {
            echo '<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="Regular">2 stars</label>';
        }
        if ($califiacion == 1) {
            echo '<input type="radio" id="star1" name="rating" value="1" checked disabled/><label for="star1" title="Deficiente">1 star</label>';
        } else {
            echo '<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="Deficiente">1 star</label>';
        }

        echo '</div>';
    } else if ($estado == 6 && $codigoPagina == 1) {
        echo '<div class = "rating">' .
        '<input type="radio" id="star5" name="rating2" value="5" onclick="calificar(this)"/><label for="star5" title="Excelente">5 stars</label>' .
        '<input type="radio" id="star4" name="rating2" value="4" onclick="calificar(this)"/><label for="star4" title="Muy Bueno">4 stars</label>' .
        '<input type="radio" id="star3" name="rating2" value="3" onclick="calificar(this)" /><label for="star3" title="Bueno">3 stars</label>' .
        '<input type="radio" id="star2" name="rating2" value="2" onclick="calificar(this)"/><label for="star2" title="Regular">2 stars</label>' .
        '<input type="radio" id="star1" name="rating2" value="1" onclick="calificar(this)"/><label for="star1" title="Deficiente">1 star</label>' .
        '</div>';
    } else {
        echo '<div class = "rating2">' .
        '<input type="radio" id="star5" name="rating2" value="5" /><label ="star5" title="Excelente">5 stars</label>' .
        '<input type="radio" id="star4" name="rating2" value="4" /><label for="star4" title="Muy Bueno">4 stars</label>' .
        '<input type="radio" id="star3" name="rating2" value="3" /><label for="star3" title="Bueno">3 stars</label>' .
        '<input type="radio" id="star2" name="rating2" value="2" /><label for="star2" title="Regular">2 stars</label>' .
        '<input type="radio" id="star1" name="rating2" value="1" /><label for="star1" title="Deficiente">1 star</label>' .
        '</div>';
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="COMENTARIOS">
function agregarAdjuntoComentario($codigoTiquete, $r) {
    $comentario = $_POST['comentario'];
    $correoU = $r->obtenerCorreo();
    $nombreU = $r->obtenerNombreResponsable();
    if ($comentario == null) {
        $comentario = '';
    }
    if ($_FILES["archivo"]) {
        $nombre_tmp = $_FILES["archivo"]["tmp_name"];
// basename() puede evitar ataques de denegació del sistema de ficheros;
// podría ser apropiado más validación/saneamiento del nombre de fichero
        $archivo = basename($_FILES["archivo"]["name"]);
        $adjuno = '..\\adjuntos\\' . $codigoTiquete . "-" . $archivo;
        move_uploaded_file($nombre_tmp, utf8_decode($adjuno));
    }
    if ($adjuno == null) {
        $adjuno = '';
    }
    $mensaje = agregarAdjunto($codigoTiquete, $comentario, $correoU, $nombreU, $adjuno);
    return $mensaje;
}

function agregarComentarios($comentarios, $r) {
    foreach ($comentarios as $comentario) {
        echo '<div class="panel" style = "background-color:#f8f9f9;">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6 encabezado">
                    <h5 class="panel-title">' . $comentario->obtenerNombreCausante() . '</h5>                                        
                </div>
                <div class="col-md-6 encabezado encabezadoAsignar" >
                    <h5 class="panel-title">' . $comentario->obtenerFecha() . '</h5>
                </div>                    
            </div>
        </div>
        <div class="panel-body">';
        if ($comentario->obtenerComentario() != '') {
            echo'<div class="form-group">                    
                <textarea class="form-control" rows="3"  name="comentario" cols="2" >' . $comentario->obtenerComentario() . ' </textarea>
            </div>';
        }
        if ($comentario->obtenerDireccionAdjunto() != '') {
            echo ' <div class="form-group"> ';
            $numero = strpos($comentario->obtenerDireccionAdjunto(), "-", 1);
            echo'<a href="' . $comentario->obtenerDireccionAdjunto() . '" target="_blank"><button type="button" class="btn btn-info">
                        <span class="glyphicon glyphicon-file"></span>' . substr($comentario->obtenerDireccionAdjunto(), $numero + 1) . '</button></a>'
            . '</div>';
        }
        echo' </div></div>';
    }
}

function obtenerComentariosCompleto($listaComentariosPorTiquete, $r) {
    agregarComentarios($listaComentariosPorTiquete, $r);
}

// </editor-fold>

function intoTiquete($r){
    $infotiqute="";
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

              .' <section class ="container-fluid"> '                     
                   .' <div class="row"> '
                       .' <div class="col-md-4 " >'
                            .'<button  onclick="retornarABandeja();" title="Regresar" type="button" class="btn btn-info " data-toggle="modal" data-target=""><i class="glyphicon glyphicon-arrow-left"></i></button>'
                       .' </div>'
                       .' <div class="  col-md-1" style="text-align: right;">'
                           .' <button title="Tiquete anterior" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick="tiqueteAnterior();"><i class="glyphicon glyphicon-triangle-left"></i></button>'
                        .'</div>'
                       .' <div class=" col-md-2">'; 
                       echo   descripcionPagina($codigoPagina, $r); 

                       echo'  </div>'
                        .'<div class="col-md-1"> '
                           .' <button  title="Siguiente Tiquete" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick=" tiqueteSiguiente();"><i class="glyphicon glyphicon-triangle-right"></i></button>'
                       .' </div>'
                   . '</div>'
                    .'<div class="row">';
                       echo  codigoPagina($codigoPagina); 
                        echo' <br>'
                   .' </div> '                                   
              .'  </section>'
               .' <section id = "seccionInfoTiquete" class ="container-fluid ocultarTiquetes">'
                   .' <div class="row">'                 
                        .'<div class="col-md-6">  ';
                          echo  panelDeCabecera($tiquete);                            
                             echo'<div class="panel-heading panel-success">' 
                               .' <div class="row">'
                                   .' <div class="col-md-3 encabezado">'
                                        .'<h5 class="panel-title" value = "<?php codigoTiquete($tiquete); ?>">Codigo: '; echo codigoTiquete($tiquete).'</h5> '                                       
                                   .' </div>'
                                    .'<div class="col-md-6 encabezado encabezadoDescripcion" >'
                                        .'<h5 class="panel-title">'; echo  descripcionTematica($tiquete) .'</h5>'
                                    .'</div>'
                                    .'<div class="col-md-3 encabezado encabezadoDescripcion" >'
                                       .' <button class = "btn btn-warning" onclick ="mostrarHistorialTiquetes();"><i class = "glyphicon glyphicon-list-alt"> Historial</i></button>'
                                    .'</div>'                                
                                .'</div>'
                            .'</div>'
                           .' <div class="panel-body">'
                               .' <div class="row"> <h4 class="col-md-3">Solicitante:</h4></div>'
                                .'<div class="row ">'  
                                    .'<h5 class="col-md-3 ">Nombre:</h5> '
                                    .'<div class=" col-md-8">'
                                        .'<h5> '; echo  nombreSolicitante($tiquete) .'</h5>'
                                    .'</div> '
                               .' </div>'
                               .' <div class="row "> '
                                   .' <h5 class="col-md-3 ">Correo:</h5>' 
                                   .' <div class=" col-md-8">'
                                       .' <h5>'; echo  correoSolicitante($tiquete) .'</h5>'
                                   .' </div> '
                               .' </div> '
                                .'<div class="row ">'
                                    .'<h5 class="col-md-3 ">Jefatura:</h5>' 
                                    .'<div class="col-md-8">'
                                        .'<h5>'; echo  jefaturaSolicitante($tiquete).'</h5>'
                                   .' </div> '
                               .' </div>'
                                .'<div class="row "> '
                                   .' <h5 class="col-md-3 ">Departamento:</h5> '
                                    .'<div class="col-md-8">'
                                       .' <h5>'; echo  departamentoSolicitante($tiquete).'</h5>'
                                   .' </div> '
                              . ' </div> '  

                               . '<div class="row "><h4 class="col-md-3">Responsable:</h4> </div>'
                               . '<div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class="col-md-8">'
                                        .'<h5>'; echo nombreResponsable($tiquete).'</h5>'
                                   .' </div> 
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
                                        .'<h5>'; echo  horasTrabajadas($tiquete, $codigoPagina) .'</h5>'
                                    .'</div>       
                                </div>

                                <div class="row "><h4 class="col-md-3 ">Tiquetes:</h4> </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Código:</h5> 
                                    <div class="col-md-8">'
                                       .' <h5 id ="codigoTiquete">'; echo codigoTiquete($tiquete).'</h5>'
                                    .'</div> 
                                </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Área:</h5> 
                                    <div class="col-md-8">'
                                        .'<h5>'; echo  areaTiquete($tiquete).'</h5>'
                                    .'</div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Clasificación:</h5> 
                                    <div class=" col-md-8">'
                                       .' <h5>'; echo clasificacionTiquete($tiquete, $codigoPagina).'</h5>'
                                  . ' </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Estado:</h5> 
                                    <div class="col-md-8">'
                                        .'<h5>'; echo  estadoTiquete($tiquete).'</h5>'
                                    .'</div> 
                                </div>
                                <div class = "row">
                                    <h5 class = "col-md-3">Prioridad:</h5>';

                                  echo   prioridadTiquete($tiquete, $codigoPagina, $prioridades); 

                                 echo'</div>'
                                .'<div class="row ">
                                    <h5 class="col-md-3">Creado el:</h5> 
                                    <div class=" col-md-8">'                                        
                                        .'<h5>' ; echo fechaCreacionTiquete($tiquete).'</h5>'
                                    .'</div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Solicitado para:</h5> 
                                    <div class=" col-md-8">';
                                       echo   $a = fechaSolicitudTiquete($tiquete, $codigoPagina); 
                                    echo' </div>'
                               . '</div>
                                <div class="row ">
                                    <h5 class="col-md-3">Fecha entrega:</h5> 
                                    <div class=" col-md-8">';
                                    echo     $a = fechaEntregaTiquete($tiquete, $codigoPagina);
                                    echo' </div>'
                              . ' </div>
                                <div class="row ">                            
                                    <h5 class="col-md-3">Fecha finalizado:</h5> 
                                    <div class=" col-md-8">'
                                        .'<h5>'; echo fechaFinalizadoTiquete($tiquete).'</h5>'
                                    .'</div> 
                                </div>
                                <div class="row ">
                                    <div><h5 class="col-md-12"> Descripción:</h5> </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="3"  id="descripcion" readonly="readonly">'; echo  descripcionTiquete($tiquete). '</textarea>
                                    </div>
                                </div>  
                                <div class="row ">&nbsp;</div>
                                <div class="row ">';
                                  echo   asignarResponsable($codigoPagina, $tiquete) ;
                                 echo'</div> '
                            .'</div>

                            <div class="panel-footer"> 
                                <label style="font-size:16px">Calificación</label> ' ;                              
                                echo  mostrarCalificacion($codigoPagina, $tiquete);                               
                             echo'</div>                              
                        </div>
                    </div>
                    <div class="col-md-6"> '    ;                   
                       echo  panelDeCabecera($tiquete); 
                         echo'<div class="panel-heading">
                            <h5 class="panel-title encabezado">Mensajes</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" id="comentarios" style ="height: 300px; overflow-y: auto; overflow-x: hidden;">  ' ;
                               
                                $listaComentariosPorTiquete = obtenerHistorialComentariosCompleto($codigoTiquete);
                            echo  obtenerComentariosCompleto($listaComentariosPorTiquete, $r);
                               
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
                          return $infotiqute;
}