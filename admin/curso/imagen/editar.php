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


if(trim($_POST["nombre"])!=""  && trim($_POST["curso"])!=""  ){

	$db->rawData("UPDATE imagen_curso SET ic_descripcion='".addslashes($_POST["descripcion"])."',"
                . "curso_id=".($_POST["curso"]).",ic_titulo='".addslashes($_POST["nombre"])."'  "
                . "WHERE ic_id=".$_POST["id"]);
    
     if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/curso/".$_POST["id"].".".$ext);
        $db->rawData("UPDATE imagen_curso SET ic_imagen='".$_POST["id"].".".$ext."' WHERE ic_id=".$_POST["id"]);
    }else{
        if(($_FILES["imagen"]["name"])!=""){
        	header("Location:../../index.php?acc=".$_POST["acc"]."&msg=2&id=".$_POST["id"]);
        	die();
        }
    }          

    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
     die();
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}