<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();
$db = new mydb();
$db->rawData("SET NAMES 'utf8'");
$formatos_img = array('image/jpeg' ,'image/pjpeg' ,'image/png','image/jpg');

$_SESSION["campos"]=$_POST;

if(trim($_POST["nombre"])!="" && trim($_POST["descripcion"])!="" && ($_POST["categoria"])!=0 ){
    
	$db->rawData("INSERT INTO producto (prod_nombre,prod_descripcion,catp_id,idioma_id,prod_eliminado,prod_foto,"
                . "prod_destacado,prod_keywords,prod_publicado)"
                . " VALUES ('".addslashes($_POST["nombre"])."','".addslashes($_POST["descripcion"])."',"
                .($_POST["categoria"]).",".$_SESSION["idioma_gestor"].",0,'',".$_POST["destacada"].""
                . ",'".addslashes($_POST["palabras_clave"])."',".$_POST["publicada"].")");
        
    $id_max=$db->consulta("SELECT * FROM producto WHERE prod_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." "
            . "ORDER BY prod_id DESC LIMIT 1");

    if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/producto/".$id_max[0]["prod_id"].".".$ext);
        $db->rawData("UPDATE producto SET prod_foto='".$id_max[0]["prod_id"].".".$ext."' WHERE prod_id=".$id_max[0]["prod_id"]);
    }else{
        if(($_FILES["imagen"]["name"])!=""){
        	header("Location:../index.php?acc=".$_POST["acc"]."&msg=2");
        	die();
        }
    }

    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}