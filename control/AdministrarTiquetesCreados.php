<?php

function cabecera() {
    echo ' <tr>                                            
        <th>Cod</th> 
        <th class ="thDescripcion">Descripción</th>
        <th>Solicitante</th>
        <th>Responsable</th>
        <th>Estado</th>
        <th>Prioridad</th>
        <th>Fecha entrega</th>
        <th>Calificación</th>                                    
        <th>Ver</th>
        <th>Historial</th>
        </tr> ';
}

// <editor-fold defaultstate="collapsed" desc="notifiaciones">
function notificacionBandeja() {
    echo ' <div style = "display:none;text-align:center" id = "divNotificacion" class="notificacion content alert alert-info">'
    . '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
    .'</br>'
    . '</div>';
}
// </editor-fold>

function cuerpoTablaMistiquetesCreados($Tiquetes, $codigoPestana, $responsables) {
    $cont = 1;
    foreach ($Tiquetes as $tique) {
        echo '<tr  data-toggle="tooltip" title="'.substr($tique->obtenerDescripcion(), 0, 70).'..." data-placement="top"  style = "text-align:center";>';
//        if($codigoPestana == 2) {
//            echo '<td value ="' . $tique->obtenerCodigoTiquete() . '">'
//            . '<input type = "checkbox" id = "check' . $tique->obtenerCodigoTiquete() . '"></td>';
//        }
        echo '<td>' . $tique->obtenerCodigoTiquete() . '</td>';
        echo '<td>' . $tique->obtenerTematica()->obtenerDescripcionTematica() . '</td>';
        echo '<td>' . $tique->obtenerNombreUsuarioIngresaTiquete() . '</td>';
        if ($codigoPestana == 2) {


            echo'<td>';
            comboResponsablesAsignar($tique, $responsables);
            echo'</td>';
        } else if ($tique->obtenerResponsable() == null) {
            echo '<td>Por asignar</td>';
        } else {
            echo '<td>' . $tique->obtenerResponsable()->obtenerNombreResponsable() . '</td>';
        }
        echo '<td>' . $tique->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $tique->obtenerPrioridad()->obtenerNombrePrioridad() . '</td>';
        if ($codigoPestana == 3) {
            $estado = $tique->obtenerEstado()->obtenerCodigoEstado();
            $fechaE = $tique->obtenerFechaEntrega();
            if ($fechaE != null) {
                $fechaE = date_format($tique->obtenerFechaEntrega(), 'd-m-Y');
                $hoy = getdate();
                $fechaDeHoy = fechaHoy($hoy);
                $datetime1 = new DateTime($fechaDeHoy);
                $datetime2 = new DateTime($fechaE);
                $interval = $datetime1->diff($datetime2);
                $intervalo = $interval->format('%d');
                $fechaE = date_format($tique->obtenerFechaEntrega(), 'd/m/Y');

                if ($intervalo < 1 && ($estado == 1 || $estado == 2 || $estado == 4)) {
                    echo '<td style= " text-align:center;background:#F2DEDE " >' . $fechaE . '</td>';
                    //rojo
                } else if ($intervalo <= 2 && ($estado == 1 || $estado == 2 || $estado == 4)) {
                    echo '<td  style= "text-align:center; background:#f7dc6f;">' . $fechaE . '</td>';
                    //amarillo
                } else if ($intervalo > 2 && ($estado == 1 || $estado == 2 || $estado == 4)) {
                    echo '<td style= "text-align:center; background:#DFF0D8;">' . $fechaE . '</td>';
                    //verde
                } else {

                    echo '<td style= "text-align:center; background:#D9EDF7;">' . $fechaE . '</td>';
                }
            } else {
                echo '<td style= "text-align:center; background:#F0F0F0">Fecha no asignada</td>';
            }
        } else {
            $fechaE = date_format($tique->obtenerFechaEntrega(), 'd/m/Y');
            if ($fechaE != "") {
                echo '<td style= "text-align:center;">' . $fechaE . '</td>';
            } else {
                echo '<td style= "text-align:center; " >Fecha no asignada</td>';
            }
        }
        calificacion($codigoPestana, $tique, $cont++);
        // if ($codigoPestana == 1) {
        echo '<td onclick="mostrarMisTIquetes(this,' . $codigoPestana . ');">' . '<button type="button" class="btn btn-info">
               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
//        } else if ($codigoPestana == 2) {
//            echo '<td onclick="mostrarTiquetesPorAsignar(this);">' . '<button type="button" class="btn btn-info">
//               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
//        } else if ($codigoPestana == 3) {
//            echo '<td onclick="mostrarTiquetesAsignados(this);">' . '<button type="button" class="btn btn-info">
//               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
//        } else if ($codigoPestana == 4) {
//            echo '<td onclick="mostrarTodosLosTiquetes(this);">' . '<button type="button" class="btn btn-info">
//               <span class="glyphicon glyphicon-eye-open"></span> </button></td>';
//        }      
        echo '<td style = "text-align: center" onclick="mostrarHistorialTiquetes(this,' . $codigoPestana . ');">' . '<button type="button" class="btn btn-warning">
        <span class="glyphicon glyphicon-list-alt"></span></button></td>';
        echo '</tr>';
    }
}

