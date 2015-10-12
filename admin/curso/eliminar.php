<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
$db->rawData("UPDATE curso SET curso_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE curso_id=".$_GET["id"]);
header("Location:../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>