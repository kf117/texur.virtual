<?php

$modelo=$db->consulta("SELECT * FROM modelo WHERE modelo_eliminado=0 AND modelo_id=".$_GET["id"]);

$marcas=$db->consulta("SELECT * FROM marca WHERE marca_eliminado=0");
    if(count($marcas)){
        foreach ($marcas as $marca){
           if($marca["marca_id"]==$modelo[0]["marca_id"])
               $formulario->setVariable("selected_marca","selected");
           $formulario->setVariable("marca_nombre",$marca["marca_nombre"]); 
           $formulario->setVariable("marca_id",$marca["marca_id"]); 
           $formulario->parse("marcas");
        }
    }

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($modelo[0]["modelo_nombre"]));

if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/modelo/".$modelo[0]["modelo_foto"]) && $modelo[0]["modelo_foto"]!="")
	$formulario->setVariable("imagen","../img/modelo/".$modelo[0]["modelo_foto"]);
	