
// <editor-fold defaultstate="collapsed" desc="Formulario">
$(function () {
    var fecha = new Date()
    $('#fechaE').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es',
    });
});

var Nrepuestos = 0;
var Nlicencias = 0;
function AgregarLicencia() {
    var repuestos = document.getElementById("divLicencias")
    var div = document.createElement("div");
    div.id = "divLicencia" + Nlicencias;
    repuestos.appendChild(div);
    var response = "<h4>Licencia</h4> <button type='button' class='close' aria-label='Close'  onclick='eliminarLicencia("+Nlicencias+")'> <span aria-hidden='true'>&times;</span></button>"+
            " <div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-3\" for=\"LfechaV" + Nlicencias + "\">Fecha  de vencimiento:</label>" +
            " <div class='input-group date col-sm-9' id='datetimepicker1'>" +
            "  <input type=\"text\" class=\"form-control\" name=\"fechaV" + Nlicencias + "\" id=\"LfechaV" + Nlicencias + "\" >" +
            " <span class=\"input-group-addon btn btn-info\" id=\"Vfecha" + Nlicencias + "\" onclick=\"document.getElementById('LfechaV" + Nlicencias + "').focus()\" >" +
            " <span class=\"glyphicon glyphicon-calendar\" ></span>" +
            "</span>" +
            " </div>" +
            "</div>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"LclaveP" + Nlicencias + "\">Clave de producto:</label>" +
            " <div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"LclaveP" + Nlicencias + "\" type=\"text\" required>" +
            " </div>" +
            " </div>" +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Lprovedor" + Nlicencias + "\">Provedor:</label>" +
            " <div class=\"col-sm-10\">" +
            "    <input class=\"form-control\" id=\"Lprovedor" + Nlicencias + "\" type=\"text\" required>" +
            " </div>" +
            "</div> " +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Ldescripcion" + Nlicencias + "\">Descripcion:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Ldescripcion" + Nlicencias + "\" type=\"text\" required>" +
            "</div>" +
            " </div> " +
            "<div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-2\" for=\"Lplaca" + Nlicencias + "\">Placa:</label>" +
            " <div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Lplaca" + Nlicencias + "\" type=\"text\" required>" +
            "</div>" +
            " </div>";
    $("#divLicencia" + Nlicencias).html(response);
    $(function () {
        var fecha = new Date()
        $('#LfechaV' + Nlicencias).datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
        });
    });
    Nlicencias++;
}
function AgregarRepuesto() {
    var repuestos = document.getElementById("divRepuestos")
    var div = document.createElement("div");
    div.id = "divRepuesto" + Nrepuestos;
    repuestos.appendChild(div);



    var response = " <h4>Repuesto</h4><button type='button' class='close' aria-label='Close' onclick='eliminarRepuesto("+Nrepuestos+")'> <span aria-hidden='true'>&times;</span></button>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Rdescripcion0\">Descripción:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Rdescripcion" + Nrepuestos + "\" type=\"text\" required>" +
            " </div>" +
            " </div> " +
            "<div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-2\" for=\"Rplaca" + Nrepuestos + "\">Placa:</label>" +
            " <div class=\"col-sm-10\">" +
            "<input class=\"form-control\" id=\"Rplaca" + Nrepuestos + "\" type=\"text\" required>" +
            " </div>" +
            "  </div> ";
    $("#divRepuesto" + Nrepuestos).html(response);
    Nrepuestos++;
}

function eliminarLicencia(numero){
    var licencias = document.getElementById("divLicencias");
    licencias.removeChild(document.getElementById("divLicencia" + numero));
}

function eliminarRepuesto(numero){
    var repuestos = document.getElementById("divRepuestos")
      repuestos.removeChild(document.getElementById("divRepuesto" + numero));
}
// </editor-fold>


