<?php
//die(print_r($_POST)." ----> ".  print_r($_FILES));
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();
$imagenes_permitidos=array ("image/jpg","image/jpeg","image/pjpeg","image/png","image/gif");


$db = new mydb();

$_SESSION["campos"]=$_POST;



if($_FILES["imagen"]["name"]=="" || mime_type_permitidos($_FILES["imagen"]["type"],$imagenes_permitidos)){
    if(isset($_POST["opcion"]) && trim($_POST["opcion"])!="" ){

       $db->rawData("INSERT INTO opcion (opcion_lista_sgte,opcion_nombre,lista_id,opcion_eliminado,id_idioma) VALUES (".$_POST["lista_sgte"].",'". addslashes($_POST["opcion"])."',". $_POST["lista_id"].",0
               ,".$_SESSION["idioma_gestor"].")");
       $id_max=$db->consulta("SELECT LAST_INSERT_ID()");
       
       $id_max=$id_max[0]["LAST_INSERT_ID()"];
       if(file_exists($_FILES["imagen"]["tmp_name"])){
           move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/opciones_lista/".$id_max.".".obtenerExtension($_FILES["imagen"]["name"]));
           $db->rawData("UPDATE opcion SET opcion_img='".$id_max.".".obtenerExtension($_FILES["imagen"]["name"])."' WHERE id_opcion=".$id_max);
       }
       
       

       unset($_SESSION["campos"]);
       header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&lista_id=".$_POST["lista_id"]."&id=".$id_max);
    }else
        header("Location:../index.php?acc=".$_POST["acc"]."&lista_id=".$_POST["lista_id"]."&msg=2");  
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&lista_id=".$_POST["lista_id"]."&msg=4");  
}
?>
