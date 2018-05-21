<html> 
    <head>   
        <meta charset="UTF-8">
        <?php require ("../control/ArchivosDeCabecera.php"); ?>
        <script  type="text/javascript" src="../recursos/js/AyudaEnLinea.js"></script> 
        <style type="text/css">
  div div div ul li div ul li div.collapse { background-color:gray; }
</style>
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?>
        <div class="container-fluid">
            <div class="row">  
                <div class="col-md-4">
                    <a href="#" class="list-group-item disabled">
                        <h4> Índice</h4>
                    </a>
                    <ul class="nav nav-list" id="sidenav01">
                        <li class="list-group-item" id="nivelbase"> 
                            <div id="toggleDemo" >
                                <ul class="nav nav-list">
                                    <li class="list-group-item" id="primerNivel" >
                                        <a  data-toggle="collapse" data-target="#toggleDemo1" data-parent="#sidenav01" class="collapsed">
                                            <label>Tiquetes</label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemo1" >
                                            <ul class="nav nav-list" >
                                                <li class = "list-group-item "id=""><a onclick="abrirPanel('tiquetes1');" >Creación de un tiquete</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes2');" >Ver la información de un tiquete</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes3');" >Ver el historial del tiquete</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes4');" >Filtrar búsqueda de tiquetes</a></li>    
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes5');" >Bandeja mis tiquetes</a></li>   
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes6');" >Bandeja tiquetes por asignar</a></li>   
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes7');" >Bandeja tiquetes asignados</a></li> 
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('tiquetes8');" >Bandeja todos los tiquetes</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="list-group-item" id="primerNivel" >
                                        <a  data-toggle="collapse" data-target="#toggleDemoCicloVidaTiquetes" data-parent="#sidenav01" class="collapsed">
                                            <label>Ciclo de vida de los tiquetes</label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemoCicloVidaTiquetes" >
                                            <ul class="nav nav-list" >
                                                <li class = "list-group-item "id=""><a onclick="abrirPanel('cicloVidaTiquete1');" >¿Cómo asignar un tiquete?</a></li>                                                
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete6');" >¿Cómo reasignar un tiquete?</a></li>   
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete7');" >¿Cómo procesar un tiquete?</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete5');" >¿Cómo finalizar un tiquete?</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete2');" >¿Cómo calificar un tiquete?</a></li>                                               
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete4');" >¿Cómo anular un tiquete?</a></li>                                               
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('cicloVidaTiquete3');" >¿Cómo reprocesar un tiquete?</a></li>                                             
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="list-group-item" id="">
                                        <a  data-toggle="collapse" data-target="#toggleDemoAdministracionSistema" data-parent="#sidenav01" class="collapsed">
                                            <label>Administración del Sistema </label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemoAdministracionSistema" >
                                            <ul class="nav nav-list">                                             
                                                <li class="list-group-item" id="">
                                                    <a  data-toggle="collapse" data-target="#toggleDemoAdministracionRolesDeUsuario" data-parent="#sidenav01" class="collapsed">
                                                        <label>Administración de responsables</label>  <span class="caret pull-right"></span>
                                                    </a> 
                                                    <div class="collapse" id="toggleDemoAdministracionRolesDeUsuario" >
                                                        <ul class="nav nav-list">
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesDeUsuario1');" >Visualizar usuario activos y todos los usuarios</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesDeUsuario2');" >Modificar el área de un responsable</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesDeUsuario3');" >Modificar el rol de un responsable</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesDeUsuario4');" >Activar o desactivar responsable</a></li>
                                                        </ul>
                                                    </div>
                                                </li>   
                                                <li class="list-group-item" id="">
                                                    <a  data-toggle="collapse" data-target="#toggleDemoAdministracionRolesPermisos" data-parent="#sidenav01" class="collapsed">
                                                        <label>Administración de roles y permisos</label>  <span class="caret pull-right"></span>
                                                    </a> 
                                                    <div class="collapse" id="toggleDemoAdministracionRolesPermisos" >
                                                        <ul class="nav nav-list">
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesPermisos1');" >Agregar rol</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesPermisos2');" >Eliminar rol</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesPermisos3');" >Visualizar usuarios asociados a un rol</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesPermisos4');" >Ver permisos asociados a un rol</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionRolesPermisos5');" >Asociar o desasociar permisos a roles</a></li>
                                                        </ul>
                                                    </div>
                                                </li> 
                                                <li class="list-group-item" id="">
                                                    <a  data-toggle="collapse" data-target="#toggleDemoAdministracionAreasClasificaciones" data-parent="#sidenav01" class="collapsed">
                                                        <label>Administración de áreas y clasificaciones</label>  <span class="caret pull-right"></span>
                                                    </a> 
                                                    <div class="collapse" id="toggleDemoAdministracionAreasClasificaciones" >
                                                        <ul class="nav nav-list">
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones1');" >Agregar un área</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones2');" >Eliminar un área</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones3');" >Editar un área</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones4');" >Agregar una clasificación</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones5');" >Cambiar el área de una clasificación</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones6');" >Activar o desactivar una clasificación</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones7');" >Editar clasificaciones</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionAreasClasificaciones8');" >Mostrar solo clasificaciones activas</a></li>
                                                        </ul>
                                                    </div>
                                                </li> 
                                                <li class="list-group-item" id="">
                                                    <a  data-toggle="collapse" data-target="#toggleDemoAdministracionTemas" data-parent="#sidenav01" class="collapsed">
                                                        <label>Administración de temas</label>  <span class="caret pull-right"></span>
                                                    </a> 
                                                    <div class="collapse" id="toggleDemoAdministracionTemas" >
                                                        <ul class="nav nav-list">
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionTemas1');" >Agregar un tema</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionTemas2');" >Eliminar un tema</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionTemas3');" >Editar un tema</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionTemas4');" >Activar o desactivar un tema</a></li>
                                                            <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('administracionTemas5');" >Mostrar solo temas activos</a></li>

                                                        </ul>
                                                    </div>
                                                </li>                                     
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="list-group-item" id="primerNivel" >
                                        <a  data-toggle="collapse" data-target="#toggleDemoActivosFijos" data-parent="#sidenav01" class="collapsed">
                                            <label>Activos fijos</label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemoActivosFijos" >
                                            <ul class="nav nav-list" >
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos1');" >¿Cómo asociar un repuesto a un activo fijo?</a></li>                                                
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos2');" >¿Cómo asociar una licencia a un activo fijo?</a></li>   
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos3');" >¿Cómo ver la información de un activo fijo?</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos4');" >¿Cómo visualizar el historial de un activo fijo?</a></li>
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos5');" >¿Cómo cambiar el estado de un activo fijo?</a></li> 
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos6');" >¿Cómo desasociar una licencias a un activo fijo?</a></li>                                               
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos7');" >¿Cómo desasociar un repuestos a un activo fijo?</a></li>                                               
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos8');" >¿Cómo ver los contratos asociados a un activo fijo ?</a></li>                                             
                                                <li class = "list-group-item " id=""><a onclick="abrirPanel('activosFijos9');" >¿Cómo desasociar un usuario a un activo fijo ?</a></li>  
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="list-group-item" id="primerNivel">
                                        <a  data-toggle="collapse" data-target="#toggleDemoInventario" data-parent="#sidenav01" class="collapsed">
                                            <label>Inventario </label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemoInventario" >
                                            <ul class="nav nav-list">
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventario1');" >¿Cómo agregar un artículo a inventario?</a></li>
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventario2');" >¿Cómo sumar un artículo a inventario existente?</a></li>
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventario3');" >¿Cómo sacar un artículo de inventario y pasarlo como activo fijo?</a></li>
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventario4');" >¿Cómo ver la información de un artículo en inventario?</a></li>
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventario5');" >¿Cómo ver el historial de un artículo en inventario?</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="list-group-item" id="primerNivel">
                                        <a  data-toggle="collapse" data-target="#toggleDemoInventarioCategoria" data-parent="#sidenav01" class="collapsed">
                                            <label>Administración de categorías de artículos en inventario </label>  <span class="caret pull-right"></span>
                                        </a> 
                                        <div class="collapse" id="toggleDemoInventarioCategoria" >
                                            <ul class="nav nav-list">
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventarioCategoria1');" >¿Cómo agregar una nueva categoría?</a></li>
                                                <li class = "list-group-item " id="segundoNivel"><a onclick="abrirPanel('inventarioCategoria2');" >¿Cómo eliminar una categoría?</a></li>
                                                
                                            </ul>
                                        </div>
                                    </li> 

                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel panel-heading list-group-item disabled">
                            <h3>Ayuda en línea</h3>
                        </div>
                        <div id = "panelContenido"class="panel panel-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
