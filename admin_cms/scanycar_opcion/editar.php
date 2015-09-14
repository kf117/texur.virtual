<?php
//die(print_r($_POST)." ".  print_r($_FILES));
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();
$imagenes_permitidos=array ("image/jpg","image/jpeg","image/pjpeg","image/png","image/gif");
$db = new mydb();
//die($conf->getRoot().$_POST["imagen_src"]);
$_SESSION["campos"]=$_POST;
if($_FILES["imagen"]["name"]=="" || mime_type_permitidos($_FILES["imagen"]["type"],$imagenes_permitidos)){
    if(isset($_POST["opcion"]) && trim($_POST["opcion"])!="" ){
        /////BORRO LA IMAGEN SI DEBO
    if($_POST["borrar_imagen"]==1){     
    $db->rawData("UPDATE scanycar_opciones SET id_opcion_padre=".$_POST["padre"].",nombre_opcion='".  addslashes($_POST["opcion"])."',us_id=".$_SESSION["usuario_gestor"]["us_id"]."
        ,img_opcion='' WHERE id_opcion=".$_POST["id"]);
    unlink($conf->getRoot().$_POST["imagen_src"]);
    }else
    $db->rawData("UPDATE scanycar_opciones SET id_opcion_padre=".$_POST["padre"].",nombre_opcion='".  addslashes($_POST["opcion"])."',us_id=".$_SESSION["usuario_gestor"]["us_id"]."
         WHERE id_opcion=".$_POST["id"]);
         //////////////////////CARGO NUEVA IMAGEN SI HAY
    if(file_exists($_FILES["imagen"]["tmp_name"])){ 
           move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/opciones/".$_POST["id"].".".obtenerExtension($_FILES["imagen"]["name"]));
           $db->rawData("UPDATE scanycar_opciones SET img_opcion='".$_POST["id"].".".obtenerExtension($_FILES["imagen"]["name"])."' WHERE id_opcion=".$_POST["id"]);
       }
   
   unset($_SESSION["campos"]);
   header("Location:../index.php?acc=".$_POST["acc"]."&msg=3&id=".$_POST["id"]);
}else
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=2&id=".$_POST["id"]); 
}else
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=2&id=".$_POST["id"]);
?>


