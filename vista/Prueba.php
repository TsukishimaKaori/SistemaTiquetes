<html>
    <head>











    </head>
    <body>
        <?php
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime('-6 year', strtotime($fecha));
        $nuevafecha = date('Y-m-j', $nuevafecha);
        echo $nuevafecha;
        ?>
    </body>






</html>