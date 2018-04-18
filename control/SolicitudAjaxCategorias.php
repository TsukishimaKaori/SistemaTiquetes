<?php

require_once ("../modelo/ProcedimientosInventario.php");
require_once ("../control/AdministrarTablaCategorias.php");

if (isset($_POST['valorInputCategoria'])) {
    $valorInputCategoria = utf8_decode($_POST['valorInputCategoria']);
    $esRepuesto = $_POST['esRepuesto'];
    if ($esRepuesto == "true") {
        $esRepuesto = "1";
    } else {
        $esRepuesto = "0";
    }
    $error = agregarCategoria($valorInputCategoria, $esRepuesto);
    if ($error == "") {
        $categorias = obtenerCategorias();
        cuerpoTablaCategorias($categorias);
    } else {
        echo $error;
    }
}


//Eliminar subtematica
if (isset($_POST['idCategoriaEliminar'])) {
    $codigoCategoria = $_POST['idCategoriaEliminar'];
   $mensaje =  eliminarCategoria($codigoCategoria);
    if ($mensaje == "") { //correcto
        $categorias = obtenerCategorias();
        cuerpoTablaCategorias($categorias);
    } else if ($mensaje == 3) { //no existe la clasificacion a elminar ya existe
        echo 3;
    } else { //error genral
        echo 1; // la tematica a eliminar no existe
    }
}


