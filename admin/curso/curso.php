<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("max_size",ini_get('upload_max_filesize'));

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    $formulario->setVariable("titulo_formulario","Editar Curso");
    $formulario->setVariable("accion","curso/editar.php");
    include_once(dirname(__FILE__)."/mostrar.php");
}else{
    $formulario->setVariable("titulo_formulario","Nuevo Curso");
	if(isset($_SESSION["campos"])){
		$formulario->setVariable("nombre",htmlspecialchars($_SESSION["campos"]["nombre"]));
                $formulario->setVariable("selected_".$_SESSION["campos"]["destacada"],"selected");
                $formulario->setVariable("selected_p_".$_SESSION["campos"]["publicada"],"selected");
                $formulario->setVariable("selected_t_".$_SESSION["campos"]["tipo"],"selected");
                $formulario->setVariable("descripcion",  ($_SESSION["campos"]["descripcion"]));
                $formulario->setVariable("palabras_clave",$_SESSION["campos"]["palabras_clave"]);
                $formulario->setVariable("previa", addslashes($_SESSION["campos"]["previa"]));
                $formulario->setVariable("contenido",addslashes($_SESSION["campos"]["contenido"]));
        }
    
    $formulario->setVariable("accion","curso/guardar.php");
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