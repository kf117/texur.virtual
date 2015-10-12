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


if(trim($_POST["nombre"])!="" && trim($_POST["previa"])!="" && trim($_POST["contenido"])!="" && trim($_POST["tipo"])!="" ){

   
	$db->rawData("UPDATE curso SET curso_nombre='".addslashes($_POST["nombre"])."',curso_texto='".addslashes($_POST["contenido"])."',curso_requiere_validacion=".($_POST["tipo"]).""
                . ",curso_publicado=".$_POST["publicada"].",curso_descripcion='".addslashes($_POST["descripcion"])."',curso_keywords='".addslashes($_POST["palabras_clave"])."'"
                . ",curso_destacado=".$_POST["destacada"].",curso_preview='".addslashes($_POST["previa"])."' "
                . "WHERE curso_id=".$_POST["id"]);
    
    
               

    header("Location:../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
     die();
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}