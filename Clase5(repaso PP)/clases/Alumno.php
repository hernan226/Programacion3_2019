<?php
    class Alumno{
        public  $nombre;
        public  $apellido;
        public  $email;
        public  $foto;
    
        function __construct($nombre, $apellido, $email, $foto){
    
            $this->nombre   = $nombre;
            $this->apellido = $apellido;
            $this->email    = $email;
            $this->foto     = $foto;
    
        }
    
        function __toString(){
            return $this->email.";".$this->nombre
            .";".$this->apellido.";".$this->foto.";";
        }
    }
?>