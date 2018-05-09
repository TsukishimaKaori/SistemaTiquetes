 <?php


// <editor-fold defaultstate="collapsed" desc="FormularioDispositivos">
function FormularioDispositivos() {
                            echo' 
                        
                            <h1> Agregar Dispositivo </h1>
                            <div class="form-group Midiv">
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(1);"><i class="glyphicon glyphicon-plus"></i>Dispositivo</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(2);"><i class="glyphicon glyphicon-plus"></i>Licencia</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(3);"><i class="glyphicon glyphicon-plus"></i>Repuesto</button>
                        </div>
                            
                            <div class="form-group  col-md-11 ">
                                <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                                <div class="col-sm-10">';
                             selectTipos($tipos);
                         echo'  </div>
                            </div>

                            <div class="form-group  col-md-11">
                                <label class="control-label col-sm-2" for="placa">Placa:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="placa" type="text" required>
                                </div>
                            </div>
                            <div class="form-group col-md-11">
                                <label class="control-label col-sm-2" for="serie">Serie:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="serie" type="text" required>
                                </div>
                            </div>
                            <div class="form-group col-md-11">
                                <label class="control-label col-sm-2" for="provedor">Proveedor:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="provedor" type="text" required>
                                </div>
                            </div>
                            <div class="form-group col-md-11">
                                <label class="control-label col-sm-2" for="modelo">Modelo:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modelo" type="text" required>
                                </div>
                            </div>
                            <div class="form-group col-md-11">
                                <label class="control-label col-sm-2" for="marca">Marca:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="marca" type="text" required>
                                </div>
                            </div>
                            <div class="form-group col-md-11">
                                <label class="control-label col-sm-2" for="precio">Precio:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="precio" type="text" required>
                                </div>
                            </div>' ;
}

function selectTipos($tipos) {
    echo'<select class="form-control">';
    echo'<option>opciones</option>';
    foreach ($tipos as $tipo) {
        echo'<option>Tipo</option>';
    }
    echo'</select>';
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="FormularioLicencias">
function FormularioLicencias() {
                      echo'
                        <h1> Agregar Licencia </h1>
                        <div class="form-group Midiv">
                          <button type="button" class="btn btn-primary" onclick="CargarFomulario(1);"><i class="glyphicon glyphicon-plus"></i>Dispositivo</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(2);"><i class="glyphicon glyphicon-plus"></i>Licencia</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(3);"><i class="glyphicon glyphicon-plus"></i>Repuesto</button>
                        </div>

                        <div class="form-group  col-md-11 ">
                            <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="descripcion" type="text" required>
                            </div>
                        </div>

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="cantidad">Cantidad:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="cantidad" type="number"  min=0 required>
                            </div>
                        </div>
                        <div class="form-group col-md-11">
                            <label class="control-label col-sm-2" for="claveP">Clave Producto:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="claveP" type="text" required>
                            </div>
                        </div>
                        <div class="form-group col-md-11">
                            <label class="control-label col-sm-2" for="provedor">Proveedor:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="provedor" type="text" required>
                            </div>
                        </div>';
                   
}


// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="FormularioRepuestos">
function FormularioRepuestos() {
                     echo' 

                        <h1> Agregar Repuesto </h1>
                        <div class="form-group Midiv">
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(1);"><i class="glyphicon glyphicon-plus"></i>Dispositivo</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(2);"><i class="glyphicon glyphicon-plus"></i>Licencia</button>
                            <button type="button" class="btn btn-primary" onclick="CargarFomulario(3);"><i class="glyphicon glyphicon-plus"></i>Repuesto</button>
                        </div>

                        <div class="form-group  col-md-11 ">
                            <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="descripcion" type="text" required>
                            </div>
                        </div>

                        <div class="form-group  col-md-11">
                            <label class="control-label col-sm-2" for="cantidad">Cantidad:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="cantidad" type="number"  min=0 required>
                            </div>
                        </div>'; 
}


// </editor-fold>

