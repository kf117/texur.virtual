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

if(trim($_POST["nombre"])!="" && trim($_POST["apellido"])!="" && $_POST["estado"]!=0 && trim($_POST["email"])!="" && trim($_POST["password"])!=""){
    if(!validarMail($_POST["email"])){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=8");
        die();
    }
    
    if(!validarPass($_POST["password"])){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=9");
         die();
    }
    
    $existe_mail=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 AND usw_email='".($_POST["email"])."'");
    if(count($existe_mail)){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=6");
         die();
    }
    
    if(trim($_POST["scanycar"])!=""){
        $existe_scanycar=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 AND usw_scanycar='".trim(addslashes($_POST["scanycar"]))."'");
        if(count($existe_scanycar)){
            header("Location:../index.php?acc=".$_POST["acc"]."&msg=7");
            die();
        }
    }
    
    $db->rawData("INSERT INTO usuario_sitio (usw_apellido,usw_nombre,estado_id,usw_email,usw_password,usw_scanycar,usw_fecha_alta,usw_eliminado) VALUES"
                . " ('".addslashes($_POST["apellido"])."','".addslashes($_POST["nombre"])."',".($_POST["estado"]).",'".(($_POST["email"]))."','".md5($_POST["password"])."',"
                . "'".trim(addslashes($_POST["scanycar"]))."','".  date("Y-m-d H:i:s")."',0)");
    $id_max=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 ORDER BY usw_id DESC LIMIT 1");

    $db->rawData("INSERT INTO direccion_envio (dire_direccion,dire_extra,pais_id,dire_provincia,dire_telefono,dire_movil,dire_ciudad,dire_cp,usw_id,dire_eliminado) VALUES"
            . " ('".addslashes($_POST["direccion"])."','".addslashes($_POST["extra"])."',".($_POST["pais"]).",'".addslashes($_POST["provincia"])."','".addslashes($_POST["telefono"])."',"
            . "'".addslashes($_POST["movil"])."','".addslashes($_POST["ciudad"])."','".addslashes($_POST["cp"])."',".$id_max[0]["usw_id"].",0)");
    unset($_SESSION["campos"]);
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
     die();
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1"); 
    die();
}