
// <editor-fold defaultstate="collapsed" desc="Formulario">

function CargarPagina() {
    var div = document.getElementById("divAgregarRepuesto");
    div.style = "display: none";

    div = document.getElementById("divAgregar");
    div.style = "display: none";

    $(function () {
        var fecha = new Date()
        $('#fechaE').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
        });
    });
}

var Nrepuestos = 0;
var Nlicencias = 0;

var Licencias = [];
var Repuestos = [];

function FormularioLicencia() {
//    var repuestos = document.getElementById("divLicencias")
//    var div = document.createElement("div");
//    div.id = "divLicencia" + Nlicencias;
//    repuestos.appendChild(div);
    var div = document.getElementById("divAgregarRepuesto");
    div.style = "display: none"
    div = document.getElementById("divAgregar");
    div.style = "";
    var response = "<div class='form-group'><label class='control-label col-sm-2' for='LfechaV'>Licencias</label><button type='button' class='close' aria-label='Close' \n\
         onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button></div>" +
            " <div class=\"form-group  col-md-12\">" +
            " <label class=\"control-label col-sm-3\" for=\"LfechaV\">Fecha  de vencimiento:</label>" +
            " <div class='input-group date col-sm-9' id='datetimepicker1'>" +
            "  <input type=\"text\" class=\"form-control\" name=\"fechaV\" id=\"LfechaV\" >" +
            " <span class=\"input-group-addon btn btn-info\" id=\"Vfecha\" onclick=\"document.getElementById('LfechaV').focus()\" >" +
            " <span class=\"glyphicon glyphicon-calendar\" ></span>" +
            "</span>" +
            " </div>" +
            "</div>" +
            "<div class=\"form-group  col-md-12\">" +
            "<label class=\"control-label col-sm-2\" for=\"LclaveP\">Clave de producto:</label>" +
            " <div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"LclaveP\" type=\"text\" required>" +
            " </div>" +
            " </div>" +
            " <div class=\"form-group  col-md-12\">" +
            "<label class=\"control-label col-sm-2\" for=\"Lprovedor\">Proveedor:</label>" +
            " <div class=\"col-sm-10\">" +
            "    <input class=\"form-control\" id=\"Lprovedor\" type=\"text\" required>" +
            " </div>" +
            "</div> " +
            " <div class=\"form-group  col-md-12\">" +
            "<label class=\"control-label col-sm-2\" for=\"Ldescripcion\">Descripción:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Ldescripcion\" type=\"text\" required>" +
            "</div>" +
            " </div> " +
            " </div><button id='aplicarL' type='button' class='btn btn-success col-md-offset-2' onclick='AgregarLicencia()'> Aplicar </button>";
    $("#divAgregar").html(response);
    $(function () {
        var fecha = new Date()
        $('#LfechaV').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
        });
    });
    document.getElementById('aplicarL').focus();

}
function FormularioRepuesto() {
//    var repuestos = document.getElementById("divRepuestos")
//    var div = document.createElement("div");
//    div.id = "divRepuesto" + Nrepuestos;
//    repuestos.appendChild(div);
    var div = document.getElementById("divAgregarRepuesto");
    div.style = ""
    div = document.getElementById("divAgregar");
    div.style = "display: none";
    $("#divAgregar").html("");
    document.getElementById('aplicar').focus();

}

function eliminarAgregar() {
    div = document.getElementById("divAgregar");
    div.style = "display: none";
    $("#divAgregar").html("");
}
function eliminarAgregarRepuestos() {
    var div = document.getElementById("divAgregarRepuesto");
    div.style = "display: none";
}

function AgregarLicencia() {
  
    var licencia = [3];
    licencia[0] = document.getElementById("LfechaV").value;
    licencia[1] = document.getElementById("LclaveP").value;
    licencia[2] = document.getElementById("Lprovedor").value;
    licencia[3] = document.getElementById("Ldescripcion").value;
 if(licencia[0]!=="" &&licencia[1]!=="" && licencia[2]!=="" && licencia[3]!=="" ) {
    Licencias[Nlicencias] = licencia;
    var a = $("#divLicencias").html();
    $("#divLicencias").html(a + "<a id='licencia" + Nlicencias + "'  onclick='verLicencia(" + Nlicencias + ")'   class='list-group-item'>" +
            licencia[3] + "<button type='button' onclick='eliminarLicencia(" + Nlicencias + ")' class='btn btn-default'>" +
            "<span class='glyphicon glyphicon-remove'></span></button></a>");


    Nlicencias++;
    div = document.getElementById("divAgregar");
    div.style = "display: none";
    $("#divAgregar").html("");
    }
    else{
               $("#errorFormulario").modal("show");
    }
}
function AgregarRepuesto() {
    var select = document.getElementById("comboRepuestos");

    for ($i = 0; $i < select.childElementCount; $i++) {
        if (select[$i].selected == true && !document.getElementById("repuesto" + select[$i].value)) {
            var repuesto = [3];
            repuesto[0] = select[$i].value;
            repuesto[1] = select[$i].innerText;
            repuesto[2] = $i;
            Repuestos[Nrepuestos] = repuesto;

            var a = $("#divRepuestos").html();
            $("#divRepuestos").html(a + "<a id='repuesto" + repuesto[0] + "'  onclick='verRepuesto(" + Nrepuestos + ")'   class='list-group-item'>" +
                    repuesto[1] + "<button type='button' onclick='eliminarRepuesto(" + Nrepuestos + ")' class='btn btn-default'>" +
                    "<span class='glyphicon glyphicon-remove'></span></button></a>");


            Nrepuestos++;
        }
    }
    select = select.previousSibling.previousSibling;
    select.title = "seleccione";
    select.firstChild.innerText = "seleccione";
    var div = document.getElementById("divAgregarRepuesto");
    div.style = "display: none";

}
function eliminarLicencia(numero) {
    var licencia = document.getElementById("licencia" + numero);

    if (licencia) {
        var padre = licencia.parentNode;
        padre.removeChild(licencia);
        Licencias[numero] = null;
    }
}

