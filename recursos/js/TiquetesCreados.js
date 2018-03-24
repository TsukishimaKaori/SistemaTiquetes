$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

// <editor-fold defaultstate="collapsed" desc="MOSTRAR TIQUETES">
function mostrarMisTIquetes(event, codigoPagina) {
    var codigoTiquete = event.parentNode.firstChild.innerHTML;
    fechaInicioFiltros;
    fechaFinalizacionFiltros;
    var nuevo = estadosFiltros[0];
    var asignado = estadosFiltros[1];
    var reasignacion = estadosFiltros[2];
    var proceso = estadosFiltros[3];
    var anulado = estadosFiltros[4];
    var finalizado = estadosFiltros[5];
    var calificado = estadosFiltros[6];
    if (codigoPagina == 1 || codigoPagina == 2 || codigoPagina == 3) {
        location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina='
                + codigoPagina + '&fechaInicioFiltros=' + fechaInicioFiltros + '&fechaFinalizacionFiltros=' + fechaFinalizacionFiltros +
                '&nuevo=' + nuevo + '&asignado=' + asignado + '&reasignacion=' + reasignacion +
                '&proceso=' + proceso + '&anulado=' + anulado + '&finalizado=' + finalizado +
                '&calificado=' + calificado + '';
    } else if (codigoPagina == 4) {
        location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina='
                + codigoPagina + '&fechaInicioFiltros=' + fechaInicioFiltros + '&fechaFinalizacionFiltros=' + fechaFinalizacionFiltros +
                '&codigoFiltroG=' + codigoFiltroG + '&nombreSG=' + nombreSG + '&correoSG=' + correoSG +
                '&nombreRG=' + nombreRG + '&correoRG=' + correoRG +
                '&nuevo=' + nuevo + '&asignado=' + asignado + '&reasignacion=' + reasignacion +
                '&proceso=' + proceso + '&anulado=' + anulado + '&finalizado=' + finalizado +
                '&calificado=' + calificado + '';
    }
}
//function mostrarTiquetesPorAsignar(event) {
//    var codigoPagina = 2;
//    var codigoTiquete = event.parentNode.firstChild.nextSibling.innerHTML;
//    location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '';
//}
//function mostrarTiquetesAsignados(event) {
//    var codigoPagina = 3;
//    var codigoTiquete = event.parentNode.firstChild.nextSibling.innerHTML;
//    location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '';
//}
//
//function mostrarTodosLosTiquetes(event) {
//    var codigoPagina = 4;
//    var codigoTiquete = event.parentNode.firstChild.nextSibling.innerHTML;
//    location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '';
//}
function mostrarHistorialTiquetes(event, codigoPagina) {
    //  var codigoTiquete = event.parentNode.firstChild.nextSibling.innerHTML;
    var codigoTiquete = event.parentNode.firstChild.innerHTML;
    location.href = '../vista/HistorialTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '';
}



$('#modalagregarAdjunto').on('show.bs.modal', function (e) {
    alert("Modal Mostrada con Evento de Boostrap");
});
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="CARACTERISTICAS DATATABLES">
$(document).ready(function () {
    tablaTodoslosTiquetes();
    tablaMisTiquetesAsignados();
    tablaTiquetesPorAsignar();
    tablaMisTiquetes();
});

