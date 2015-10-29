<?php
session_start();
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(dirname(__FILE__))))."/functions/inc/seguridad.php");

$db = new mydb();

if(is_numeric($_GET["id"])){
    $rs=$db->consulta("SELECT * FROM imagen_curso WHERE ic_id=".$_GET["id"]);
$db->rawData("DELETE FROM imagen_curso WHERE ic_id=".$_GET["id"]);

if(file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/img/curso/".$rs[0]["ic_imagen"]))
	unlink(dirname(dirname(dirname(dirname(__FILE__))))."/img/curso/".$rs[0]["ic_imagen"]);
header("Location:../../index.php?acc=".$_GET["acc"]."&msg=1");
}
?>