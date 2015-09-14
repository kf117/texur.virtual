<?php
//die(print_r($_POST));
session_start();
include(dirname(dirname(__FILE__))."/functions/inc/util.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/seguridad.php");
include(dirname(dirname(__FILE__))."/entidades/usuario.class.php");

$db = new mydb();
//die(print_r($_POST));
$_SESSION["campos"]=$_POST;
$usuario=new usuario();
$check=$db->consulta("SELECT * FROM usuario 
        WHERE us_nick='{$_POST["nick"]}' 
         
        AND us_eliminado=0");
        
if(trim($_POST["nick"])!="" && trim($_POST["nombre"])!="" && $_POST["perfil"]!=0 ){
    if(count($check)==0){
    $usuario->setus_nombre(addslashes($_POST["nombre"]));
    $usuario->setus_apellido(addslashes($_POST["apellido"]));
    $usuario->setus_email(addslashes($_POST["email"]));
    $usuario->setus_nombre(addslashes($_POST["nombre"]));
    $usuario->setus_telefono(addslashes($_POST["telefono"]));
    $usuario->setus_direccion(addslashes($_POST["domicilio"]));
    $usuario->setus_nick(addslashes($_POST["nick"]));
    $usuario->setperfil_id($_POST["perfil"]);
    
    
    
    if($_POST["contrasenia"]==$_POST["recontrasenia"] && $_POST["contrasenia"]!="")
    $usuario->setus_pass(md5($_POST["contrasenia"]));
    else{
        header("Location:/index.php?acc=".$_POST["acc"]."&msg=1");
        die();
    }
    $id=$usuario->add();
    
    unset($_SESSION["campos"]);
    header("Location:/index.php?acc=".$_POST["acc"]."&msg=1&id=$id");
    }else{
        header("Location:/index.php?acc=".$_POST["acc"]."&msg=3");
    }
}else{
    header("Location:/index.php?acc=".$_POST["acc"]."&msg=2"); 
}        
?>
