<?php

require_once ("../modelo/ProcedimientosTiquetes.php");
require_once ("../control/AdministrarTablasSubTematicasTematicas.php");
$tematicasNivel1 = obtenerTematicasPadreCompletas();
$mensajeSubtematicas = "";

//Carga las subtematicas correspondientes a una tematica
if (isset($_POST['tematicaSeleccionada'])) {
    $actual = $_POST['tematicaSeleccionada'];
    $codigoPadre = tematicaSeleccionado($tematicasNivel1, $actual);
    $clickeado3 = $_POST['clickeado3'];
    $tematicasHijas = $clickeado3 == 'radio2' ?
            obtenerTematicasHijasCompletas($codigoPadre) :
            obtenerTematicasHijasActivas($codigoPadre);
    cuerpoTablaSubTematicas($tematicasHijas, $actual);
}

if (isset($_POST['nombreTematica'])) {
    $nombreTematica = $_POST['nombreTematica'];
    $activoTematica = $_POST['activoTematica'];
    $clickeado2 = $_POST['clickeado2'];
    $valorComboTematicaPadre = $_POST['valorComboTematicaPadre'];
    $codigoPadre = tematicaSeleccionado($tematicasNivel1, $valorComboTematicaPadre);
    cambiarTematicasActivas(obtenerTematicasHijasCompletas($codigoPadre), $nombreTematica, $activoTematica);
    $tematicasHijasCompletas = obtenerTematicasHijasCompletas($codigoPadre);
    $tematicasHijasActivas = obtenerTematicasHijasActivas($codigoPadre);
    $tematicasHijas = $clickeado2 == 'radio2' ? $tematicasHijasCompletas : $tematicasHijasActivas;
    cuerpoTablaSubTematicas($tematicasHijas, $nombreTematica);
}
//Agrega subtematicas
if (isset($_POST['valorInputSubTematica'])) {
    $valorInputSubTematica =  utf8_decode($_POST['valorInputSubTematica']);
    $valorComboPadreSubTematica = $_POST['valorComboPadreSubTematica'];
    $codPadre = tematicaSeleccionado($tematicasNivel1, $valorComboPadreSubTematica);
    $mensajeSubtematicas = agregarTematicaHija($valorInputSubTematica, $codPadre);
    echo $mensajeSubtematicas;
}

//MOdificar subtematica
if (isset($_POST['subtematicaModificada'])) {
    $valorSubtematicaModificada = $_POST['subtematicaModificada'];
    $subtematicaAnterior = $_POST['subtematicaAnterior'];
    $tematicaPadre = $_POST['tematicaPadre'];
    $tematicaPadreAnterior = $_POST['tematicaPadreAnterior'];
    $clickeado4 = $_POST['clickeado4'];
    $tematicasNivel1 = obtenerTematicasPadreCompletas();
    $codigoTematicaPadreAnterior = tematicaSeleccionada($tematicasNivel1, $tematicaPadreAnterior);
    $subtematicas = obtenerTematicasHijasCompletas($codigoTematicaPadreAnterior);
    $codigoInputSubTematica = tematicaSeleccionada($subtematicas, $subtematicaAnterior);
    $codigoTematicaPadre = tematicaSeleccionada($tematicasNivel1, $tematicaPadre);
    actualizarPadreTematica($codigoInputSubTematica, $codigoTematicaPadre);
    $men = actualizarDescripcionTematica($codigoInputSubTematica, $valorSubtematicaModificada);
    $tematicasHijasActivas = obtenerTematicasHijasActivas($codigoTematicaPadreAnterior);
    $tematicasHijasCompletas = obtenerTematicasHijasCompletas($codigoTematicaPadreAnterior);
    $clickeado4 = $clickeado4 == 'radio2' ? $tematicasHijasCompletas : $tematicasHijasActivas;
    if ($men == '') {
        cuerpoTablaSubTematicas($clickeado4, $tematicaPadre);
    }else if ($men == 1) {
        echo 1; // no existe la tematica a actualizar
    }else if ($men == 2) {
        echo 2; //  'Ya existe una temática con la descripción '
    }else {
        echo 3; //'Ha ocurrido un error';
    }
}

//Eliminar subtematica
if (isset($_POST['nombreSubtematicaEliminar'])) {
    $eliminar = $_POST['nombreSubtematicaEliminar'];
    $tematicaPadre = $_POST['tematicaPadre'];
    $clickeado4 = $_POST['clickeado4'];
    $codPadre = tematicaSeleccionada($tematicasNivel1, $tematicaPadre);
    $subtematicas = obtenerTematicasHijasCompletas($codPadre);
    $codiTema = tematicaSeleccionada($subtematicas, $eliminar);
    $mensaje = eliminarTematica($codiTema);
    $tematicasHijasActivas = obtenerTematicasHijasActivas($codPadre);
    $tematicasHijasCompletas = obtenerTematicasHijasCompletas($codPadre);
    $clickeado4 = $clickeado4 == 'radio2' ? $tematicasHijasCompletas : $tematicasHijasActivas;
    if ($mensaje == 3) { //correcto
        cuerpoTablaSubTematicas($clickeado4, $tematicaPadre);
    } else if ($mensaje == 1) { //no existe la clasificacion a elminar ya existe
        echo 1;
    } else { //error genral
        echo 2;
    }
}

//Radio button filtrado por activo o inactivo
if (isset($_POST['clickeado'])) {
    $clickeado = $_POST['clickeado'];
    $tematicaPadre = $_POST['tematicaPadre'];
    $codPadre = tematicaSeleccionada($tematicasNivel1, $tematicaPadre);
    $tematicasHijasActivas = obtenerTematicasHijasActivas($codPadre);
    $tematicasHijasCompletas = obtenerTematicasHijasCompletas($codPadre);
    $clickeado = $clickeado == 'radio2' ? $tematicasHijasCompletas : $tematicasHijasActivas;
    cuerpoTablaSubTematicas($clickeado, $tematicaPadre);
}


