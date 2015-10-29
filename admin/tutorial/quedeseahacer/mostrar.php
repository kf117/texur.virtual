<?php

$qdh=$db->consulta("SELECT * FROM que_desea_hacer WHERE qdh_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"].""
        . " AND qdh_id=".$_GET["id"]);



$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($qdh[0]["qdh_titulo"]));


	