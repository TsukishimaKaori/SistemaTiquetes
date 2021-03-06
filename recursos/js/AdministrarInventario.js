

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
    tablaTiquetedInventario();
    $(function () {
        $('#fechafiltroI').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es'
        });
    });
    $(function () {
        $('#fechafiltroF').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es'
        });
    });
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
function tablaTiquetedInventario() {
    $('#tablaTiquetesI').DataTable({
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
    eventoAsociar = event;
    codigo = "" + codigo;
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    // $(this).parent().css( "background-color", "red" );
    $.ajax({
        data: {'codigoActivo': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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

function cargarPanelPasivos(codigo, bodega, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoPasivo': codigo,
            'bodega': bodega},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#panelInformacionInventario").html(response);
        }
    });
}

function cargarPanelSumarInventario(codigo, bodega, event) {
    $(event).parent().parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().parent().css("background-color", "#dff0d8");
    $.ajax({
        data: {'codigoSumarInventario': codigo,
            'bodega': bodega},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#archivo").val("");
            $("#Textarchivo").val("");
            $("#panelInformacionInventario").html(response);
        }
    });
}

//Carga el formulario para agregar al formurio
function cargarPanelAgregarInventario() {
    $('#cuerpo-Tabla-Inventario').children('tr').css("background-color", "#ffffff");
    $('#cuerpo-Tabla-Activos').children('tr').css("background-color", "#ffffff");
    var codigo = 1; // cambiar codigo
    $.ajax({
        data: {'codigoAgregarInventario': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#panelInformacionInventario").html(response);
            $('.selectpicker').selectpicker({
                size: 5
            });
            $("#archivo").val("");
            $("#Textarchivo").val("");
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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
    if (archivoCorrecto()) {
        var codigoArticulo = $("#codigo").val();
        var descripcion = $("#descripcion").val();
        var categoria = $("#categoria option:selected").val();
        var estado = $("#estado").val();
        var costo = $("#costo").val();
        var cantidad = $("#cantidad").val();
        var orden = $("#orden").val();
        var bodega = $("#bodega option:selected").val();
        var provedor = $("#provedor").val();
        var marca = $("#marca").val();
        var comentario = $("#comentario").val();
        var correoUsuario = $("#correoUsuario").val();
        var nombreUsuario = $("#nombreUsuario").val();
        var validacion = validacionFormularioAgregar();
        var tiquete = $("#tiquete").val();
        var file = document.getElementById("archivo");
        var archivo = file.files[0];
        var data = new FormData();
        data.append('codigoArticuloAgregarInventario', codigoArticulo);
        data.append('descripcion', descripcion);
        data.append('categoria', categoria);
        data.append('estado', estado);
        data.append('cantidad', cantidad);
        data.append('orden', orden);
        data.append('costo', costo);
        data.append('bodega', bodega);
        data.append('comentario', comentario);
        data.append('correoUsuario', correoUsuario);
        data.append('nombreUsuario', nombreUsuario);
        data.append('tiquete', tiquete);
        data.append('provedor', provedor);
        data.append('marca', marca);
        data.append('archivo', archivo);
        var mensaje = "";
        if (validacion === 0) {
            $.ajax({

                type: 'POST',
                url: '../control/SolicitudAjaxInventario.php',
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function () {
                    $("#cargandoImagen").css('display', 'block');
                },
                success: function (response) {
                    $("#cargandoImagen").css('display', 'none');
                    if (response != 'Error') {
                        $('#tablaPasivos').DataTable().destroy();
                        $("#cuerpo-Tabla-Inventario").html(response);
                        tablaPasivos();
                        limpiarFormularioInventario();
                        mensaje = "Articulo agregado correctamente";
                        notificacion(mensaje);
                    } else {
                        mensaje = "Error al agregar articulo";
                        notificacion(mensaje);
                    }
                }
            });
        } else {
            mensaje = "Error al agregar el articulo, verifique los campos";
            notificacion(mensaje);
        }
    } else {
        alert("no se puede enviar el archivo");
    }
}

function archivoCorrecto() {
    if (document.getElementById("archivo").files.length > 0) {
        var documento = document.getElementById("archivo").files[0];
        var tipo = documento.type;
        if (tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation" ||
                tipo == "text/plain" || tipo == "application/pdf" || tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||
                tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || tipo == "image/png" || tipo == "image/jpeg") {
            return true;
        } else {
            return false;
        }
    }
    return true;
}
//Agrega un elemento al inventario
function agregarInventarioSuma() {
    var codigoArticuloSuma = $("#codigoSuma").text();
    var cantidad = $("#cantidad-suma").val();
    var comentario = $("#comentario-suma").val();
    var correoUsuario = $("#correoUsuario").val();
    var nombreUsuario = $("#nombreUsuario").val();
    var orden = $("#ordenS").val();
    var tiquete = $("#tiquete").val();
    var file = document.getElementById("archivo");
    var archivo = file.files[0];
    var data = new FormData();
    data.append('codigoArticuloSuma', codigoArticuloSuma);
    data.append('cantidadSuma', cantidad);
    data.append('comentarioSuma', comentario);
    data.append('correoUsuario', correoUsuario);
    data.append('nombreUsuario', nombreUsuario);
    data.append('orden', orden);
    data.append('tiquete', tiquete);
    data.append('archivo', archivo);
    var mensaje = "";
    if (validacionFormularioSumar() == 0) {
        $.ajax({
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
                if (response != 'Error') {
                    $('#tablaPasivos').DataTable().destroy();
                    $("#cuerpo-Tabla-Inventario").html(response);
                    tablaPasivos();
                    limpiarFormularioInventarioSuma();
                    mensaje = "Articulo agregado correctamente";
                    notificacion(mensaje);
                } else {
                    mensaje = "Error al agregar articulo";
                    notificacion(mensaje);
                }
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
    $("#orde").val("");
    $("#tiquete").val("");
    $("#archivo").val("");
    $("#Textarchivo").val("");
    $("#marca").val("");
    $("#provedor").val("");
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
    $("#archivo").val("");
    $("#Textarchivo").val("");
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
    var orden = $("#orden").val();
    var provedor = $("#provedor").val();
    var marca = $("#marca").val();
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
    if (!validacionExpRegular(marca)) {
        $("#marca").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(provedor)) {
        $("#provedor").css("border-color", "red");
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
    if (costo <= 0) {
        $("#costo").css("border-color", "red");
        bandera = 1;
    }
    if (costo <= 0) {
        $("#costo").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionNumeros(costo)) {
        $("#costo").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(orden)) {
        $("#orden").css("border-color", "red");
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
    var orden = $("#ordenS").val();
    if (!validacionExpRegular(bodega)) {
        $("#bodega-suma").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(comentario)) {
        $("#comentario-suma").css("border-color", "red");
        bandera = 1;
    }
    if (!validacionExpRegular(orden)) {
        $("#ordenS").css("border-color", "red");
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
        case 8:
            $("#orden").css("border-color", "#99beda");
            break;
        case 9:
            $("#provedor").css("border-color", "#99beda");
            break;
        case 10:
            $("#marca").css("border-color", "#99beda");
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
        case 4:
            $("#ordenS").css("border-color", "#99beda");
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
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
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
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
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
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
                $("#cambiarEstado").modal("hide");
                if (response !== 'Error') {
                    $("#panelInformacionInventario").html(response);
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
    var usuari = eventoAsociar.parentNode.parentNode.firstChild.nextSibling.nextSibling;
    $.ajax({
        data: {'codigoDesasociar': placa

        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#eliminarUsuario").modal("hide");
            if (response === "Error") {
                var mensaje = "Error al desasociar activo";
                notificacion(mensaje);
            } else {
                $("#panelInformacionInventario").html(response);
                usuari.innerText = "";
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
var eventoAsociar;
function asignarActivo() {
    var usuarioAsociado = document.getElementById("Usuarios");
    var usuarioAsociado = usuarioAsociado[document.getElementById("Usuarios").selectedIndex].value;
    if (usuarioAsociado != -1) {
        $("#AsociarACtivo").modal("show");
    }
}
function cancelarasignarActivo() {
    document.getElementById("dockingAsociar").innerText = "";
    document.getElementById("asociadosAsociar").innerText = "";
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
    var categoria = document.getElementById("categoria").innerText;
    var modelo = document.getElementById("modelo").innerText;
    var marca = document.getElementById("marca").innerText;
    var usuario = eventoAsociar.parentNode.parentNode.firstChild.nextSibling.nextSibling;
    var docking = document.getElementById("dockingAsociar").value;
    var asociados = document.getElementById("asociadosAsociar").value;
    if (usuarioAsociado != -1) {
        $.ajax({
            data: {'usuarioAsociado': usuarioAsociado,
                'placa': placa, 'categoria': categoria,
                'modelo': modelo, 'marca': marca,
                'docking': docking, 'asociados': asociados

            },
            type: 'POST',
            url: '../control/SolicitudAjaxInventario.php',
            beforeSend: function () {
                $("#cargandoImagen").css('display', 'block');
            },
            success: function (response) {
                $("#cargandoImagen").css('display', 'none');
                $("#AsociarACtivo").modal("hide");
                document.getElementById("dockingAsociar").value = "";
                document.getElementById("asociadosAsociar").value = "";
                if (response === "Error") {
                    var mensaje = "Error al desasociar tiquete";
                    notificacion(mensaje);
                } else {
                    var mensaje = "Activo desasociado correctamente";
                    usuarioAsociado = document.getElementById("Usuarios");
                    usuarioAsociado = usuarioAsociado[document.getElementById("Usuarios").selectedIndex];
                    usuario.innerText = usuarioAsociado.innerText;
                    var pos  = response.indexOf("dirrecion");
                    if (pos === -1) {
                        mensaje += " pero con Error en el contrato";
                    } else {
                       var dirrecion  = response.substring(pos+9);
                        window.open(dirrecion);
                        response=response.substring(0,pos);
                    }
                    $("#panelInformacionInventario").html(response);

                    notificacion(mensaje);
                }

            }
        });
    }
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            if (response === "Error") {
                var mensaje = "Error al filtrar";
                notificacion(mensaje);
            } else {
                $('#tablaActivos').DataTable().destroy();
                $("#cuerpo-Tabla-Activos").html(response);
                $("#panelInformacionInventario").html("");
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            if (response === "Error") {
                var mensaje = "Error al filtrar";
                notificacion(mensaje);
            } else {
                $('#tablaPasivos').DataTable().destroy();
                $("#cuerpo-Tabla-Inventario").html(response);
                $("#panelInformacionInventario").html("");
                tablaPasivos();
            }

        }
    });
}

function subirarchivoInventario(event) {
    var archivo = event.value;
    document.getElementById("Textarchivo").value = archivo;
}
function cancelarAdjuntoInventario() {
    document.getElementById("Textarchivo").value = "";
    document.getElementById("archivo").value = "";
}


// seleccionar tiquete
function elegirTiquete(codigo) {
    document.getElementById("tiquete").value = codigo;
    $("#modalaTiquetes").modal("hide");
}
function tiquete() {
    $("#modalaTiquetes").modal("show");
}

function filtrartiquetesAjax() {
    var codigoFiltro = document.getElementById("codigoFiltro").value;
    var nombreS = document.getElementById("NombreSFiltro").value;
    var correoS = document.getElementById("CorreoSFiltro").value;
    var nombreR = document.getElementById("NombreRFiltro").value;
    var correoR = document.getElementById("CorreoRFiltro").value;
    var fechaI = document.getElementById("fechafiltroI").value;
    var fechaF = document.getElementById("fechafiltroF").value;
    var estado;
    var j = 0;
    var estados = [];
    for (var i = 1; i < 8; i++) {
        estado = document.getElementById("estado-" + i);
        if (estado.checked == true) {
            estados[estados.length] = estado.value;
        }

    }

    if (estados.length == 0) {
        estados = null;
    }
    $.ajax({
        data: {'codigoFiltro': codigoFiltro, 'nombreS': nombreS, 'correoS': correoS,
            'nombreR': nombreR, 'correoR': correoR, 'fechaI': fechaI, 'fechaF': fechaF, 'estados': estados
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $('#tablaTiquetesI').DataTable().destroy();
            $("#tbody-tablaTiquetesI").html(response);
            tablaTiquetedInventario();
        }
    });
}

// adjuntar contrato
function subirarchivo(event) {
    var archivo = event.value;
    document.getElementById("Textarchivo").value = archivo;
}

function enviarAdjunto() {
        if (document.getElementById("archivo").files.length > 0) {
            var documento = document.getElementById("archivo").files[0];
            var tipo = documento.type;
            if (tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation" ||
                    tipo == "text/plain" || tipo == "application/pdf" || tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||
                    tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || tipo=="image/png" ||tipo=="image/jpeg") {
                
                   AdjuntarAjax();
             
              
            } else {
                 alert("no se puede enviar el archivo");
            }
        } 

    
}

function AdjuntarAjax(){
   var placa = document.getElementById("placa").innerText;
    var file = document.getElementById("archivo");
    var archivo = file.files[0];
    var data = new FormData();
    data.append('AdjuntarArchivo', archivo);
   data.append('placa', placa);
    $.ajax({
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',

        contentType: false,
        processData: false,
        data: data,
 beforeSend: function () {
              $("#cargandoImagen").css('display','block');
        },
        success: function (response) {
            $('#modalagregarAdjunto').modal('hide');
            if(response!=="Error"){
            $("#cargandoImagen").css('display', 'none');
            $("#cuerpoTablaContratos").html(response);
            $("#tituloModalContratos").empty();
            $("#tituloModalContratos").append('Contratos asociadas al equipo: ' + codigo);
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