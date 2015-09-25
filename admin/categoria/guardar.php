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

if(trim($_POST["nombre"])!=""){
    
	$db->rawData("INSERT INTO categoria_producto (catp_nombre,catp_descripcion,catp_keywords,idioma_id,catp_publicado,catp_eliminado)"
                . " VALUES ('".addslashes($_POST["nombre"])."','".addslashes($_POST["descripcion"])."','".addslashes($_POST["palabras_clave"])."',".$_SESSION["idioma_gestor"].","
                . "".$_POST["publicada"].",0)");


    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}