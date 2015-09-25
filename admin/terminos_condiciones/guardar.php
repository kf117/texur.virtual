<?php
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();
$db = new mydb();
$db->rawData("SET NAMES 'utf8'");


    $db->rawData("UPDATE terminos_condiciones "
            . "SET terminos='".addslashes($_POST["texto"])."' WHERE"
            . " idioma_id=".$_SESSION["idioma_gestor"]);

    header("Location:../index.php?acc=".$_POST["acc"]."&msg=3");
