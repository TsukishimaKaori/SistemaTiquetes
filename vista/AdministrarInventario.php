<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require_once ("../control/ArchivosDeCabecera.php");   ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>   
        <link href="../recursos/css/inventario.css" rel="stylesheet"/> 
    </head>
    <body>           
        <?php require ("../vista/Cabecera.php"); ?>   
        
        <div class="container-fluid">
            <div class="row">
                <div class=""></div>
                <div class="col-md-12">
                    <div id="tab-indice" class="tab">
                        <button class="tablinks" onclick="abrirTab(event, 'admin-empresas')" id="defaultOpen">Activos</button>
                        <button class="tablinks" onclick="abrirTab(event, 'admin-rutas')" >Pasivos</button>                        
                        <button class="tablinks" onclick="abrirTab(event, 'admin-buses')">Licencias</button>
                        <button class="tablinks" onclick="abrirTab(event, 'admin-buses')">Repuestos</button>
                    </div>                                   
                    <section id="admin-empresas" class="tabcontent">
                        <h1>Inventario</h1>
                        <div class="container-fluid">
                            <div class="row">
                               
                            </div>
                            <div class="row">  
                                <div class=""></div>
                               
                            </div>
                        </div>
                    </section>
                   
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        
        
        
        
    </body>
</html>