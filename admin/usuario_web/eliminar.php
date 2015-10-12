<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
$db->rawData("UPDATE usuario_sitio SET usw_eliminado={$_SESSION["usuario_gestor"]["us_id"]},usw_fecha_baja='".date("Y-m-d H:i:s")."' WHERE usw_id=".$_GET["id"]);
$db->rawData("UPDATE direccion_envio SET dire_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE usw_id=".$_GET["id"]);
header("Location:../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>