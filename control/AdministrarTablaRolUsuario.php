<?php


$roles = consultarRoles();

$mensaje = 'null';
$mensaje2 = "NULL";


function tablaRolesUsuarios($r,$responsa, $roles, $areas) {
 
    foreach ($responsa as $respo) {
        echo '<tr >';
        echo '<td name="cod"' . $contador . '"  >';
        echo $respo->obtenerCodigoEmpleado();
        echo '</td>';
        echo '<td  >';
        echo $respo->obtenerNombreResponsable();
        echo '</td>';
        echo '<td  >';
        echo '<div class="form-group">';
        echo '<select class="form-control"  id="area" onclick="guardarvaloractual(this);" onchange="alertaSeguridad(this);"  >';
        foreach ($areas as $area) {
            if ($area->obtenerNombreArea() == $respo->obtenerArea()->obtenerNombreArea()) {
                echo '<option id = opcSeleccionada selected value="' . $area->obtenerCodigoArea() . '">';
            } else {
                echo '<option id = opcSeleccionada  value="' . $area->obtenerCodigoArea() . '">';
            }
            echo $area->obtenerNombreArea();
            echo ' </option>';
        }
        echo '</select>';
        echo '</div>';
        echo '</td>';
        echo '<td >';
        echo '<div class="form-group">';
        echo '<select class="form-control"  id="rol" onclick="guardarvaloractual(this);"   onchange="alertaSeguridad(this);" >';
        foreach ($roles as $rol) {
            if ($rol->obtenerNombreRol() == $respo->obtenerRol()->obtenerNombreRol()) {
                echo '<option id = opcSeleccionada selected value="' . $rol->obtenerCodigoRol() . '">';
            } else {
                echo '<option id = opcSeleccionada  value="' . $rol->obtenerCodigoRol() . '">';
            }
            echo $rol->obtenerNombreRol();
            echo ' </option>';
        }
        echo '</select>';
        echo '</div>';
        echo '</td>';
        echo '<td >';
        if ($respo->obtenerLoginActivo()) {
            if($respo->obtenerRol()->obtenerCodigoRol()!=1 && $r->obtenerCodigoEmpleado()!=$respo->obtenerCodigoEmpleado()){
            echo' <label for="act" class="btn btn-success" onclick="cambiarActivo(this);" >Activo</label>';
            }
           
        } else {
            if($respo->obtenerRol()->obtenerCodigoRol()!=1 && $r->obtenerCodigoEmpleado()!=$respo->obtenerCodigoEmpleado()){
            echo'  <label for="act" class="btn btn-danger" onclick="cambiarActivo(this);" >Inactivo</label>';
            }
           
        }
        
        echo '</td>';
        echo '</tr>';
        $contador++;
    }
}

//// funcion post para actualizar la base de datos
//
function actualizarPermisos($responsa,$nuevo,$codigo){
    foreach ($responsa as $respo) {
        if ($codigo== $respo->obtenerCodigoEmpleado()) {       
            $mensaje = actualizarRolResponsable($nuevo, $codigo);
                    break;
                }
            } 
    return $mensaje;
}

//
function actualizarAreas($responsa,$nuevo, $codigo) {
    foreach ($responsa as $respo) {
        if ($codigo== $respo->obtenerCodigoEmpleado()) {
             $nombre= utf8_decode($respo->obtenerNombreResponsable());
             $login=  $respo->obtenerLoginActivo();
             $codRol= $respo->obtenerRol()->obtenerCodigoRol();
             $corr = $respo->obtenerCorreo();
                    $mensaje = actualizarResponsable($codigo, $nombre, $login, $nuevo, $codRol, $corr);
                    break;
                }
            }
    
    return $mensaje;
}

//
function selectRoles($roles) {

    echo '<select class="form-control " name = "rol" id="rolU"    >';
    foreach ($roles as $rol) {
        echo '<option id = "opcSeleccionada"  value="' . $rol->obtenerCodigoRol() . '">';
        echo $rol->obtenerNombreRol();
        echo ' </option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
}

function selectAreas($areas) {

    echo '<select class="form-control" name = "area" id="areaU"    >';

    foreach ($areas as $area) {
        echo '<option id = "opcSeleccionada"  value="' . $area->obtenerCodigoArea() . '">';

        echo $area->obtenerNombreArea();
        echo ' </option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
}

//
function nuevoresponsable() {
    $nombre = utf8_decode($_POST["nombre"]);
    $codigoE = $_POST["codigoU"];
    $email = $_POST["emailA"];
    $Area = $_POST["area"];
    $rol = $_POST["rol"];
    $mensaje2 = agregarResponsable($rol, $codigoE, $nombre, $Area, $email);
    return $mensaje2;
}
//

function desactivarEmpleados($responsa,$nuevo,$codigo){
    foreach ($responsa as $respo) {
        if ($codigo== $respo->obtenerCodigoEmpleado()) {
                       
            if ($nuevo=="Activo") {
                $mensaje = activarResponsable($codigo);
            } else {
                $mensaje = inactivarResponsable($codigo);
            }
        }
       
    }
    return $mensaje;
}

////// funcion javascript para mostrar el comfiamr
?>
