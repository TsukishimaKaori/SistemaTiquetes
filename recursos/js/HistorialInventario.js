// <editor-fold defaultstate="collapsed" desc="filtros">
var filtros = true;

function filtrosInventario() {
    FiltrosAjax(filtros);
    if (filtros) {
        filtros = false;
    } else {
        filtros = true;
    }
}

function FiltrosAjax(filtros) {
    $.ajax({
        data: {'filtros': filtros
        },
        type: 'POST',
        url: '../control/SolicitudAjaxHistorialInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
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

function filtrarBusqueda() {
    var pagina = $("#pagina").val();
    var fechaI = $("#fechafiltroI").val();
    var fechaF = $("#fechafiltroF").val();
    var codigoDispositivo = $("#codigoDispositivo").val();
    if (pagina == "1") {
        filtrarBusquedaActivos(codigoDispositivo, fechaI, fechaF);
    } else if (pagina == "2") {
        var bodega = $("#bodega").val();
        filtrarBusquedaInventario(codigoDispositivo, bodega, fechaI, fechaF);
    }
}

function filtrarBusquedaInventario(codigoDispositivo, bodega, fechaI, fechaF) {
    $.ajax({
        data: {'codigoDispositivoInventario': codigoDispositivo,
            'bodega': bodega,
            'fechaI': fechaI,
            'fechaF': fechaF
        },
        type: 'POST',
        url: '../control/SolicitudAjaxHistorialInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#panelFiltrado").html(response);
            notificacion("Filtro aplicado correctamente");
        }
    });
}

function filtrarBusquedaActivos(codigoDispositivo, fechaI, fechaF) {
    $.ajax({
        data: {'codigoDispositivoActivos': codigoDispositivo,
            'fechaI': fechaI,
            'fechaF': fechaF
        },
        type: 'POST',
        url: '../control/SolicitudAjaxHistorialInventario.php',
          beforeSend: function () {
              $("#cargandoImagen").css('display','block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none');
            $("#panelFiltradoActivos").html(response);
            notificacion("Filtro aplicado correctamente");

        }
    });
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