
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

var Licencias = [];
var Repuestos = [];

function FormularioLicencia() {
//    var repuestos = document.getElementById("divLicencias")
//    var div = document.createElement("div");
//    div.id = "divLicencia" + Nlicencias;
//    repuestos.appendChild(div);
    var response = "<h4>Licencia</h4> <button type='button' class='close' aria-label='Close'  onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
            " <div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-3\" for=\"LfechaV\">Fecha  de vencimiento:</label>" +
            " <div class='input-group date col-sm-9' id='datetimepicker1'>" +
            "  <input type=\"text\" class=\"form-control\" name=\"fechaV\" id=\"LfechaV\" >" +
            " <span class=\"input-group-addon btn btn-info\" id=\"Vfecha\" onclick=\"document.getElementById('LfechaV').focus()\" >" +
            " <span class=\"glyphicon glyphicon-calendar\" ></span>" +
            "</span>" +
            " </div>" +
            "</div>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"LclaveP\">Clave de producto:</label>" +
            " <div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"LclaveP\" type=\"text\" required>" +
            " </div>" +
            " </div>" +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Lprovedor\">Provedor:</label>" +
            " <div class=\"col-sm-10\">" +
            "    <input class=\"form-control\" id=\"Lprovedor\" type=\"text\" required>" +
            " </div>" +
            "</div> " +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Ldescripcion\">Descripcion:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Ldescripcion\" type=\"text\" required>" +
            "</div>" +
            " </div> " +
           
            " </div><button id='aplicar' type='button' class='btn btn-success col-md-offset-2' onclick='AgregarLicencia()'> Aplicar </button>";
    $("#divAgregar").html(response);
    $(function () {
        var fecha = new Date()
        $('#LfechaV').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
        });
    });
    document.getElementById('aplicar').focus();

}
function FormularioRepuesto() {
//    var repuestos = document.getElementById("divRepuestos")
//    var div = document.createElement("div");
//    div.id = "divRepuesto" + Nrepuestos;
//    repuestos.appendChild(div);
    var response = " <h4>Repuesto</h4><button type='button' class='close' aria-label='Close' onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Rdescripcion0\">Descripción:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Rdescripcion\" type=\"text\" required>" +
            " </div>" +
            " </div> " +
            "<div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-2\" for=\"Rplaca\">Placa:</label>" +
            " <div class=\"col-sm-10\">" +
            "<input class=\"form-control\" id=\"Rplaca\" type=\"text\" required>" +
            " </div>" +
            "  </div><button  id='aplicar' type='button' class='btn btn-success col-md-offset-2'  onclick='AgregarRepuesto()' > Aplicar </button>";
    $("#divAgregar").html(response);
    document.getElementById('aplicar').focus();

}

function eliminarAgregar() {
    $("#divAgregar").html("");
}

function AgregarLicencia() {
    
//    if(Nlicencias==0){
//      $("#divLicencias").html("<h5>Licencias: </h5>"); 
//    }
     var licencia = [3];
    licencia[0] = document.getElementById("LfechaV").value;
    licencia[1] = document.getElementById("LclaveP").value;
    licencia[2] = document.getElementById("Lprovedor").value;
    licencia[3] = document.getElementById("Ldescripcion").value;
  
    Licencias[Nlicencias]=licencia;
    var a=$("#divLicencias").html(); 
    $("#divLicencias").html(a+"<button  id='licencia"+Nlicencias+"' type='button' class='btn btn-primary' onclick='verLicencia("+Nlicencias+")'   >"+licencia[3]+"</button>"+
    "<button type='button' class='btn btn-danger' onclick='eliminarLicencia("+Nlicencias+")'> <span aria-hidden='true'>&times;</span></button>\n"); 
    Nlicencias++;
     $("#divAgregar").html("");
}
function AgregarRepuesto() {
//    if(Nrepuestos==0){
//       $("#divRepuestos").html("<h5>Repuestos: </h5>"); 
//    }
    var repuesto = [2];
    repuesto[0]=document.getElementById("Rdescripcion").value;
    repuesto[1]=document.getElementById("Rplaca").value;
    Repuestos[Nrepuestos]=repuesto;
    var a=$("#divRepuestos").html(); 
    $("#divRepuestos").html(a+"<button  id='repuesto"+Nrepuestos+"' type='button' class='btn btn-primary ' onclick='verRepuesto("+Nrepuestos+")' >"+repuesto[0]+"</button>"+
    "<button type='button' class='btn btn-danger' onclick='eliminarRepuesto("+Nrepuestos+")' > <span aria-hidden='true'>&times;</span></button>\n"); 
    Nrepuestos++;
     $("#divAgregar").html("");
    
}
function eliminarLicencia(numero) {
    var licencia = document.getElementById("licencia"+numero);
 
	if (licencia){
            var equis=licencia.nextSibling;
	
		var padre = licencia.parentNode;
		padre.removeChild(licencia);
                padre.removeChild(equis);
                Licencias[numero]=null;
	}
}

