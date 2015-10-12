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
if(trim($_POST["nombre"])!="" && trim($_POST["video"])!="" && trim($_POST["curso"])!=""  ){
    
	$db->rawData("INSERT INTO video_curso (vc_codigo,vc_descripcion,curso_id,vc_titulo)"
                . " VALUES ('".addslashes($_POST["video"])."','".addslashes($_POST["descripcion"])."',".($_POST["curso"]).",'".addslashes($_POST["nombre"])."')");
        
    unset($_SESSION["campos"]);
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=3");
     die();
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}