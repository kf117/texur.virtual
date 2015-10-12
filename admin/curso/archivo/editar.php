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

	$db->rawData("UPDATE archivo_curso SET ac_descripcion='".addslashes($_POST["descripcion"])."',"
                . "curso_id=".($_POST["curso"]).",ac_nombre='".addslashes($_POST["nombre"])."'  "
                . "WHERE ac_id=".$_POST["id"]);
    
     if($_FILES["archivo"]["size"]>max_upload_file_size()){
        header("Location:../../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["archivo"]["name"])!="" ){
    	$ext=obtenerExtension($_FILES["archivo"]["name"]);
    	move_uploaded_file($_FILES["archivo"]["tmp_name"], $conf->getRoot()."/archivos/curso/".$_POST["id"].".".$ext);
        $db->rawData("UPDATE archivo_curso SET ac_archivo='".$_POST["id"].".".$ext."' WHERE ac_id=".$_POST["id"]);
    }else{
        if(($_FILES["archivo"]["name"])!=""){
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