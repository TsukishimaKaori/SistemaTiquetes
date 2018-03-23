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
        <?php require ("../vista/Cabecera.php");
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        } else {
            $tab = 1;
        }
        ?>
        <input id = 'tabInventario' type="hidden" value ='<?php echo $tab ?>' >
        <div class="container-fluid">
            <div class="row">                
                <div class="col-md-7">
                    <div id="tab-indice" class="tab">
                        
                        <button id = "link-pasivos" class="tablinks" onclick="abrir_tab_inventario(this, 'tab-pasivos')" id="defaultOpen">Pasivos</button>
                        <button id = "link-activos"  class="tablinks" onclick="abrir_tab_inventario(this, 'tab-activos')" >Activos</button>                        
                        <button id = "link-licencias"  class="tablinks" onclick="abrir_tab_inventario(this, 'tab-licencias')">Licencias</button>
                        <button id = "link-repuestos"  class="tablinks" onclick="abrir_tab_inventario(this, 'tab-repuestos')">Repuestos</button>
                    </div>                                   
                    <section id="tab-pasivos" class="tabcontent">
                        <h2>Pasivos</h2>
                        <div class="container-fluid">
                            <div class="row">                                                           
                                <div id ="" class="col-md-10"></div>                
                                <div class="row">                                             
                                    <div class="col-md-offset-10">                   
                                        <a href="../vista/AgregarDispositivo.php">  <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>    </a>     
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-offset-12">&nbsp;</div>
                                </div>
                                <div class="row">                                
                                    <div class="col-md-12 ">
                                        <div class="table table-responsive">  
                                            <table class="table table-hover">
                                                <thead>
                                                    <?php cabeceraTablaPasivos(); ?>                                 
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
                    <section id="tab-activos" class="tabcontent tab-oculto">
                        <h2>Activos</h2>
                        <div class="container-fluid">
                            <div class="row">                                               
                                <div class="col-md-offset-10">                    
                                    <a href="../vista/AgregarDispositivo.php">   <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>   </a>      
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-offset-12">&nbsp;</div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover">
                                            <thead>
                                                <?php cabeceraTablaActivos(); ?>                                 
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
                        <h2>Licencias</h2>
                        <div class="container-fluid">
                            <div class="row">                                               
                                <div class="col-md-offset-10">                    
                                    <a href="../vista/AgregarDispositivo.php">  <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button>   </a>      
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-offset-12">&nbsp;</div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover">
                                            <thead>
                                                <?php cabeceraTablaActivos(); ?>                                 
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
                    <section id="tab-repuestos" class="tabcontent tab-oculto">
                        <h2>Repuestos</h2>
                        <div class="container-fluid">
                            <div class="row">                                               
                                <div class="col-md-offset-10">                    
                                    <a href="../vista/AgregarDispositivo.php">  <button type="button" class="btn btn-success  btn-circle btn-xl" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-plus"></i></button> </a>        
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-offset-12">&nbsp;</div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 ">
                                    <div class="table table-responsive">  
                                        <table class="table table-hover">
                                            <thead>
                                                <?php cabeceraTablaActivos(); ?>                                 
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
                </div>
                <div class="col-md-5">                   
                    <div class="panel panel-default">
                        <div class="panel-heading">Especificaciones</div>
                        <div class="panel-body">hola hola</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
