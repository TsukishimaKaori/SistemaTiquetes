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