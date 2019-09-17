<?php
    
    class Persona
    {
        
        public $legajo;
        public $nombre;
        public $apellido;
        public $foto;
        
        function __construct($legajo, $nombre, $apellido, $foto)
        {
            
            $this->nombre   = $nombre;
            $this->apellido = $apellido;
            $this->legajo   = $legajo;
            $this->foto     = $foto;
        }
    }
    
?>