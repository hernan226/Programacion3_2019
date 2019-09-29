<?php
    
    const VALIDADOR_NOMBRE      = "/^([a-zA-Z' ]+)$/";
    const VALIDADOR_EMAIL       = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
    const ACHIVO_ALUMNOS        = "archivos\alumnos.txt";
    const ACHIVO_MATERIAS       = "archivos\materias.txt";
    const ACHIVO_INSCRIPCIONES  = "archivos\inscripciones.txt";

    function ValidarNombre($dato){
        return preg_match(VALIDADOR_NOMBRE, $dato);
    }

    function ValidarEmail($dato){
        return preg_match(VALIDADOR_EMAIL, $dato);
    }

    function Escribir($dato, $path){
        $archivo = fopen($path, "a");
        $rta = fwrite($archivo, $dato.PHP_EOL);
        fclose($archivo);        
    }

    function Leer($path){
        $archivo = fopen($path, "r");
        while(!feof($archivo))
        {
            $str = explode(";", fgets($archivo));            
            $array[] = $str;
        }
        fclose($archivo);
        return $array;
    }

    function BuscarAlumno($apellido, $email = ""){
        $alumnos = Leer(ACHIVO_ALUMNOS);
        $retorno = array();
        for ($i = 0; $i < count($alumnos)-1; $i++) {
            $aux = new Alumno($alumnos[$i][1], $alumnos[$i][2], $alumnos[$i][0], $alumnos[$i][3]);
            if (strtolower($aux->apellido) == strtolower($apellido))
                $retorno[] = $aux;
        }    
        if ($email != "") {
            for ($i = 0; $i < count($retorno); $i++) { 
                if ($retorno[$i]->email == $email) {
                    $retorno = array($retorno[$i]->email);
                    break;
                }
            }
        }
        return $retorno;
    }

    function BuscarMateria($codigo)
    {
        $materias = Leer(ACHIVO_MATERIAS);
        $retorno = 0;

        for ($i = 0; $i < count($materias); $i++) {
            if ($materias[$i][0] == $codigo){
                if ($materias[$i][2] > 0)
                    $retorno = 1;
                else
                    $retorno = 2;                    
                break;
            }
        }
        return $retorno;
    }

    function GuardarFoto($file, $mail){
        
        $tmp    = $file["foto"]["tmp_name"];
        $ext    = ".".pathinfo($file["foto"]["name"], PATHINFO_EXTENSION);
        $foto   = 'fotos/'.$mail.$ext;
        if (file_exists($foto)) {
            rename($foto, 'backUpFotos/'.'OLD_'.$mail.$ext);
            $rta = move_uploaded_file($tmp, $foto);
        }
        else{
            $rta = move_uploaded_file($tmp, $foto);
        }
        if ($rta)
            return $foto;
        else
            return '';
    }

    function Inscribir($nombre, $apellido, $email, $materia, $codigo){
        $materias = Leer(ACHIVO_MATERIAS);
        $retorno = 0;
        $aux = array();
        for ($i = 0; $i < count($materias)-1; $i++) {
            if ($materias[$i][0] == $codigo){
                $aux[] = new Materia($materias[$i][0], $materias[$i][1], ((int)$materias[$i][2] - 1), $materias[$i][3]);
            }
            else
                $aux[] = new Materia($materias[$i][0], $materias[$i][1], $materias[$i][2], $materias[$i][3]);
        }

        Reescribir($aux, ACHIVO_MATERIAS);
        Escribir($nombre.";".$apellido.";".$email.";".$materia.";".$codigo.";", ACHIVO_INSCRIPCIONES);
        
    }

    function Reescribir($datos, $path){
        $aux = "";
 
        for ($i=0; $i < count($datos); $i++) {
            $aux = $aux.$datos[$i].PHP_EOL;
        }

        $archivo = fopen($path, "w");
        $rta = fwrite($archivo, $aux);
        fclose($archivo);
    }

    function EstaInscripto($email, $codigoMateria){
        $retorno = false;
        $aux = Leer(ACHIVO_INSCRIPCIONES);

        for ($i=0; $i < count($aux)-1; $i++) { 
            if ($aux[$i][2] == $email && $aux[$i][4] == $codigoMateria) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    // GET FUNCTIONS

    function ConsultarAlumno($apellido){
        
        $array = BuscarAlumno($apellido);

        if (count($array) > 0)
            var_dump($array);
        else
            echo "No existe el alumno con apellido ".$apellido.".";
    }

    function InscribirAlumno($nombre, $apellido, $email, $materia, $codigo){
        if (ValidarNombre($nombre) && ValidarNombre($apellido) && ValidarEmail($email) && ValidarNombre($materia) && is_numeric($codigo)){
            $array = BuscarAlumno($apellido, $email);
            if (count($array) != 1)
                echo "Alumno no encontrado.";
            else if(EstaInscripto($email, $codigo)){
                echo "Alumno ya inscripto.";
            }else{
                $rta = BuscarMateria($codigo);
                if ($rta == 1) {
                    Inscribir($nombre, $apellido, $email, $materia, $codigo);
                }else if($rta == 2){
                    echo "La materia ".$materia." esta llena.";
                }else{
                    echo "La materia ".$materia." no existe.";
                }
            }
        }
    }
    ///////////////////////////////////////////////////////////////////
    
    // POST FUNCTIONS /////////////////////////////////////////////////

    function CargarAlumno($nombre, $apellido, $email, $file){
        if (ValidarNombre($nombre) && ValidarNombre($apellido) && ValidarEmail($email)){
            $foto = GuardarFoto($file, $email);
            if ($foto != '')
                Escribir(new Alumno($nombre, $apellido, $email, $foto), ACHIVO_ALUMNOS);
            else
                echo 'Error al guardar la foto.';
        } 
        else
            echo 'Error al ingresar los datos.';
    }

    function CargarMateria($nombre, $cupo, $codigo, $aula){
        if (!ValidarNombre($nombre))
            echo 'Nombre invalido. <br/>Evite usar numeros, simbolos o espacios.<br/>Ejemplo: "ProgramacionIII" en vez de "Programacion 3"';
        else if(is_numeric($cupo) && is_numeric($codigo) && is_numeric($aula))
            Escribir(new Materia($codigo, $nombre, $cupo, $aula), ACHIVO_MATERIAS);
        else
            echo 'Error al ingresar los datos.';
    }

    ///////////////////////////////////////////////////////////////////
?>