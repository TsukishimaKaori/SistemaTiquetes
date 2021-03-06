<?php

function cuerpoTablaCategorias($categorias) {
    foreach ($categorias as $tema) {
        echo '<tr><td>' . $tema->obtenerCodigoCategoria() . '</td>';
        echo '<td>' . $tema->obtenerNombreCategoria() . '</td>';
        if ($tema->obtenerEsRepuesto() == "1") {
            echo '<td><i class = "glyphicon glyphicon-ok"></i></td>';
        } else {
            echo '<td><i class = "glyphicon glyphicon-remove"></i></td>';
        }
        echo '<td>';
        echo' <button type="button" class="btn btn-danger btn-circle btn-xl" onclick = "eliminarCategoriaModal(this);" data-toggle="modal"  ><i class=" glyphicon glyphicon-minus"></i></button>';
        echo '</td>';
        echo '</tr>';
    }
}

function filtrarBusqueda($categorias, $filtro) {
    $filtrado = array();
    foreach ($categorias as $categoria) {

        if ($categoria->obtenerEsRepuesto() === $filtro) {
            $filtrado[] = $categoria;
        }
    }
    return $filtrado;
}

function filtrarEsRepuesto($categorias) {
    return filtrarBusqueda($categorias, 1);
}

function filtrarPorNoRepuesto($categorias) {
   return filtrarBusqueda($categorias, 0);
}
