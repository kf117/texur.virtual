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

if(validarMail($_POST["email"])){

    $db->rawData("UPDATE parametros_sitio "
            . "SET domicilio='".addslashes($_POST["domicilio"])."',email='".addslashes($_POST["email"])."',telefono='".addslashes($_POST["telefono"])."'"
            . ",descripcion='".addslashes($_POST["descripcion"])."',mapa='".addslashes($_POST["google_map"])."',palabras_clave='".addslashes($_POST["palabras_clave"])."'"
            . ",skype='".addslashes($_POST["skype"])."',facebook='".addslashes($_POST["facebook"])."'"
            . ",twitter='".addslashes($_POST["twitter"])."',google_plus='".addslashes($_POST["google_plus"])."',youtube='".addslashes($_POST["youtube"])."' WHERE"
            . " idioma_id=".$_SESSION["idioma_gestor"]);
    
    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}