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

function cargarPanelActivos(codigo) {
    $.ajax({
        data: {'codigoActivo': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

function cargarPanelPasivos(codigo) {
    $.ajax({
        data: {'codigoPasivo': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}


function cargarPanelSumarInventario(codigo) {
    $.ajax({
        data: {'codigoSumarInventario': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}

function cargarPanelAgregarInventario(codigo) {
    $.ajax({
        data: {'codigoAgregarInventario': codigo},
        type: 'POST',
        url: '../control/SolicitudAjaxInventario.php',
        success: function (response) {
            $("#panelInformacionInventario").html(response);
        }
    });
}
