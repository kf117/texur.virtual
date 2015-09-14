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

       $db->rawData("INSERT INTO scanycar_opciones (id_opcion_padre,nombre_opcion,opcion_eliminado,us_id,id_idioma) VALUES (".$_POST["padre"].",'". addslashes($_POST["opcion"])."',0
               ,".$_SESSION["usuario_gestor"]["us_id"].",".$_SESSION["idioma_gestor"].")");
       $id_max=$db->consulta("SELECT * FROM scanycar_opciones WHERE opcion_eliminado=0 ORDER BY id_opcion DESC LIMIT 1");

       if(file_exists($_FILES["imagen"]["tmp_name"])){
           move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/opciones/".$id_max[0]["id_opcion"].".".obtenerExtension($_FILES["imagen"]["name"]));
           $db->rawData("UPDATE scanycar_opciones SET img_opcion='".$id_max[0]["id_opcion"].".".obtenerExtension($_FILES["imagen"]["name"])."' WHERE id_opcion=".$id_max[0]["id_opcion"]);
       }
       
       

       unset($_SESSION["campos"]);
       header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$id_max[0]["id_opcion"]);
    }else
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=2");  
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=4");  
}
?>
