// <editor-fold defaultstate="collapsed" desc="SELECCION EN COMBOBOX">
function tematicaSeleccionada(event) {
    var tematicaSeleccionada = event.value;
    var clickeado3 = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    tematicaSeleccionadaAjax(tematicaSeleccionada, clickeado3);
}

function tematicaSeleccionadaAjax(tematicaSeleccionada, clickeado3) {
    $.ajax({
        data: {'tematicaSeleccionada': tematicaSeleccionada,
            'clickeado3': clickeado3},
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        beforeSend: function () {
              $("#cargandoImagen").css('display','block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display','none');
            $("#cuerpoTablaTematica").html(response);
        }
    });
}

function clickeado(event) {
    var clickeado = event.value;
    var tematicaPadre = $('#comboTematicas').val();
    $.ajax({
        data: {'clickeado': clickeado,
            'tematicaPadre': tematicaPadre},
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        success: function (response) {
            $("#cuerpoTablaTematica").html(response);
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="AGREGACIÓN DE SUBTEMATICAS">
function subtematicasAgregar(event) {
    var valorInputSubTematica = $('#valorInputSubTematica').val();
    var valorComboPadreSubTematica = $('#comboAgregarSubTematicas').val();
    var val = validacionExpRegular(valorInputSubTematica);
    if (val == 'false' || valorInputSubTematica == null || valorInputSubTematica.length == 0) {
        $("#alertaNombreTemaNoValido").modal('show');
    } else {
        subtematicasAgregarAjax(valorInputSubTematica, valorComboPadreSubTematica);
    }
}

function subtematicasAgregarAjax(valorInputSubTematica, valorComboPadreSubTematica) {
    $.ajax({
        data: {'valorInputSubTematica': valorInputSubTematica,
            'valorComboPadreSubTematica': valorComboPadreSubTematica},
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        success: function (response) {
            if (response == 1) {// Tematica agregada correctamente
                $("#alertaSubTemaAgregada").modal('show');
                $("#modalAgregarSubTematica").modal('hide');
            } else if (response == 2) { //Ya existe
                $("#alertaNombreTemaExistente").modal('show');
            } else {
                $("#errorGeneral").modal('show');
                $("#modalAgregarSubTematica").modal('hide');
            }
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ACTIVIDAD DE SUBTEMATICAS">
var activ;
var nombreDesactivar;
var valorComboTematicaPadre;
function cambiarActivoSubTematica(event) {
    var posicion = event;
    valorComboTematicaPadre = $('#comboTematicas option:selected').html();
    do {
        posicion = posicion.parentNode;
    } while (posicion.nodeName != "TR");
    nombreDesactivar = posicion.firstChild.innerText;
    activ = event.nextSibling.nextSibling;
    $("#confirmarCambioActivoSubTematica").modal("show");
}

function cambiarActivoSubTematicaConfirmado(event) {
    var clickeado = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    if (activ.value == "1") {
        activ.value = "0";
    } else {
        activ.value = "1";
    }
    $("#confirmarCambioActivoSubTematica").modal("hide");
    activarDesactivarTematicas(activ.value, nombreDesactivar, valorComboTematicaPadre, clickeado);
}

function activarDesactivarTematicas(activoTematica, nombreTematica, valorComboTematicaPadre, clickeado2) {
    $.ajax({
        data: {'activoTematica': activoTematica,
            'nombreTematica': nombreTematica,
            'valorComboTematicaPadre': valorComboTematicaPadre,
            'clickeado2': clickeado2},
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        success: function (response) {
            $("#cuerpoTablaTematica").html(response);
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ELIMINACION DE SUBTEMATICAS">
var nombreSubtematicaEliminar;
function eliminarSubtematicaModal(event) {
    var tr = event.parentNode.parentNode;
    nombreSubtematicaEliminar = tr.firstChild.innerText;
    $("#descripcionEliminarSubtematica").text('¿Desea eliminar la temática: ' + nombreSubtematicaEliminar + '?');
    $("#modalEliminarSubTematica").attr("data-target", "#modalEliminarSubTematica");
    $("#modalEliminarSubTematica").modal('show');
}

function eliminarSubtematica(event) {
    var tematicaPadre = $('#comboTematicas').val();
    var clickeado4 = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    eliminarSubTematicaAjax(nombreSubtematicaEliminar, tematicaPadre, clickeado4);
}

function eliminarSubTematicaAjax(nombreSubtematicaEliminar, tematicaPadre, clickeado4) {
    $.ajax({
        data: {'nombreSubtematicaEliminar': nombreSubtematicaEliminar,
            'tematicaPadre': tematicaPadre,
            'clickeado4': clickeado4
        },
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        success: function (response) {
            if (response == 1) {
                $("#errorGeneral").modal("show");
                $("#modalEliminarSubTematica").modal('hide');
            } else if (response == 2) {
                $("#alertaSubTematicaNoEliminada").modal("show");
                $("#modalEliminarSubTematica").modal('hide');
            } else {
                $("#cuerpoTablaTematica").html(response);
                $("#alertaSubTematicaEliminada").modal("show");
                $("#modalEliminarSubTematica").modal('hide');
            }
        }
    });
}
// </editor-fold> 

// <editor-fold defaultstate="collapsed" desc="MODIFICACION DE SUBTEMATICAS">
var tdhijoTablaTematica;
function nombreClasificacionTabla(event) {
    var tr = event.parentNode.parentNode;
    tdhijoTablaTematica = tr.firstChild.innerText;
    return tdhijoTablaTematica;
}

var nombreSubtematica;
function modificarSubtematicaModal(event) {
    tdhijoTablaTematica = nombreClasificacionTabla(event);
    var tr = event.parentNode.parentNode;
    nombreSubtematica = tr.firstChild.innerText;
    var tematicaPadre = $('#comboTematicas').val();
    $('#descripcionModificarSubtematica').val(nombreSubtematica);
    $('#comboTematicasModificar').val(tematicaPadre);
    $("#modalModifcarSubTematica").attr("data-target", "#modalModifcarSubTematica");
    $("#modalModifcarSubTematica").modal('show');
}

function modificarSubTematica(event) {
    var valor = $('#descripcionModificarSubtematica').val();
    var clickeado4 = ($("input:radio[id=radio1]:checked").val()) ? 'radio1' : 'radio2';
    var tematicaPadre = $('#comboTematicasModificar').val();
    var tematicaPadreAnterior = $('#comboTematicas').val();
    var val = validacionExpRegular(valor);
    if (val == 'false' || valor == null || valor.length == 0) {
        $("#alertaEditarNombreSubtematicaFallido").modal('show');
    } else if (tdhijoTablaTematica == valor) {
        $("#modalModifcarSubTematica").modal('hide');
    } else {
        modificarSubTematicaAjax(valor, nombreSubtematica, tematicaPadre, tematicaPadreAnterior, clickeado4);
    }
}

//Modificar el nombre de la subtematica y el padre
function modificarSubTematicaAjax(subtematicaModificada, subtematicaAnterior, tematicaPadre, tematicaPadreAnterior, clickeado4) {
    $.ajax({
        data: {'subtematicaModificada': subtematicaModificada,
            'subtematicaAnterior': subtematicaAnterior,
            'tematicaPadre': tematicaPadre,
            'tematicaPadreAnterior': tematicaPadreAnterior,
            'clickeado4': clickeado4},
        type: 'POST',
        url: '../control/SolicitudAjaxTematicasSubtematicas.php',
        success: function (response) {
            if (response == 1) {
                $("#alertaEditarNombreSubtematicaInactivo").modal('show'); // no existe la tematica a actualizar
                $("#modalModifcarSubTematica").modal('hide');
            } else if (response == 3) {
                $("#errorGeneral").modal('show'); // no existe la tematica a actualizar
            } else if (response == 2) {
                $("#modalModifcarSubTematica").modal('hide');
                $("#alertaEditarNombreSubtematicaRepetido").modal('show'); //  'Ya existe una temática con la descripción '
            } else {
                $("#cuerpoTablaTematica").html(response);
                $("#modalModifcarSubTematica").modal('hide');
            }
        }
    });
}
// </editor-fold>

function validacionExpRegular(expresion) {
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    return (exp.test(expresion)) ? 'true' : 'false';
}