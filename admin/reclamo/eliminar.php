<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
$db->rawData("UPDATE reclamo SET reclamo_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE reclamo_id=".$_GET["id"]);

header("Location:../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>