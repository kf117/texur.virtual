<?php
//die(print_r($_POST)." ----> ".  print_r($_FILES));
session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/conf/conf.php");
$conf=new conf();



$db = new mydb();

$_SESSION["campos"]=$_POST;


$es_principal;

    if(isset($_POST["titulo"]) && trim($_POST["titulo"])!="" ){
        if(isset($_POST["principal"]))
            $es_principal=1;
        else $es_principal=0;
        
        if($es_principal)
        $db->rawData ("UPDATE lista_opcion SET lista_principal=0 WHERE lista_principal=1 AND id_idioma=".$_SESSION["idioma_gestor"]);
        
       $db->rawData("INSERT INTO lista_opcion (lista_nombre,lista_eliminado,lista_principal,id_idioma) VALUES ('".addslashes($_POST["titulo"])."',0
               ,$es_principal,".$_SESSION["idioma_gestor"].")");
       $id_max=$db->consulta("SELECT * FROM lista_opcion WHERE lista_eliminado=0 ORDER BY lista_id DESC LIMIT 1");

       unset($_SESSION["campos"]);
       header("Location:../index.php?acc=".$_POST["acc"]."&msg=1&id=".$id_max[0]["lista_id"]);
    }else
        header("Location:../index.php?acc=".$_POST["acc"]."&msg=2");  

?>
