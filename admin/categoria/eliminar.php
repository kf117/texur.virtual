<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
$db->rawData("UPDATE producto SET catp_id=0 WHERE catp_id=".$_GET["id"]);
$db->rawData("UPDATE categoria_producto SET catp_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE catp_id=".$_GET["id"]);

header("Location:../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>