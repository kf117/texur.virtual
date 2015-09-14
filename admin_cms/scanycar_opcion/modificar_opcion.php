<?php
$opcion=$db->consulta("SELECT * FROM scanycar_opciones WHERE opcion_eliminado=0 AND id_opcion=".$_GET["id"]);
$opcion=$opcion[0];
$formulario->setVariable("id", $_GET["id"]);
$formulario->setVariable("opcion", htmlspecialchars($opcion["nombre_opcion"]));
    
$opciones=$db->consulta("SELECT * FROM scanycar_opciones WHERE opcion_eliminado=0 AND id_opcion!=".$_GET["id"]."  AND id_idioma=".$_SESSION["idioma_gestor"]." ORDER BY nombre_opcion ASC");
    if(count($opciones)){
        foreach ($opciones as $op){
            if( $op["id_opcion"]==$opcion["id_opcion_padre"])
                $formulario->setVariable("opcion_selected", "selected");
            $formulario->setVariable("opcion_id", $op["id_opcion"]);
            $formulario->setVariable("opcion_nombre", $op["nombre_opcion"]);
            $formulario->parse("sel_opciones");
        }
}
        
if(file_exists($conf->getRoot()."/img/opciones/".$opcion["img_opcion"]) && trim($opcion["img_opcion"])!=""){
    $formulario->setVariable("img_src", "/img/opciones/".$opcion["img_opcion"]);
}   else { 
    $formulario->setVariable("mostrar_boton", "none");
}    
        
        




?>

