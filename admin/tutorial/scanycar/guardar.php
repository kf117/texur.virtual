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
//die(print_r($_POST));
if(trim($_POST["nombre"])!="" && trim($_FILES["imagen"]["name"])!="" && trim($_POST["curso"])!=""  ){
    
	$db->rawData("INSERT INTO imagen_curso (ic_imagen,ic_descripcion,curso_id,ic_titulo)"
                . " VALUES ('','".addslashes($_POST["descripcion"])."',".($_POST["curso"]).",'".addslashes($_POST["nombre"])."')");
        
        
        
    $id_max=$db->consulta("SELECT * FROM imagen_curso WHERE 1 ORDER BY ic_id DESC LIMIT 1");

    if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/curso/".$id_max[0]["ic_id"].".".$ext);
        $db->rawData("UPDATE imagen_curso SET ic_imagen='".$id_max[0]["ic_id"].".".$ext."' WHERE ic_id=".$id_max[0]["ic_id"]);
    }else{
        if(($_FILES["imagen"]["name"])!=""){
        	header("Location:../../index.php?acc=".$_POST["acc"]."&msg=2");
        	die();
        }
    }    
        
        
    unset($_SESSION["campos"]);
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=3");
     die();
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}