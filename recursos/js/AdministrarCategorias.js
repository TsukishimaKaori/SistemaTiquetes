// <editor-fold defaultstate="collapsed" desc="AGREGACIÓN DE SUBTEMATICAS">
function categoriaAgregar(event) {
    var valorInputCategoria = $('#valorInputCategoria').val();
    var esRepuesto = $('#esRepuesto').prop("checked"); //retorna true o false
    alert(esRepuesto);
    var val = validacionExpRegular(valorInputCategoria);
    if (val == 'false' || valorInputCategoria == null || valorInputCategoria.length == 0) {
       // $("#alertaNombreTemaNoValido").modal('show');
    } else {
        categoriaAgregarAjax(valorInputCategoria, esRepuesto);
    }
}

function categoriaAgregarAjax(valorInputCategoria, esRepuesto) {
    $.ajax({
        data: {'valorInputCategoria': valorInputCategoria,
            'esRepuesto': esRepuesto
        },
        type: 'POST',
        url: '../control/SolicitudAjaxCategorias.php',
        success: function (response) {
            if (response == 1) {// Tematica agregada correctamente
               // $("#alertaSubTemaAgregada").modal('show');
               // $("#modalAgregarSubTematica").modal('hide');
            } else if (response == 2) { //Ya existe
               // $("#alertaNombreTemaExistente").modal('show');
            } else {
                 $('#cuerpoTablaTematica').html(response);
                $("#modalAgregarCategoria").modal('hide');
               // $("#errorGeneral").modal('show');
               // $("#modalAgregarSubTematica").modal('hide');
            }
        }
    });
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ELIMINACION DE SUBTEMATICAS">
var nombreSubtematicaEliminar;
var idCategoriaEliminar;
function eliminarCategoriaModal(event) {
    var tr = event.parentNode.parentNode;
    idCategoriaEliminar = tr.firstChild.innerText;
    nombreSubtematicaEliminar = tr.firstChild.nextSibling.innerText;
    $("#descripcionEliminarCategoria").text('¿Desea eliminar la temática: ' + nombreSubtematicaEliminar + '?');
    $("#modalEliminarCategoria").attr("data-target", "#modalEliminarCategoria");
    $("#modalEliminarCategoria").modal('show');
}

function eliminarCategoria(event) {
    eliminarCategoriaAjax(idCategoriaEliminar);
}

function eliminarCategoriaAjax(idCategoriaEliminar) {
  var clickeados;
    if($("input:radio[id=radio1]:checked").val()){
        clickeados = "radio1";
    }else if($("input:radio[id=radio2]:checked").val()){
        clickeados = "radio2";        
    }else if($("input:radio[id=radio3]:checked").val()){
        clickeados = "radio3";        
    }
    $.ajax({
        data: {'idCategoriaEliminar': idCategoriaEliminar ,
            'clickeados':clickeados
        },
        type: 'POST',
        url: '../control/SolicitudAjaxCategorias.php',
        success: function (response) {
            if (response == 1) {
                //$("#errorGeneral").modal("show");
                $("#modalEliminarCategoria").modal('hide');
                notificacion("Error al eliminar la categoria");                  
                //$("#modalEliminarSubTematica").modal('hide');
            } else if (response == 3) {
                   $("#modalEliminarCategoria").modal('hide');
                  notificacion("La categoria no se puede eliminar ya que posee un activo o articulo del inventario asociado"); 
                //$("#alertaSubTematicaNoEliminada").modal("show");
                //$("#modalEliminarSubTematica").modal('hide');
            } else {
                $("#cuerpoTablaTematica").html(response);
                $("#modalEliminarCategoria").modal('hide');
                notificacion("Categoria eliminada correctamente");
            }
        }
    });
}
// </editor-fold> 

function clickeado(event) {
    var clickeado = event.value;
  
    $.ajax({
        data: {'clickeado': clickeado
           },
        type: 'POST',
        url: '../control/SolicitudAjaxCategorias.php',
        success: function (response) {
            $("#cuerpoTablaTematica").html(response);
        }
    });
}
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

function validacionExpRegular(expresion) {
    var exp = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\s]+$/g;
    return (exp.test(expresion)) ? 'true' : 'false';
}
