<?php

$archivo=$db->consulta("SELECT * FROM archivo_curso "
        . " WHERE  ac_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($archivo[0]["ac_nombre"]));
$formulario->setVariable("descripcion",  addslashes($archivo[0]["ac_descripcion"]));

if(file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/archivos/curso/".$archivo[0]["ac_archivo"]) && $archivo[0]["ac_archivo"]!="")
	$formulario->setVariable("archivo","../archivos/curso/".$archivo[0]["ac_archivo"]);


$cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($archivo[0]["curso_id"]) && $archivo[0]["curso_id"]==$curso["curso_id"] )
                $formulario->setVariable("curso_selected","selected") ; 
            $formulario->setVariable("curso_id",$curso["curso_id"]) ; 
            $formulario->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $formulario->parse("cursos") ; 
        }



	