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

if(trim($_POST["nombre"])!="" && $_POST["marca"]!=""){
    
	$db->rawData("INSERT INTO modelo (modelo_nombre,marca_id,modelo_eliminado) VALUES ('".addslashes($_POST["nombre"])."',".$_POST["marca"].",0)");
    $id_max=$db->consulta("SELECT * FROM modelo WHERE modelo_eliminado=0 ORDER BY modelo_id DESC LIMIT 1");

    if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/modelo/".$id_max[0]["modelo_id"].".".$ext);
        $db->rawData("UPDATE modelo SET modelo_foto='".$id_max[0]["modelo_id"].".".$ext."' WHERE modelo_id=".$id_max[0]["modelo_id"]);
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