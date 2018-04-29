<?php
session_start();
require_once ("../control/UsuarioLogueado.php");
?>
<header >

    <nav  class="navbar navbar-inverse" role="navigation">
        <!-- El logotipo y el icono que despliega el menú se agrupan
             para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <a href="../vista/BandejasTiquetes.php?tab=1" >  <img class="nav" src="../recursos/img/logoBrittShop.png"></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#myNavBar">
                <span class="sr-only">Desplegar navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Agrupar los enlaces de navegación, los formularios y cualquier
             otro elemento que se pueda ocultar al minimizar la barra -->
        <div class="collapse navbar-collapse" id = "myNavBar">
            <ul class="nav navbar-nav">
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tiquetes <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="../vista/CrearNuevoTiquete.php">Crear tiquete</a></li>
                        <!--                        <li><a href="../vista/AdministracionRolesPermisosUsuarios.php">Calificar tiquete</a></li>-->
                        <li><a href="../vista/BandejasTiquetes.php?tab=1" >Mis tiquetes</a></li>
                    </ul>
                </li>
                <?php
                //$r = obtenerResponsable('dannyalfvr97@gmail.com');
                $r = obtenerResponsable('nubeblanca1997@outlook.com');
                // $r = obtenerResponsable('francini113@gmail.com');
                $_SESSION['objetoUsuario'] = $r;
                $r = $_SESSION['objetoUsuario'];
//                        if ($r == 'Ha ocurrido un error' || $r == null) {
//                           // $r = obtenerResponsable('nubeblanca1997@outlook.com'); //admin
//                            // $r = obtenerResponsable('gina@gmail.com');
//                            $r = obtenerResponsable('dannyalfvr97@gmail.com');
//                            //  $r = obtenerResponsable('francini113@gmail.com'); //coordinador
//                        }
                if ($r) {
                    $permiso1 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 1); //ver permisos
                    $permiso2 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 2); //Asignar rol a usuario
                    $permiso3 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 3); //asignar area a tematica
                    $permiso4 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 4); //Administrar subtemáticas
                    $permiso5 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 5); //Administrar estados
                    $permiso6 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 6); // Tiquetes sin asignar
                    $permiso7 = verificarPermiso($r->obtenerRol()->obtenerCodigoRol(), 7); // Tiquetes asignados
                    if ($permiso6 || $permiso7) {
                        echo'   <li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración de tiquetes<b class="caret"></b></a>';
                        echo '<ul class="dropdown-menu">';
                        if ($permiso6) {
                            echo' <li><a href="../vista/BandejasTiquetes.php?tab=' . '2' . '">Asignar tiquetes</a></li>';
                        }
                        if ($permiso7) {
                            echo '<li><a href="../vista/BandejasTiquetes.php?tab=' . '3' . '">Tiquetes asignados</a></li>';
                        }
                        if ($permiso7) { //CAMBIAR EL PERMISO QUE CREO QUE ESTE AUN NO TIENE 
                            echo '<li><a href="../vista/BandejasTiquetes.php?tab=' . '4' . '">Todos los tiquetes</a></li>';
                        }
                        echo'</ul>
                            </li>';
                    }
                    if ($permiso1 || $permiso2 || $permiso3 || $permiso4) {

                        echo'   <li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración del sistema <b class="caret"></b></a>';
                        echo '<ul class="dropdown-menu">';
                        if ($permiso2) {
                            echo '<li><a href="../vista/AdministrarRolesUsuarios.php">Administración roles de usuario</a></li>';
                        }
                        if ($permiso1) {
                            echo '<li><a href="../vista/AdministracionRolesPermisosUsuarios.php">Administración de roles y permisos</a></li>';
                        }
                        if ($permiso3) {
                            echo '<li><a href="../vista/AdministrarAreasTematicas.php">Administración de áreas y clasificaciones</a></li>';
                        }
                        if ($permiso4) {
                            echo '<li><a href="../vista/AdministrarTematicasSubTematicas.php">Administración de temas</a></li>';
                        }
                        if ($permiso5) {
                            echo '<li><a href="../vista/AdministrarEstadoTiquetes.php">Administración estado de tiquetes</a></li>';
                        }
                        echo '</ul>';
                    }

                    if ($permiso1 || $permiso2 || $permiso3 || $permiso4) { //cambiar permisos y url
                        echo'   <li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Activos fijos <b class="caret"></b></a>';
                        echo '<ul class="dropdown-menu">';
//                        if ($permiso1) { //cambiar el permiso y url
//                            echo '<li><a href="../vista/AgregarInventario.php">Agregar inventario</a></li>';
//                        }
                        if ($permiso1) { //cambiar el permiso y url
                            echo '<li><a href="../vista/AdministrarInventario.php?tab=1">Administrar activos</a></li>';
                        }
                       
                        echo '</ul>';
                    }

                    if ($permiso1 || $permiso2 || $permiso3 || $permiso4) { //cambiar permisos y url
                        echo'   <li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventario <b class="caret"></b></a>';
                        echo '<ul class="dropdown-menu">';
                        if ($permiso1) { //cambiar el permiso y url
                            echo '<li><a href="../vista/AdministrarInventario.php?tab=2">Administrar inventario</a></li>';
                        }
                         echo '<li><a href="../vista/AdministrarCategorias.php">Administrar categorías</a></li>';
                        echo '</ul>';
                    }
                    
                    
                    if ($permiso1 || $permiso2 || $permiso3 || $permiso4) { //cambiar permisos y url
                        echo'   <li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>';
                        echo '<ul class="dropdown-menu">';
                        if ($permiso1) { //cambiar el permiso y url
                            echo '<li><a href="../vista/ReportesTiquetes.php">Reportes de tiquetes</a></li>';
                        }
                         echo '<li><a href="../vista/ReportesInventario.php">Reportes de inventario</a></li>';
                        echo '</ul>';
                    }
                                        
                }
//                        }
                ?>

                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-text"> 
<?php
if ($r) {
    echo $r->obtenerNombreResponsable();
}
?> 
                    </p>
                </li>
                <li>
                    <p class="navbar-text"> <?php echo $r->obtenerCorreo(); ?> </p>
                </li>
            </ul>
        </div>
    </nav>
</header>

