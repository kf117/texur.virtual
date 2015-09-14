<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");


$db = new mydb();

$usuario=  mysql_real_escape_string(($_POST["usuario"]));
$clave=mysql_real_escape_string(($_POST["clave"]));

$clave=  md5($clave);

$usuario=$db->consulta("SELECT * FROM usuario WHERE us_nick='$usuario' AND us_pass='$clave' AND us_eliminado=0");
if(isset($usuario) && count($usuario)){
    $_SESSION["usuario_gestor"]=$usuario[0];   
}else{
    $_SESSION["mensaje_error"]="Wrong user or password.";
}
header("Location:../index.php");
die();
?>
