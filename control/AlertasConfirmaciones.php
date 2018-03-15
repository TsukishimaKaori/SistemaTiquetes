<?php

function notificacion() {
    echo ' <div style = "display:none;text-align:center" id = "divNotificacion" class="notificacion content alert alert-info">'
    . '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
    .'</br>'
    . '</div>';
}

function alerta($idDiv, $mensaje, $onclick) {
    echo ' <div id="' . $idDiv . '" class = "modal fade" data-backdrop="static" data-keyboard="false"  >' .
    ' <div class="modal-dialog modal-sm"> ' .
    '  <div class="modal-content">     ' .
    '     <div class="modal-body"> ' .
    '         <div class="row">    ' .
    '             <div class="" style ="text-align: center"> ' .
    '                 <h4> ' . $mensaje . ' </h4>' .
    '             </div> ' .
    '         </div>' .
    '     </div>' .
    '     <div class="modal-footer">';
    if ($onclick != '') {
        echo '<button type="button" class= "btn btn-success" data-dismiss="modal" onclick = "' . $onclick . '">Aceptar</button>';
    } else {
        echo '<button type="button" class= "btn btn-success" data-dismiss="modal">Aceptar</button>';
    }
    echo '</div>' .
    ' </div>' .
    ' </div>' .
    ' </div>';
}

function confirmacion($idDiv, $mensaje, $onclick, $onclickCancelar) {
    echo
    ' <div id="' . $idDiv . '" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">' .
    '        <div class="modal-dialog modal-sm ">               ' .
    '            <div class="modal-content">                    ' .
    '                <div class="modal-body">                   ' .
    '                    <div class="row">                      ' .
    '                        <div style ="text-align: center" id="tiquete"> ' .
    '                            <h4> ' . $mensaje . '</h4>' .
    '                        </div> ' .
    '                    </div>' .
    '                    <!--   <div class="modal-backdrop fade in"></div>-->' .
    '                    <!--    </body>-->' .
    '                </div>' .
    '                <div class="modal-footer">' .
    '         <button class="btn btn-success" onclick="' . $onclick . '"> Aceptar</button> ';
    if ($onclickCancelar != '') {
        echo '<button type="button" class="btn btn-danger"  onclick="' . $onclickCancelar . '">Cancelar</button>';
    } else {
        echo '<button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>';
    }
    echo '</div>' .
    '</div>' .
    '</div>' .
    '</div>';
}

function enviarCorreo($para, $tematica, $mensaje) {
    $to = $para;
    $subject = $tematica;
    //$to = "francini113@gmail.com";
    //$tema = "Pedido de Materiales";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $message = $mensaje;
   mail($to, $subject, $message, $headers);
  
}

//pagina: AdminsitracionRolesPermisosUsuarios.php 
//Alertas de eliminar ROL
if (isset($_GET['alertaEliminarRol'])) {

    echo "<script>" .
    "  $(function(){";
    if ($_GET['alertaEliminarRol'] == 1) {
        echo "       $('#alertaEliminarRol').modal('show'); " .
        "});";
    } else if ($_GET['alertaEliminarRol'] == 2) {
        echo "       $('#alertaEliminarRolFallido').modal('show'); " .
        "});";
    } else if ($_GET['alertaEliminarRol'] == 3) {
        echo "       $('#alertaEliminarRolFallidoAdmin').modal('show'); " .
        "});";
    }
    echo "</script>";
}



//pagina: AdminsitracionRolesPermisosUsuarios.php 
//Alertas del agregar ROL
if (isset($_GET['alertaRolAgregado'])) {
    echo "<script>" .
    "  $(function(){";
    if ($_GET['alertaRolAgregado'] == 1) {
        echo "$('#alertaRolAgregado').modal('show'); " .
        "});";
    }
    echo "</script>";
}



//pagina: AdminsitracionRolesPermisosUsuarios.php 
//Alertas de guardar cambios al modificar los permisos de un rol
if (isset($_GET['alertaPermisosModificados'])) {
    echo "<script>" .
    "  $(function(){";
    if ($_GET['alertaPermisosModificados'] == 1) {
        echo "$('#alertaPermisosModificados').modal('show'); " .
        "});";
    }
    echo "</script>";
}

