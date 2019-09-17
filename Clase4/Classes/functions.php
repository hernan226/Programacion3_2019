<?php
    /**
     * 
     * Escribe en el archivo .json.
     * 
     * @param object $dato el objeto a guardar.
     * @param bool $opcion opciona, usar false si se borra o edita un campo. 
     * @return bool true si pudo guardar.
     */
    function Escribir($dato, $opcion = true)
    {
        $aux= array();

        if($opcion)
            $aux = Leer();
        
        $archivo = fopen("jayson.json", "w");
        array_push($aux, $dato);
        $rta = fwrite($archivo, json_encode($aux));
        fclose($archivo);
        
        return $rta;
        
    }
    /**
     * 
     * Lee el archivo .json con personas y lo devuelve como array.
     * 
     * @return array
     * 
     */
    function Leer( )
    {

        if (!file_exists("jayson.json")){
            $archivo = fopen("jayson.json", "a");            
            fclose($archivo);
            return array( );
        }
        else                
            $archivo = fopen("jayson.json", "r");
        
        $aux = fread($archivo, filesize("jayson.json"));
        fclose($archivo);
        
        return json_decode($aux, true);
    }
    
    function Borrar($borrar)
    {
        $aux     = Leer( );
        $retorno = array( );
        
        for ($i = 0; $i < count($aux); $i++) {
            if ($aux[$i][0] != $borrar[0]) {
                $retorno[ ] = $aux[$i];
            }
        }

        $rta = Escribir(json_encode($retorno), false);

        return $rta;
    }
    
    function Editar($pers, $edit)
    {
        $aux     = Leer( );
        $retorno = array( );
        
        for ($i = 0; $i < count($aux); $i++) {
            if ($aux[$i][0] != $pers[0]) {
                $retorno[ ] = $aux[$i];
            } else {
                $retorno[ ] = $edit;
            }
        }
        Escribir();
        /*
        foreach ($aux as $value) {
            if ($value->legajo != $pers->legajo) {
                $retorno[ ] = $value;
            } else {
                $retorno[ ] = $edit;
            }
        } */

        $rta = Escribir(json_encode($retorno), false);

        return $rta;
    }
    
?>