

// <editor-fold defaultstate="collapsed" desc="Formulario">
function CargarFomulario(formulario){
     $("#Inventario").load('../vista/AgregarInventario.php?for=' + formulario+' #Inventario');       
     fechas(formulario);
}

function fechas(formulario){
    if(formulario==2){
   document.getElementById("divfechaC").className="form-group col-md-11"
   document.getElementById("divfechaV").className="form-group col-md-11"
    }else{
   document.getElementById("divfechaC").className="form-group col-md-11 oculto"
   document.getElementById("divfechaV").className="form-group col-md-11 oculto"
    }
}


$(function () {
  
    var fecha= new Date()  
    $('#fechaC').datetimepicker({
        minDate:fecha.setDate( fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es',
    });
});
$(function () {
    var fecha= new Date()  
    $('#fechaV').datetimepicker({
        minDate:fecha.setDate( fecha.getDate() - 1),
        format: 'DD/MM/YYYY',
        locale: 'es',
    });
});

// </editor-fold>