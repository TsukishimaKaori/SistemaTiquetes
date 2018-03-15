// <editor-fold defaultstate="collapsed" desc="MODIFICACION DE TEMATICAS">
var tdhijoTablaTematica;
function nombreClasificacionTabla(event) {
    var tr = event.parentNode.parentNode;
    tdhijoTablaTematica = tr.firstChild.innerText;
    return tdhijoTablaTematica;
}

//Setea los campos del modificar tematica
//var tdhijoTablaTematica;
function validacionModifcarTematica(event) {
    tdhijoTablaTematica = nombreClasificacionTabla(event);
    $('#inputModificarTematica').val(tdhijoTablaTematica);
    $("#modalModificarTematica").attr("data-target", "#modalModificarTematica");
    $("#modalModificarTematica").modal('show');
}

//Modificar la tematica.
function modificarTematica(event) {
    var clickeado2 = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    var valor = $('#inputModificarTematica').val();
    var val = validacionExpRegular(valor);
    if (val == 'false' || valor == null || valor.length == 0) {
        $("#alertaNombreClasificacionNoValido").modal('show');
    } else if (tdhijoTablaTematica == valor) {
        $("#modalModificarTematica").modal('hide');
    } else {
        modificarTematicaAjax(valor, tdhijoTablaTematica, clickeado2);
    }
}