function eliminarRepuesto(numero) {
    var codigo = Repuestos[numero][0];
    var repuesto = document.getElementById("repuesto" + codigo);
    if (repuesto) {

        padre = repuesto.parentNode;
        padre.removeChild(repuesto);


        var select = document.getElementById("comboRepuestos");
        select[Repuestos[numero][2]].selected = false;
        deseleccionar(Repuestos[numero][2]);
        Repuestos[numero] = null;
    }

}
function deseleccionar(numero) {
    var select = document.getElementById("comboRepuestos");
    select = select.previousSibling.firstChild.nextSibling;
    select = select.firstChild;
    var cont = 0;
    while (cont != numero) {
        select = select.nextSibling;
        cont++;
    }
    select.className = "";
}

function verLicencia(numero) {
    var licencia = Licencias[numero];
    if (licencia) {
        var response = "<h4>Licencia</h4> <button type='button' class='close' aria-label='Close'  onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
                " <div class=\"form-group  col-md-11\">" +
                " <label class=\"control-label col-sm-3\" for=\"LfechaV\">Fecha  de vencimiento:</label>" +
                " <div class='input-group date col-sm-9' id='datetimepicker1'>" +
                "  <input type=\"text\" class=\"form-control\" name=\"fechaV\" id=\"LfechaV\" value='" + licencia[0] + "' >" +
                " <span class=\"input-group-addon btn btn-info\" id=\"Vfecha\" onclick=\"document.getElementById('LfechaV').focus()\" >" +
                " <span class=\"glyphicon glyphicon-calendar\" ></span>" +
                "</span>" +
                " </div>" +
                "</div>" +
                "<div class=\"form-group  col-md-11\">" +
                "<label class=\"control-label col-sm-2\" for=\"LclaveP\">Clave de producto:</label>" +
                " <div class=\"col-sm-10\">" +
                " <input class=\"form-control\" id=\"LclaveP\" type=\"text\" value='" + licencia[1] + "' required>" +
                " </div>" +
                " </div>" +
                " <div class=\"form-group  col-md-11\">" +
                "<label class=\"control-label col-sm-2\" for=\"Lprovedor\">Proveedor:</label>" +
                " <div class=\"col-sm-10\">" +
                "    <input class=\"form-control\" id=\"Lprovedor\" type=\"text\" value='" + licencia[2] + "' required>" +
                " </div>" +
                "</div> " +
                " <div class=\"form-group  col-md-11\">" +
                "<label class=\"control-label col-sm-2\" for=\"Ldescripcion\">Descripción:</label>" +
                "<div class=\"col-sm-10\">" +
                " <input class=\"form-control\" id=\"Ldescripcion\" type=\"text\" value='" + licencia[3] + "' required>" +
                "</div>" +
                " </div> " +
                " </div><button  id='aplicarL' type='button' class='btn btn-success col-md-offset-2'  onclick='editarLicencia(" + numero + ")' > Editar </button>";
        $("#divAgregar").html(response);
        div = document.getElementById("divAgregar");
        div.style = "";
        document.getElementById('aplicarL').focus();
    }
}

function verRepuesto(numero) {

    var repuesto = Repuestos[numero];
    if (repuesto) {
        var div = document.getElementById("divAgregarRepuesto");
        div.style = "display: none";
        div = document.getElementById("divAgregar");
        div.style = "";
        var response = " <h4>Repuesto</h4><button type='button' class='close' aria-label='Close' onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
                "<div class=\"form-group  col-md-11\">" +
                "<label class=\"control-label col-sm-2\" for=\"Rdescripcion0\">Código:</label>" +
                "<div class=\"col-sm-10\">" +
                " <input class=\"form-control\" id=\"Rdescripcion\" type=\"text\" value='" + repuesto[0] + "' readonly>" +
                " </div>" +
                " </div> " +
                "<div class=\"form-group  col-md-11\">" +
                " <label class=\"control-label col-sm-2\" for=\"Rplaca\">Descripción:</label>" +
                " <div class=\"col-sm-10\">" +
                "<input class=\"form-control\" id=\"Rplaca\" type=\"text\" value='" + repuesto[1] + "' readonly>" +
                " </div>" +
                "  </div>";
        $("#divAgregar").html(response);
        document.getElementById('Rplaca').focus();
    }
}

