

$(document).ready(function () {
    var tab = document.getElementById("tabInventario").value;
    var evt;
    filtroActivo = $('#filtros').html();
    if (tab == 1) {
        evt = document.getElementById("link-activos");
        abrir_tab_inventario(evt, 'tab-activos');

    } else if (tab == 2) {
        evt = document.getElementById("link-inventario");
        abrir_tab_inventario(evt, 'tab-inventario');


    }



    tablaActivos();
    tablaPasivos();

});
function tablaActivos() {
    $('#tablaActivos').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar búsqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }

    });
}
function tablaPasivos() {
    $('#tablaPasivos').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar búsqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });
}
function abrir_tab_inventario(evt, id) {
    tabla = id;
    document.getElementById("filtros").className = "";
    $('#filtros').html("");
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
var tabla;
var filtroActivo;
function filtrar() {
    var response;
    if (tabla === 'tab-inventariofalse') {
        response = "";
        document.getElementById("filtros").className = "";
        tabla = 'tab-inventario';
    } else if (tabla === 'tab-inventario') {
        tabla = 'tab-inventariofalse';
        document.getElementById("filtros").className = "col-md-12";
        response = ' <div class="panel panel-primary">' +
                '    <div class="panel-body filtrosVisible">' +
                ' <div class="form-group  col-md-4">' +
                ' <label class="control-label col-md-3" for="codigoI">Codigo:</label>' +
                ' <div class="col-md-9">' +
                '  <input class="form-control" id="codigoI" type="text">' +
                '</div>' +
                ' </div>  ' +
                '<div class="form-group  col-md-4">' +
                '  <label class="control-label col-md-3" for="descripcionI">Descripcón:</label>' +
                '  <div class="col-md-9">' +
                ' <input class="form-control" id="descripcionI" type="text">' +
                ' </div>' +
                '</div> ' +
                '<div class="form-group  col-md-4">' +
                ' <label class="control-label col-md-3" for="categoriaI">Categoria:</label>' +
                ' <div class="col-md-9">' +
                ' <input class="form-control" id="categoriaI" type="text">' +
                ' </div>' +
                '  </div>' +
                ' <div class="form-group  col-md-4">' +
                ' <label class="control-label col-md-3" for="bodegaI">Bodega:</label>' +
                ' <div class="col-md-9">' +
                '     <input class="form-control" id="bodegaI" type="text">' +
                ' </div>' +
                ' </div> ' +
                '    <div class="form-check col-md-4"> ' +
                '        <label class="form-check-label " for="CheckI">Repuesto</label>' +
                '        <input type="checkbox" class="form-check-input" id="CheckI">   ' +
                ' </div>       ' +
                '<div class="col-md-10">' +
                '   <button onclick = "filtrarInventario()" type="button" class="btn btn-success  btn-circle col-md-3" data-toggle="modal" > buscar </button>' +
                '        </div>' +
                '        </div>' +
                '        </div>';

    } else if (tabla == "tab-activosfalse") {
        tabla = "tab-activos";
        document.getElementById("filtros").className = "";
        response = ""

    } else {
        tabla = "tab-activosfalse";
        document.getElementById("filtros").className = "col-md-12";
        response = filtroActivo;

    }
    $('#filtros').html(response);
}

function cargarPanelActivos(codigo, event) {
    codigo = "" + codigo;
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");

    // $(this).parent().css( "background-color", "red" );
    $.ajax({
        data: {'codigoActivo': codigo  },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
            var select = document.getElementById("Usuarios");
            if (select) {
                $('.selectpicker').selectpicker({
                    size: 5
                });
            }
        }
    });
}

