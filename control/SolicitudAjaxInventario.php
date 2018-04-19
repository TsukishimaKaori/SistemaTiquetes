<?php

require_once ("../control/AdministrarTablaInventario.php");
require ("../modelo/ProcedimientosInventario.php");
require ("../modelo/Cliente.php");

session_start();
$r = $_SESSION['objetoUsuario'];
//Muestra el panel de activos fijos
if (isset($_POST['codigoActivo'])) {
    $codigo = $_POST['codigoActivo'];
    $activos = obtenerActivosFijos();
    $listaActivos = obtenerActivosFiltradosPlaca($codigo);
    $codigoEstadoActual = $listaActivos->obtenerEstado()->obtenerCodigoEstado();
    $estadosSiguentes = obtenerEstadosEquipo($codigoEstadoActual);
    $responsables = null;
    if ($listaActivos->obtenerNombreUsuarioAsociado() == null) {
        $responsables = consumirMetodoDos();
    }
    panelActivos($listaActivos, $estadosSiguentes, $responsables);
}

//Muestra el panel de inventario
if (isset($_POST['codigoPasivo'])) {
    $codigo = $_POST['codigoPasivo'];
    $bodega = $_POST['bodega'];
    $inventario = obtenerInventario();
    $listaPasivos = obtenerArticuloFiltradoCodigoBodega($codigo, $bodega);
    panelPasivos($listaPasivos);
}

//MOstrar el panel que suma elemetnos al inventario
if (isset($_POST['codigoSumarInventario'])) {
    $codigo = $_POST['codigoSumarInventario'];
    $bodega = $_POST['bodega'];
    ////////////////////////////////////////
    $inventario = obtenerArticuloFiltradoCodigoBodega($codigo, $bodega);
    panelSumarAInventario($inventario, $codigo);
}

//Mostrar el panel para agregar a inventario
if (isset($_POST['codigoAgregarInventario'])) {
    $codigo = $_POST['codigoAgregarInventario'];
    $categorias = obtenerCategorias();
    $bodegas = obtenerBodegas();
    panelAgregarInventario($categorias, $bodegas);
}

//Agrega nuevos elementos al inventario
if (isset($_POST['codigoArticuloAgregarInventario'])) {
    $codigoArticulo = $_POST['codigoArticuloAgregarInventario'];
    $descripcion = $_POST['descripcion'];
    $codigoCategoria = $_POST['categoria'];
    $estado = $_POST['estado'];
    $cantidad = $_POST['cantidad'];
    $orden = $_POST['orden'];
    $codigoBodega = $_POST['bodega'];
    $costo = $_POST['costo'];
    $comentarioUsuario = $_POST['comentario'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];
    $codigoTiquete=$_POST['tiquete'];
    $proveedor=$_POST['provedor'];
     $marca=$_POST['marca'];
    $direccionOrdenDeCompra = "";
    if ($_FILES["archivo"]) {
        $nombre_tmp = $_FILES["archivo"]["tmp_name"];
        // basename() puede evitar ataques de denegació del sistema de ficheros;
        // podría ser apropiado más validación/saneamiento del nombre de fichero
        $archivo = basename($_FILES["archivo"]["name"]);
        $direccionOrdenDeCompra = '../adjuntos/ordenesCompra/' . $orden . "-" . $archivo;
        $mensaje = agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado, $cantidad, $codigoBodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante, $proveedor, $marca, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete);

        if ($mensaje == '') {
            move_uploaded_file($nombre_tmp, utf8_decode($direccionOrdenDeCompra));
        }
    } else {
        $mensaje = agregarArticuloInventario($codigoArticulo, $descripcion, $costo, $codigoCategoria, $estado, $cantidad, $codigoBodega, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante, $proveedor, $marca, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete);
    }
    if ($mensaje == '') {
        $inventario = obtenerInventario();
        cuerpoTablaPasivos($inventario);
    } else {
        echo 'Error';
    }
}

//Suma articulos al inventario ya existente
if (isset($_POST['codigoArticuloSuma'])) {
    $codigoArticulo = $_POST['codigoArticuloSuma'];
    $cantidadEfecto = $_POST['cantidadSuma'];
    $comentarioUsuario = $_POST['comentarioSuma'];
    $correoUsuarioCausante = $_POST['correoUsuario'];
    $nombreUsuarioCausante = $_POST['nombreUsuario'];

    aumentarCantidadInventario($codigoArticulo, $cantidadEfecto, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante, $numeroOrdenDeCompra, $direccionOrdenDeCompra, $codigoTiquete);
    $inventario = obtenerInventario();
    cuerpoTablaPasivos($inventario);
}

