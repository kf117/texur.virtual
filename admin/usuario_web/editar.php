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


if(trim($_POST["nombre"])!="" && trim($_POST["apellido"])!="" && $_POST["estado"]!=0 && trim($_POST["email"])!=""){

    if(!validarMail($_POST["email"])){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=8&id=".$_POST["id"]);
        die();
    }
    
    if(!validarPass($_POST["password"]) && $_POST["password"]!=""){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=9&id=".$_POST["id"]);
         die();
    }
    
    $existe_mail=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 AND usw_id!=".$_POST["id"]." AND usw_email='".($_POST["email"])."'");
    if(count($existe_mail)){
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=6&id=".$_POST["id"]);
         die();
    }
    
    if(trim($_POST["scanycar"])!=""){
        $existe_scanycar=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 AND usw_id!=".$_POST["id"]." AND usw_scanycar='".trim(addslashes($_POST["scanycar"]))."'");
        if(count($existe_scanycar)){
            header("Location:../index.php?acc=".$_POST["acc"]."&msg=7&id=".$_POST["id"]);
            die();
        }
    }
    $password_upd="";
    if($_POST["password"]!="")
        $password_upd=",usw_password='".  md5($_POST["password"])."'";
    
    $valido_upd="";
    if($_POST["estado"]==3)
        $valido_upd=",usw_fecha_valido='".date("Y-m-d H:i:s")."'";
    else
        $valido_upd=",usw_fecha_valido='0000-00-00 00:00:00'";
    
    $db->rawData("UPDATE usuario_sitio SET usw_apellido='".addslashes($_POST["apellido"])."',usw_nombre='".addslashes($_POST["nombre"])."',"
    . "estado_id=".$_POST["estado"].",usw_email='".$_POST["email"]."' $password_upd $valido_upd ,usw_scanycar='".addslashes($_POST["scanycar"])."'"
    . " WHERE usw_eliminado=0 AND usw_id=".$_POST["id"]);
    
    $db->rawData("UPDATE direccion_envio SET dire_direccion='".addslashes($_POST["direccion"])."',dire_extra='".addslashes($_POST["extra"])."'"
            . ",pais_id=".($_POST["pais"]).",dire_provincia='".addslashes($_POST["provincia"])."',"
            . "dire_telefono='".addslashes($_POST["telefono"])."',dire_movil='".addslashes($_POST["movil"])."',"
            . "dire_ciudad='".addslashes($_POST["ciudad"])."',dire_cp='".addslashes($_POST["cp"])."' "
            . "WHERE usw_id=".$_POST["id"]);

    header("Location:../index.php?acc=".$_POST["acc"]."&msg=4&id=".$_POST["id"]);
}else{
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$_POST["id"]); 
    die();
}