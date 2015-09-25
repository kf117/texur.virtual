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


if(trim($_POST["nombre"])!=""  ){

    
$db->rawData("UPDATE categoria_producto SET catp_nombre='".addslashes($_POST["nombre"])."',catp_descripcion='".addslashes($_POST["descripcion"])."',"
                . "catp_keywords='".addslashes($_POST["palabras_clave"])."',catp_publicado=".($_POST["publicada"])." "
                . "WHERE catp_id=".$_POST["id"]);

    header("Location:../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
    die();
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}