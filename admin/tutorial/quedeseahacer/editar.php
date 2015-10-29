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


if(trim($_POST["nombre"])!=""  ){

    
$db->rawData("UPDATE que_desea_hacer SET qdh_titulo='".addslashes($_POST["nombre"])."' "
                . "WHERE qdh_eliminado=0 AND qdh_id=".$_POST["id"]);

    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
    die();
}else{
    header("Location:../../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}