function tablaTodoslosTiquetes() {
    $('#tablaTodoslosTiquetes').DataTable({
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
function tablaMisTiquetesAsignados() {
    $('#tablaMisTiquetesAsignados').DataTable({
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
function tablaTiquetesPorAsignar() {
    $('#tablaTiquetesPorAsignar').DataTable({
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
function tablaMisTiquetes() {
    $('#tablaMisTiquetes').DataTable({
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
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ARCHIVOS ADJUNTOS">
function subirarchivo(event) {
    var archivo = event.value;
    document.getElementById("Textarchivo").value = archivo;
}
function cancelarAdjunto() {
    document.getElementById("Textarchivo").value = "";
    document.getElementById("comentario").value = "";
    document.getElementById("archivo").value = "";
}
function agregaerAdjuntoAJAX() {
    var codigo = document.getElementById("CódigoT").value;
    var comentario = document.getElementById("comentario").value;
    var file = document.getElementById("archivo");
    var archivo = file.files[0];
    if (archivo != null || comentario != '') {
        var data = new FormData();
        data.append('Mycodigo', codigo);
        data.append('comentario', comentario);
        data.append('archivo', archivo);
        $.ajax({

            type: 'POST',
            url: '../control/SolicitudAjaxTiquetesCreados.php',

            contentType: false,
            processData: false,
            data: data,

            success: function (response) {
                $(document).ready(function () {
                    $("#comentarios").html(response);
                    document.getElementById("Textarchivo").value = "";
                    document.getElementById("comentario").value = "";
                    document.getElementById("archivo").value = "";
                    var elmnt = document.getElementById("final");
                    elmnt.scrollIntoView();

                });
            }
        });
    }
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ASIGNACION DE RESPONSABLE">

function asignarTiqueteAjax(evento) {
    var codigoTiquete = evento.parentNode.parentNode.firstChild.innerHTML;
    var codigoResponsable = evento.value;
    var nombre = evento[evento.selectedIndex].innerText;
    if (codigoResponsable != "") {

        $.ajax({
            data: {'AsignarTiquetes': codigoTiquete, 'codioResponsable': codigoResponsable},
            type: 'POST',
            url: '../control/SolicitudAjaxTiquetesCreados.php',
            success: function (response) {

                actualizarTabla("PorAsignar");
                if (response != "error") {
                    var mensaje = "Tiquete " + codigoTiquete + " asignado a: " + nombre;
                } else {
                    var mensaje = "NO se puedo asignar el tiquete " + codigoTiquete;
                }
                notificacionBandeja(mensaje);
            }
        });
    }

}

//function asignarTiquete() {
//    var valorCheck = [];
//    var i = 0;
//    $("#tablaTiquetesPorAsignar tr").find('td:eq(0)').each(function () {
//        if (this.firstChild.checked) {
//            valorCheck[i] = this.nextSibling.innerHTML;
//            i++;
//        }
//    });
//
//    valorCheck.length > 0 ?
//            $("#modalAsignar").modal("show") :
//            $("#tiqueteNoSeleccionado").modal("show");
//}
//function asignarResponsableAjax(event) {
//    var valorCheck = [];
//    var asignado = $("#comboResponsables").val();
//    var i = 0;
//    valorCheck[i++] = asignado;
//
//    $("#tablaTiquetesPorAsignar tr").find('td:eq(0)').each(function () {
//        if (this.firstChild.checked) {
//            valorCheck[i] = this.nextSibling.innerHTML;
//            i++;
//        }
//    });
//
//    $.ajax({
//        data: {'AsignarTiquetes': JSON.stringify(valorCheck)},
//        type: 'POST',
//        url: '../control/SolicitudAjaxTiquetesCreados.php',
//
//        success: function (response) {
//            actualizarTabla('PorAsignar');
//        }
//    });
//
//}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ACTUALIZAR TABLAS">
function actualizarTabla(tabla) {
    $.ajax({
        data: {'botones': tabla},
        type: 'POST',
        url: '../control/SolicitudAjaxTiquetesCreados.php',

        success: function (response) {
            $("#botones").html(response);
            if (tabla != 'TodosLosTiquetes') {
                actualizarTablaAjax(tabla);
            } else {
                FiltrosAjax(false, tabla);
                filtros = true;
            }
        }
    });
}

function actualizarTablaAjax(tabla) {
    $.ajax({
        data: {'tabla': tabla},
        type: 'POST',
        url: '../control/SolicitudAjaxTiquetesCreados.php',

        success: function (response) {
            if (tabla == 'PorAsignar') {
                FiltrosAjax(false, tabla);
                filtros = true;
                $('#tablaTiquetesPorAsignar').DataTable().destroy();
                $("#tbody-roles-usuariosPorAsignar").html(response);
                tablaTiquetesPorAsignar();
            }
            if (tabla == 'Creados') {
                FiltrosAjax(false, tabla);
                filtros = true;
                $('#tablaMisTiquetes').DataTable().destroy();
                $("#tbody-roles-usuariosCreados").html(response);
                tablaMisTiquetes();
            }
            if (tabla == 'Asignados') {
                FiltrosAjax(false, tabla);
                filtros = true;
                $('#tablaMisTiquetesAsignados').DataTable().destroy();
                $("#tbody-roles-usuariosAsignados").html(response);
                tablaMisTiquetesAsignados();
            }
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }
    });

}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="en proceso">
//function IniciarTiquete() {
//    var valorCheck = [];
//    var i = 0;
//    $("#tablaMisTiquetesAsignados tr").find('td:eq(0)').each(function () {
//        if (this.firstChild.checked) {
//            valorCheck[i] = this.nextSibling.innerHTML;
//            i++;
//        }
//    });
//    document.getElementById("infoJusticiacion").innerHTML = "Desea poner en proceso el tiquete(s)?";
//    document.getElementById("aceptarJustificacion").onclick = function () {
//        IniciarTiqueteAjax()
//    };
//    document.getElementById("cancelarJustificacion").onclick = function () {
//        CancelarIniciarAsignados()
//    };
//    valorCheck.length > 0 ?
//            $("#ModalJustificacion").modal("show") :
//            $("#tiqueteNoSeleccionado").modal("show");
//}

function CancelarIniciarAsignados() {
    document.getElementById("justificacion").value = "";
}

function IniciarTiqueteAjax(event) {
    var valorCheck = [];
    var justificacion = $("#justificacion").val();
    if (justificacion != "") {
        $("#ModalJustificacion").modal("hide");
        document.getElementById("justificacion").value = "";
        var i = 0;
        valorCheck[i++] = justificacion;
        $("#tablaMisTiquetesAsignados tr").find('td:eq(0)').each(function () {
            if (this.firstChild.checked) {
                valorCheck[i] = this.nextSibling.innerHTML;
                i++;
            }
        });
        $.ajax({
            data: {'IniciarTiquetes': JSON.stringify(valorCheck)},
            type: 'POST',
            url: '../control/SolicitudAjaxTiquetesCreados.php',

            success: function (response) {
                actualizarTabla("Asignados");
            }
        });
    }

}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="calificacion">
var calificacion;
function calificar(event) {
    calificacion = event;
    calificacion.checked = false;
    var micalificacion = calificacion.value;
    document.getElementById("infoJusticiacion").innerHTML = "\"Estrellas:" + micalificacion + "\" Agregar comentario a la calificaion";
    document.getElementById("aceptarJustificacion").onclick = function () {
        calificarAjax();

    };
    document.getElementById("cancelarJustificacion").onclick = function () {
        cancelarcalificar();
    };
    $("#ModalJustificacion").modal("show");

}
function  cancelarcalificar() {
    calificacion = null;
}

function calificarAjax() {
    //var codigo = calificacion.parentElement.parentElement.firstChild.nextSibling.innerText;
    var codigo = calificacion.parentElement.parentElement.firstChild.innerText;
    var micalificacion = calificacion.value;
    var justificacion = document.getElementById("justificacion").value;
    calificacion = null;
    if (justificacion != "") {

        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoCalificar': codigo, 'justificacion': justificacion, 'calificacion': micalificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxTiquetesCreados.php',

            success: function (response) {
                $(".rating > input").prop('cursor', 'cursor:not-allowed;');
                actualizarTabla("Creados");
            }
        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="filtros">

var filtros = true;
function Filtros(tabla) {
    FiltrosAjax(filtros, tabla);
    if (filtros) {
        filtros = false;
    } else {
        filtros = true;
    }
}

function FiltrosAjax(filtros, tabla) {
    $.ajax({
        data: {'filtros': filtros, 'mitabla': tabla
        },
        type: 'POST',
        url: '../control/SolicitudAjaxTiquetesCreados.php',

        success: function (response) {
            $("#Filtros").html(response);
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
        }

    });
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="FILTRAR LA BUSQUEDA">
fechaInicioFiltros = '';
fechaFinalizacionFiltros = "";
estadosFiltros = [];
for (var i = 0; i < 7; i++) {
    estadosFiltros[i] = '';
}
codigoFiltroG = "";
nombreSG = "";
correoSG = "";
nombreRG = "";
correoRG = "";
function limpiarFiltros() {
    fechaInicioFiltros = '';
    fechaFinalizacionFiltros = "";
    for (var i = 0; i < 7; i++) {
        estadosFiltros[i] = '';
    }
    codigoFiltroG = "";
    nombreSG = "";
    correoSG = "";
    nombreRG = "";
    correoRG = "";
}

function filtrarBusqueda(mitabla) {
    limpiarFiltros();
    $("#nadaPorMostrar").hide();
    var codigoFiltro = "";
    var nombreS;
    var correoS;
    var nombreR;
    var correoR;
    if (mitabla == "TodosLosTiquetes") {
        codigoFiltro = document.getElementById("codigoFiltro").value;
        nombreS = document.getElementById("NombreSFiltro").value;
        correoS = document.getElementById("CorreoSFiltro").value;
        nombreR = document.getElementById("NombreRFiltro").value;
        correoR = document.getElementById("CorreoRFiltro").value;
        codigoFiltroG = codigoFiltro;
        nombreSG = nombreS;
        correoSG = correoS;
        nombreRG = nombreR;
        correoRG = correoR;
    }
    var fechaI = document.getElementById("fechafiltroI").value;
    fechaInicioFiltros = fechaI;
    var fechaF = document.getElementById("fechafiltroF").value;
    fechaFinalizacionFiltros = fechaF;
    var estado;
    var j = 0;
    var estados = [];
    for (var i = 1; i < 8; i++) {
        estado = document.getElementById("estado-" + i);

        if (estado.checked == true) {
            estadosFiltros[j] = estado.checked;
            estados[estados.length] = estado.value;
        }
        j = j + 1;
    }

    if (estados.length == 0) {
        estados = null;
    }
    $.ajax({
        data: {'codigoFiltro': codigoFiltro, 'nombreS': nombreS, 'correoS': correoS,
            'nombreR': nombreR, 'correoR': correoR, 'fechaI': fechaI, 'fechaF': fechaF, 'estados': estados, 'mitabla': mitabla
        },
        type: 'POST',
        url: '../control/SolicitudAjaxTiquetesCreados.php',

        success: function (response) {
            if (mitabla == "Creados") {
                $('#tablaMisTiquetes').DataTable().destroy();
                $("#tbody-roles-usuariosCreados").html(response);
                tablaMisTiquetes();
            }

            if (mitabla == "Asignados") {
                $('#tablaMisTiquetesAsignados').DataTable().destroy();
                $("#tbody-roles-usuariosAsignados").html(response);
                tablaMisTiquetesAsignados();
            }

            if (mitabla == "TodosLosTiquetes") {
                $('#tablaTodoslosTiquetes').DataTable().destroy();
                $("#tbody-roles-usuariosTodosLosTiquetes").html(response);
                tablaTodoslosTiquetes();
            }
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="notifiaciones">
function notificacionBandeja(mensaje) {
    $("#divNotificacion").empty();
    $("#divNotificacion").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
    $("#divNotificacion").append("</br><h4>" + mensaje + "</h4>");
    $("#divNotificacion").css("display", "block");
    setTimeout(function () {
        $(".content").fadeOut(1500);
    }, 3000);
}
// </editor-fold>

function navActivoBandeja() {
    var nav = $("#tabBandejaTiquetes").val();
    if (nav == 1) {
        $('#liMisTiquetes').addClass('active').siblings().removeClass('active');
        $('#misTiquetes').addClass('active').siblings().removeClass('active');
    } else if (nav == 2) {
        // $('.nav-pills a[href="../vista/BandejasTiquetes.php#tiquetesPorAsignar"]').tab('show');
        $('#liAsignar').addClass('active').siblings().removeClass('active');
        $('#tiquetesPorAsignar').addClass('active').siblings().removeClass('active');
        // $('#miTabBandeja a[href="../vista/BandejasTiquetes.php#tiquetesPorAsignar"]').tab('show')
    } else if (nav == 3) {
        $('#liAsignados').addClass('active').siblings().removeClass('active');
        $('#misTiquetesAsignados').addClass('active').siblings().removeClass('active');
    } else if (nav == 4) {
        $('#liTodos').addClass('active').siblings().removeClass('active');
        $('#todosLosTiquetes').addClass('active').siblings().removeClass('active');
    }
    return nav;
} 