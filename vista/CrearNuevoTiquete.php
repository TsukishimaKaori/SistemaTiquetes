<html> 
    <head>   
        <meta charset="UTF-8">
        <?php require ("../modelo/Tematica.php"); ?>
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require ("../control/AdministrarTablaCreartiquete.php"); ?>
        <?php
        echo '<link href="../recursos/css/creartiquetes.css" rel="stylesheet"/>';
        ?>
        <script  type="text/javascript" src="../recursos/js/CrearNuevoTiquete.js"></script> 
    </head>
    <body>
        <?php
        require ("../vista/Cabecera.php");
        echo'<link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />';
        ?>
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>
        <div class="container ">
            <div class="row">

                <div id="cargandoImagen"><img src="../recursos/img/cargando2.gif"/></div>
                <div class="col-md-6 col-md-offset-3" id="tiquete"> 
                    <form  id ="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <h1> Nuevo tiquete</h1>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control"  readonly="readonly" id="nombre" value="<?php echo $r->obtenerNombreResponsable() ?>"  required>
                        </div>
                        <div class="form-group">
                            <label for="tematica"> Clasificación </label>
                            <div class='input-group date' id='clasificacion2'onclick="Clasificaciones()" >
                                <input type="text" class="form-control" name="tematica"  readonly="readonly" id="clasificacion" onclick="Clasificaciones()"  required  >
                                <span class="input-group-addon  btn btn-info" id="clasificacion3">
                                    <span class="glyphicon glyphicon-th-list"></span>
                                </span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha"> Fecha requerida </label>
                            <div class='input-group date' id='datetimepicker1'>
                                <?php
                                $hoy = getdate();
                                $anio = $hoy["year"];
                                $mes = $hoy["mon"];
                                if ($mes < 10)
                                    $mes = "0" . $mes;
                                $dia = $hoy["mday"];
                                if ($dia < 10)
                                    $dia = "0" . $dia;
                                $fecha = $dia . "/" . $mes . "/" . $anio;
                                echo '  <input type="text" class="form-control" name="fecha" id="fecha" value="' . $fecha . '">';
                                ?>                                
                                <span class="input-group-addon btn btn-info" id="Efecha">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>                              
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea class="form-control" rows="3"  name="comentario" cols="2" id="comment"></textarea>
                        </div>

                        <button type="button" class="btn btn-info btn-circle btn-xl" data-toggle="modal" data-target="#modalagregarAdjunto" >Adjuntar archivo</button><br><br>
                        <button type="button" class="btn btn-success" onclick="enviar(this);"> Enviar </button>
                        <button type="reset" class="btn btn-danger">Cancelar</button>   
                        <!--                        <----------------------------------->
                        <div id="modalagregarAdjunto" class="modal fade" role="dialog">
                            <div class="modal-dialog">                
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Adjuntar archivo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="archivo" class="btn btn-info btn-circle btn-xl" >Subir archivo</label>
                                        <input id="archivo"  name="archivo" type="file" id="archivo" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation,
                                               text/plain, application/pdf, image/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document
                                               ,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  onchange="subirarchivo(this);" />
                                        <input type="text" name="archivo2"  readonly="readonly" class="form-control" id="Textarchivo" >
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success"  data-dismiss="modal"> Guardar</button>
                                            <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="cancelarAdjunto();">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                        <----------------------------------->
                    </form>
                </div> 
            </div>
        </div>
        <!--                        <----------------------------------->
        <div id="TiqueteEnviado" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div class="" style ="text-align: center" id="tiquete"> 
                                <h4> Tiquete enviado </h4>                               
                            </div> 
                        </div>
                        <!--   <div class="modal-backdrop fade in"></div>-->
                        <!--    </body>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick='location.href = "../vista/BandejasTiquetes.php"' > Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--                        <----------------------------------->
        <div id="errorInfo" class="modal fade " role="dialog">
            <div class="modal-dialog modal-sm">                
                <div class="modal-content">                
                    <div class="modal-body">
                        <div class="row">    
                            <div class="" style ="text-align: center" id="errorDiv"> 

                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" > Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--                        <----------------------------------->
        <div id="EnviarTiquete" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm ">                
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">    
                            <div style ="text-align: center" id="tiquete"> 
                                <h4> ¿Está seguro que desea enviar el tiquete? </h4>
                            </div> 
                        </div>
                        <!--   <div class="modal-backdrop fade in"></div>-->
                        <!--    </body>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="EnviarAjax()"> Aceptar</button>
                        <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalClasificaciones" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm ">                
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">    

                            <?php
                            $tematicas = obtenerTematicasCompletasActivas();
                            $vectematica = crearListatematicas($tematicas)
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
                                        <ul class="nav nav-list">
                                            <?php tematicasNivel1($vectematica) ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"  data-dismiss="modal">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
