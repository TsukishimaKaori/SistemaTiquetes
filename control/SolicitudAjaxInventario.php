<?php

require_once ("../control/AdministrarTablaInventario.php");
require ("../modelo/ProcedimientosInventario.php");

//Muestra el panel de activos fijos
if (isset($_POST['codigoActivo'])) {
    $codigo = $_POST['codigoActivo'];
    $activos = obtenerActivosFijos();
    panelActivos($activos, $codigo);
}

//Muestra el panel de inventario
if (isset($_POST['codigoPasivo'])) {
    $codigo = $_POST['codigoPasivo'];
    $inventario = obtenerInventario();
    panelPasivos($inventario, $codigo);
}

//MOstrar el panel que suma elemetnos al inventario
if (isset($_POST['codigoSumarInventario'])) {
    $codigo = $_POST['codigoSumarInventario'];
    $inventario = obtenerInventario();
    panelSumarAInventario($inventario,$codigo);
}

//Mostrar el panel para agregar a inventario
if (isset($_POST['codigoAgregarInventario'])) {
    $codigo = $_POST['codigoAgregarInventario'];
    $categorias = obtenerCategorias();
    $bodegas = obtenerBodegas();
    panelAgregarInventario($categorias,$bodegas);
}

//Agrega nuevos elementos al inventario
if (isset($_POST['codigoArticuloAgregarInventario'])) {
    $codigoArticulo = $_POST['codigoArticuloAgregarInventario'];
    $descripcion = $_POST['descripcion'];
    $codigoCategoria = $_POST['categoria'];
    $estado = $_POST['estado'];
    $cantidad = $_POST['cantidad'];
    $bodega = $_POST['bodega'];
    $costo =  $_POST['costo'];
    $comentarioUsuario = $_POST['comentario'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];
    agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado,
	$cantidad, $bodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante);
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);

}

//Suma articulos al inventario ya existente
if (isset($_POST['codigoArticuloSuma'])) {
    $codigoArticulo = $_POST['codigoArticuloSuma'];
    $cantidadEfecto = $_POST['cantidadSuma'];
    $comentarioUsuario = $_POST['comentarioSuma'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];
    aumentarCantidadInventario($codigoArticulo, $cantidadEfecto,$comentarioUsuario, 
        $correoUsuarioCausante, $nombreUsuarioCausante) ;
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);

}

//Muestra el panel para asociar repuestos 
if(isset($_POST['codigoAgregarRepuesto'])){
     $codigoArticulo = $_POST['codigoAgregarRepuesto'];
     $dispositivos = obtenerActivosFijos();
     $repuestos = obtenerRepuestosParaAsociar();     
     panelAgregarRepuesto($dispositivos,$repuestos, $codigoArticulo);
}

//Muestra el panel para agregar licencias 
if(isset($_POST['codigoAgregarLicencia'])){
     $codigoArticulo = $_POST['codigoAgregarLicencia'];
      $dispositivos = obtenerActivosFijos();
     panelAgregarLicencia($dispositivos, $codigoArticulo);
}

//Agregar una licencia a un equipo
if (isset($_POST['claveProductoLicencia'])){
    $placa = $_POST['codigoEquipo'];
    $descripcionLicencia = $_POST['descripcionLicencia'];
    $claveProductoLicencia = $_POST['claveProductoLicencia'];
    $proveedorLicencia = $_POST['proveedorLicencia'];
    $vencimientoLicencia = $_POST['vencimientoLicencia'];    
    $dia = substr($vencimientoLicencia, 0, 2);
    $mes = substr($vencimientoLicencia, 3, 2);
    $anio = substr($vencimientoLicencia, 6, 4);
   //$vencimientoLicencia = $anio . '-' . $dia. '-' .$mes;
      $vencimientoLicencia = $anio . '-' .$mes. '-'. $dia ;
    $correoUsuarioCausante =  $_POST['correoUsuarioCausante'];
    $nombreUsuarioCausante =  $_POST['nombreUsuarioCausante'];
    agregarLicencia($vencimientoLicencia, $claveProductoLicencia, $proveedorLicencia, $descripcionLicencia, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
}


//Listar las licencias asociados a un equipo
if (isset($_POST['codigoEquipoParaLicencia'])){
    $placa = $_POST['codigoEquipoParaLicencia'];
    $licencias  = obtenerLicencias($placa);
     cuerpoTablaLicencias($licencias);
    
}

//Listar los repusetos asociados a un equipo
if (isset($_POST['codigoEquipoParaRepuesto'])){
    $placa = $_POST['codigoEquipoParaRepuesto'];
    $repuestos  = obtenerRepuestos($placa);
    cuerpoTablaRepuestos($repuestos);
 
}

//Asociar un repuesto a un equipo 
if (isset($_POST['codigoAsociarEquipo'])){
    $placa =$_POST['codigoAsociarEquipo'];
    $codigoArticulo =$_POST['codigoArticulo'];
    $bodega = $_POST['bodega'];
    $correoUsuarioCausante =  $_POST['correoUsuarioCausante'];
    $nombreUsuarioCausante =  $_POST['nombreUsuarioCausante'];   
    asociarRepuesto($codigoArticulo, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);
}