function calificacion($codigoPestana, $tiquete, $cont) {
    $califiacion = $tiquete->obtenerCalificacion();
    $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();
    if ($califiacion != null) {
        echo '<td class = "rating">';
        if ($califiacion == 5) {
            echo '<input type="radio" id="' . $codigoPestana . 'star5-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="5" checked Disabled /><label for="' . $codigoPestana . 'star5-' . $cont . '" title="Excelente">5 stars</label>';
        } else {
            echo '<input type="radio" id="' . $codigoPestana . 'star5-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="5"  Disabled /><label for="' . $codigoPestana . 'star5-' . $cont . '" title="Excelente">5 stars</label>';
        }
        if ($califiacion == 4) {
            echo '<input type="radio" id="' . $codigoPestana . 'star4-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="4" checked Disabled/><label for="' . $codigoPestana . 'star4-' . $cont . '" title="Muy Bueno">4 stars</label>';
        } else {
            echo '<input type="radio" id="' . $codigoPestana . 'star4-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="4" Disabled/><label for="' . $codigoPestana . 'star4-' . $cont . '" title="Muy Bueno">4 stars</label>';
        }
        if ($califiacion == 3) {
            echo '<input type="radio" id="' . $codigoPestana . 'star3-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '"" value="3" checked Disabled/><label for="' . $codigoPestana . 'star3-' . $cont . '" title="Bueno">3 stars</label>';
        } else {
            echo '<input type="radio" id="' . $codigoPestana . 'star3-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="3" Disabled/><label for="' . $codigoPestana . 'star3-' . $cont . '" title="Bueno">3 stars</label>';
        }
        if ($califiacion == 2) {
            echo '<input type="radio" id="' . $codigoPestana . 'star2-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="2" checked Disabled/><label for="' . $codigoPestana . 'star2-' . $cont . '" title="Regular">2 stars</label>';
        } else {
            echo '<input type="radio" id="' . $codigoPestana . 'star2-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="2" Disabled/><label for="' . $codigoPestana . 'star2-' . $cont . '" title="Regular">2 stars</label>';
        }
        if ($califiacion == 1) {
            echo '<input type="radio" id="' . $codigoPestana . 'star1-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="1" checked Disabled/><label for="' . $codigoPestana . 'star1-' . $cont . '" title="Deficiente">1 star</label>';
        } else {
            echo '<input type="radio" id="' . $codigoPestana . 'star1-' . $cont . '" name="' . $codigoPestana . 'star' . $cont . '" value="1" Disabled/><label for="' . $codigoPestana . 'star1-' . $cont . '" title="Deficiente">1 star</label>';
        }

        echo '</td>';
    } else if ($estado == 6 && $codigoPestana == 1) {
        echo '<td class = "rating">' .
        '<input type="radio" id="' . $codigoPestana . 'star5-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="5" onclick="calificar(this)"/><label for="' . $codigoPestana . 'star5-' . $cont . '" title="Excelente">5 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star4-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="4" onclick="calificar(this)"/><label for="' . $codigoPestana . 'star4-' . $cont . '" title="Muy Bueno">4 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star3-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="3" onclick="calificar(this)" /><label for="' . $codigoPestana . 'star3-' . $cont . '" title="Bueno">3 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star2-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="2" onclick="calificar(this)"/><label for="' . $codigoPestana . 'star2-' . $cont . '" title="Regular">2 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star1-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="1" onclick="calificar(this)"/><label for="' . $codigoPestana . 'star1-' . $cont . '" title="Deficiente">1 star</label>' .
        '</td>';
    } else {
        echo '<td class = "rating2">' .
        '<input type="radio" id="' . $codigoPestana . 'star5-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="5"/><label for="' . $codigoPestana . 'star5-' . $cont . '" title="Excelente">5 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star4-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="4" /><label for="' . $codigoPestana . 'star4-' . $cont . '" title="Muy Bueno">4 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star3-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="3"  /><label for="' . $codigoPestana . 'star3-' . $cont . '" title="Bueno">3 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star2-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="2" /><label for="' . $codigoPestana . 'star2-' . $cont . '" title="Regular">2 stars</label>' .
        '<input type="radio" id="' . $codigoPestana . 'star1-' . $cont . '"  name="' . $codigoPestana . 'star' . $cont . '" value="1" /><label for="' . $codigoPestana . 'star1-' . $cont . '" title="Deficiente">1 star</label>' .
        '</td>';
    }
}

