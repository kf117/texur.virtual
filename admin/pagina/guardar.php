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

if(trim($_POST["nombre"])!="" && trim($_POST["resumen"])!="" && trim($_POST["texto"])!="" ){
    
	$db->rawData("INSERT INTO pagina (pagina_titulo,pagina_resumen,pagina_contenido,idioma_id,pagina_eliminado,pagina_foto,pagina_destacada,pagina_keywords,pagina_publicada)"
                . " VALUES ('".addslashes($_POST["nombre"])."','".addslashes($_POST["resumen"])."','".addslashes($_POST["texto"])."',".$_SESSION["idioma_gestor"].",0,'',".$_POST["destacada"].""
                . ",'".addslashes($_POST["palabras_clave"])."',".$_POST["publicada"].")");
        
    $id_max=$db->consulta("SELECT * FROM pagina WHERE pagina_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." ORDER BY pagina_id DESC LIMIT 1");

    if($_FILES["imagen"]["size"]>max_upload_file_size()){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=5");
        die();
    }

    if(($_FILES["imagen"]["name"])!="" && in_array($_FILES["imagen"]["type"], $formatos_img)){
    	$ext=obtenerExtension($_FILES["imagen"]["name"]);
    	move_uploaded_file($_FILES["imagen"]["tmp_name"], $conf->getRoot()."/img/pagina/".$id_max[0]["pagina_id"].".".$ext);
        $db->rawData("UPDATE pagina SET pagina_foto='".$id_max[0]["pagina_id"].".".$ext."' WHERE pagina_id=".$id_max[0]["pagina_id"]);
    }else{
        if(($_FILES["imagen"]["name"])!=""){
        	header("Location:../index.php?acc=".$_POST["acc"]."&msg=2");
        	die();
        }
    }

    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}