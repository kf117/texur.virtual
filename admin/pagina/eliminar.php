<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
$db->rawData("UPDATE pagina SET pagina_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE pagina_id=".$_GET["id"]);
$rs=$db->consulta("SELECT * FROM pagina WHERE pagina_id=".$_GET["id"]);
if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/pagina/".$rs[0]["pagina_foto"]))
	unlink(dirname(dirname(dirname(__FILE__)))."/img/pagina/".$rs[0]["pagina_foto"]);
header("Location:../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>