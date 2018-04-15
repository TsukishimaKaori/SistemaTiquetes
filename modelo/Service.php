<?php

//http://localhost/sistemaTicketing/modelo/Service.php?metodo=1&correo=%27nubeblanca1997@outlook.com%27
//http://localhost/sistemaTicketing/modelo/Service.php?metodo=2
if(isset($_GET['metodo']) ) {
    $metodo = intval($_GET['metodo']);
    
    $serverName = "TATIANA\SQLEXPRESS02";
    $connectionOptions = array("Database" => "SistemaTiquetes", "UID" => "dbatiquetes", "PWD" => "dbatiquetes");
    $conn = sqlsrv_connect($serverName, $connectionOptions);
            
    if($metodo == 1){
        if(isset($_GET['correo']) ){
            $correo = $_GET['correo'];
            $tsql = "{call PAobtenerDatosUsuario (?) }";
            $params = array(array($correo, SQLSRV_PARAM_IN));
            $getMensaje = sqlsrv_query($conn, $tsql, $params);
            if ($getMensaje == FALSE) {
                sqlsrv_free_stmt($getMensaje);
                die();
            }
            $usuarios = array();
            while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {            
                $nombreUsuario = utf8_encode($row['nombreUsuario']);
                $departamento = utf8_encode($row['departamento']);
                $jefatura = utf8_encode($row['jefatura']);
                $correo = utf8_encode($row['correo']);
                $codigoEmpleado = utf8_encode($row['codigoEmpleado']);
                $numeroCedula = $row['numeroCedula'];
                $usuarios[] = $nombreUsuario;
                $usuarios[] = $departamento;
                $usuarios[] = $jefatura;
                $usuarios[] = $correo;
                $usuarios[] = $codigoEmpleado;
                $usuarios[] = $numeroCedula;
            }
        }
    } else if($metodo = 2){
        $tsql = "{call PAobtenerUsuariosParaAsociar }";
        $getMensaje = sqlsrv_query($conn, $tsql);
        if ($getMensaje == FALSE) {
            sqlsrv_free_stmt($getMensaje);
            die();
        }
        $usuarios = array();
        while ($row = sqlsrv_fetch_array($getMensaje, SQLSRV_FETCH_ASSOC)) {  
            $usuario = array();
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $departamento = utf8_encode($row['departamento']);
            $jefatura = utf8_encode($row['jefatura']);
            $correo = utf8_encode($row['correo']);
            $codigoEmpleado = utf8_encode($row['codigoEmpleado']);
            $numeroCedula = $row['numeroCedula'];
            $usuario[] = $nombreUsuario;
            $usuario[] = $departamento;
            $usuario[] = $jefatura;
            $usuario[] = $correo;
            $usuario[] = $codigoEmpleado;
            $usuario[] = $numeroCedula;
            $usuarios[] = $usuario;
        }
    }
            

    
    sqlsrv_free_stmt($getMensaje);


        $format = 'json';
        /* formateamos el resultado */
    if($format == 'json') {
        header('Content-type: application/json');
        echo json_encode(array('usuarios'=>$usuarios));
    }


        /* nos desconectamos de la bd */
        //@mysql_close($link);
        sqlsrv_close($conn);
}

