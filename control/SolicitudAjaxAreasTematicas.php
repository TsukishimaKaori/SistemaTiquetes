<?php

require_once ("../modelo/ProcedimientosTiquetes.php");
require_once ("../control/AdministrarTablasAreasTematicas.php");
$areas = obtenerAreas();
$tematicasNivel1 = obtenerTematicasPadreCompletas();
//Cambia el estado activo o inactivo de las areas
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $activo = $_POST['activo'];
    cambiarAreasActivas($areas, $nombre, $activo);
}

//Actualiza las areas asociadas a una tematica
if (isset($_POST['tematica'])) {
    $tematica = $_POST['tematica']; //Tematica relacionada
    $area = $_POST['seleccionado']; //area seleccionada
    actualizarAreaAsociadaTematicas($area, $areas, $tematica, $tematicasNivel1);
}

//Post del boton activar de la tabla de tematicas areas
if (isset($_POST['nombreTematica'])) {
    $nombreTematica = $_POST['nombreTematica'];
    $activoTematica = $_POST['activoTematica'];
    $clickeado = $_POST['clickeado2'];
    cambiarTematicasActivas($tematicasNivel1, $nombreTematica, $activoTematica);
    $tematicasNivel1Activas = obtenerTematicasPadreActivas();
    $tematicasNivel1 = obtenerTematicasPadreCompletas();
    $clickeado = $clickeado == 'radio2' ? $tematicasNivel1 : $tematicasNivel1Activas;
    cuerpoTablaTematicasNivel1($clickeado, $areas);
}

//Agrega tematicas asociadas a un area
if (isset($_POST['valorInputTematica'])) {
    $valorInputTematica = utf8_decode($_POST['valorInputTematica']);
    $valorComboPadre = $_POST['valorComboPadre'];
    $codArea = areaSeleccionada($areas, $valorComboPadre);
    $mensajeTematica = agregarTematicaPadre($valorInputTematica, $codArea);
    echo $mensajeTematica;
}



if (isset($_POST['tematicaModificada'])) {
    $tematicaModificada = $_POST['tematicaModificada'];
    $tematicaAnterior = $_POST['tematicaAnterior'];
    $clickeado2 = $_POST['clickeado2'];
    $codTema = tematicaSeleccionada($tematicasNivel1, $tematicaAnterior);
    $retorno = actualizarDescripcionTematica($codTema, $tematicaModificada);
    if ($retorno == '') {
        $tematicasNivel1 = $clickeado2 == 'radio2' ? obtenerTematicasPadreCompletas() : obtenerTematicasPadreActivas();
        cuerpoTablaTematicasNivel1($tematicasNivel1, $areas);
    }else if ($retorno == 1) { //'No existe la temática a actualizar'. (Esta inactiva)    
        echo 1;
    }  else if ($retorno == 2) { //El nombre de la tematica a modificar ya existe.        
        echo 2;
    } else if ($retorno == 3) { //'Ha ocurrido un error' no esta activa la tematica.
        echo 3;
    }
}

//Modifica el nombre de las areas
if (isset($_POST['valorInputArea'])) {
    $valorInputArea = utf8_decode($_POST['valorInputArea']);
    //$codTema = tematicaSeleccionada($tematicasNivel1, $tematicaAnterior);
    $retorno = agregarArea($valorInputArea);
    if ($retorno == '') {
        //cuerpoTablaTematicasNivel1($tematicasNivel1, $areas);
        echo 3;
    } else if ($retorno == 1) { //Ya existe    
        echo 1;
    } else if ($retorno == 2) { //Error general       
        echo 2;
    } else { //Agregado correctamente
    }
}

//Modificar nombre del area
if (isset($_POST['areaModificada'])) {
    $areaModificada = $_POST['areaModificada'];
    $areaAnterior = $_POST['areaAnterior'];
    $codArea = areaSeleccionada($areas, $areaAnterior);
    actualizarArea($codArea, $areaModificada);
}

if (isset($_POST['clickeado'])) {
    $clickeado = $_POST['clickeado'];
    $tematicasNivel1Activas = obtenerTematicasPadreActivas();
    $clickeado = $clickeado == 'radio2' ? $tematicasNivel1 : $tematicasNivel1Activas;
    cuerpoTablaTematicasNivel1($clickeado, $areas);
}

//Modal eliminar areas 
if (isset($_POST['valorEliminarArea'])) {
    $actual = $_POST['valorEliminarArea'];
    $codArea = areaSeleccionada($areas, $actual);
    $mensaje = eliminarArea($codArea); //
    if ($mensaje == "") { // Eliminado correctamente
        $mensaje = 2;
    } else if ($mensaje == 1) { //'Ha ocurrido un error al eliminar el área';
          $mensaje = 1;
    } else {
        $mensaje =3; //'El área tiene clasificaciones o tiquetes asociados';
    }
    echo $mensaje;
}  