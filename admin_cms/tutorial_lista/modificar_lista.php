<?php
$opcion=$db->consulta("SELECT * FROM lista_opcion WHERE lista_eliminado=0 AND lista_id=".$_GET["id"]);
$opcion=$opcion[0];
$formulario->setVariable("id", $_GET["id"]);
$formulario->setVariable("titulo", htmlspecialchars($opcion["lista_nombre"]));
    

        
if($opcion["lista_principal"]){
    $formulario->setVariable("principal", "checked");
}   
        
        




?>