function usuariosAsignadosRol($roles) {
    $actual = $_POST['comboRolesUsuariosModal'];
    $codRol = rolSeleccionado($roles, $actual);
    $responsablePorRol = obtenerResponsablesAsignadosRol($codRol);
    foreach ($responsablePorRol as $responsable) {
        echo '<tr>';
        echo '<td>' . $responsable->obtenerCodigoEmpleado() . '</td>';
        echo '<td>' . $responsable->obtenerNombreResponsable() . '</td>';
        echo '<td>' . $responsable->obtenerArea()->obtenerNombreArea() . '</td>';
        echo '</tr>';
    }
}

function agregarAdjuntoComentario($codigoT, $r) {
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
        $adjuno = '..\\adjuntos\\' . $codigoT . "-" . $archivo;
        move_uploaded_file($nombre_tmp, utf8_decode($adjuno));
    }
    if ($adjuno == null) {
        $adjuno = '';
    }
    $mensaje = agregarAdjunto($codigoT, $comentario, $correoU, $nombreU, $adjuno);

    return $mensaje;
}

function comboEstados($estados) {
    foreach ($estados as $estado) {
        echo'<label class="checkbox-inline"><input type="checkbox" id="estado-' . $estado->obtenerCodigoEstado() . '" value="' . $estado->obtenerCodigoEstado() . '">' . $estado->obtenerNombreEstado() . '</label>';
    }
}

