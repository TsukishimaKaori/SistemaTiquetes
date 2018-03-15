<?php

class Tiquete {

    public function __construct($coTique, $coUsu, $nomUsu, $es, $respo, $are, $tema, $feCrea, $feFina, $feCali,
            $feCoti, $fePro, $descrip, $cali, $hora, $depU, $jefU, $pri, $feEn) {
        $this->codigoTiquete = $coTique;  //codigo utilizado
        $this->codigoUsuarioIngresaTiquete = $coUsu;
        $this->nombreUsuarioIngresaTiquete = $nomUsu;
        $this->estado = $es; //objeto de la clase Estado
        $this->responsable = $respo; //objeto de la clase Responsable
        $this->area = $are; //objeto de la clase Area
        $this->tematica = $tema; //objeto de la clase Tematica
        $this->fechaCreacion = $feCrea;
        $this->fechaFinalizado = $feFina;
        $this->fechaCalificado = $feCali;
        $this->fechaCotizado = $feCoti;
        $this->fechaEnProceso = $fePro;
        $this->fechaEntrega =$feEn;
        $this->descripcion = $descrip;
        $this->calificacion = $cali;
        $this->horasTrabajadas = $hora;
        $this->departamentoUsuarioSolicitante = $depU;
        $this->jefaturaUsuarioSolicitante = $jefU;
        $this->prioridad = $pri;
    }

    public function obtenerCodigoTiquete(){
        return $this->codigoTiquete;
    }
    
    public function obtenerCodigoUsuarioIngresaTiquete(){
        return $this->codigoUsuarioIngresaTiquete;
    }
    
    public function obtenerNombreUsuarioIngresaTiquete(){
        return $this->nombreUsuarioIngresaTiquete;
    }
    
    public function obtenerEstado(){
        return $this->estado;
    }
    
    public function obtenerResponsable(){
        return $this->responsable;
    }
    
    public function obtenerArea(){
        return $this->area;
    }
    
    public function obtenerFechaCreacion(){
        return $this->fechaCreacion;
    }

    public function obtenerFechaFinalizado(){
        return $this->fechaFinalizado;
    }
    
    public function obtenerFechaCalificado(){
        return $this->fechaCalificado;
    }
    
    public function obtenerFechaCotizado(){
        return $this->fechaCotizado;
    }
    
    public function obtenerFechaEnProceso(){
        return $this->fechaEnProceso;
    }
    
    public function obtenerDescripcion(){
        return $this->descripcion;
    }
    
    public function obtenerCalificacion(){
        return $this->calificacion;
    }
    
    public function obtenerHorasTrabajadas(){
        return $this->horasTrabajadas;
    }
    
    public function obtenerTematica(){
        return $this->tematica;
    }
    
    public function obtenerDepartamentoUsuarioSolicitante(){
        return $this->departamentoUsuarioSolicitante;
    }
    
    public function obtenerJefaturaUsuarioSolicitante(){
        return $this->jefaturaUsuarioSolicitante;
    }
    
    public function obtenerPrioridad(){
        return $this->prioridad;
    }
    
    public function obtenerFechaEntrega(){
        return $this->fechaEntrega;
    }
    
    private $codigoTiquete;  //codigo utilizado
    private $codigoUsuarioIngresaTiquete;
    private $nombreUsuarioIngresaTiquete;
    private $estado; //objeto de la clase Estado
    private $responsable; //objeto de la clase Responsable
    private $area; //objeto de la clase Area
    private $tematica; //objeto de la clase Tematica
    private $fechaCreacion;
    private $fechaFinalizado;
    private $fechaCalificado;
    private $fechaCotizado;
    private $fechaEnProceso;
    private $fechaEntrega;
    private $descripcion;
    private $calificacion;
    private $horasTrabajadas;
    private $departamentoUsuarioSolicitante;
    private $jefaturaUsuarioSolicitante;
    private $prioridad; //objeto de la clase prioridad

}
