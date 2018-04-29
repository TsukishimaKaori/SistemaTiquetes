<?php

class Conexion {

    private function __construct() {
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionOptions);
        if (!$this->conn) {
            $this->conn = -1;
        }
    }

    public static function getInstancia() {
        if (!self::$conn) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    public static function cerrar() {
        sqlsrv_close(self::$conn);
        self::$instancia = null;
    }

    public function getConn() {
        return $this->conn;
    }


   //  private $serverName = "DANNY\SQLEXPRESS01";
    private $serverName = "DESKTOP-HFVR94I\SQLEXPRESS01";     
   // private $serverName = "TATIANA\SQLEXPRESS02";
    //Conexion para el hosting gratuito
    //private $serverName = "den1.mssql5.gear.host"; 
    //private $connectionOptions = array("Database" => "sistemaTiquetes", "UID" => "sistematiquetes", "PWD" => "Be503V3cU9?_");
    //--------------------------------------------------------------------------
    
    private $connectionOptions = array("Database" => "SistemaTiquetes", "UID" => "dbatiquetes", "PWD" => "dbatiquetes");
    private static $instancia = null;
    private static $conn;
    
}