// <editor-fold defaultstate="collapsed" desc="ASIGNACION DEL TIQUETE">
function comboResponsablesAsignar($tique, $responsables) {
    echo '<select class="form-control" id="comboResponsables" onchange="asignarTiqueteAjax(this)">';   
        echo '<option value="" selected>Por asignar</option>';    
    foreach ($responsables as $responsable) {        
            echo '<option value="' . $responsable->obtenerCodigoEmpleado() . '" >' . $responsable->obtenerNombreResponsable() . '</option>';
        }
    echo '</select>';
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="FILTROS">
function filtros($mitabla) {
    //$estados = obtenerEstados();
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
    $fecha = $dia . "/" . $mes . "/" . $anio;
    if ($mitabla == TodosLosTiquetes) {
        filtroTodosLosTiquetes($mitabla, $fecha);
    } else {
        filtroTiquetes($mitabla, $fecha);
    }
}

function filtroTiquetes($mitabla, $fecha) {
    echo'<div class="col-md-12">
        <div class="panel panel-primary"> 
            <div class="panel-body">  
                <div class="container-fluid">                              
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Fecha de inicio:</h5>
                        </div>                                     
                        <div class="col-md-2  ">
                            <div class = "form-group input-group date" id = "datetimepicker1">
                                <input id = "fechafiltroI" name ="filtro-fecha" type="text" class="  form-control" value="01/01/1950">
                                <span class="input-group-addon btn btn-info"  onclick="document.getElementById(\'fechafiltroI\').focus()" >
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>  
                            </div>
                        </div>
                        <div class="col-md-1  ">
                            <h5>Estados:</h5>
                        </div>
                        <div class="col-md-7  ">';
    $estados1 = obtenerEstados();
    comboEstados($estados1);
    echo'               </div>                        
                    </div>
                    <div class="row"> 
                        <div class="col-md-2">
                            <h5>Fecha de final:</h5>
                        </div>                                     
                        <div class="col-md-2  ">
                            <div class = "form-group input-group date" id = "datetimepicker2">
                                <input id = "fechafiltroF" name ="filtro-fecha" type="text" class="form-control" value="' . $fecha . '" >
                                <span class="input-group-addon btn btn-info"  onclick="document.getElementById(\'fechafiltroF\').focus()">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>  
                            </div>
                        </div>  
                    </div>                    
                    <div class="col-md-12 form-group input-group boton-filtrar">
                        <button class="btn btn-success" onclick="filtrarBusqueda(\'' . $mitabla . '\')">Filtrar búsqueda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function filtroTodosLosTiquetes($mitabla, $fecha) {
    echo'     <div class="col-md-12">
                    <div class="panel panel-primary"> 
                        <div class="panel-body">  
                            <div class="container-fluid">
                                <div class="row">';
    if ($mitabla == TodosLosTiquetes) {
        echo'
                                    <div class="col-md-2">
                                        <h5>Código:</h5>
                                    </div>                                     
                                    <div class="col-md-2">
                                        <input class="form-control" id="codigoFiltro" >
                                    </div>
                                    <div class="col-md-2"> 
                                        <h5>Correo Solicitante:</h5>
                                    </div>                                   
                                    <div class="col-md-2">
                                        <input class="form-control" id="CorreoSFiltro" >
                                    </div>

                                    <div class="col-md-2">
                                        <h5>Nombre Solicitante:</h5> 
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" id="NombreSFiltro">
                                    </div>';
    }
    echo'                       </div>
                                <div class="row">  ';
    if ($mitabla == TodosLosTiquetes) {
        echo'                       <div class="col-md-2"> 
                                        <h5>Correo Responsable:</h5>
                                    </div>                                   
                                    <div class="col-md-2">
                                        <input class="form-control" id="CorreoRFiltro" >
                                    </div>
                                    <div class="col-md-2">
                                        <h5>Nombre Responsable:</h5> 
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" id="NombreRFiltro">
                                    </div>';
    }
    echo '                           <div class="col-md-2">
                                        <h5>Fecha de inicio:</h5>
                                    </div>                                     
                                    <div class="col-md-2  ">
                                        <div class = "form-group input-group date" id = "datetimepicker1">
                                            <input id = "fechafiltroI" name ="filtro-fecha" type="text" class="  form-control" value="01/01/1950">
                                            <span class="input-group-addon btn btn-info"  for="filtro-fecha">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div>
                                    </div> 
                                </div> 
                                
                                <div class="row">                                   

                                    <div class="col-md-2">
                                        <h5>Fecha de final:</h5>
                                    </div>                                     
                                    <div class="col-md-2  ">
                                        <div class = "form-group input-group date" id = "datetimepicker2">
                                            <input id = "fechafiltroF" name ="filtro-fecha" type="text" class="form-control" value="' . $fecha . '" >
                                            <span class="input-group-addon btn btn-info"  for="filtro-fecha">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>  
                                        </div>
                                    </div>
                                    <div class="col-md-1  ">
                                     <h5>Estados:</h5>
                                     </div>
                                    <div class="col-md-7  ">';
    $estados1 = obtenerEstados();
    comboEstados($estados1);
    echo'                           </div>
                                </div>
                                <div class="row">&nbsp;</div>
                                <div class="col-md-12 form-group input-group boton-filtrar">
                                    <button class="btn btn-success" onclick="filtrarBusqueda(\'' . $mitabla . '\')">Filtrar búsqueda</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>';
}

function agregabotones($botones) {
    echo'<div  class = "col-md-12" style="text-align: right;"> ' .
    '<a  href = "../vista/CrearNuevoTiquete.php">' .
    '<button type="button" class="btn btn-success" >' .
    '<i class="glyphicon glyphicon-plus"></i> &nbsp; Nuevo Tiquete</button>' .
    '</a>';
    if ($botones != "PorAsignar") {
        echo'&nbsp; <a>' .
        '<button type="button" class="btn btn-info" onclick="Filtros(\'' . $botones . '\')" >' .
        '<i class="glyphicon glyphicon-wrench"></i> &nbsp; Filtrar búsqueda</button>' .
        '</a>';
    }
    echo '&nbsp; ';
    echo '</div>';
}

// </editor-fold>


function fechaHoy($hoy) {
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10) {
        $mes = "0" . $mes;
    }
    $dia = $hoy["mday"];
    if ($dia < 10) {
        $dia = "0" . $dia;
    }
    $fecha = $dia . "-" . $mes . "-" . $anio;
    return $fecha;
}

?>
