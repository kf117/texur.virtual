<?php
session_start();
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/conf/conf.php");
$conf=new conf();
$db = new mydb();
$db->rawData("SET NAMES 'utf8'");


$_SESSION["campos"]=$_POST;
if(trim($_POST["nombre"])!="" && trim($_FILES["archivo"]["name"])!="" && trim($_POST["curso"])!=""  ){
    
	$db->rawData("INSERT INTO archivo_curso (ac_archivo,ac_descripcion,curso_id,ac_nombre)"
                . " VALUES ('','".addslashes($_POST["descripcion"])."',".($_POST["curso"]).",'".addslashes($_POST["nombre"])."')");
        
        
        
    $id_max=$db->consulta("SELECT * FROM archivo_curso WHERE 1 ORDER BY ac_id DESC LIMIT 1");

    if($_FILES["archivo"]["size"]>max_upload_file_size()){
        header("Location:../../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["archivo"]["name"])!="" ){
    	$ext=obtenerExtension($_FILES["archivo"]["name"]);
    	move_uploaded_file($_FILES["archivo"]["tmp_name"], $conf->getRoot()."/archivos/curso/".$id_max[0]["ac_id"].".".$ext);
        $db->rawData("UPDATE archivo_curso SET ac_archivo='".$id_max[0]["ac_id"].".".$ext."' WHERE ac_id=".$id_max[0]["ac_id"]);
    }else{
        if(($_FILES["archivo"]["name"])!=""){
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