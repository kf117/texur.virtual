<?php

$pagina=$db->consulta("SELECT * FROM pagina WHERE pagina_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." AND pagina_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($pagina[0]["pagina_titulo"]));
$formulario->setVariable("resumen",addslashes($pagina[0]["pagina_resumen"]));
$formulario->setVariable("texto",addslashes($pagina[0]["pagina_contenido"]));
$formulario->setVariable("palabras_clave",($pagina[0]["pagina_keywords"]));
$formulario->setVariable("selected_".$pagina[0]["pagina_destacada"],"selected");
$formulario->setVariable("selected_p_".$pagina[0]["pagina_publicada"],"selected");

if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/pagina/".$pagina[0]["pagina_foto"]) && $pagina[0]["pagina_foto"]!="")
	$formulario->setVariable("imagen","../img/pagina/".$pagina[0]["pagina_foto"]);
	