<?php

$curso=$db->consulta("SELECT * FROM curso "
        . " WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." AND curso_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($curso[0]["curso_nombre"]));
$formulario->setVariable("descripcion",($curso[0]["curso_descripcion"]));
$formulario->setVariable("palabras_clave",($curso[0]["curso_keywords"]));
$formulario->setVariable("selected_".$curso[0]["curso_destacado"],"selected");
$formulario->setVariable("selected_p_".$curso[0]["curso_publicado"],"selected");
$formulario->setVariable("selected_t_".$curso[0]["curso_requiere_validacion"],"selected");

$formulario->setVariable("previa",  addslashes($curso[0]["curso_preview"]));
$formulario->setVariable("contenido",addslashes($curso[0]["curso_texto"]));


	