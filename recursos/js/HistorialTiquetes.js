// <editor-fold defaultstate="collapsed" desc="CAMBIAR FECHA SOLICITADA">
//$(function () {
//    var fecha = new Date();
//    $('#datetimepicker1').datetimepicker({
//        format: 'DD/MM/YYYY',
//        locale: 'es'
//    });
//});
//
//$(function () {
//    var fecha = new Date();
//    $('#datetimepicker2').datetimepicker({
//        format: 'DD/MM/YYYY',
//        locale: 'es'
//    });
//});
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="FILTROS">
//function filtrarBusqueda() {
//    $("#cuerpoHistorialTiquete div").remove();
//    var codigoTiqueteHistorial = $('#codigoTiqueteHistorial').val();
//    var correoSolicitante = $('#correoSolicitante').val();
//    var correoResponsable = $('#correoResponsable').val();
//    var filtroFecha = $('#filtroFecha').val();
//    var nombreSolicitante = $('#nombreSolicitante').val();
//    var nombreResponsable = $('#nombreResponsable').val();
//    var filtroFechaFinal = $('#filtroFechaFinal').val();
//    // validacionExpRegular(correoSolicitante);                     
//    $.ajax({
//        data: {'codigoTiqueteHistorial': codigoTiqueteHistorial,
//            'correoSolicitante': correoSolicitante,
//            'correoResponsable': correoResponsable,
//            'filtroFecha': filtroFecha,
//            'nombreSolicitante': nombreSolicitante,
//            'nombreResponsable': nombreResponsable,
//            'filtroFechaFinal': filtroFechaFinal
//        },
//        type: 'POST',
//        url: '../control/SolicitudAjaxHistorialTiquetes.php',
//        success: function (response) {
//            if (response != 1) {
//                $("#cuerpoListadoHistorialTiquetes").html(response);
//                $("#divHistorialTiqueteHeader").addClass("animated flash");
//            }
//
//        }
//    });
//}

function filtroIndicadores() {
    var indicadores = new Array(); //son los indicadores seleccionados   // 9 ......9 6 11 12
    var historial = new Array(); //estan dentro del filtro
    var j = 0;
    for (var i = 1; i < 15; i++) {
        if ($('#opcIndicador' + i + '').prop('checked') && i != 13) {
            indicadores[j] = $('#opcIndicador' + i + '').val();
            //alert($('#opcIndicador' + i + '').val());
            j = j + 1;
        }
    }

    if ($('#opcIndicador13').prop('checked')) {
        $('#cuerpoHistorialTiquete').find('h5.indicadorh5').each(function () { // busca en el dom los indicadores que hay
            $('div.divHistorial' + this.innerText + '').show();
        });
    } else {
        j = 0;
        $('#cuerpoHistorialTiquete').find('h5.indicadorh5').each(function () { // busca en el dom los indicadores que hay
            $('div.divHistorial' + this.innerText + '').show();
            if (!indicadores.includes(this.innerText)) {
                historial[j] = 'div.divHistorial' + this.innerText + '';
                j = j + 1;
                //alert(this.innerText);
                //$('div.divHistorial'+this.innerText+'').remove();
            }
        });
        historial.forEach(function (element) {
            console.log("ultimo for:" + element);
            // $(element).remove();
            $(element).hide();
        });
    }
}

// </editor-fold>

function mostrarHistorialTiquete(event) {
    // $('.checkRemover').removeProp('checked');
    //var codigoInformacionTiqueteHistorial = event.id;
    var codigoInformacionTiqueteHistorial = $("#codigoTique").val();
    $(".panelTiqueteHistorial").removeClass('panel-success').addClass('panel-default');
    $("#" + codigoInformacionTiqueteHistorial + "").removeClass('panel-default').addClass('panel-success');
    //$('#divHistorialTiquete').css("display", "block !important");
    $.ajax({
        data: {'codigoInformacionTiqueteHistorial': codigoInformacionTiqueteHistorial
        },
        type: 'POST',
        url: '../control/SolicitudAjaxHistorialTiquetes.php',
        success: function (response) {
            $("#cuerpoHistorialTiquete").html(response);
        }
    });
}

function cargarHistorialInformacion(codigoTiqueteInformacion,codigoIndicadorInformacion) {
    $.ajax({
        data: {'codigoTiqueteInformacion': codigoTiqueteInformacion,
            'codigoIndicadorInformacion': codigoIndicadorInformacion
        },
        type: 'POST',
        url: '../control/SolicitudAjaxHistorialTiquetes.php',
        success: function (response) {
            if (response != 1) {
                $("#cuerpoHistorialInformacion").html(response);
            }
        }
    });
}

$(document).ready(function () {
    mostrarHistorialTiquete();
});

function retornarABandejaDesdeHistorial() {
    var codigoPagina = $('#codigoPagina').val();
    var paginaRegreso = $('#paginaRegreso').val();
    var codigoTiquete = $('#codigoTique').val();
    if (paginaRegreso == 1) {

        var fechaI = $("#filtroFechaI").val(); //codigo de la pagina actual
        var fechaF = $("#filtroFechaF").val();
        var nuevo = $("#filtroNuevo").val();
        var asignado = $("#filtroAsignado").val();
        var reasignado = $("#filtroReasignado").val();
        var proceso = $("#filtroProceso").val();
        var anulado = $("#filtroAnulado").val();
        var finalizado = $("#filtroFinalizado").val();
        var calificado = $("#filtroCalificado").val();

        if (codigoPagina == 4) {
            var nombreSG = $("#nombreSG").val();
            var correoSG = $("#correoSG").val();
            var nombreRG = $("#nombreRG").val();
            var correoRG = $("#correoRG").val();
            var codigoFiltroG = $("#codigoFiltroG").val();


            location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                    '&codigoFiltroG=' + $("#codigoFiltroG").val() + '&nombreSG=' + $("#nombreSG").val() + '&correoSG=' + $("#correoSG").val() +
                    '&nombreRG=' + $("#nombreRG").val() + '&correoRG=' + $("#correoRG").val() +
                    '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                    '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                    '&calificado=' + $("#filtroCalificado").val() + '&paginaPrincipal=' + $("#paginaPrincipal").val();
        } else {
            location.href = '../vista/AdministrarInformacionTiquetes.php?tiquete=' + codigoTiquete + '&pagina=' + codigoPagina + '&fechaInicioFiltros=' + $("#filtroFechaI").val() + '&fechaFinalizacionFiltros=' + $("#filtroFechaF").val() +
                    '&nuevo=' + $("#filtroNuevo").val() + '&asignado=' + $("#filtroAsignado").val() + '&reasignacion=' + $("#filtroReasignado").val() +
                    '&proceso=' + $("#filtroProceso").val() + '&anulado=' + $("#filtroAnulado").val() + '&finalizado=' + $("#filtroFinalizado").val() +
                    '&calificado=' + $("#filtroCalificado").val() + '&paginaPrincipal=' + $("#paginaPrincipal").val();
        }

    } else {
        location.href = "../vista/BandejasTiquetes.php?tab=" + codigoPagina + "";
    }
}