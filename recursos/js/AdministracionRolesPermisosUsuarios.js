// <editor-fold defaultstate="collapsed" desc="AGREGACION DE ROLES">
function validacionAgregarRol(event) {
    var bandera = 0;
    console.log(val);
    var valor = $('#inputAgregarRol').val();
    var val = validacionExpRegular(valor);
    console.log(val);
    if (val == 'false' || valor == null || valor.length == 0) {
        $("#alertaRolAgregarFallido").modal('show');
        bandera = 1;
    } else {
        $("#comboRoles option").each(function () {
            if (valor == $(this).text()) {
                bandera = 1;
                $("#alertaRolAgregarRepetido").modal('show');
            }
        });

        if (bandera == 0) {
            event.form.action = window.location.href + "?alertaRolAgregado=1";
            event.form.submit();
        }
    }
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ELIMINACION DE ROLES">
function eliminarRol(event) {
    var combo = $('#comboRoles').val();
    $("#rolAElminar").text('¿Desea eliminar el rol ' + combo + '?');
    $("#modalEliminarRol").modal('show');
}

function confimarcionEliminar(event) {
    var combo = $('#comboRoles').val();
    if (combo != 'Administrador') {
        $.ajax({
            data: {'hiddenEliminarRol': combo},
            type: 'POST',
            url: '../control/SolicitudAjaxUsuariosRoles.php',
            success: function (response) {
                $("#modalEliminarRol").modal('hide');
                if (response == 1) {
                    window.location = window.location.href + "?alertaEliminarRol=1";

                } else {
                    window.location = window.location.href + "?alertaEliminarRol=2";
                }
            },
        });
    } else {
        $("#modalEliminarRol").modal('hide');
        window.location = window.location.href + "?alertaEliminarRol=3";

    }
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="MODIFICACION DE PERMISOS">
function enviarCambiosPermisos(event) {
    $("#confirmacionPermisosModificados").modal('show');
}

function confirmarPermisosModificados(event) {
    var values1 = $('#comboRoles').val();
    if ($('#comboRoles').val() != 'Administrador') {
        console.log("ENtro" + values1);
        $('#inputHiddenPermisos').attr('value', "inputHiddenPermisos");
        var formulario = document.getElementById("formComboRoles");
        formulario.action = window.location.href + "?alertaPermisosModificados=1";
        formulario.submit();
    } else {
        $("#confirmacionPermisosModificados").modal('hide');
    }
}

// </editor-fold>


function comboRolesUsuarios(event) {
    var comboRolesUsuariosModal = $('#comboRolesUsuariosModal').val();
    procesarRolesUsuarios(comboRolesUsuariosModal);
}

function procesarRolesUsuarios(comboRolesUsuariosModal) {
    $.ajax({
        data: {'comboRolesUsuariosModal': comboRolesUsuariosModal},
        type: 'POST',
        url: '../control/SolicitudAjaxUsuariosRoles.php',
        beforeSend: function () {
            console.log("Este es mi prametro " + comboRolesUsuariosModal);
            // $("#cuerpoTablaRolUsuario").html("Procesando, espere por favor...");
        },
        success: function (response) {
            $("#cuerpoTablaRolUsuario").html(response);
        }
    });
}

function guardarvaloractual(event) {
    $('#inputHiddenPermisos').attr('value', "submitComboRoles");
    event.form.submit();
}

function validacionExpRegular(expresion) {
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    return (exp.test(expresion)) ? 'true' : 'false';
}