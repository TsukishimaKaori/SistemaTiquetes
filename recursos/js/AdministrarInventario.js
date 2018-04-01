$(function () {
    var fecha = new Date();
    $('#datetimepicker1').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es',
    });

});

$(document).ready(function () {
    var tab = document.getElementById("tabInventario").value;
    var evt;
    if (tab == 1) {
        evt = document.getElementById("link-activos");
        abrir_tab_inventario(evt, 'tab-activos');
    } else if (tab == 2) {
        evt = document.getElementById("link-inventario");
        abrir_tab_inventario(evt, 'tab-inventario');


    }
});

function abrir_tab_inventario(evt, id) {
    $('#cuerpo-Tabla-Inventario').children('tr').css("background-color", "#ffffff");
    $('#cuerpo-Tabla-Activos').children('tr').css("background-color", "#ffffff");
    $('#panelInformacionInventario').empty();
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(id).style.display = "block";
    evt.className += " active";

}

function cargarPanelActivos(codigo, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");

    // $(this).parent().css( "background-color", "red" );
    $.ajax({
        data: {'codigoActivo': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

function cargarPanelPasivos(codigo, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoPasivo': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

function cargarPanelSumarInventario(codigo, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoSumarInventario': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

//Carga el formulario para agregar al formurio
function cargarPanelAgregarInventario() {
    $('#cuerpo-Tabla-Inventario').children('tr').css("background-color", "#ffffff");
    $('#cuerpo-Tabla-Activos').children('tr').css("background-color", "#ffffff");
    var codigo = 1;// cambiar codigo
    $.ajax({
        data: {'codigoAgregarInventario': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

//Seccion de activos> repuestos
function cargarPanelRepuestos(codigo, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoAgregarRepuesto': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}
//seccion de activos> licencias
function cargarPanelLicencias(codigo, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoAgregarLicencia': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });

}

function agregarLicenciaEquipo(codigo) {
    var descripcionLicencia = $("#descripcion-licencia").val();
    var claveProductoLicencia = $("#clave-producto-licencia").val();
    var proveedorLicencia = $("#proveedor-licencia").val();
    var vencimientoLicencia = $("#vencimiento-licencia").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var mensaje = "";
    if (validacionFormularioAsociarLicencia() == 0) {
        $.ajax({
            data: {'codigoEquipo': codigo,
                'descripcionLicencia': descripcionLicencia,
                'claveProductoLicencia': claveProductoLicencia,
                'proveedorLicencia': proveedorLicencia,
                'vencimientoLicencia': vencimientoLicencia,
                'correoUsuarioCausante': correoUsuario,
                'nombreUsuarioCausante': nombreUsuario
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#cuerpo-Tabla-Inventario").html(response);
                limpiarFormularioLicencia();
                mensaje = "Licencia asociada correctamente";
                notificacion(mensaje);
            }
        });
    } else {
         mensaje = "Error al asociar la licencia, verifique los campos.";
                notificacion(mensaje);
    }
}

function obtenerLicencias(codigo) {

    $.ajax({
        data: {'codigoEquipoParaLicencia': codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#cuerpoTablaLicencias").html(response);
            //limpiarFormularioLicencia();
            $("#tituloModalLicencias").empty();
            $("#tituloModalLicencias").append('Licencias asociadas al equipo: ' + codigo);
            $('#modalLicencias').modal('show');
        }
    });

}

function obtenerRepuestos(codigo) {
    $.ajax({
        data: {'codigoEquipoParaRepuesto': codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#cuerpoTablaRepuestos").html(response);
            $("#tituloModalRepuestos").empty();
            $("#tituloModalRepuestos").append('Repuestos asociadas al equipo: ' + codigo);
            $('#modalRepuestos').modal('show');
        }
    });

}
//Asociar un equipo a un repuesto
function asociarRepuestos(codigo) {
    var codigoArticulo = $("#repuestosSelect option:selected").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var mensaje = "";
    //var nombreBodega  =  'bodega' + codigoArticulo;
    // var bodega = $("'#"+nombreBodega+"'").val();
    $.ajax({
        data: {'codigoAsociarEquipo': codigo,
            'codigoArticulo': codigoArticulo,
            'correoUsuarioCausante': correoUsuario,
            'nombreUsuarioCausante': nombreUsuario,

        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#cuerpo-Tabla-Inventario").html(response);
            mensaje = "Repuesto asociada correctamente";
            notificacion(mensaje);
        }
    });
}

//Agrega un elemento al inventario
function agregarInventario() {
    var codigoArticulo = $("#codigo").val();
    var descripcion = $("#descripcion").val();
    var categoria = $("#categoria option:selected").val();
    var estado = $("#estado").val();
    var costo = $("#costo").val();
    var cantidad = $("#cantidad").val();
    var bodega = $("#bodega option:selected").val();
    var comentario = $("#comentario").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var validacion = validacionFormularioAgregar();
    var mensaje = "";
    if (validacion === 0) {
        $.ajax({
            data: {'codigoArticuloAgregarInventario': codigoArticulo,
                'descripcion': descripcion,
                'categoria': categoria,
                'estado': estado,
                'cantidad': cantidad,
                'costo': costo,
                'bodega': bodega,
                'comentario': comentario,
                'correoUsuario': correoUsuario,
                'nombreUsuario': nombreUsuario
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#cuerpo-Tabla-Inventario").html(response);
                limpiarFormularioInventario();
                mensaje = "Articulo agregado correctamente";
                notificacion(mensaje);
            }
        });
    } else {
         mensaje = "Error al agregar el articulo, verifique los campos";
                notificacion(mensaje);
    }
}

//Agrega un elemento al inventario
function agregarInventarioSuma() {
    var codigoArticuloSuma = $("#codigoSuma").text();
    var cantidad = $("#cantidad-suma").val();
    var comentario = $("#comentario-suma").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var mensaje = "";
    if (validacionFormularioSumar() == 0) {
        $.ajax({
            data: {'codigoArticuloSuma': codigoArticuloSuma,
                'cantidadSuma': cantidad,
                'comentarioSuma': comentario,
                'correoUsuario': correoUsuario,
                'nombreUsuario': nombreUsuario
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#cuerpo-Tabla-Inventario").html(response);
                limpiarFormularioInventarioSuma();
                mensaje = "Articulos agregados correctamente";
                notificacion(mensaje);
            }
        });
    }else {
         mensaje = "Error al agregar el articulo, verifique los campos";
                notificacion(mensaje);
    }
}

function limpiarFormularioInventario() {
    $("#codigo").val("");
    $("#descripcion").val("");
    $("#categoria option:selected").val();
    $("#estado").val("");
    $("#costo").val("");
    $("#cantidad").val("");
    $("#comentario").val("");
}

function limpiarFormularioLicencia() {
    $("#descripcion-licencia").val("");
    $("#clave-producto-licencia").val("");
    $("#proveedor-licencia").val("");
    $("#vencimiento-licencia").val("");
    $("#correoUsuario").val("");
    $("#nombreUsuario").val("");
}

function limpiarFormularioInventarioSuma() {
    var cantidad = $("#cantidad-suma").val("");
    var bodega = $("#bodega-suma").val("");
    var comentario = $("#comentario-suma").val("");
}

function validacionExpRegular(expresion) {
    if (expresion == "") {
        return false;
    }
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    return (exp.test(expresion)) ? 'true' : 'false';
}

function validacionNumeros(valor) {
    if (isNaN(valor)) {
        return false;
    }
    return true;
}

function validacionFormularioAgregar() {
    var codigoArticulo = $("#codigo").val();
    var descripcion = $("#descripcion").val();
    var categoria = $("#categoria option:selected").val();
    var estado = $("#estado").val();
    var costo = $("#costo").val();
    var cantidad = $("#cantidad").val();
    var categoria = $("#bodega option:selected").val();
    var comentario = $("#comentario").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var bandera = 0;
    if (!validacionExpRegular(codigoArticulo)) {
        $("#codigo").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(codigoArticulo)) {
        $("#descripcion").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(descripcion)) {
        $("#codigo").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(categoria)) {
        $("#categoria").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(estado)) {
        $("#estado").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(bodega)) {
        $("#bodega").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(comentario)) {
        $("#comentario").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(correoUsuario)) {
        bandera = 1;
    }
    if (!validacionExpRegular(nombreUsuario)) {
        bandera = 1;
    }
    if (!validacionNumeros(cantidad)) {
        $("#cantidad").css("border-color", "red");
        bandera = 1;
    }
    if (cantidad <= 0) {
        $("#cantidad").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionNumeros(costo)) {
        $("#costo").css("border-color", "red");
        bandera = 1;
    }
    if (costo <= 0) {
        $("#costo").css("border-color", "red");
        bandera = 1;
    }
    return bandera;
}

function validacionFormularioSumar() {
    var bandera = 0;
    var cantidad = $("#cantidad-suma").val();
    var bodega = $("#bodega-suma").val();
    var comentario = $("#comentario-suma").val();
    if (!validacionExpRegular(bodega)) {
        $("#bodega-suma").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(comentario)) {
        $("#comentario-suma").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionNumeros(cantidad)) {
        $("#cantidad-suma").css("border-color", "red");
        bandera = 1;
    }
    if (cantidad <= 0) {
        $("#cantidad-suma").css("border-color", "red");
        bandera = 1;
    }
    return bandera;
}

function validacionFormularioAsociarLicencia() {
    var bandera = 0;
    var descripcionLicencia = $("#descripcion-licencia").val();
    var claveProductoLicencia = $("#clave-producto-licencia").val();
    var proveedorLicencia = $("#proveedor-licencia").val();
    var vencimientoLicencia = $("#vencimiento-licencia").val();
    if (!validacionExpRegular(descripcionLicencia)) {
        $("#descripcion-licencia").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(proveedorLicencia)) {
        $("#proveedor-licencia").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(claveProductoLicencia)) {
        $("#clave-producto-licencia").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(vencimientoLicencia)) {
        $("#vencimiento-licencia").css("border-color", "red");
        bandera = 1;
    }

    return bandera;
}

function foco(evt) {
    switch (evt) {
        case 1:
            $("#codigo").css("border-color", "#99beda");
            break;
        case 2:
            $('#descripcion').css("border-color", "#99beda");
            break;
        case 3:
            $("#estado").css("border-color", "#99beda");
            break;
        case 4:
            $("#cantidad").css("border-color", "#99beda");
            break;
        case 5:
            $("#costo").css("border-color", "#99beda");
            break;

        case 6:
            $("#bodega").css("border-color", "#99beda");
            break;
        case 7:
            $("#comentario").css("border-color", "#99beda");
            break;
        default:
            break;
    }
}

function focoSuma(evt) {
    switch (evt) {
        case 1:
            $("#cantidad-suma").css("border-color", "#99beda");
            break;
        case 2:
            $('#bodega-suma').css("border-color", "#99beda");
            break;
        case 3:
            $("#comentario-suma").css("border-color", "#99beda");
            break;
        default:
            break;
    }
}

function focoAsociarLicencia(evt) {
    var descripcionLicencia = $("#descripcion-licencia").val();
    var claveProductoLicencia = $("#clave-producto-licencia").val();
    var proveedorLicencia = $("#proveedor-licencia").val();
    var vencimientoLicencia = $("#vencimiento-licencia").val();
    switch (evt) {
        case 1:
            $("#descripcion-licencia").css("border-color", "#99beda");
            break;
        case 2:
            $("#clave-producto-licencia").css("border-color", "#99beda");
            break;
        case 3:
            $("#proveedor-licencia").css("border-color", "#99beda");
            break;
        case 4:
            $("#vencimiento-licencia").css("border-color", "#99beda");
            break;
        default:
            break;
    }
}


// <editor-fold defaultstate="collapsed" desc="NOTIFICACIONES">
function notificacion(mensaje) {
    $("#divNotificacion").empty();
    $("#divNotificacion").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
    $("#divNotificacion").append("</br><h4>" + mensaje + "</h4>");
    $("#divNotificacion").css("display", "block");
    setTimeout(function () {
        $(".content").fadeOut(1500);
    }, 3000);
}

// </editor-fold>