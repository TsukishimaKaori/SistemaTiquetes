<!DOCTYPE html>
<html>
    <head>
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?> 
        <link rel="stylesheet" href="../recursos/css/informacionTiquetes.css">
        <script  type="text/javascript" src="../recursos/js/AdministrarInformacionTiquetes.js"></script>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />      
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>

        <!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <?php
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        require ("../modelo/ProcedimientosInventario.php");
        require ("../control/AdministrarTablaInformacionTiquetes.php");
        require ("../control/AlertasConfirmaciones.php");
        ?>


    </head>
    <body onload="cargarpaginaPrincipal();">
        <?php
        require ("../vista/Cabecera.php");
        ?> 
        <?php
        $estados = obtenerEstados();
        $permisos = consultarPermisos();
        $prioridades = obtenerPrioridades();
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
        if (isset($_GET['fechaInicioFiltros'])) {
            $fechaI = $_GET['fechaInicioFiltros'];
            $fechaF = $_GET['fechaFinalizacionFiltros'];
            $nuevo = $_GET['nuevo'];
            $asignado = $_GET['asignado'];
            $reasignacion = $_GET['reasignacion'];
            $proceso = $_GET['proceso'];
            $anulado = $_GET['anulado'];
            $finalizado = $_GET['finalizado'];
            $calificado = $_GET['calificado'];

            if (isset($_GET['codigoFiltroG'])) {
                $codigoFiltroG = $_GET['codigoFiltroG'];
                $nombreSG = $_GET['nombreSG'];
                $correoSG = $_GET['correoSG'];
                $nombreRG = $_GET['nombreRG'];
                $correoRG = $_GET['correoRG'];
                echo "<input type = 'hidden' id = 'codigoFiltroG' value = '" . $codigoFiltroG . "'></input>";
                echo "<input type = 'hidden' id = 'nombreSG' value = '" . $nombreSG . "'></input>";
                echo "<input type = 'hidden' id = 'correoSG' value = '" . $correoSG . "'></input>";
                echo "<input type = 'hidden' id = 'nombreRG' value = '" . $nombreRG . "'></input>";
                echo "<input type = 'hidden' id = 'correoRG' value = '" . $correoRG . "'></input>";
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
            echo "<input type = 'hidden' id = 'filtroFechaI' value = '" . $fechaI . "'></input>";
            echo "<input type = 'hidden' id = 'filtroFechaF' value = '" . $fechaF . "'></input>";
            echo "<input type = 'hidden' id = 'filtroNuevo' value = '" . $nuevo . "'></input>";
            echo "<input type = 'hidden' id = 'filtroAsignado' value = '" . $asignado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroReasignado' value = '" . $reasignacion . "'></input>";
            echo "<input type = 'hidden' id = 'filtroProceso' value = '" . $proceso . "'></input>";
            echo "<input type = 'hidden' id = 'filtroAnulado' value = '" . $anulado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroFinalizado' value = '" . $finalizado . "'></input>";
            echo "<input type = 'hidden' id = 'filtroCalificado' value = '" . $calificado . "'></input>";
            if (isset($_GET['paginaPrincipal'])) {
                $paginaPrincipal = $_GET['paginaPrincipal'];
                echo "<input type = 'hidden' id = 'paginaPrincipal' value = '" . $paginaPrincipal . "'></input>";
            }
        }
        ?>
         <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
        <div id = "cargarTiquetePagina" onload="hacerDatapiker();">
            <?php
            if (isset($_GET['tiquete']) && isset($_GET['pagina'])) {
                $codigoTiquete = $_GET['tiquete'];
                $codigoPagina = $_GET['pagina'];
                echo "<input type = 'hidden' id = 'codigoPagina' value = '" . $codigoPagina . "'></input>";
                echo "<input type = 'hidden' id = 'codigoTique' value = '" . $codigoTiquete . "'></input>";
                /* CodigoPagina corresponde a la pagina de donde se envia la solicitud
                 * COdigoPagina = 1: Solicitud enviada desde TiquetesCreados
                 * COdigoPagina = 2: Solicitud enviada desde AsginarTiquetes
                 * COdigoPagina = 3: Solicitud enviada desde TiquetesCreados
                 * COdigoPagina = 4: Solicitud enviada desde TodosLosTiquetes
                 * COdigoPagina = 5: Solicitud enviada desde Historial de inventario
                 */
            }
            ?>   
            <?php
            if ($r) {
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
                ?>                    
                <h3 style = "text-align: center;">Administrador de tiquetes</h3>

                <section class ="container-fluid">   

                    <div class="row"> 
                        <?php
                        if ($codigoPagina == 5) {
                            $bodega = $_GET['bodega'];
                            $dispositivo = $_GET['dispositivo'];
                            $paginaAnterior = $_GET['paginaAnterior'];
                            ?>
                            <div class="col-md-4 " >
                            <?php echo '<button onclick="retornarABandejaHistorialInventario(' . $paginaAnterior . ',' . $bodega . ' ,' . $dispositivo . ');" title="Regresar" type="button" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></button>' ?>
                            </div>
    <?php } else { ?>
                            <div class="col-md-4 " >
                                <button  onclick="retornarABandeja();" title="Regresar" type="button" class="btn btn-info " data-toggle="modal" data-target=""><i class="glyphicon glyphicon-arrow-left"></i></button>
                            </div>                        
                        <?php } ?>
    <?php if ($codigoPagina != 5) { ?>
                            <div class="  col-md-1" style="text-align: right;">
                                <button title="Tiquete anterior" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick="tiqueteAnterior();"><i class="glyphicon glyphicon-triangle-left"></i></button>
                            </div>
                            <div class=" col-md-2">  
        <?php descripcionPagina($codigoPagina, $r); ?>
                            </div>
                            <div class="col-md-1"> 
                                <button  title="Siguiente Tiquete" type="button" class="btn btn-info ocultarTiquetes " data-toggle="modal" data-target="" onclick=" tiqueteSiguiente();"><i class="glyphicon glyphicon-triangle-right"></i></button>
                            </div>
    <?php } ?>
                    </div>
                    <div class="row">
    <?php codigoPagina($codigoPagina); ?>
                        <br>
                    </div>                                    
                </section>
                <section id = "seccionInfoTiquete" class ="container-fluid ocultarTiquetes">
                    <div class="row">                 
                        <div class="col-md-6">  
    <?php panelDeCabecera($tiquete); ?>                               
                            <div class="panel-heading panel-success">   
                                <div class="row">
                                    <div class="col-md-3 encabezado">
                                        <h5 class="panel-title" value = "<?php codigoTiquete($tiquete); ?>">Codigo: <?php codigoTiquete($tiquete); ?></h5>                                        
                                    </div>
                                    <div class="col-md-6 encabezado encabezadoDescripcion" >
                                        <h5 class="panel-title"><?php descripcionTematica($tiquete) ?></h5>
                                    </div>
    <?php                            if ($codigoPagina != 5) { ?>
                                        <div class="col-md-3 encabezado encabezadoDescripcion" >
                                            <button class = "btn btn-warning" onclick ="mostrarHistorialTiquetes();"><i class = "glyphicon glyphicon-list-alt"> Historial</i></button>
                                        </div> 
    <?php                            } ?>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row"> <h4 class="col-md-3">Solicitante:</h4></div> 
                                <div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class=" col-md-8">
                                        <h5> <?php nombreSolicitante($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row "> 
                                    <h5 class="col-md-3 ">Correo:</h5> 
                                    <div class=" col-md-8">
                                        <h5><?php correoSolicitante($tiquete); ?></h5>
                                    </div> 
                                </div> 
                                <div class="row "> 
                                    <h5 class="col-md-3 ">Jefatura:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php jefaturaSolicitante($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row "> 
                                    <h5 class="col-md-3 ">Departamento:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php departamentoSolicitante($tiquete); ?></h5>
                                    </div> 
                                </div>   

                                <div class="row "><h4 class="col-md-3">Responsable:</h4> </div>
                                <div class="row ">  
                                    <h5 class="col-md-3 ">Nombre:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php nombreResponsable($tiquete); ?></h5>
                                    </div> 
                                </div> 
                                <div class="row ">
                                    <h5 class="col-md-3 ">Correo:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php correoResponsable($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3 ">Horas trabajadas:</h5> 
                                    <div class=" col-md-8">
                                        <h5><?php horasTrabajadas($tiquete, $codigoPagina) ?></h5>
                                    </div>       
                                </div>

                                <div class="row "><h4 class="col-md-3 ">Tiquetes:</h4> </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Código:</h5> 
                                    <div class="col-md-8">
                                        <h5 id ="codigoTiquete"><?php codigoTiquete($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">  
                                    <h5 class="col-md-3">Área:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php areaTiquete($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Clasificación:</h5> 
                                    <div class=" col-md-8">
                                        <h5 id =""><?php clasificacionTiquete($tiquete, $codigoPagina); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Estado:</h5> 
                                    <div class="col-md-8">
                                        <h5><?php estadoTiquete($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class = "row">
                                    <h5 class = "col-md-3">Prioridad:</h5>

    <?php prioridadTiquete($tiquete, $codigoPagina, $prioridades); ?>

                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Creado el:</h5> 
                                    <div class=" col-md-8">                                        
                                        <h5><?php fechaCreacionTiquete($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Solicitado para:</h5> 
                                    <div class=" col-md-8">
    <?php $a = fechaSolicitudTiquete($tiquete, $codigoPagina); ?>
                                    </div>
                                </div>
                                <div class="row ">
                                    <h5 class="col-md-3">Fecha entrega:</h5> 
                                    <div class=" col-md-8">
    <?php $a = fechaEntregaTiquete($tiquete, $codigoPagina); ?>
                                    </div>
                                </div>
                                <div class="row ">                            
                                    <h5 class="col-md-3">Fecha finalizado:</h5> 
                                    <div class=" col-md-8">
                                        <h5><?php fechaFinalizadoTiquete($tiquete); ?></h5>
                                    </div> 
                                </div>
                                <?php
                                $activos = obtenerActivosAsociadosTiquete($tiquete->obtenerCodigoTiquete());
                                $estado = $tiquete->obtenerEstado()->obtenerCodigoEstado();
                                equipoAsociado($estado, $activos, $codigoPagina);
                                ?>                                    

                                <div class="row ">
                                    <div><h5 class="col-md-12"> Descripción:</h5> </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="3"  id="descripcion" readonly="readonly"><?php descripcionTiquete($tiquete); ?> </textarea>
                                    </div>
                                </div>  
                                <div class="row ">&nbsp;</div>
                                <div class="row ">
                                    <?php
                                    $anular = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 9);
                                    asignarResponsable($codigoPagina, $tiquete, $anular)
                                    ?>
                                </div> 
                            </div>

                            <div class="panel-footer" id="divCalificacion"> 
                                <label style="font-size:16px" >Calificación</label>                                
    <?php mostrarCalificacion($codigoPagina, $tiquete); ?> 
                              
                            </div>
                           <div  ></div>
                        </div>
                    </div>
                    <div class="col-md-6">                        
    <?php panelDeCabecera($tiquete) ?>
                        <div class="panel-heading">
                            <h5 class="panel-title encabezado">Mensajes</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" id="comentarios" style ="height: 300px; overflow-y: auto; overflow-x: hidden;">   
                                <?php
                                $listaComentariosPorTiquete = obtenerHistorialComentariosCompleto($codigoTiquete);
                                obtenerComentariosCompleto($listaComentariosPorTiquete, $r);
                                ?>
                            </div>  
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
                </section>

            </div>
            <!-------------------------ModalClasificaciones------------------>
            <div id="modalClasificaciones" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm ">                
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">    
                                <?php
                                $tematicas = obtenerTematicasCompletasActivas();
                                $vectematica = crearListatematicas($tematicas);
                                ?>
                                <a href="#" class="list-group-item disabled">
                                    <h4> Clasificación de tiquetes</h4>
                                </a>
                                <ul class="nav nav-list" id="sidenav01">
                                    <li class="list-group-item" id="nivelbase">
                                        <a  data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed">
                                            <label>Escoger clasificación</label>  <span class="caret pull-right"></span>
                                        </a>
                                        <div class="collapse" id="toggleDemo" >
                                            <ul class="nav nav-list"            >
    <?php tematicasNivel1($vectematica) ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class            ="modal-footer">
                            <button type="button" class="btn btn-danger"  data-dismiss="modal">    Salir</button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------    ---------ModalAsignar------------------>
            <div id="modalAsignar" class="modal fade" role="dialog">
                <div class="modal-dialog ">   
                    <div class="modal-content">  
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4> Asignar tiquete a responsable</h4>
                        </div>
                        <div class="modal-body" id="Modal2">
                            <div class="row">  
                                <div class="" style ="text-align: center;" id=""> 
                                    <label class="col-md-3" for="responsables">Responsables</label>
                                    <div class="form-group col-md-6">                                     
                                        <?php
                                        $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
                                        $responsables = obtenerResponsablesAsignar($codigoArea);

                                        comboResponsablesAsignar($responsables, 2);
                                        ?>
                                    </div>                                
                                </div> 
                            </div>
                            <div class="row">
                                <label class="form-group col-lg-10" for="responsables">
                                    Nota: al asignar un tiquete este será dirigido a la band    eja de asignados del usuario, 
                                    por lo que desaparecerá de la bandeja de tiquetes        por asignar.
                                </label>
                            </div >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="AsignartiqueteSiguiente();"  > Aceptar</button>
                            <button type="button"     class="btn btn-danger" data-dismiss="modal"   > cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------ModalAsignartodos---------    --------->
            <div id="modalAsignartodos" class="modal fade" role="dialog">
                <div class="modal-dialog ">                
                    <div class="modal-content">  
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4> Asignar tiquete a responsable</h4>
                        </div>
                        <div class="modal-body" id="Modal2">
                            <div class="row">  
                                <div class="" style ="text-align: center;" id=""> 
                                    <label class="col-md-3" for="responsables">Responsables</label>
                                    <div class="form-group col-md-6">                                     
                                        <?php
                                        $responsables = obtenerResponsables();
                                        comboResponsablesAsignar($responsables, 4);
                                        ?>
                                    </div>                                
                                </div> 
                            </div>
                            <div class="row">
                                <label class="form-group col-lg-10" for="responsables">
                                    Nota: al asignar un tiquete este será dirigido a la bandeja de asignados del usuario, 
                                    por lo que desaparecerá de la bandeja de tiquetes por asignar.
                                </label>
                            </div >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="asignarResponsableAjax();"  > Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"   > cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-------------------------ModalAsignartodos------------------>
            <div id = "noHayTiquetes"></div>

            <!-------------------------Modaljustificacion----------------->
            <div id="ModalJustificacion" class="modal fade " role="dialog">
                <div class="modal-dialog modal-sm">                
                    <div class="modal-content">                
                        <div class="modal-body">
                            <div class="row">    
                                <div class="" style ="text-align: center" id="tiquete"> 
                                    <h4 id="infoJusticiacion"></h4>                               
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="comment">Justificación</label>
                                <textarea class="form-control" rows="3"  name="justificacion" cols="2" id="justificacion"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="aceptarJustificacion" > Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"  id="cancelarJustificacion" > cancelar</button>
                        </div>
                    </div>
                </div>
            </div
            <!------------------------------------------------>
            <!-------------------------Modaljustificacion----------------->
            <div id="ModalProceso" class="modal fade " role="dialog">
                <div class="modal-dialog modal-sm">                
                    <div class="modal-content">                
                        <div class="modal-body">
                            <div class="row">    
                                <div class="" style ="text-align: center" id="tiquete"> 
                                    <h4>En proceso</h4>                               
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="comment">Fecha de entrega</label>
                                <div class="form-group input-group date" id="datetimepicker2"  >
                                    <input type="text"  class="form-control" name="cotizada" id="fechaEntrega"
                                           value="' . date_format($tiquete->obtenerFechaCotizado(), 'd/m/Y') . '" >
                                    <span class="input-group-addon btn btn-info" id="fecha" onclick="document.getElementById('fechaEntrega').focus()"  >
                                        <span class="glyphicon glyphicon-calendar" ></span>
                                    </span>                              
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="aceptarJustificacion" onclick="enProcesoAjax()" > Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"  id="cancelarJustificacion" > cancelar</button>
                        </div>
                    </div>
                </div>
            </div
            <!------------------------------------------------>
            <!-------------------------Modaljustificacion----------------->
            <div id="confirmarFechaEntrega" class="modal fade " role="dialog">
                <div class="modal-dialog modal-sm">                
                    <div class="modal-content">                
                        <div class="modal-body">
                            <div class="row">    
                                <div style ="text-align: center" id="tiquete"> 
                                    <h4> </h4>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="comment">justificacion</label>
                                <textarea class="form-control" rows="3"  name="justificacion" cols="2" id="justificacionEntrega"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="CambiarFechaEntregaAjax()" > Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick=" document.getElementById('justificacionEntrega').value = ''" > cancelar</button>
                        </div>
                    </div>
                </div>
            </div
            <!------------------------------------------------>

            <!-------------------------Modal elegir equipo-------------------------->

            <div id="modalaEquipos" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg" >                
                    <div class="modal-content" id="cuerpoModalEquipos">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Filtros equipos</h4>
                        </div>
                        <div class="modal-body table-responsive">
                            <div class="panel panel-primary">
                                <div class="panel-body filtrosVisible">

                                    <div class="row">  
                                        <div class="form-group  col-md-4">
                                            <label class="control-label col-md-3" for="placaA">Placa:</label>
                                            <div class="col-md-9">
                                                <input class="form-control" id="placaA" type="text">
                                            </div>
                                        </div>  
                                        <div class="form-group  col-md-4">
                                            <label class="control-label col-md-3" for="categoriaA">Categoría:</label>
                                            <div class="col-md-9">
                                                <input class="form-control" id="categoriaA" type="text">
                                            </div>
                                        </div> 
                                        <div class="form-group  col-md-4">
                                            <label class="control-label col-md-3" for="marcaA">Marca:</label>
                                            <div class="col-md-9">
                                                <input class="form-control" id="marcaA" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="form-group  col-md-4">
                                            <label class="control-label col-md-3" for="usuarioA">Usuario:</label>
                                            <div class="col-md-9">
                                                <input class="form-control" id="usuarioA" type="text">
                                            </div>
                                        </div> 
                                        <div class="form-group  col-md-4">
                                            <label class="control-label col-md-3" for="correoA">Correo:</label>
                                            <div class="col-md-9">
                                                <input class="form-control" id="correoA" type="text">
                                            </div>
                                        </div> 
                                        <div class="form-check col-md-4">                           
                                            <label class="control-label col-md-3" for="estadosA">Estado:</label>
                                            <div class="col-md-9">
                                                <?php
                                                $estados = obtenerEstadosEquipoParaFiltrar();
                                                selectEstado($estados);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-10">
                                            <button onclick = " filtrarActivosAjax()" type="button" class="btn btn-success   " data-toggle="modal" > buscar </button> 
                                        </div>                       
                                    </div> 
                                </div>
                            </div>
                            <table class = "table tablasTiquetes  table-hover" id="tablaTiquetesI">
                                <thead>
                                    <tr>                                            
                                        <th>Placa</th>
                                        <th>Categoría</th>
                                        <th> Marca</th>
                                        <th>Usuario_asociado</th>
                                        <th>Fecha de salida de inventario </th>


                                    </tr>                             
                                </thead>
                                <tbody id = "tbody-tablaEquipo"> 

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!------------------------------------------------>
            <?php
            confirmacion("Modalinfo", "", "confirmarActualizarTematica(this)", "cancelarActualizarTematica()");
            confirmacion("confirmarFechaSolicitada", "", "CambiarFechaSolicitadaAjax()", "");
            confirmacion("desasociarEquipo", "Desea desasociar el equipo", "desasociarEquipoAjax()", "");
            notificacion();
            alerta("ceroHoras", "El tiquete no tiene horas trabajadas", "");
        }
        ?>
    </body >


</html>
