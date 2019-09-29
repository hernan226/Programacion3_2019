<?php

    include_once 'functions.php';
    include_once 'clases\Alumno.php';
    include_once 'clases\Materias.php';

    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        switch ($_GET['opcion']) {
            case 'consultarAlumno':
                ConsultarAlumno($_GET['alumno']);
                break;
            case 'inscribirAlumno':
                InscribirAlumno($_GET['nombre'],
                     $_GET['apellido'], $_GET['email'], $_GET['materia'], $_GET['codigo']);
                break;
            case 'inscripciones':
                var_dump($_GET);
                break;
            case 'alumnos':
                # code...
                break;
            
            default:
                break;
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['opcion']) {
            case 'cargarAlumno':
                CargarAlumno($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_FILES);
                break;
            case 'cargarMateria':
                CargarMateria($_POST['nombre'], $_POST['cupo'], $_POST['codigo'], $_POST['aula']);
                break;
            case 'modificarAlumno':
                # code...
                break;
            
            default:
                break;
        }
    }

?>

