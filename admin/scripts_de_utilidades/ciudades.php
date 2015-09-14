<?php
include_once '/functions/inc/mydb.inc.php';
$nombre_fichero="ciudades.html";
$fichero_texto = fopen ($nombre_fichero, "r");
$contenido_fichero = fread($fichero_texto, filesize($nombre_fichero));
$contenido=  explode("<id_prov>", $contenido_fichero);
$db=new mydb();
//die(print_r($contenido)."   ".count($contenido));
for($i=0;$i<count($contenido);$i++){
    if(isset($contenido[$i]) && trim($contenido[$i])!=""){
        $ciudades=  explode("@@", $contenido[$i]);
        $id_provincia=$ciudades[0];
        $ciudades=explode("</option>", $ciudades[1]);
        //die(print_r($contenido[$i]));
        
        for($j=0;$j<count($ciudades);$j++){
            $nombre=  explode(">", $ciudades[$j]);
            //die(print_r($nombre));
            if(isset($nombre[1]) && trim($nombre[1])!=""){
            $nombre=  addslashes($nombre[1]);
            $existe=$db->consulta("SELECT * FROM ciudad WHERE ciud_nombre='{$nombre}'");
           // die(print_r($existe)."   ".count($existe));
            if(count($existe)==0)
            $db->rawData("INSERT INTO ciudad (prov_id,ciud_nombre) VALUES ($id_provincia,'$nombre')");
            }
        }
        
    }
}

?>
