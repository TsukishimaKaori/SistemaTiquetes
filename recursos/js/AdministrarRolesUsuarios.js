var actual;
var tipo;
var codigo;
var nuevo;

function guardarvaloractual(event) {
    actual = event.value;
}

function alertaSeguridad(event) {
    var posicion = event.firstChild;
    var viejo = event;
    tipo = event.id;
    nuevo = event.value;
    var correcto = false;
    while (!correcto) {
        if (posicion.value == nuevo) {
            var Nombrenuevo = posicion.innerText;
            correcto = true;
        } else {
            posicion = posicion.nextSibling;
        }
    }
    var nombre;
    do {
        posicion = posicion.parentNode;
    } while (posicion.nodeName != "TR");
    nombre = posicion.firstChild.nextSibling.innerText;
    codigo = posicion.firstChild.innerText;
    var a = document.getElementById("Cambiartiquete");
    a.removeChild(a.firstChild);
    var node = document.createElement("h4");
    node.appendChild(document.createTextNode("¿Desea cambiar a " + nombre + " a " + Nombrenuevo + "?"));
    document.getElementById("Cambiartiquete").appendChild(node);
    $("#cambiarUsuario").modal("show");
    viejo.value = actual;
}
function cambiarUsuarioAJAX() {
    var activos = document.getElementById("radio").checked;
    $.ajax({
        data: {'tipo': tipo,
            'codigo': codigo,
            'nuevo': nuevo,
            'activo': activos
        },
        type: 'POST',
        url: '../control/SolicitudAjaxRolUsaurio.php',
        success: function (response) {
            $(document).ready(function () {
                var a = "error\n";
                if (response == a) {
                    $("#error").modal("show");
                } else {
                    $("#tbody-roles-usuarios").html(response);
                }

            });
        }
    });

}
function crearUsuarioAjax() {
    $("#error").modal("hide");
    var activos = document.getElementById("radio").checked;
    var nombre = document.getElementById("nombre").value;
    var codigoU = document.getElementById("codigoU").value;
    var email = document.getElementById("emailA").value;
    var area = document.getElementById("areaU").value;
    var rol = document.getElementById("rolU").value;

    $.ajax({
        data: {'nombre': nombre,
            'codigoU': codigoU,
            'emailA': email,
            'area': area,
            'rol': rol,
            'activo': activos
        },
        type: 'POST',
        url: '../control/SolicitudAjaxRolUsaurio.php',
        success: function (response) {
            $(document).ready(function () {
                var a = "error\n";
                if (response == a) {
                    $("#error").modal("show");
                } else {
                    $("#tbody-roles-usuarios").html(response);

                }

            });
        }
    });
}

function cambiarActivo(event) {
    var posicion = event
    tipo = "activacion";
    actual = posicion.innerText;
    if (actual == "Inactivo") {
        nuevo = "Activo";
    } else {
        nuevo = "Inactivo";
    }
    do {
        posicion = posicion.parentNode;
    } while (posicion.nodeName != "TR");
    var nombre = posicion.firstChild.nextSibling.innerText;
    codigo = posicion.firstChild.innerText;
    var a = document.getElementById("Cambiartiquete");
    a.removeChild(a.firstChild);
    var node = document.createElement("h4");
    node.appendChild(document.createTextNode("¿Desea cambiar a " + nombre + " a " + nuevo + "?"));
    document.getElementById("Cambiartiquete").appendChild(node);
    $("#cambiarUsuario").modal("show");
}
// cambiar todos o activos 
function clickeado(event) {
    var posicion = event.value;
    ajaxclickeado(posicion);
}

function ajaxclickeado(posicion) {
    $.ajax({
        data: {'activos': posicion},
        type: 'POST',
        url: '../control/SolicitudAjaxRolUsaurio.php',
        success: function (response) {
            $(document).ready(function () {
                $("#tbody-roles-usuarios").html(response);

            });
        }
    });
}
