<?php
//die(print_r($_POST)." ".  print_r($_FILES));
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();

$db = new mydb();
$es_principal;
$_SESSION["campos"]=$_POST;

    if(isset($_POST["titulo"]) && trim($_POST["titulo"])!="" ){
        
        if(isset($_POST["principal"]))
            $es_principal=1;
        else $es_principal=0;
        
        if($es_principal)
        $db->rawData ("UPDATE lista_opcion SET lista_principal=0 WHERE lista_principal=1 AND id_idioma=".$_SESSION["idioma_gestor"]);
    
    $db->rawData("UPDATE lista_opcion SET lista_nombre='".addslashes($_POST["titulo"])."',lista_principal=$es_principal
         WHERE lista_id=".$_POST["id"]);
     
   
   unset($_SESSION["campos"]);
   header("Location:../index.php?acc=".$_POST["acc"]."&msg=3&id=".$_POST["id"]);
}else
    header("Location:../index.php?acc=".$_POST["acc"]."&msg=2&id=".$_POST["id"]); 

?>


