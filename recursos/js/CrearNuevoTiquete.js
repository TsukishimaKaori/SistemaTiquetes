$(function () {
    var fecha = new Date()
    $('#datetimepicker1').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es',
    });
});

$(function () {
    var fecha = new Date()
    $('#fecha').datetimepicker({
        minDate: fecha.setDate(fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es',
    });

});

function Clasificaciones() {
    $("#modalClasificaciones").modal("show");

}

function actualizarTematica(event) {
    var clasificacion = event.innerHTML;
    document.getElementById("clasificacion").value = clasificacion;
    $("#modalClasificaciones").modal("hide");
}

function subirarchivo(event) {
    var archivo = event.value;
    document.getElementById("Textarchivo").value = archivo;
}


function enviar(event) {

    var tematica = document.getElementById("clasificacion").value;
    var comentario = document.getElementById("comment").value;
    var a = document.getElementById("errorDiv");
    if (a.firstChild != null)
        a.removeChild(a.firstChild);
    var node = document.createElement("h4");
    if (tematica == "") {
        node.appendChild(document.createTextNode("Escoga una Clasificación"));
        document.getElementById("errorDiv").appendChild(node);
        $("#errorInfo").modal("show");
    } else if (comentario == "") {
        node.appendChild(document.createTextNode("debe agregar un comentario"));
        document.getElementById("errorDiv").appendChild(node);
        $("#errorInfo").modal("show");
    } else {
        if (document.getElementById("archivo").files.length > 0) {
            var documento = document.getElementById("archivo").files[0];
            var tipo = documento.type;
            if (tipo == "application/vnd.openxmlformats-officedocument.presentationml.presentation" ||
                    tipo == "text/plain" || tipo == "application/pdf" || tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||
                    tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || tipo=="image/png" ||tipo=="image/jpeg") {
                 $(document).ready(function () {
                    $("#EnviarTiquete").modal("show");
                });
              
            } else {
                 alert("no se puede enviar el archivo");
            }
        } else {
            $(document).ready(function () {
                $("#EnviarTiquete").modal("show");
            });
        }

    }
}

function  EnviarAjax() {
    var nombre = document.getElementById("nombre").value;
    var fecha = document.getElementById("fecha").value;
    var clasificacion = document.getElementById("clasificacion").value;
    var comentario = document.getElementById("comment").value;
    var file = document.getElementById("archivo");
    var archivo = file.files[0];
    var data = new FormData();
    data.append('nombre', nombre);
    data.append('fecha', fecha);
    data.append('clasificacion', clasificacion);
    data.append('comentario', comentario);
    data.append('archivo', archivo);

    $.ajax({

        type: 'POST',
        url: '../control/SolicitudAjaxCrearTiquete.php',

        contentType: false,
        processData: false,
        data: data,
 beforeSend: function () {
              $("#cargandoImagen").css('display','block');
        },
        success: function (response) {
            $(document).ready(function () {
                var a = "error";
                $("#cargandoImagen").css('display','none');
                if (response == a) {
                    var a = document.getElementById("errorDiv");
                    if (a.firstChild != null)
                        a.removeChild(a.firstChild);
                    var node = document.createElement("h4");
                    node.appendChild(document.createTextNode("Error al enviar"));
                    document.getElementById("errorDiv").appendChild(node);
                    $("#EnviarTiquete").modal("hide");
                    $("#errorInfo").modal("show");
                } else {
                    $("#EnviarTiquete").modal("hide");
                    $("#TiqueteEnviado").modal("show");

                }

            });
        }
    });
}

function cancelarAdjunto() {
    document.getElementById("Textarchivo").value = "";
    document.getElementById("archivo").value = "";
}