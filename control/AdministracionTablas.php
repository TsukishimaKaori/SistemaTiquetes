<?php

$roles = consultarRoles();
$permisos = consultarPermisos();
$responsa = obtenerResponsables();
$mensaje = 'null'; // necesario para mostrar las alertas de error
$bandera = 0;

//Carga combo de selectores Modal
function comboRolesModal($roles, $combo) {
    $actual = $_POST[$combo];
    opcionesSelect($combo);
    foreach ($roles as $rol) {
        if ($rol->obtenerNombreRol() != 'Administrador' && $combo == 'comboRolesModal') {
            opcionesSeleccion($rol, $actual);
        } else if ($combo == 'comboRolesUsuariosModal') {
            opcionesSeleccion($rol, $actual);
        } else if ($combo == 'comboRoles') {
            opcionesSeleccion($rol, $actual);
        }
    }
    echo '</select>';
}

//Creacion de las opciones de los comboBox
function opcionesSeleccion($rol, $actual) {
    if ($rol->obtenerNombreRol() == $actual) {
        echo '<option  value="' . $rol->obtenerNombreRol() . '" selected>' . $rol->obtenerNombreRol() . '</option>';
    } else {
        echo '<option  value="' . $rol->obtenerNombreRol() . '">' . $rol->obtenerNombreRol() . '</option>';
    }
}

//Creacion de la cabecera de los comboBox
function opcionesSelect($combo) {
    if ($combo == 'comboRoles') { // carga el combo de permisos roles
        echo '<select class="form-control " name ="' . $combo . '" id="' . $combo . '"   onchange="guardarvaloractual(this);" >';
    } else if ($combo == 'comboRolesModal') { //carga el combo de eliminacion
        echo '<select class="form-control " name ="' . $combo . '" id= "' . $combo . '" >';
    } else if ($combo == 'comboRolesUsuariosModal') { //carga el combo de usuarios roles
        echo '<select class="form-control " name ="' . $combo . '" id= "' . $combo . '" onchange="comboRolesUsuarios(this);" >';
    }
}

//Creacion del cuerpo de la tabla de permisos activos o inactivos
function cuerpoTablaPermisos($permisos, $roles) {    
    $actual = $_POST['comboRoles'];
    $codigoRol = rolSeleccionado($roles, $actual);
    $i = 0;
    foreach ($permisos as $per) {
        $permisoCodigos[] = $per->obtenerCodigoPermiso();
    }
    $codPermiso = obtenerPermisosAsignadosRol($codigoRol);
    foreach ($permisos as $per) {
        echo '<tr><td>' . $per->obtenerDescripcionPermiso() . '</td>';
        
        if ($codigoRol == 1) { //Verifica si es administrador, el administrador tiene codigo 1. //
            if (in_array($permisoCodigos[$i], $codPermiso)) {
               echo '<td ><input name ="permiso' . $i . '" id="' . $i . '"type="checkbox" checked disabled></td>'; //acutal checkeado
            } else {
               echo '<td ><input name ="permiso' . $i . '" id="' . $i . '" type="checkbox" " disabled></td>';
            }
        } else {
            if (in_array($permisoCodigos[$i], $codPermiso)) {
                echo '<td ><input name ="permiso' . $i . '" id="' . $i . '"type="checkbox" checked></td>'; //acutal checkeado
            } else {
                echo '<td ><input name ="permiso' . $i . '" id="' . $i . '" type="checkbox" "></td>';
            } 
        }
        echo '</tr>';

        $i = $i + 1;
    }
}

//Retorna el codigo del rol. Recibe el nombre del rol
function rolSeleccionado($roles, $actual) {
    foreach ($roles as $rol) {
        if ($rol->obtenerNombreRol() == $actual) {
            $a = $rol->obtenerCodigoRol();
        }
    }
    return $a != null ? $a : $roles[0]->obtenerCodigoRol(); //si no hay ningun rol, el agarra el codigo del rol en la posicion 0
}

//Funcion que lista los usuarios por rol (llamada desde SolicitudAjaxUuariosRoles)
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

//Metodos que verifica los check 
if (isset($_POST['inputHiddenPermisos']) == 'inputHiddenPermisos') {
    if ($_POST['inputHiddenPermisos'] == "inputHiddenPermisos") {
        $i = 0;
        $actual = $_POST['comboRoles'];
        $codigoRol = rolSeleccionado($roles, $actual);
        $codPermiso = obtenerPermisosAsignadosRol($codigoRol);
        foreach ($permisos as $perm) {
            $per = "permiso" . $i;
            $codigoPermiso = $perm->obtenerCodigoPermiso();
            if (isset($_POST[$per]) == "on") {
                if (!verificarPermiso($codigoRol, $codigoPermiso)) {
                    insertarPermisoRol($codigoRol, $codigoPermiso);
                }
            } else {  //no esta checkeado    
                if ((verificarPermiso($codigoRol, $codigoPermiso))) {
                    eliminarPermisoRol($codigoRol, $codigoPermiso);
                }
            }
            $i++;
        }
    }
}

//Modal agregar roles
if (isset($_POST['hiddenAgregarRol']) == 'hiddenAgregarRol') {
    $nuevoRol = utf8_decode($_POST['agregarRol']);
    $mensaje = agregarRol($nuevoRol);
    $bandera = $mensaje != "" ? 1 : 2; // 1 correcto, 2 error
}



//Usuarios roles
if (isset($_POST['hiddenRolesUsuarios']) == 'hiddenRolesUsuarios') {
    $mensaje = actualizarPermisos($responsa, $roles);
}

//function alertas() {
//    global $bandera;
//    global $mensaje;
//    //Para el agregar roles
//    if ($bandera == 1) { // 1: Trata de agregar un usuario que ya existe
//        echo "<script> alert('" . $mensaje . "'); </script>";
//    } else if ($bandera == 2) { //2: Agrega el usuario correctamente
//        echo "<script> alert('Rol agregado correctamente '); </script>";
//    }
//    //Para el eliminar roles
//    else if ($bandera == 3) { //2: Agrega el usuario correctamente
//        echo "<script> alert('" . $mensaje . "'); </script>";
//    } else if ($bandera == 4) { //2: Agrega el usuario correctamente
//        echo "<script> alert('Rol eliminado'); </script>";
//    }
//}
