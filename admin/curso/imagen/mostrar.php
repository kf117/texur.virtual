<?php

$imagen=$db->consulta("SELECT * FROM imagen_curso "
        . " WHERE  ic_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($imagen[0]["ic_titulo"]));
$formulario->setVariable("descripcion",  addslashes($imagen[0]["ic_descripcion"]));

if(file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/img/curso/".$imagen[0]["ic_imagen"]) && $imagen[0]["ic_imagen"]!="")
	$formulario->setVariable("imagen","../img/curso/".$imagen[0]["ic_imagen"]);


$cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($imagen[0]["curso_id"]) && $imagen[0]["curso_id"]==$curso["curso_id"] )
                $formulario->setVariable("curso_selected","selected") ; 
            $formulario->setVariable("curso_id",$curso["curso_id"]) ; 
            $formulario->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $formulario->parse("cursos") ; 
        }



	