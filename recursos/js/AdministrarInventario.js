$(document).ready(function () {
    var tab = document.getElementById("tabInventario").value;
    var evt;
    if (tab == 1) {       
        evt = document.getElementById("link-activos");
        abrir_tab_inventario(evt, 'tab-activos');
      
    } else if (tab == 2) {
         evt = document.getElementById("link-pasivos");
          abrir_tab_inventario(evt, 'tab-pasivos');
    } else if (tab == 3) {
         evt = document.getElementById("link-licencias");
          abrir_tab_inventario(evt, 'tab-licencias'); 
    } else if (tab == 4) {
         evt = document.getElementById("link-repuestos");
          abrir_tab_inventario(evt, 'tab-repuestos'); 
    }
    
    
});

function abrir_tab_inventario(evt, id) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(id).style.display = "block";
    evt.className += " active";

}

