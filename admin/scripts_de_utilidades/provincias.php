<?php
include_once '/functions/inc/mydb.inc.php';
$nombre_fichero="provincias.html";
$fichero_texto = fopen ($nombre_fichero, "r");
$contenido_fichero = fread($fichero_texto, filesize($nombre_fichero));
$contenido=  explode("</option>", $contenido_fichero);
$db=new mydb();
//die(print_r($contenido));
for($i=0;$i<count($contenido);$i++){
    $nombre=  explode(">", $contenido[$i]);
    //die(print_r($nombre));
    if(isset($nombre[1]) && trim($nombre[1])!=""){
    $nombre=  addslashes($nombre[1]);
    $db->rawData("INSERT INTO provincia (prov_nombre) VALUES ('$nombre')");
    }
}
die(print_r($contenido));
?>
