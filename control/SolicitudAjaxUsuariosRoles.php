<?php

require_once ("../modelo/ProcedimientosPermisos.php");
require_once ("../control/AdministracionTablas.php");
$roles = consultarRoles();

//Traté de  colocar esto en la página control/AdministracionTablas.php pero no funciona no se porque
if (isset($_POST['comboRolesUsuariosModal'])) {
    usuariosAsignadosRol($roles);
}

//Modal eliminar roles  
if (isset($_POST['hiddenEliminarRol']) == 'hiddenEliminarRol') {
    $actual = $_POST['hiddenEliminarRol'];
    $codRol = rolSeleccionado($roles, $actual);
    $mensaje = eliminarRol($codRol);
    if($mensaje != ''){
        $mensaje =  2;
    echo $mensaje;      
    } else {
        $mensaje =  1;       
        echo $mensaje;
    } 
}

