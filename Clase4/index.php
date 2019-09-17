<?php 

include_once "./Classes/Persona.php";
include_once "./Classes/functions.php";
/*
var_dump($_FILES);

$archivotmp = $_FILES["imagen"]["tmp_name"];

//$extension = explode("/",$_FILES["imagen"]["type"]);
//$extension = explode(".",$_FILES["imagen"]["name"]);
$extension = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
$rta = move_uploaded_file($archivotmp, "./Imagenes/Crisantemo.".$extension);

*/

$archivotmp = $_FILES["foto"]["tmp_name"];

$extension = ".".pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);

$foto = "./Imagenes/".$_POST["nombre"].$_POST["apellido"].$_POST["legajo"].$extension;


$rta = move_uploaded_file($archivotmp, $foto);

if ($rta) {
    $rta = rename($archivotmp,
        "./Imagenes/Backups"."OLD_".$_POST["nombre"].$_POST["apellido"].$_POST["legajo"].$extension);
    if ($rta) {
        Escribir(new Persona($_POST["legajo"], $_POST["nombre"], $_POST["apellido"], $foto));
    }
}

?>