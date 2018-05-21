<html> 
    <head>
        <meta charset="UTF-8">
        <?php
        require_once ("../control/ArchivosDeCabecera.php");
        require ("../modelo/ProcedimientosPermisos.php");
        require ("../modelo/ProcedimientosTiquetes.php");
        ?>


        <link rel="stylesheet" href="../recursos/bootstrap/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="../recursos/css/reportesTiquetes.css" />
    </head>
    <body>   


        <h1>Login de Usuarios</h1>
       
        <div class="col-md-6 col-md-offset-3" >
 <h4>cristina>nubeblanca1997@outlook.com</h4>
        <h4>luis>francini113@gmail.com</h4>
        <h4>Alejandro>dannyalfvr97@gmail.com</4>          
        <h4>gina>gina@gmail.com</h4>
            <form action="checklogin.php" method="post" >
                <div class="form-group"  >
                    <label>Nombre Usuario:</label><br>
                    <div>
                        <input class="form-control" name="username" type="email" id="username" required> 
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-success" onclick="enviar();"> Login </button>
                </div>
            </form>

        </div>
        
        <script>
        function enviar(){
            var corre=document.getElementById("username").value;
            location.href='../vista/BandejasTiquetes.php?correo='+corre;
        }
        </script>

    </body>
</html> 

