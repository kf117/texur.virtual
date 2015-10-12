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
//die(print_r($_POST));
if(trim($_POST["nombre"])!="" && trim($_POST["previa"])!="" && trim($_POST["contenido"])!="" && trim($_POST["tipo"])!="" ){
    
	$db->rawData("INSERT INTO curso (curso_nombre,curso_texto,curso_requiere_validacion,idioma_id,curso_eliminado,curso_publicado,curso_descripcion,curso_keywords"
                . ",curso_destacado,curso_preview)"
                . " VALUES ('".addslashes($_POST["nombre"])."','".addslashes($_POST["contenido"])."',".($_POST["tipo"]).",".$_SESSION["idioma_gestor"].",0,".$_POST["publicada"].""
                . ",'".addslashes($_POST["descripcion"])."','".addslashes($_POST["palabras_clave"])."',".$_POST["destacada"].",'".addslashes($_POST["previa"])."')");
        
    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
     die();
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}