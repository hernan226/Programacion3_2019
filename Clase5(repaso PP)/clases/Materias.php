<?php
    class Materia{

        public $nombre;
        public $codigo;
        public $cupo;
        public $aula;

        function __construct($codigo, $nombre, $cupo, $aula){
            
            $this->nombre   = $nombre;
            $this->codigo   = $codigo;
            $this->cupo     = $cupo;
            $this->aula     = $aula;
        }

        function __toString(){
            return $this->codigo.";".$this->nombre
            .";".$this->cupo.";".$this->aula.";";
        }

    }


?>