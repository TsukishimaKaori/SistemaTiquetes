<?php

require ("../modelo/ProcedimientosPermisos.php");
require ("../modelo/Cliente.php");    //Archivo que consume el web service de la base de recursos humanos
if($_SERVER['AUTH_USER']){
    $_SESSION['username'] = $_SERVER['AUTH_USER'];
}

$r = obtenerResponsable($_SESSION['username']);  //el username es el correo del empleado

if($r == ''){
    //aquí hay que tomar el usuario del web service
    $r = consumirMetodoUno($_SESSION['username']);
    $_SESSION['objetoUsuario'] = $r;
}else{
    $_SESSION['objetoUsuario'] = $r;
}