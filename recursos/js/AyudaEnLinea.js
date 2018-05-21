function abrirPanel(panel) {
    $.ajax({
        data: {'panel': panel
        },
        type: 'POST',
        url: '../control/AdministrarAyudaEnLinea.php',
        beforeSend: function () {
        },
        success: function (response) {
            $("#panelContenido").html(response);
        }
    });
}




