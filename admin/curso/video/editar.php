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


if(trim($_POST["nombre"])!="" && trim($_POST["video"])!="" && trim($_POST["curso"])!=""  ){

   
	$db->rawData("UPDATE video_curso SET vc_codigo='".addslashes($_POST["video"])."',vc_descripcion='".addslashes($_POST["descripcion"])."',"
                . "curso_id=".($_POST["curso"]).",vc_titulo='".addslashes($_POST["nombre"])."' "
                . "WHERE vc_id=".$_POST["id"]);
    
               

    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
     die();
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}