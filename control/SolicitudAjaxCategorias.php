<?php

require_once ("../modelo/ProcedimientosInventario.php");
require_once ("../control/AdministrarTablaCategorias.php");

if (isset($_POST['valorInputCategoria'])) {
    $valorInputCategoria = utf8_decode($_POST['valorInputCategoria']);
    $esRepuesto = $_POST['esRepuesto'];
    $clickeados = $_POST['clickeados'];
    if ($esRepuesto == "true") {
        $esRepuesto = '1';
    } else {
        $esRepuesto = '0';
    }
    $error = agregarCategoria($valorInputCategoria, $esRepuesto);
    if ($error == "") {
        $categorias = obtenerCategorias();
        $cate = retornarCategoriasFiltradas($categorias, $clickeados);
        cuerpoTablaCategorias($cate);
    } else {
        echo $error;
    }
}


//Eliminar subtematica
if (isset($_POST['idCategoriaEliminar'])) {
    $codigoCategoria = $_POST['idCategoriaEliminar'];
    $clickeados = $_POST['clickeados'];
    $mensaje = eliminarCategoria($codigoCategoria);
    if ($mensaje == "") { //correcto
        $categorias = obtenerCategorias();
          $cate = retornarCategoriasFiltradas($categorias,$clickeados);
        cuerpoTablaCategorias($cate);
    } else if ($mensaje == 3) { //no existe la clasificacion a elminar ya existe
        echo 3;
    } else { //error genral
        echo 1; // la tematica a eliminar no existe
    }
}


//Radio button filtrado por activo o inactivo
if (isset($_POST['clickeado'])) {
    $clickeado = $_POST['clickeado'];
    $categorias = obtenerCategorias();
    $cate = retornarCategoriasFiltradas($categorias, $clickeado);
    cuerpoTablaCategorias($cate);
}

function retornarCategoriasFiltradas($categorias, $clickeado) {
    if ($clickeado == "radio1") { //Repuestos
        $cate = filtrarEsRepuesto($categorias);
    } else if ($clickeado == "radio2") { //todos
        $cate = $categorias;
    } else if ($clickeado == "radio3") { //no repuestos
        $cate = filtrarPorNoRepuesto($categorias);
    }
    return $cate;
}
