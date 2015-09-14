<?php
session_start();


include(dirname(dirname(__FILE__))."/functions/inc/util.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
include(dirname(__FILE__)."/scripts_de_utilidades/check_date.php");


$db = new mydb();
$db->rawData("SET NAMES 'utf8'");
if(!isset($_SESSION["idioma_gestor"]))
    $_SESSION["idioma_gestor"]=1;


if(isset($_GET["acc"]))
$acc=$_GET["acc"];
else
$acc=0;
//phpinfo();
if(isset($_SESSION["usuario_gestor"])){
    inicializar($template,dirname(__FILE__)."/interfaces/inicial.html");   
    $template->setVariable("usuario",$_SESSION["usuario_gestor"]["us_nombre"]." ".$_SESSION["usuario_gestor"]["us_apellido"]);
    
    if(isset($_SESSION["acc_prev"]) && $acc!=$_SESSION["acc_prev"] ){
        
        borrar_sesiones();
    }
    unset($_SESSION["acc_prev"]);
    $_SESSION["acc_prev"]=$acc;
    
    armarMenu($db,$template,$_SESSION["usuario_gestor"]["perfil_id"],$acc,$_SESSION["idioma_gestor"]);
}else{
   
    inicializar($template,dirname(__FILE__)."/interfaces/login.html");
    
    if(isset($_SESSION["mensaje_error"])){
        $template->setVariable("mensaje_error",$_SESSION["mensaje_error"]);
        unset($_SESSION["mensaje_error"]);
    }
    
    
}
$template->show();


?>