//Muestra el panel para asociar repuestos 
if (isset($_POST['codigoAgregarRepuesto'])) {
    $codigoArticulo = $_POST['codigoAgregarRepuesto'];
    $dispositivos = obtenerActivosFiltradosPlaca($codigoArticulo);
    $repuestos = obtenerRepuestosParaAsociar();
    panelAgregarRepuesto($dispositivos, $repuestos, $codigoArticulo);
}

//Muestra el panel para agregar licencias 
if (isset($_POST['codigoAgregarLicencia'])) {
    $codigoArticulo = $_POST['codigoAgregarLicencia'];
    $dispositivos = obtenerActivosFiltradosPlaca($codigoArticulo);
    panelAgregarLicencia($dispositivos, $codigoArticulo);
}

//Agregar una licencia a un equipo
if (isset($_POST['claveProductoLicencia'])) {
    $placa = $_POST['codigoEquipo'];
    $descripcionLicencia = $_POST['descripcionLicencia'];
    $claveProductoLicencia = $_POST['claveProductoLicencia'];
    $proveedorLicencia = $_POST['proveedorLicencia'];
    $vencimientoLicencia = $_POST['vencimientoLicencia'];
    $dia = substr($vencimientoLicencia, 0, 2);
    $mes = substr($vencimientoLicencia, 3, 2);
    $anio = substr($vencimientoLicencia, 6, 4);

    $vencimientoLicencia = $anio . $mes . $dia;
    $correoUsuarioCausante = $_POST['correoUsuarioCausante'];
    $nombreUsuarioCausante = $_POST['nombreUsuarioCausante'];
    $bandera = agregarLicencia($vencimientoLicencia, $claveProductoLicencia, $proveedorLicencia, $descripcionLicencia, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    if ($bandera == 1) {
        echo 1; // Ha ocurrido un error
    }
}


//Listar las licencias asociados a un equipo
if (isset($_POST['codigoEquipoParaLicencia'])) {
    $placa = $_POST['codigoEquipoParaLicencia'];
    $licencias = obtenerLicencias($placa);
    cuerpoTablaLicencias($licencias);
}

//Listar los repusetos asociados a un equipo
if (isset($_POST['codigoEquipoParaRepuesto'])) {
    $placa = $_POST['codigoEquipoParaRepuesto'];
    $repuestos = obtenerRepuestos($placa);
    cuerpoTablaRepuestos($repuestos);
}
//Listar los contratos asociados a un equipo
if (isset($_POST['codigoEquipoParaContratos'])) {
    $placa = $_POST['codigoEquipoParaContratos'];
    $contratos = obtenerDocumentosAsociados($placa);
    cuerpoTablaContratos($contratos);
}

//Asociar un repuesto a un equipo 
if (isset($_POST['codigoAsociarEquipo'])) {
    $placa = $_POST['codigoAsociarEquipo'];
    $codigoArticulo = $_POST['codigoArticulo'];
    $bodega = $_POST['bodega'];
    $correoUsuarioCausante = $_POST['correoUsuarioCausante'];
    $nombreUsuarioCausante = $_POST['nombreUsuarioCausante'];
    $bandera = asociarRepuesto($codigoArticulo, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    if ($bandera == "") {
        $inventario = obtenerInventario();
        cuerpoTablaPasivos($inventario);
    } else if ($bandera == 1) {
        echo 1; // Ha ocurrido un error
    } else if ($bandera == 2) {
        echo 2; // Ya hay un usuario asociado
    }
}

// eliminar licencias
if (isset($_POST['codigoLicenciaEliminar'])) {
    $claveDeProducto = $_POST["codigoLicenciaEliminar"];
    $placa = $_POST["placa"];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = eliminarLicencia($claveDeProducto, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    echo $mensaje;
}

// eliminar repuesto
if (isset($_POST['descripcionRepuestoEliminar'])) {
    $descripcion = $_POST['descripcionRepuestoEliminar'];
    $placa = $_POST["placa"];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = eliminarRepuesto($descripcion, $placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    echo $mensaje;
}
// cambiar estado
if (isset($_POST['codigoEstadoSiguiente'])) {
    $codigoEstadoSiguiente = $_POST['codigoEstadoSiguiente'];
    $placa = $_POST["placa"];
    $comentarioUsuario = $_POST["comentario"];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = actualizarEstadoEquipo($placa, $codigoEstadoSiguiente, $comentarioUsuario, $correoUsuarioCausante, $nombreUsuarioCausante);
    echo $mensaje;
}
// desasociar
if (isset($_POST['codigoDesasociar'])) {
    $placa = $_POST["codigoDesasociar"];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $mensaje = eliminarUsuarioActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante);
    if ($mensaje === "") {
        $activos = obtenerActivosFijos();
        $listaActivos = buscarDispositivoActivoFijo($activos, $placa);
        $codigoEstadoActual = $listaActivos->obtenerEstado()->obtenerCodigoEstado();
        $estadosSiguentes = obtenerEstadosEquipo($codigoEstadoActual);
        $responsables = null;
        if ($listaActivos->obtenerNombreUsuarioAsociado() == null) {
            $responsables = consumirMetodoDos();
        }
        panelActivos($listaActivos, $estadosSiguentes, $responsables);
    } else {
        echo "Error";
    }
}

// cambiar estado
if (isset($_POST['usuarioAsociado'])) {
    $correoUsuarioAsociado = $_POST['usuarioAsociado'];
    $placa = $_POST["placa"];
    $correoUsuarioCausante = $r->obtenerCorreo();
    $nombreUsuarioCausante = $r->obtenerNombreResponsable();
    $usuario = consumirMetodoUno($correoUsuarioAsociado);
    $nombreUsuarioAsociado = $usuario->obtenerNombreUsuario();
    $departamentoUsuarioAsociado = $usuario->obtenerDepartamento();
    $jefaturaUsuarioAsociado = $usuario->obtenerJefatura();
    $mensaje = asociarUsuarioActivo($placa, $correoUsuarioCausante, $nombreUsuarioCausante, $correoUsuarioAsociado, $nombreUsuarioAsociado, $departamentoUsuarioAsociado, $jefaturaUsuarioAsociado);
    if ($mensaje === "") {
        $activos = obtenerActivosFijos();
        $listaActivos = buscarDispositivoActivoFijo($activos, $placa);
        $codigoEstadoActual = $listaActivos->obtenerEstado()->obtenerCodigoEstado();
        $estadosSiguentes = obtenerEstadosEquipo($codigoEstadoActual);
        $responsables = null;
        if ($listaActivos->obtenerNombreUsuarioAsociado() == null) {
            $responsables = obtenerUsuariosParaAsociar();
        }
        panelActivos($listaActivos, $estadosSiguentes, $responsables);
    } else {
        echo "Error";
    }
}
if (isset($_POST['filtrarActivo'])) {
    $placa = $_POST['filtrarActivo'];
    $nombreCategoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $nombreUsuario = $_POST['usuario'];
    $correoUsuario = $_POST['correo'];
    $codigoEstado = $_POST['estado'];
    $activos = busquedaAvanzadaActivos($placa, $codigoEstado, $nombreCategoria, $marca, $nombreUsuario, $correoUsuario);
    if ($activos === 'Ha ocurrido un error al obtener los activos') {
        echo'Error';
    } else {
        cuerpoTablaActivos($activos);
    }
}
if (isset($_POST['filtrarInventario'])) {

    $codigoArticulo = $_POST['filtrarInventario'];
    $descripcion = $_POST['descripcion'];
    $nombreCategoria = $_POST['categoria'];
    $nombreBodega = $_POST['bodega'];
    $esRepuesto = $_POST['repuesto'];
    if ($esRepuesto == 'true') {
        $esRepuesto = 1;
    } else {
        $esRepuesto = 0;
    }
    $inventario = busquedaAvanzadaInventario($codigoArticulo, $descripcion, $nombreCategoria, $esRepuesto, $nombreBodega);
    if ($inventario === 'Ha ocurrido un error al obtener el inventario') {
        echo'Error';
    } else {
        cuerpoTablaPasivos($inventario);
    }
}

if (isset($_POST['codigoFiltro'])) {
    $mitabla = $_POST['mitabla'];
    $codigoTiquete = $_POST['codigoFiltro'];
    $correoSolicitante = $_POST['correoS'];
    $nombreSolicitante = $_POST['nombreS'];
    $correoResponsable = $_POST['correoR'];
    $nombreResponsable = $_POST['nombreR'];
    $fechaInicio = $_POST['fechaI'];
    $dia = substr($fechaInicio, 0, 2);
    $mes = substr($fechaInicio, 3, 2);
    $anio = substr($fechaInicio, 6, 4);
    $fechaInicio = $anio . '-' . $mes . '-' . $dia;
    $fechaFinal = $_POST['fechaF'];
    $dia = substr($fechaFinal, 0, 2);
    $mes = substr($fechaFinal, 3, 2);
    $anio = substr($fechaFinal, 6, 4);
    $fechaFinal = $anio . '-' . $mes . '-' . $dia;
    $codigosEstados = $_POST['estados'];
    $codigoArea = $r->obtenerArea()->obtenerCodigoArea();
    $codigoRol = $r->obtenerRol()->obtenerCodigoRol();
    $todosLosTiquetes = busquedaAvanzadaGeneral($codigoTiquete, $correoSolicitante, $nombreSolicitante, $correoResponsable, $nombreResponsable, $fechaInicio, $fechaFinal, $codigosEstados, $codigoArea, $codigoRol);
    cuerpoTablaMistiquetesInventario($todosLosTiquetes, 4);
}