function eliminarRepuesto(numero) {
    var repuesto = document.getElementById("repuesto"+numero); 
	if (repuesto){
            var equis=repuesto.nextSibling;
		padre = repuesto.parentNode;
		padre.removeChild(repuesto);
                padre.removeChild(equis);
                Repuestos[numero]=null;
	}

}

function verLicencia(numero){
      var licencia=Licencias[numero];
    var response="<h4>Licencia</h4> <button type='button' class='close' aria-label='Close'  onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
            " <div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-3\" for=\"LfechaV\">Fecha  de vencimiento:</label>" +
            " <div class='input-group date col-sm-9' id='datetimepicker1'>" +
            "  <input type=\"text\" class=\"form-control\" name=\"fechaV\" id=\"LfechaV\" value='"+licencia[0]+"' >" +
            " <span class=\"input-group-addon btn btn-info\" id=\"Vfecha\" onclick=\"document.getElementById('LfechaV').focus()\" >" +
            " <span class=\"glyphicon glyphicon-calendar\" ></span>" +
            "</span>" +
            " </div>" +
            "</div>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"LclaveP\">Clave de producto:</label>" +
            " <div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"LclaveP\" type=\"text\" value='"+licencia[1]+"' required>" +
            " </div>" +
            " </div>" +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Lprovedor\">Provedor:</label>" +
            " <div class=\"col-sm-10\">" +
            "    <input class=\"form-control\" id=\"Lprovedor\" type=\"text\" value='"+licencia[2]+"' required>" +
            " </div>" +
            "</div> " +
            " <div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Ldescripcion\">Descripcion:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Ldescripcion\" type=\"text\" value='"+licencia[3]+"' required>" +
            "</div>" +
            " </div> " +            
            " </div><button  id='aplicar' type='button' class='btn btn-success col-md-offset-2'  onclick='editarLicencia("+numero+")' > Editar </button>";
    $("#divAgregar").html(response);
    document.getElementById('aplicar').focus();
}

function verRepuesto(numero){
    var repuesto=Repuestos[numero];
     var response = " <h4>Repuesto</h4><button type='button' class='close' aria-label='Close' onclick='eliminarAgregar()'> <span aria-hidden='true'>&times;</span></button>" +
            "<div class=\"form-group  col-md-11\">" +
            "<label class=\"control-label col-sm-2\" for=\"Rdescripcion0\">Descripción:</label>" +
            "<div class=\"col-sm-10\">" +
            " <input class=\"form-control\" id=\"Rdescripcion\" type=\"text\" value='"+repuesto[0]+"' required>" +
            " </div>" +
            " </div> " +
            "<div class=\"form-group  col-md-11\">" +
            " <label class=\"control-label col-sm-2\" for=\"Rplaca\">Placa:</label>" +
            " <div class=\"col-sm-10\">" +
            "<input class=\"form-control\" id=\"Rplaca\" type=\"text\" value='"+repuesto[1]+"' required>" +
            " </div>" +
            "  </div><button  id='aplicar' type='button' class='btn btn-success col-md-offset-2'  onclick='editarRepuesto("+numero+")' > Editar </button>";
    $("#divAgregar").html(response);
    document.getElementById('aplicar').focus();
}

function editarLicencia(numero){
      var licencia = [3];   
    licencia[0] = document.getElementById("LfechaV").value;
    licencia[1] = document.getElementById("LclaveP").value;
    licencia[2] = document.getElementById("Lprovedor").value;
    licencia[3] = document.getElementById("Ldescripcion").value;
    if(Licencias[numero]!=null){
    Licencias[numero]=licencia;
    var boton =document.getElementById("licencia"+numero);    
    boton.innerHTML=licencia[3];
    }
     $("#divAgregar").html("");
}
function editarRepuesto(numero){
    
    var repuesto = [2];
    repuesto[0]=document.getElementById("Rdescripcion").value;
    repuesto[1]=document.getElementById("Rplaca").value;
     if(Repuestos[numero]!=null){
    Repuestos[numero]=repuesto;
     var boton =document.getElementById("repuesto"+numero);
     boton.innerHTML=repuesto[0];
     }
     $("#divAgregar").html("");
}
// </editor-fold>


