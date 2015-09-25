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


if(trim($_POST["nombre"])!="" && $_POST["marca"]!=""){

    $img_del="";
    if($_POST["elim_img"]==1){
        $img_del=",modelo_foto='' ";
        $rs=$db->consulta("SELECT * FROM modelo WHERE modelo_id=".$_POST["id"]);
        if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/modelo/".$rs[0]["modelo_foto"]))
	unlink(dirname(dirname(dirname(__FILE__)))."/img/modelo/".$rs[0]["modelo_foto"]);
    }
	$db->rawData("UPDATE modelo SET modelo_nombre='".addslashes($_POST["nombre"])."',marca_id=".$_POST["marca"]." ".$img_del." WHERE modelo_id=".$_POST["id"]);
    
    if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/modelo/".$_POST["id"].".".$ext);
        $db->rawData("UPDATE modelo SET modelo_foto='".$_POST["id"].".".$ext."' WHERE modelo_id=".$_POST["id"]);
    }else{
        if(($_FILES["imagen"]["name"])!=""){
        	header("Location:../index.php?acc=".$_POST["acc"]."&msg=2&id=".$_POST["id"]);
        	die();
        }
    }

    header("Location:../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}