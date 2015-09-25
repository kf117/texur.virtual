<?php

$catp=$db->consulta("SELECT * FROM categoria_producto WHERE catp_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." AND catp_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($catp[0]["catp_nombre"]));
$formulario->setVariable("descripcion",($catp[0]["catp_descripcion"]));
$formulario->setVariable("palabras_clave",($catp[0]["catp_keywords"]));
$formulario->setVariable("selected_p_".$catp[0]["catp_publicado"],"selected");

	