function editarLicencia(numero) {
    var licencia = [3];
    licencia[0] = document.getElementById("LfechaV").value;
    licencia[1] = document.getElementById("LclaveP").value;
    licencia[2] = document.getElementById("Lprovedor").value;
    licencia[3] = document.getElementById("Ldescripcion").value;
    if(licencia[0]!=="" &&licencia[1]!=="" && licencia[2]!=="" && licencia[3]!=="" ) {
    if (Licencias[numero] != null) {
        Licencias[numero] = licencia;
        var boton = document.getElementById("licencia" + numero);
        boton.innerHTML = licencia[3] + "<button type='button' onclick='eliminarLicencia(" + numero + ")' class='btn btn-default'>" +
                "<span class='glyphicon glyphicon-remove'></span></button>";
    }
    div = document.getElementById("divAgregar");
    div.style = "display: none";
    $("#divAgregar").html("");
    }else{
               $("#errorFormulario").modal("show");
    }
}



// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Agregar activo">
function agregarActivo() {

    if (!lleno()) {
        $("#errorFormulario").modal("show");

    } else {
        $("#confirmarAsociar").modal("show");

    }
}
function lleno() {
    var placa = document.getElementById("placa").value
    var serie = document.getElementById("serie").value;
    var provedor = document.getElementById("provedor").value;
    var modelo = document.getElementById("modelo").value;
    var marca = document.getElementById("marca").value;
    var fechaE = document.getElementById("fechaE").value;
    if (placa != "" && serie != "" && provedor != "" && modelo != "" && marca != "" && fechaE != "") {
        return true;
    }
    return false;
}
function agregarActivoAjax() {
    var codigo = document.getElementById("codigoA").innerHTML;
    var codigoCategoria = document.getElementById("codigoC").value;
    var placa = document.getElementById("placa").value
    var UsuarioAsociado = document.getElementById("Usuarios").value;
    var serie = document.getElementById("serie").value;
    var provedor = document.getElementById("provedor").value;
    var modelo = document.getElementById("modelo").value;
    var marca = document.getElementById("marca").value;
    var fechaE = document.getElementById("fechaE").value;

    $.ajax({
        type: "POST",
        url: '../control/SolicitudAjajxAgregarActivos.php',
        data: {'Licencias': JSON.stringify(Licencias), 'Repuestos': JSON.stringify(Repuestos), 'codigo': codigo, 'placa': placa, 'usuarioA': UsuarioAsociado,
            'serie': serie, 'provedor': provedor, 'modelo': modelo, 'marca': marca, 'codigoC': codigoCategoria, 'fechaE': fechaE}, //capturo array     
        success: function (reponse) {
            $("#confirmarAsociar").modal("hide");
            var separador = "-";
            var arregloDeSubCadenas = reponse.split(separador);
            var mensageA = "asociado";
            var mensageL = "asociado";
            var mensageE = "asociado";
            document.getElementById("aceptar").onclick = function () {
                document.location.href = "../vista/AdministrarInventario.php?tab=1";
            }
            if (arregloDeSubCadenas[0] != "") {
                mensageA = "Error al asociar";
                mensageL = "Error al asociar";
                mensageE = "Error al asociar";
                document.getElementById("aceptar").onclick = "";
            } else {
                if (arregloDeSubCadenas[1] == "nada") {
                    mensageL = "sin licencias";
                } else if (arregloDeSubCadenas[1] != "") {
                    mensageL = "Error al asociar";
                }
                if (arregloDeSubCadenas[2] == "nada") {
                    mensageE = "sin repuestos";
                } else if (arregloDeSubCadenas[2] != "") {
                    mensageE == "Error al asociar";
                }
            }


            var mensage = '<h3>Informacion general: </h3>' +
                    '<div class="form-group  col-md-11"><label class="control-label  col-sm-4"> Equipo:</label>' +
                    '<span id="codigoA" class=" col-md-8">' + mensageA + ' </span> </div>' +
                    '<div class="form-group  col-md-11"><label class="control-label  col-sm-4" >Licencias:</label>' +
                    '<span class=" col-md-8">' + mensageL + ' </span> </div>' +
                    '<div class="form-group  col-md-11"><label class="control-label  col-sm-4" >Repuestos:</label>' +
                    '<span class=" col-md-8" >' + mensageE + ' </span> </div>';

            document.getElementById("errorDiv").innerHTML = mensage;
            $("#errorInfo").modal("show");
        }
    });
}
// </editor-fold>