function cargarPanelPasivos(codigo,bodega, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoPasivo': codigo,
        'bodega':bodega},
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
    if (event != -1) {
        $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
        $(event).parent().parent().css("background-color", "#dff0d8");
    }
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
            $(function () {
                var fecha = new Date();
                $("#vencimiento-licencia").datetimepicker({
                    minDate: fecha.setDate(fecha.getDate() - 1),
                    format: 'DD/MM/YYYY',
                    locale: 'es'
                });

            });
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
                if (response == 1) {
                    notificacion("Ha ocurrido un error al ingresar la licencia");
                } else {
                    // $("#cuerpo-Tabla-Inventario").html(response);
                    limpiarFormularioLicencia();
                    mensaje = "Licencia asociada correctamente";
                    notificacion(mensaje);
                }
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
function obtenerContratos(codigo) {
    $.ajax({
        data: {'codigoEquipoParaContratos': codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#cuerpoTablaContratos").html(response);
            $("#tituloModalContratos").empty();
            $("#tituloModalContratos").append('Contratos asociadas al equipo: ' + codigo);
            $('#modalContratos').modal('show');
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
            if (response == 1) {
                notificacion("Ha ocurrido un error al asociar el repuesto.");
            } else if (response == 2) {
                notificacion("El repuesto ya está asociado a este equipo.");
            } else {
                $("#cuerpo-Tabla-Inventario").html(response);
                mensaje = "Repuesto asociada correctamente";
                notificacion(mensaje);
            }
        }
    });
    cargarPanelRepuestos(codigo, -1);
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
                $('#tablaPasivos').DataTable().destroy();
                $("#cuerpo-Tabla-Inventario").html(response);
                tablaPasivos();
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
    } else {
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
    //  var bodega = $("#bodega-suma").val("");
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
    var bodega = $("#bodega option:selected").val();
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

var codigoRepuesto;
var codigoLicencia;
function eliminarRepuesto(Codigo) {
    codigoRepuesto = Codigo;
    $("#eliminarRepuesto").modal("show");

}

function eliminarRepuestoAjax() {
    var placa = document.getElementById("placa").innerText;
    if (codigoRepuesto != "") {
        $.ajax({
            data: {'descripcionRepuestoEliminar': codigoRepuesto,
                'placa': placa

            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#eliminarRepuesto").modal("hide");
                if (response === "") {
                    var repuesto = document.getElementById(codigoRepuesto);
                    if (repuesto) {
                        var padre = repuesto.parentNode;
                        padre.removeChild(repuesto);
                        codigoRepuesto = "";
                    }
                } else {
                    $("#ErrorRepuesto").modal("show");
                    codigoRepuesto = "";
                }
            }
        });
    }
}
/// elimianr licencias
function eliminarLicencia(Codigo) {
    codigoLicencia = Codigo;
    $("#eliminarLicencia").modal("show");
}
// eliminar repeustos
function eliminarLicenciaAjax() {
    var placa = document.getElementById("placa").innerText;
    if (codigoLicencia != "") {
        $.ajax({
            data: {'codigoLicenciaEliminar': codigoLicencia,
                'placa': placa

            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#eliminarLicencia").modal("hide");
                if (response === "") {
                    var licencia = document.getElementById(codigoLicencia);
                    if (licencia) {
                        var padre = licencia.parentNode;
                        padre.removeChild(licencia);
                        codigoLicencia = "";
                    }
                } else {
                    $("#ErrorLicencia").modal("show");
                    codigoLicencia = "";
                }
            }
        });
    }
}


// cambiar estado

var placa;
var EstadoAnterior;
var estadoSiguiente;
function estadoAnterior() {
    EstadoAnterior = document.getElementById("estadosSiguentes").value;
}
// cambiar estado
function cambiarEstado(miplaca) {
    placa = miplaca;
    var estado = document.getElementById("estadosSiguentes");
    var estadoNombre = estado[document.getElementById("estadosSiguentes").selectedIndex].innerText;
    estadoSiguiente = estado.value;
    estado.value = EstadoAnterior;
    document.getElementById("EstadoMensaje").innerText = "Desea cambiar el estado a: " + estadoNombre;
    $("#cambiarEstado").modal("show");
}
// cambiar estado
function cambiarEstadoAjax() {
    var justificacion = document.getElementById("justificacionEstado");
    var comentario = justificacion.value;
    if (comentario !== "") {
        justificacion.style = "";
        justificacion.value = "";
        var placa = document.getElementById("placa").innerText;

        $.ajax({
            data: {'codigoEstadoSiguiente': estadoSiguiente,
                'placa': placa,
                'comentario': comentario

            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            success: function (response) {
                $("#cambiarEstado").modal("hide");
                if (response === "") {
                    document.getElementById("estadosSiguentes").value = estadoSiguiente;
                    var mensaje = "Estado cambiado correctamente";
                    notificacion(mensaje);
                } else {
                    var mensaje = "Error al cambiar estado";
                    notificacion(mensaje);
                }

            }
        });

    } else {
        justificacion.style = "border-color: red;"
    }
}
// cambiar estado
function cancelarEstado() {
    $("#cambiarEstado").modal("hide");

    document.getElementById("estadosSiguentes").value = EstadoAnterior;
    document.getElementById("justificacionEstado").value = "";
    document.getElementById("justificacionEstado").style = "";
    estadoSiguiente = "";
    EstadoAnterior = "";
}
function eliminarUsuario() {
    $("#eliminarUsuario").modal("show");

}
function eliminarUsuarioAjax() {
    var placa = document.getElementById("placa").innerText;
    $.ajax({
        data: {'codigoDesasociar': placa

        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#eliminarUsuario").modal("hide");
            if (response === "Error") {
                var mensaje = "Error al desasociar activo";
                notificacion(mensaje);
            } else {
                $("#panelInformacionInventario").html(response);
                $('.selectpicker').selectpicker({
                    size: 5
                });
                var mensaje = "activo desasociado correctamente";
                notificacion(mensaje);
            }

        }
    });
}
// asignar activo
function asignarActivo() {
    $("#AsociarACtivo").modal("show");
}
function cancelarasignarActivo() {
    var opcion = document.getElementById("Usuarios");
    opcion.value = -1;
    var opcion = opcion[0].innerText;
    deseleccionarAsociado(opcion);
    $("#AsociarACtivo").modal("hide");

}
function deseleccionarAsociado(opcion) {
    var select = document.getElementById("Usuarios");
    select = select.previousSibling.previousSibling.firstChild;
    select.innerText = opcion;
    select = document.getElementById("Usuarios");
    select = select.previousSibling.firstChild.nextSibling;
    select = select.firstChild;
    select.className = "selected active";
    select = select.nextSibling;
    while (select) {
        select.className = "";
        select = select.nextSibling;
    }



}

function asignarActivoAjax() {
    var usuarioAsociado = document.getElementById("Usuarios");
    var usuarioAsociado = usuarioAsociado[document.getElementById("Usuarios").selectedIndex].value;
    var placa = document.getElementById("placa").innerText;
    $.ajax({
        data: {'usuarioAsociado': usuarioAsociado,
            'placa': placa

        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#AsociarACtivo").modal("hide");
            if (response === "Error") {
                var mensaje = "Error al desasociar tiquete";
                notificacion(mensaje);
            } else {
                $("#panelInformacionInventario").html(response);
                var mensaje = "Tiquete desasociado correctamente";
                notificacion(mensaje);
            }

        }
    });
}


function filtrarActivos() {
    var placa = document.getElementById("placaA").value;
    var categoria = document.getElementById("categoriaA".value);
    var marca = document.getElementById("marcaA").value;
    var usuario = document.getElementById("usuarioA").value;
    var correo = document.getElementById("correoA").value;
    var estado = document.getElementById("estadosA").value;
    $.ajax({
        data: {'filtrarActivo': placa,
            'categoria': categoria,
            'marca': marca,
            'usuario': usuario,
            'correo': correo,
            'estado': estado

        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            if (response === "Error") {
                var mensaje = "Error al filtrar";
                notificacion(mensaje);
            } else {
                $('#tablaActivos').DataTable().destroy();
                $("#cuerpo-Tabla-Activos").html(response);
                tablaActivos();
            }

        }
    });
}
function filtrarInventario() {
    var codigo = document.getElementById("codigoI").value;
    var descripcion = document.getElementById("descripcionI").value;
    var categoria = document.getElementById("categoriaI").value;
    var bodega = document.getElementById("bodegaI").value;
    var repuesto = document.getElementById("CheckI").checked;
    $.ajax({
        data: {'filtrarInventario': codigo,
            'descripcion': descripcion,
            'categoria': categoria,
            'bodega': bodega,
            'repuesto': repuesto
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            if (response === "Error") {
                var mensaje = "Error al filtrar";
                notificacion(mensaje);
            } else {
                $('#tablaPasivos').DataTable().destroy();
                $("#cuerpo-Tabla-Inventario").html(response);
                tablaPasivos();
            }

        }
    });
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