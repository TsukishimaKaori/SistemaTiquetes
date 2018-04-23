<?php

require_once '../modelo/Usuario.php';

function consumirMetodoUno($correo) {


    $url = file_get_contents("http://localhost/sistemaTicketing/modelo/Service.php?metodo=1&correo=$correo", FILE_USE_INCLUDE_PATH);
    $url = file_get_contents("http://localhost/sistemaTicketing/modelo/Service.php?metodo=1&correo=$correo");

    $opciones = array(
        'http' => array(
            'header' => "Content-type: application/json"
        )
    );

    $contexto = stream_context_create($opciones);
    $url =  file_get_contents("http://localhost/sistemaTicketing/modelo/Service.php?metodo=1&correo=$correo", false, $contexto);
    $jsonObject = json_decode($url, true);
    foreach ($jsonObject as $j) {
        $usuario = new Usuario($j[0], $j[1], $j[2], $j[3], $j[4], $j[5]);
    }
    return $usuario;
}

function consumirMetodoDos() {
    $jsonObject = json_decode(file_get_contents("http://localhost/sistemaTicketing/modelo/Service.php?metodo=2"), FILE_USE_INCLUDE_PATH);
    $usuarios = array();
    foreach ($jsonObject as $j) {
        foreach ($j as $f) {
            $usuario = new Usuario($f[0], $f[1], $f[2], $f[3], $f[4], $f[5]);
            $usuarios[] = $usuario;
        }
    }
    return $usuarios;
}

$usuario = consumirMetodoUno('nubeblanca1997@outlook.com');
echo $usuario->obtenerNombreUsuario();
echo $usuario->obtenerCorreo();
echo $usuario->obtenerDepartamento();
echo $usuario->obtenerJefatura();
echo $usuario->obtenerNumeroCedula();
echo $usuario->obtenerCodigoEmpleado();

$usuarios = consumirMetodoDos();

foreach ($usuarios as $usuario) {
    echo $usuario->obtenerNombreUsuario() . '<br />';
    echo $usuario->obtenerCorreo() . '<br />';
    echo $usuario->obtenerDepartamento() . '<br />';
    echo $usuario->obtenerJefatura() . '<br />';
    echo $usuario->obtenerNumeroCedula() . '<br />';
    echo $usuario->obtenerCodigoEmpleado() . '<br />';
    echo '<br />';
}

