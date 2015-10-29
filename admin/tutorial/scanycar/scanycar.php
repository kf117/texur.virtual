<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("max_size",ini_get('upload_max_filesize'));

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    $formulario->setVariable("titulo_formulario","Editar Item Scanycar");
    $formulario->setVariable("accion","tutorial/scanycar/editar.php");
    include_once(dirname(__FILE__)."/mostrar.php");
}else{
    $formulario->setVariable("titulo_formulario","Nuevo Item Scanycar");
	if(isset($_SESSION["campos"])){
		$formulario->setVariable("nombre",htmlspecialchars($_SESSION["campos"]["nombre"]));
                
                $formulario->setVariable("descripcion",  addslashes($_SESSION["campos"]["descripcion"]));
                
                
        }
    $cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($_SESSION["campos"]["curso"]) && $_SESSION["campos"]["curso"]==$curso["curso_id"] )
                $formulario->setVariable("curso_selected","selected") ; 
            $formulario->setVariable("curso_id",$curso["curso_id"]) ; 
            $formulario->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $formulario->parse("cursos") ; 
        }
    $formulario->setVariable("accion","tutorial/scanycar/guardar.php");
}

if(isset($_GET["msg"]))
{
    switch ($_GET["msg"]){
        case 1:
            $formulario->setVariable("mensaje_error","<b>Error:</b> Debe ingresar los campos requeridos.") ; 
        break;
        case 2:
            $formulario->setVariable("mensaje_error","<b>Error:</b> El formato de la imagen es incorrecto.") ; 
        break;
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> El nuevo registro ha sido cargado exitosamente.") ; 
        break;
        case 4:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> El registro ha sido modificado correctamente.") ; 
        break;
        case 5:
            $formulario->setVariable("mensaje_error","<b>Error:</b> El tama&ntilde;o de la imagen es demasiado grande.") ; 
        break;
    };
}


$template->setVariable("contenido",$formulario->get());