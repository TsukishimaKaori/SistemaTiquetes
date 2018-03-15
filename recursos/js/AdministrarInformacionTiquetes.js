var paginaPrincipal
function cargarpaginaPrincipal() {
    if ($("#paginaPrincipal").val() != null) {
        paginaPrincipal = $("#paginaPrincipal").val();
    } else {
        paginaPrincipal = $("#codigoPagina").val();
    }
}

// <editor-fold defaultstate="collapsed" desc="CLASIFICACION TIQUETES">
function ClasificacionesAsignar() {
    $("#modalClasificaciones").modal("show");
}

var clasificacion;
function actualizarTematica(event) {
    clasificacion = event.innerHTML;
    var a = document.getElementById("Modalinfo");
    $("div#Modalinfo h4").text("¿Desea cambiar la clasificación  a " + clasificacion + "?");
    $("#Modalinfo").modal("show");
}

function confirmarActualizarTematica() {
    var codigoTiquete = $("#codigoTiquete").text();
    var pagina = document.getElementById("comboPagina").value;
    $.ajax({
        data: {'Clasificacion': clasificacion,
            codigoClasificacion: codigoTiquete
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',

        success: function (response) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            TiqueteExiste(codigoTiquete, pagina);
        }
    });
    $("#modalClasificaciones").modal("hide");
    $("#Modalinfo").modal("hide");
}

function TiqueteExiste(codigoTiquete, pagina) {
    $.ajax({
        data: {'tiqueteExiste': codigoTiquete,
            'codigoPagina': pagina
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',
        success: function (response) {
            if (response == "Si") {
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + pagina + " #cargarTiquetePagina");
            } else {

                cambiarComboPagina(document.getElementById("comboPagina"));
            }
        }
    });

}

function cancelarActualizarTematica() {
    $("#Modalinfo").modal("hide");
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="CAMBIAR FECHA SOLICITADA">

$(function () {
    var fecha = new Date();
    $('#cotizada').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es'
    });

});





var fechaVieja;
var fechanueva;
function fechaAntigua() {
    fechaVieja = document.getElementById("cotizada").value;
}
function CambiarFechaSolicitadaAjax() {
    var codigo = $("#codigoTiquete").text();
    $.ajax({
        data: {'fechaSolicitada': fechanueva,
            codigoFechaSolicitada: codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',
        success: function (response) {
            $(document).ready(function () {
                document.getElementById("cotizada").value = fechanueva;
            });
            $("#confirmarFechaSolicitada").modal("hide");
        }
    });

}
function validate_fechaMayorQue(fechanueva) {
    valuesEnd = fechanueva.split("/");
    // Verificamos que la fecha no sea posterior a la actual
    var dateStart = new Date();
    var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0], 23, 59, 59);
    if (dateStart > dateEnd || isNaN(dateEnd.getTime()))
    {
        return 1;
    }
    return 0;
}
function CambiarFechaSolicitada() {
    fechanueva = document.getElementById("cotizada").value;
    document.getElementById("cotizada").value = fechaVieja;
    if (fechanueva != fechaVieja) {
        if (fechanueva == "" || validate_fechaMayorQue(fechanueva)) {
            document.getElementById("cotizada").value = fechaVieja;
        } else {
            $("div#confirmarFechaSolicitada h4").text("¿Desea cambiar la fecha solicitada a " + fechanueva + "?");
            $("#confirmarFechaSolicitada").modal("show");
        }
    }
}

