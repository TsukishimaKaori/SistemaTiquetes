//valor correspondiete al combobox
$("#modalEditarNombreEstado").on('hidden.bs.modal', function (event) {
    if ($('.modal:visible').length) //check if any modal is open
    {
        $('body').addClass('modal-open');//add class to body
    }
});

function guardarvaloractual(event) {
    var comboEstados = event.value;
    $.ajax({
        data: {'comboEstados': comboEstados},
        type: 'POST',
        url: '../control/SolicitudAjaxEstadoTiquetes.php',
        success: function (response) {
            $("#cuerpoTablaEstadoTiquetes").html(response);
        }
    });
}

function validacionExpRegular(expresion) {
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    return (exp.test(expresion)) ? 'true' : 'false';
}

// <editor-fold defaultstate="collapsed" desc="MODIFICACION DE ESTADOS">
//guarda las modificaciones a los estados siguientes
var estado;
var sigEstado;
var comboEstados;


function confirmarEstadosModificados(event) {
    $.ajax({
        data: {'comboEstados2': comboEstados,
            'estado': estado,
            'sigEstado': sigEstado},
        type: 'POST',
        url: '../control/SolicitudAjaxEstadoTiquetes.php',
    });
    $("#confirmacionEstadosModificados").modal('hide');
}

var correoActivo;
var nombreEstadoModal;
var casilla;
//Guarda si envia correo o no, desde el modal de editar estados
function guardarEnviaCorreo(event) {
    $("#confirmarCorreoModificado").modal('show');
    casilla = event.id;
    nombreEstadoModal = event.parentNode.parentNode.firstChild.innerHTML;
    correoActivo = event.value;
    correoActivo = correoActivo == '1' ? correoActivo = '0' : correoActivo = '1';
}

//Solicitud en ajax para modificaciondel estado
function confirmarCorreoModificado(event) {
    $.ajax({
        data: {'correoActivo': correoActivo,
            'nombreEstadoModal': nombreEstadoModal
        },
        type: 'POST',
        url: '../control/SolicitudAjaxEstadoTiquetes.php',
    });
    $("#confirmarCorreoModificado").modal('hide');
}

//Cancelar  checkear estado envia correo.
function cancelarCorreoModificado(event) {
    var idElemento = "#" + casilla;
    var marcado = ($(idElemento).is(":checked"));
    if (marcado) {
        // $(idElemento).removeAttr('checked');
        $(idElemento).prop('checked', false);
    } else {
        $(idElemento).prop('checked', true);
    }
    $("#confirmarCorreoModificado").modal('hide');

}

// </editor-fold>

