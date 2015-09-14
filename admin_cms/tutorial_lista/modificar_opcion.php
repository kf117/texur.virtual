<?php
$opcion=$db->consulta("SELECT * FROM opcion WHERE opcion_eliminado=0 AND opcion_id=".$_GET["id"]);
$opcion=$opcion[0];
$formulario->setVariable("id", $_GET["id"]);
$formulario->setVariable("opcion", htmlspecialchars($opcion["opcion_nombre"]));
$formulario->setVariable("lista_id", $opcion["lista_id"]);    

$opciones=$db->consulta("SELECT * FROM lista_opcion WHERE lista_eliminado=0 AND id_idioma=".$_SESSION["idioma_gestor"]." ORDER BY lista_nombre ASC");
    if(count($opciones)){
        foreach ($opciones as $op){
            if( $op["lista_id"]==$opcion["lista_id"])
                $formulario->setVariable("opcion_selected", "selected");
            $formulario->setVariable("opcion_id", $op["lista_id"]);
            $formulario->setVariable("opcion_nombre", $op["lista_nombre"]);
            $formulario->parse("sel_opciones");
        }
}
        
if(file_exists($conf->getRoot()."/img/opciones_lista/".$opcion["opcion_img"]) && trim($opcion["opcion_img"])!=""){
    $formulario->setVariable("img_src", "/img/opciones_lista/".$opcion["opcion_img"]);
}   else { 
    $formulario->setVariable("mostrar_boton", "none");
}    
        
        




?>