//Modificar el nombre de la tematica via ajax
function modificarTematicaAjax(tematicaModificada, tematicaAnterior, clickeado2) {
    $.ajax({
        data: {'tematicaModificada': tematicaModificada,
            'tematicaAnterior': tematicaAnterior,
            'clickeado2': clickeado2},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            if (response == 2) {
                $("#alertaEditarNombreClasificacion").modal('show');
            } else if (response == 1) {
                $("#alertaEditarActivo").modal('show');
            } else {
                $("#cuerpoTablaTematicasNivel1").html(response);
                $("#modalModificarTematica").modal('hide');
            }
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="AGREGACION DE TEMATICAS">
//Agrega las tematicas padre
function validacionAgregarTematica(event) {
    var valorInputTematica = $('#inputAgregarTematica').val();
    var valorComboPadre = $('#comboAreasAgregarTematicas').val();
    var val = validacionExpRegular(valorInputTematica);
    if (val == 'false' || valorInputTematica == null || valorInputTematica.length == 0) {
        $("#alertaNombreClasificacionNoValido").modal('show');
    } else {
        agregarTematicasPadreAjax(valorInputTematica, valorComboPadre);
    }
}
//Envia la solicitud via ajax para agregar tematicas padres
function agregarTematicasPadreAjax(valorInputTematica, valorComboPadre) {
    $.ajax({
        data: {'valorInputTematica': valorInputTematica,
            'valorComboPadre': valorComboPadre},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            if (response == 4) { //agregado correctamente              
                $("#alertaClasificacionAgregada").modal('show');
                $("#modalAgregarTematica").modal('hide');
            } else if (response == 1) {// Tematica ya existente
                $("#alertaNombreClasificacionExistente").modal('show');
            } else { //No existe el area a asociar                
                $("#errorGeneral").modal('show');
            }
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="MODIFICACION DE AREAS">
var tdhijoTablaArea;
function validacionModificarArea(event) {
    var tr = event.parentNode.parentNode;
    tdhijoTablaArea = tr.firstChild.innerText;
    $('#inputModificarArea').val(tdhijoTablaArea);
    $("#modalAreaActiva").modal('hide');
    $("#modalModificarArea").modal('show');
}

//Modificar la tematica.
function modificarArea(event) {
    var valor = $('#inputModificarArea').val();
    var val = validacionExpRegular(valor);
    if (val == 'false' || valor == null || valor.length == 0) {
        $("#alertaNombreAreaNoValido").modal('show');
    } else {
        modificarAreaAjax(valor, tdhijoTablaArea);
    }
}

//Modificar el nombre de la tematica via ajax
function modificarAreaAjax(areaModificada, areaAnterior) {
    $.ajax({
        data: {'areaModificada': areaModificada,
            'areaAnterior': areaAnterior},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            // $("#cuerpoTablaTematicasNivel1").html(response);
            // $("#modalModificarTematica").modal('hide');
            location.reload();
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ACTIVIDAD DE AREAS">
//areas activas o inactivas cambio
//Activa o desactiva las areas
function activarDesactivarAreas(activo, nombre) {
    $.ajax({
        data: {'activo': activo,
            'nombre': nombre
        },
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
    });
}

var posicion;
var activ1;
function cambiarActivo(event) {    
     posicion = event;
     activ1 = event.nextSibling.nextSibling;
    $("#confirmarEditarAreaActiva").modal("show");
}

function cambiarActivoConfirmacion(event) {
      event = posicion;
    do {        
        posicion = posicion.parentNode;
    } while (posicion.nodeName != "TR");
    
    var nombre = posicion.firstChild.innerText;
   
    var accion;
    if (activ1.value == "1") {
        accion = "Inactivo";
    } else {
        accion = "Activo";
    }
    if (activ1.value == "1") {
        activ1.value = "0";
        event.className = "btn btn-danger";
    } else {
        activ1.value = "1";
        event.className = "btn btn-success";
    }
    event.innerText = accion;
    activarDesactivarAreas(activ1.value, nombre);
      $("#confirmarEditarAreaActiva").modal("hide");
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="COMBOBOX DE AREAS DE LA TABLA DE CLASIFICACIONES">
//Confirmacion al inactivar o desactivar una clasificacion
//MOdal que se muestra al cambiar el area de una clasificacion
var eventoComboAreas, posicionTematica, posicionArea, anteriorArea;
function cambiarSeleccionAreaTablaNivel1(event) {
    posicionArea = event;
    eventoComboAreas = event.value;
    anteriorArea = anterior;
    var posicion = event.parentNode;
    var posiciontr = posicion.parentNode;
    posicionTematica = posiciontr.firstChild.innerHTML;
    $("#confirmarCambioAreaTablaTematica").modal("show");
}

//En caso de que se cambie la clasificacion
function cambiarAreaTematicaTablaConfirmado(event) {
    cambiarSeleccionAreaTablaNivel1Ajax(eventoComboAreas, posicionTematica);
    $("#confirmarCambioAreaTablaTematica").modal("hide");
}

//En caso de cancelada la modificacion de area de una clasificacion
function cambiarAreaTematicaTablaCancelado(event) {
    posicionArea.value = anteriorArea;
    $("#confirmarCambioAreaTablaTematica").modal("hide");
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ACTIVIDAD DE TEMATICAS">
var activ;
var nombreDesactivar;
function cambiarActivoTematica(event) {
    var posicion = event;
    do {
        posicion = posicion.parentNode;
    } while (posicion.nodeName != "TR");
    nombreDesactivar = posicion.firstChild.innerText;
    activ = event.nextSibling.nextSibling;
    $("#confirmarCambioActivoTematica").modal("show");
}

function cambiarActivoTematicaConfirmado(event) {
    var clickeado = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    if (activ.value == "1") {
        activ.value = "0";
    } else {
        activ.value = "1";
    }
    activarDesactivarTematicas(activ.value, nombreDesactivar, clickeado);
    $("#confirmarCambioActivoTematica").modal("hide");
}

//Activa y desactiva las tematicas padre
function activarDesactivarTematicas(activoTematica, nombreTematica, clickeado2) {
    $.ajax({
        data: {'activoTematica': activoTematica,
            'nombreTematica': nombreTematica,
            'clickeado2': clickeado2},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            $("#cuerpoTablaTematicasNivel1").html(response);
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="AGREGACIÓN DE ÁREAS">
function validacionAgregarArea(event) {
    var valor = $('#inputAgregarArea').val();
    var val = validacionExpRegular(valor);
    if (val == 'false' || valor == null || valor.length == 0) {
        $("#alertaNombreAreaNoValido").modal('show');
    } else {
        agregarAreaAjax(valor);
    }
}

function agregarAreaAjax(valorInputArea) {
    $.ajax({
        data: {'valorInputArea': valorInputArea},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            if (response == 1) {// Tematica ya existente
                $("#alertaNombreAreaExistente").modal('show');
            } else if (response == 3) { //Agregada correctamente
                $("#alertaNombreAreaValido").modal('show');
                $("#modalAgregarArea").modal('hide');
            }
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ELIMINACION DE ÁREAS">
//LLama el modal que abre la ventana para eliminar un area
var areaEliminar;
function enviarCambiosAreas(event) {
    areaEliminar = $("#comboAreas option:selected").text();
    $("#confirmarEliminarArea").modal('show');
}

function eliminarArea(event) {
    $("#confirmarEliminarArea").modal('hide');
    eliminarAreaAjax(areaEliminar);
}

function eliminarAreaAjax(valorEliminarArea) {
    $.ajax({
        data: {'valorEliminarArea': valorEliminarArea},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) { // Se ha producido un error
            if (response == 1) {// Tematica ya existente
                $("#errorGeneral").modal('show');
                $("#modalEliminarArea").modal('hide');
            } else if (response == 2) { //Elminado correctamente
                $("#alertaEliminarAreaValido").modal('show');
                $("#modalEliminarArea").modal('hide');
            } else if (response == 3) { //Hay usuarios asociados
                $("#alertaEliminarAreaRestringido").modal('show');

            }
        }
    });
}
// </editor-fold>

//Cambia el valor del selector y sus tematicas asociadas
function cambiarSeleccionAreaTablaNivel1Ajax(seleccionado, tematica) {
    $.ajax({
        data: {'seleccionado': seleccionado,
            'tematica': tematica},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
    });
}

function guardarAnterior(event) {
    anterior = event.value;
}

function guardarvaloractual(event) {
    $('#inputHiddenTematicas').attr('value', "submitComboAreas");
    event.form.submit();
}

function clickeado(event) {
    var clickeado = event.value;
    $.ajax({
        data: {'clickeado': clickeado},
        type: 'POST',
        url: '../control/SolicitudAjaxAreasTematicas.php',
        success: function (response) {
            $("#cuerpoTablaTematicasNivel1").html(response);
        }
    });
}



function validacionExpRegular(expresion) {
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    if (exp.test(expresion)) {
        return 'true';
    } else {
        return 'false';
    }
}

