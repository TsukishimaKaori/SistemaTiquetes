<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <?php require_once ("../control/ArchivosDeCabecera.php"); ?>
        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <script src="../recursos/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script src="../recursos/bootstrap/js/es.js"></script>   
        <script src="../recursos/js/AdministrarInventario.js"></script>   
        <link href="../recursos/css/inventario.css" rel="stylesheet"/> 
        <?php require ("../control/AdministrarTablaInventario.php"); ?>
    </head>
    <body>
        <?php require ("../vista/Cabecera.php"); ?>          
 

>>>>>>> THEIRS
        <div class="container-fluid">
            <div class="row">
                <div class=""></div>
                <div class="col-md-12">
                    <div id="tab-indice" class="tab">
                        <button class="tablinks" onclick="abrir_tab_inventario(this, 'tab-activos')" id="defaultOpen">Activos</button>
                        <button class="tablinks" onclick="abrir_tab_inventario(this, 'tab-pasivos')" >Pasivos</button>                        
                        <button class="tablinks" onclick="abrir_tab_inventario(this, 'tab-licencias')">Licencias</button>
                        <button class="tablinks" onclick="abrir_tab_inventario(this, 'tab-repuestos')">Repuestos</button>
                    </div>                                   
                    <section id="tab-activos" class="tabcontent">
                        <h1>Pasivos</h1>
                        <div class="container-fluid">
                            <div class="row">                                                           
                                <div id ="" class="col-md-10"></div>                
                            <div class="row">
                                <div class="col-md-2"></div>                                
                                <div id ="" class="col-md-6"></div>                
                                <div class="col-md-2">                    
                                    <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i>Agregar activo</button>         
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover">
                                            <thead>
                                                <?php cabeceraTablaPasivos();?>                                 
                                            </thead>
                                            <tbody>
                                                <?php ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="tab-pasivos" class="tabcontent tab-oculto">
                        <h1>Activos</h1>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-2"></div>                                
                                <div id ="" class="col-md-6"></div>                
                                <div class="col-md-2">                    
                                    <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>         
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover">
                                            <thead>
                                                <?php cabeceraTablaActivos();?>                                 
                                            </thead>
                                            <tbody>
                                                <?php ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="tab-licencias" class="tabcontent tab-oculto">
                        <h1>Licencias</h1>
                        <div class="container-fluid">
                            <div class="row">                               
                            </div>
                            <div class="row">  
                                <div class=""></div>                               
                            </div>
                        </div>
                    </section>
                    <section id="tab-repuestos" class="tabcontent tab-oculto">
                        <h1>Repuestos</h1>
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
