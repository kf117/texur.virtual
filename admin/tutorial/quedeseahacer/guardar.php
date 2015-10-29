<?php
session_start();
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/conf/conf.php");
$conf=new conf();
$db = new mydb();
$db->rawData("SET NAMES 'utf8'");
$formatos_img = array('image/jpeg' ,'image/pjpeg' ,'image/png','image/jpg');

$_SESSION["campos"]=$_POST;

if(trim($_POST["nombre"])!=""){
    
	$db->rawData("INSERT INTO que_desea_hacer (qdh_titulo,qdh_eliminado,idioma_id)"
                . " VALUES ('".addslashes($_POST["nombre"])."',0,".$_SESSION["idioma_gestor"].
                ")");


    unset($_SESSION["campos"]);
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=3");
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}