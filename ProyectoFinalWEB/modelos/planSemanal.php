<?php
    class PlanSemanal{
        public $id=0;
        public $lunes="";
        public $martes="";
        public $miercoles="";
        public $jueves="";
        public $viernes=""; 
        public $fechaInicio;
        public $fechaFin;  
        public $materia_id=0;
        public $nombre_materia="";

        public function __construct(){
            $this->fechaInicio=new DateTime();
            $this->fechaFin=new DateTime();
        }
    }
?>