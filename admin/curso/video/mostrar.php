<?php

$video=$db->consulta("SELECT * FROM video_curso "
        . " WHERE  vc_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($video[0]["vc_titulo"]));
$formulario->setVariable("descripcion",  addslashes($video[0]["vc_descripcion"]));
$formulario->setVariable("video",($video[0]["vc_codigo"]));


$cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($video[0]["curso_id"]) && $video[0]["curso_id"]==$curso["curso_id"] )
                $formulario->setVariable("curso_selected","selected") ; 
            $formulario->setVariable("curso_id",$curso["curso_id"]) ; 
            $formulario->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $formulario->parse("cursos") ; 
        }



	