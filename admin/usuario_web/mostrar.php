<?php

$marca=$db->consulta("SELECT * FROM marca WHERE marca_eliminado=0 AND marca_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($marca[0]["marca_nombre"]));

if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/marca/".$marca[0]["marca_foto"]) && $marca[0]["marca_foto"]!="")
	$formulario->setVariable("imagen","../img/marca/".$marca[0]["marca_foto"]);
	