function confirmarFechaSolicitada() {
    CambiarFechaSolicitadaAjax();
    var elemento = document.getElementById("cotizada");
    elemento.blur();
    $("#Modal").modal("show");
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="COMENTARIOS Y ADJUNTOS">
function agregarAdjuntoAJAX() {
    var codigo = $("#codigoTiquete").text();
    var comentario = $("#comentario").val();
    var file = document.getElementById("archivo");
    var archivo = file.files[0];
    if (archivo != null || comentario != '') {
        var data = new FormData();
        data.append('Mycodigo', codigo);
        data.append('comentario', comentario);
        data.append('archivo', archivo);
        $.ajax({
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            contentType: false,
            processData: false,
            data: data,
            success: function (response) {
                $(document).ready(function () {
                    $("#comentarios").html(response);
                    document.getElementById("Textarchivo").value = "";
                    document.getElementById("comentario").value = "";
                    document.getElementById("archivo").value = "";
                });
            }
        });
    }
}
function subirarchivo(event) {
    var archivo = event.value;
    document.getElementById("Textarchivo").value = archivo;
}
function cancelarAdjunto() {
    document.getElementById("Textarchivo").value = "";
    document.getElementById("comentario").value = "";
    document.getElementById("archivo").value = "";
}
function VerComentariosAjax() {
    var codigo = $("#CódigoTiquete").text();
    $.ajax({
        data: {'adjuntos': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxTiquetesAsignados.php',

        success: function (response) {
            $(document).ready(function () {
                $("#comentarios").html(response);
                //$("#modalagregarAdjunto").modal("show");


            });
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="HORAS TRABAJADAS">
var horavieja;
var horanueva;
//function horaAntiguo() {
//    horavieja = $("#HorasT").val();    
//}
//
//function horaNueva(){
//     horanueva = $("#HorasT").val();   
//}
$(document).ready(function () {
    horavieja = $("#HorasT").val();
});
function pierdeFoco() {
    $("#HorasT").val(horavieja);
}

function CambiarHorastrabajadas() {
    horanueva = $("#HorasT").val();
    $("#HorasT").val(horavieja);
    if (horanueva != horavieja) {
        if (horanueva == "" || (!parseInt(horanueva) && horanueva != "0") || horanueva < 0) {
            $("#HorasT").val(horavieja);
        }
        ////else {
//            var a = $("#Modalinfo").val();
//            if (a.firstChild != null) {
//                a.removeChild(a.firstChild);
//            }       
        CambiarHorasAjax();
        //       }
    }
}

function CambiarHorasAjax() {
    var codigo = $("#codigoTiquete").text();
    $.ajax({
        data: {'horasTrabajadas': horanueva,
            codigoTiquete: codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',

        success: function (response) {
            $(document).ready(function () {
                $("#HorasT").val(horanueva);
                horavieja = horanueva;
                var mensaje = "Horas agregadas correctamente";
                notificacion(mensaje);
            });
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ADMINISTRADOR DE CONTROLES">
function cambiarComboPagina(event) {
    paginaSeleccionada = event.value;
    var codigoTiquete = '-1';  //Si el codigo es -1 se carga el primer tiquete que se encuentra OJO
    var codigoPagina = paginaSeleccionada; //codigo de la pagina actual
    if (codigoPagina == paginaPrincipal) {
        var fechaI = $("#filtroFechaI").val(); //codigo de la pagina actual
        var fechaF = $("#filtroFechaF").val();
        var nuevo = $("#filtroNuevo").val();
        var asignado = $("#filtroAsignado").val();
        var reasignado = $("#filtroReasignado").val();
        var proceso = $("#filtroProceso").val();
        var anulado = $("#filtroAnulado").val();
        var finalizado = $("#filtroFinalizado").val();
        var calificado = $("#filtroCalificado").val();
    }
    if (codigoPagina == 1 || codigoPagina == 2 || codigoPagina == 3) {
        $.ajax({
            data: {'comboPaginas': 1,
                'codigoTiquete': codigoTiquete,
                'codigoPagna': codigoPagina,
                '$fechaI': fechaI,
                'fechaF': fechaF,
                'nuevo': nuevo,
                'asignado': asignado,
                'reasignado': reasignado,
                'proceso': proceso,
                'anulado': anulado,
                'finalizado': finalizado,
                'calificado': calificado
            },
            type: 'POST',
            dataType: 'json',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                var tiquete = response['tiquete'];
                var pagina = response['pagina'];
                if (tiquete != '-1') {
                    $("h2").remove(".bandejaTiquetesVacia");
                    $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + tiquete + '&pagina=' + pagina + " #cargarTiquetePagina");

                } else {
                    // $("#cargarTiquetePagina").load("../vista/AdministrarInformacionTiquetes.php?#cargarTiquetePagina");
                    $("h2").remove(".bandejaTiquetesVacia");
                    $('#noHayTiquetes').append('<h2 class ="bandejaTiquetesVacia" style = "text-align:center">La bandeja de tiquetes se encuentra vacía</h2>');
                    //  $('#noHayTiquetes').show();
                    $(".ocultarTiquetes").hide();
                }
            }
        });
    }
}

function retornarABandeja() {
    var $codigoPagina = $("#comboPagina").val();
    if ($codigoPagina == 1 || $codigoPagina == 2 || $codigoPagina == 3) {
        location.href = "../vista/BandejasTiquetes.php?tab=" + $codigoPagina + "";
    } else {
        location.href = "../vista/BandejasTiquetes.php?tab=4";
    }
}

//Manejo de controles anterior
function tiqueteSiguiente() {
    var siguiente = 1; //tiquete siguietne
    var codigoTiquete = $("#codigoTiquete").text(); //codigo tiquete actual 
    var codigoPagina = $("#codigoPagina").val(); //codigo de la pagina actual
    if (codigoPagina == paginaPrincipal) {
        var fechaI = $("#filtroFechaI").val(); //codigo de la pagina actual
        var fechaF = $("#filtroFechaF").val();
        var nuevo = $("#filtroNuevo").val();
        var asignado = $("#filtroAsignado").val();
        var reasignado = $("#filtroReasignado").val();
        var proceso = $("#filtroProceso").val();
        var anulado = $("#filtroAnulado").val();
        var finalizado = $("#filtroFinalizado").val();
        var calificado = $("#filtroCalificado").val();
    }
    if (codigoPagina == 1 || codigoPagina == 2 || codigoPagina == 3) {
        $.ajax({
            data: {'siguiente': siguiente,
                'codigoTiquete': codigoTiquete,
                'codigoPagna': codigoPagina,
                'fechaI': fechaI,
                'fechaF': fechaF,
                'nuevo': nuevo,
                'asignado': asignado,
                'reasignado': reasignado,
                'proceso': proceso,
                'anulado': anulado,
                'finalizado': finalizado,
                'calificado': calificado
            },
            type: 'POST',
            dataType: 'json',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                var tiquete = response['tiquete'];
                var pagina = response['pagina'];

                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + tiquete + '&pagina='
                        + pagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                        '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                        '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                        '&calificado=' + $("#filtroCalificado").val() + " #cargarTiquetePagina");




            }
        });
    } else if (codigoPagina == 4) {
        if (codigoPagina == paginaPrincipal) {
            var codigoFiltroG = $("#codigoFiltroG").val();
            var nombreSG = $("#nombreSG").val();
            var correoSG = $("#correoSG").val();
            var nombreRG = $("#nombreRG").val();
            var correoRG = $("#correoRG").val();
        }


        $.ajax({
            data: {'siguiente': siguiente,
                'codigoTiquete': codigoTiquete,
                'codigoPagna': codigoPagina,
                'fechaI': fechaI,
                'fechaF': fechaF,
                'nuevo': nuevo,
                'asignado': asignado,
                'reasignado': reasignado,
                'proceso': proceso,
                'anulado': anulado,
                'finalizado': finalizado,
                'calificado': calificado,
                'codigoFiltroG': codigoFiltroG,
                'nombreSG': nombreSG,
                'correoSG': correoSG,
                'nombreRG': nombreRG,
                'correoRG': correoRG
            },
            type: 'POST',
            dataType: 'json',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                var tiquete = response['tiquete'];
                var pagina = response['pagina'];
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + tiquete + '&pagina='
                        + pagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                        '&codigoFiltroG=' + $("#codigoFiltroG").val() + '&nombreSG=' + $("#nombreSG").val() + '&correoSG=' + $("#correoSG").val() +
                        '&nombreRG=' + $("#nombreRG").val() + '&correoRG=' + $("#correoRG").val() +
                        '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                        '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                        '&calificado=' + $("#filtroCalificado").val() + " #cargarTiquetePagina");
            }
        });
    }
}

//Manejo de controles siguiente
function tiqueteAnterior() {
    var anterior = 0; // tiquete anterior
    var codigoTiquete = $("#codigoTiquete").text(); //codigo tiquete actual 
    var codigoPagina = $("#codigoPagina").val(); //codigo de la pagina actual
    if (codigoPagina == paginaPrincipal) {
        var fechaI = $("#filtroFechaI").val(); //codigo de la pagina actual
        var fechaF = $("#filtroFechaF").val();
        var nuevo = $("#filtroNuevo").val();
        var asignado = $("#filtroAsignado").val();
        var reasignado = $("#filtroReasignado").val();
        var proceso = $("#filtroProceso").val();
        var anulado = $("#filtroAnulado").val();
        var finalizado = $("#filtroFinalizado").val();
        var calificado = $("#filtroCalificado").val();
    }
    if (codigoPagina == 1 || codigoPagina == 2 || codigoPagina == 3) {
        $.ajax({
            data: {'anterior': anterior,
                'codigoTiquete': codigoTiquete,
                'codigoPagna': codigoPagina,
                'fechaI': fechaI,
                'fechaF': fechaF,
                'nuevo': nuevo,
                'asignado': asignado,
                'reasignado': reasignado,
                'proceso': proceso,
                'anulado': anulado,
                'finalizado': finalizado,
                'calificado': calificado
            },
            type: 'POST',
            dataType: 'json',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                var tiquete = response['tiquete'];
                var pagina = response['pagina'];
                var codigoTiquete = $("#codigoTiquete").text();
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + tiquete + '&pagina='
                        + pagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                        '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                        '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                        '&calificado=' + $("#filtroCalificado").val() + " #cargarTiquetePagina");
            }
        });
    } else if (codigoPagina == 4) {
        if (codigoPagina == paginaPrincipal) {
            var codigoFiltroG = $("#codigoFiltroG").val();
            var nombreSG = $("#nombreSG").val();
            var correoSG = $("#correoSG").val();
            var nombreRG = $("#nombreRG").val();
            var correoRG = $("#correoRG").val();
        }
        $.ajax({
            data: {'anterior': anterior,
                'codigoTiquete': codigoTiquete,
                'codigoPagna': codigoPagina,
                'fechaI': fechaI,
                'fechaF': fechaF,
                'nuevo': nuevo,
                'asignado': asignado,
                'reasignado': reasignado,
                'proceso': proceso,
                'anulado': anulado,
                'finalizado': finalizado,
                'calificado': calificado,
                'codigoFiltroG': codigoFiltroG,
                'nombreSG': nombreSG,
                'correoSG': correoSG,
                'nombreRG': nombreRG,
                'correoRG': correoRG
            },
            type: 'POST',
            dataType: 'json',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                var tiquete = response['tiquete'];
                var pagina = response['pagina'];
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + tiquete + '&pagina='
                        + pagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                        '&codigoFiltroG=' + $("#codigoFiltroG").val() + '&nombreSG=' + $("#nombreSG").val() + '&correoSG=' + $("#correoSG").val() +
                        '&nombreRG=' + $("#nombreRG").val() + '&correoRG=' + $("#correoRG").val() +
                        '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                        '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                        '&calificado=' + $("#filtroCalificado").val() + " #cargarTiquetePagina");
            }
        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ESTADO ASIGNAR">
var paginadePagina;
function asignarUnTiquete(numero) {
    paginadePagina = numero;

    if (paginadePagina == 2) {
        $("#modalAsignar").modal("show");
    } else if (paginadePagina == 4) {
        $("#modalAsignartodos").modal("show");
    }

}

function asignarResponsableAjax() {

    var codigo = document.getElementById("codigoTiquete").innerHTML;
    if (paginadePagina == 2) {
        var asignado = $("#comboResponsables").val();
        var nombreEmpleadoAsignado = $('#comboResponsables option:selected').html();
    } else if (paginadePagina == 4) {
        var asignado = $("#comboTodosResponsables").val();
        var nombreEmpleadoAsignado = $('#comboTodosResponsables option:selected').html();
    }
    $.ajax({
        data: {'codigoAsignado': codigo,
            'Asignado': asignado,
            'nombreEmpleadoAsignado': nombreEmpleadoAsignado
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',

        success: function (response) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            var mensaje = "Tiquete asignado correctamente";
            notificacion(mensaje);
            var pagina = document.getElementById("comboPagina");
            if (paginadePagina == 2) {
                cambiarComboPagina(pagina);
            } else if (paginadePagina == 4) {
                pagina = pagina.value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
            }


        }
    });
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ESTADO REASIGNAR">

function reasignar() {
    document.getElementById("infoJusticiacion").innerHTML = "Porque desea enviar a reasignar?";
    document.getElementById("aceptarJustificacion").onclick = function () {
        reasignarAjax()
    };
    document.getElementById("cancelarJustificacion").onclick = function () {
        cancelarReasignar()
    };
    $("#ModalJustificacion").modal("show");
}
function cancelarReasignar() {
    document.getElementById("justificacion").value = "";
}

function reasignarAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var justificacion = document.getElementById("justificacion").value;
    if (justificacion != "") {
        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoReasignar': codigo, 'justificacion': justificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina");
                cambiarComboPagina(pagina);
                document.getElementById("justificacion").value = "";

                if (response == "") {
                    var mensaje = "Tiquete reasignado correctamente";
                    notificacion(mensaje);
                }


            }
        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ESTADO EN PROCESO">

$(function () {
    var fecha = new Date();
    $('#fechaEntrega').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es'
    });

});
$(function () {
    var fecha = new Date();
    $('#fechaEntregaC').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es'
    });

});

function enProceso() {

    $("#ModalProceso").modal("show");
}


function enProcesoAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var fechaEntrega = document.getElementById("fechaEntrega").value;
    if (fechaEntrega != "") {
        $("#ModalProceso").modal("hide");
        $.ajax({
            data: {'codigoEnProceso': codigo, 'fechaEntrega': fechaEntrega
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina").value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
                if (response == "") {
                    var mensaje = "El estado del tiquete cambio a proceso correctamente";
                    notificacion(mensaje);
                }
            }


        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="CAMBIAR FECHA Entrega"> 
var fechaViejaEntrega;
var fechanuevaEntrega;
function fechaAntiguaEntrega() {
    fechaViejaEntrega = document.getElementById("fechaEntregaC").value;
}
function CambiarFechaEntregaAjax() {
    var justificacion = document.getElementById("justificacionEntrega").value;
    if (justificacion != "") {
        var codigo = $("#codigoTiquete").text();
        document.getElementById("justificacionEntrega").value = "";
        $.ajax({
            data: {'fechaEntrega': fechanuevaEntrega,
                'codigoFechaEntrega': codigo,
                'justificacion': justificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',
            success: function (response) {
                $(document).ready(function () {
                    document.getElementById("fechaEntregaC").value = fechanuevaEntrega;
                });
                $("#confirmarFechaEntrega").modal("hide");
                if(response ==""){
                var mensaje = "La fecha de entrega se ha cambiado exitosamente";
                notificacion(mensaje);
            }
            }
        });
    }

}

function CambiarFechaEntrega() {
    fechanuevaEntrega = document.getElementById("fechaEntregaC").value;
    document.getElementById("fechaEntregaC").value = fechaViejaEntrega;
    if (fechanuevaEntrega != fechaViejaEntrega) {
        if (fechanuevaEntrega == "" || validate_fechaMayorQue(fechanuevaEntrega)) {
            document.getElementById("fechaEntregaC").value = fechaViejaEntrega;
        } else {
            $("div#confirmarFechaEntrega h4").text("¿Desea cambiar la fecha Entrega a " + fechanuevaEntrega + "?");
            $("#confirmarFechaEntrega").modal("show");
        }
    }
}

function confirmarFechaSolicitada() {
    CambiarFechaSolicitadaAjax();
    var elemento = document.getElementById("cotizada");
    elemento.blur();
    $("#Modal").modal("show");
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ESTADO ANULADO">

function Anular() {
    document.getElementById("infoJusticiacion").innerHTML = "Porque desea anular el tiquete?";
    document.getElementById("aceptarJustificacion").onclick = function () {
        AnularAjax();
    };
    document.getElementById("cancelarJustificacion").onclick = function () {
        cancelarReasignar();
    };
    $("#ModalJustificacion").modal("show");
}

function AnularAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var justificacion = document.getElementById("justificacion").value;
    if (justificacion != "") {
        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoAnular': codigo, 'justificacion': justificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina").value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
                var mensaje = "El tiquete a sido anulado";
                notificacion(mensaje);
            }
        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ESTADO FINALIZAR">

function Finalizar() {
    var horas = document.getElementById("HorasT").value;
    if (horas < 1) {
        $("#ceroHoras").modal("show");
    } else {
        document.getElementById("infoJusticiacion").innerHTML = "¿Por qué desea finalizar el tiquete?";
        document.getElementById("aceptarJustificacion").onclick = function () {
            FinalizarAjax();
        };
        document.getElementById("cancelarJustificacion").onclick = function () {
            cancelarenProceso();
        };
        $("#ModalJustificacion").modal("show");
    }
}

function FinalizarAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var justificacion = document.getElementById("justificacion").value;
    if (justificacion != "") {
        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoFinalizar': codigo, 'justificacion': justificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina").value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
                document.getElementById("justificacion").value = "";
                var mensaje = "El tiquete ha sido finalizado";
                notificacion(mensaje);

            }
        });
    }
}

// </editor-fold>

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



// <editor-fold defaultstate="collapsed" desc="ESTADO CALIFICADO">
var calificacion;
function calificar(event) {
    calificacion = event;
    calificacion.checked = false;
    var micalificacion = calificacion.value;
    document.getElementById("infoJusticiacion").innerHTML = "\"Estrellas:" + micalificacion + "\" Agregar comentario a la calificaion";
    document.getElementById("aceptarJustificacion").onclick = function () {
        calificarAjax()
    };
    document.getElementById("cancelarJustificacion").onclick = function () {
        cancelarcalificar()
    };
    $("#ModalJustificacion").modal("show");

}
function  cancelarcalificar() {
    calificacion = null;
}

function calificarAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var micalificacion = calificacion.value;
    var justificacion = document.getElementById("justificacion").value;
    calificacion = null;
    if (justificacion != "") {

        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoCalificar': codigo, 'justificacion': justificacion, 'calificacion': micalificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina").value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
                document.getElementById("justificacion").value = "";
                var mensaje = "El tiquete ha sido calificado";
                notificacion(mensaje);
            }
        });
    }
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="PRIORIDAD">
function cambiarPrioridad(event) {
    var codigoTiquete = document.getElementById("codigoTiquete").innerHTML;
    var prioridad = event.value;
    $.ajax({
        data: {'codigoPrioridad': prioridad,
            'codigoTiquete': codigoTiquete
        },
        type: 'POST',
        url: '../control/SolicitudAjaxInformacionTiquetes.php',

        success: function (response) {
            var pagina = document.getElementById("comboPagina").value;
            $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + pagina + " #cargarTiquetePagina");
            var mensaje = "La prioridad del tiquete se cambio correctamente";
            notificacion(mensaje);
        }
    });
}


// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Reprocesar">

function Reprocesar() {
    document.getElementById("infoJusticiacion").innerHTML = "Porque desea reprocesar el tiquete?";
    document.getElementById("aceptarJustificacion").onclick = function () {
        ReprocesarAjax()
    };
    document.getElementById("cancelarJustificacion").onclick = function () {
        cancelarReasignar()
    };
    $("#ModalJustificacion").modal("show");
}

function ReprocesarAjax() {
    var codigo = document.getElementById("codigoTiquete").innerHTML;
    var justificacion = document.getElementById("justificacion").value;
    if (justificacion != "") {
        $("#ModalJustificacion").modal("hide");
        $.ajax({
            data: {'codigoReprocesar': codigo, 'justificacion': justificacion
            },
            type: 'POST',
            url: '../control/SolicitudAjaxInformacionTiquetes.php',

            success: function (response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                var pagina = document.getElementById("comboPagina").value;
                $("#cargarTiquetePagina").load('../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigo + '&pagina=' + pagina + " #cargarTiquetePagina");
            }
        });
    }
}

// </editor-fold>

//Historial
function mostrarHistorialTiquetes() {
    //  var codigoTiquete = event.parentNode.firstChild.nextSibling.innerHTML;
    var codigoPagina = $("#codigoPagina").val();
    var codigoTiquete = $("#codigoTique").val();
    if (codigoPagina == 4) {
        location.href = '../vista/HistorialTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '&paginaRegreso=1' + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                '&codigoFiltroG=' + $("#codigoFiltroG").val() + '&nombreSG=' + $("#nombreSG").val() + '&correoSG=' + $("#correoSG").val() +
                '&nombreRG=' + $("#nombreRG").val() + '&correoRG=' + $("#correoRG").val() +
                '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                '&calificado=' + $("#filtroCalificado").val() + '&paginaPrincipal=' + paginaPrincipal;
    } else {
        location.href = '../vista/HistorialTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '&paginaRegreso=1' + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                '&codigoFiltroG=' + '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                '&calificado=' + $("#filtroCalificado").val() + '&paginaPrincipal=' + paginaPrincipal;
    }
}