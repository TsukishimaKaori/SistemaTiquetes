<!DOCTYPE html>
<html> 
    <head>       
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>   
        <?php require ("../modelo/ProcedimientosPermisos.php"); ?>        
        <?php require ("../modelo/ProcedimientosTiquetes.php"); ?>
        <?php require_once ("../control/AdministrarTablaEstadoTiquetes.php"); ?> 
        <?php require ("../control/AlertasConfirmaciones.php"); ?>
        <?php
        $estados = obtenerEstados();
        $permisos = consultarPermisos();
        ?>  
        <script type="text/javascript" src="../recursos/js/AdministrarEstadoTiquetes.js"></script>
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?> 
        <?php
        if ($r) {
            if (!verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 5)) {
                header('Location: ../vista/Error.php');
            } else {
                ?> 
                <section class ="container-fluid">
                    <div class="row"> <h1>Administración de Estados</h1></div>
                    <div class="row"> 
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div  class="table table-responsive">                   
                                <table class = "table tablasInfo table-hover" id = 'tablaEstadoTiquetes'>                
                                    <thead>
                                        <tr>
                                            <th>Estados</th>                                            
                                            <th>Envía correo</th>
                                        </tr>
                                    </thead>
                                    <tbody  id ="cuerpoTablaEstadoTiquetes">
                                        <?php cuerpoTablaEstados($estados); ?>                            
                                    </tbody>
                                </table>                                 
                            </div>
                        </div>                    
                    </div>
                </section>               
                <!--Inicio de las ventanas modales-->
                <!--Ventana agregar estado-->
   

                <!--Confirmaciones y alertas-->
                <?php
               confirmacion("confirmarCorreoModificado", "¿Desea que el estado puede enviar un correo?", "confirmarCorreoModificado(this);","cancelarCorreoModificado(this);");
                         }
        }
        ?>
    </body>
</html>

