<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("accion","configuracion/guardar.php");

$parametros_sitio=$db->consulta("SELECT * FROM parametros_sitio WHERE idioma_id=".$_SESSION["idioma_gestor"]);

if(isset($_SESSION["campos"])){
    $formulario->setVariable("domicilio",  htmlspecialchars($_SESSION["campos"]["domicilio"]));
    $formulario->setVariable("email",htmlspecialchars($_SESSION["campos"]["email"]));
    $formulario->setVariable("telefono",htmlspecialchars($_SESSION["campos"]["telefono"]));
    $formulario->setVariable("skype",htmlspecialchars($_SESSION["campos"]["skype"]));
    $formulario->setVariable("descripcion",($_SESSION["campos"]["descripcion"]));
    $formulario->setVariable("palabras_clave",($_SESSION["campos"]["palabras_clave"]));
    $formulario->setVariable("facebook",htmlspecialchars($_SESSION["campos"]["facebook"]));
    $formulario->setVariable("twitter",htmlspecialchars($_SESSION["campos"]["twitter"]));
    $formulario->setVariable("google_plus",htmlspecialchars($_SESSION["campos"]["google_plus"]));
    $formulario->setVariable("youtube",htmlspecialchars($_SESSION["campos"]["youtube"]));
    if(trim($_SESSION["campos"]["google_map"])!=""){
        $formulario->setVariable("google_map",($_SESSION["campos"]["google_map"]));
        $formulario->setVariable("map_preview",$_SESSION["campos"]["google_map"]);
    }
    
}else{
    $formulario->setVariable("domicilio",  htmlspecialchars($parametros_sitio[0]["domicilio"]));
    $formulario->setVariable("email",htmlspecialchars($parametros_sitio[0]["email"]));
    $formulario->setVariable("telefono",htmlspecialchars($parametros_sitio[0]["telefono"]));
    $formulario->setVariable("skype",htmlspecialchars($parametros_sitio[0]["skype"]));
    $formulario->setVariable("descripcion",($parametros_sitio[0]["descripcion"]));
    $formulario->setVariable("palabras_clave",($parametros_sitio[0]["palabras_clave"]));
    $formulario->setVariable("facebook",htmlspecialchars($parametros_sitio[0]["facebook"]));
    $formulario->setVariable("twitter",htmlspecialchars($parametros_sitio[0]["twitter"]));
    $formulario->setVariable("google_plus",htmlspecialchars($parametros_sitio[0]["google_plus"]));
    $formulario->setVariable("youtube",htmlspecialchars($parametros_sitio[0]["youtube"]));
    if(trim($parametros_sitio[0]["mapa"])!=""){
        $formulario->setVariable("google_map",($parametros_sitio[0]["mapa"]));
        $formulario->setVariable("map_preview",$parametros_sitio[0]["mapa"]);
    }
}

if(isset($_GET["msg"]))
{
    switch ($_GET["msg"]){
        case 1:
            $formulario->setVariable("mensaje_error","<b>Error:</b> El formato del email es incorrecto.") ; 
        break;
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> Los cambios han sido cargados exitosamente.") ; 
        break;
        
    };
}


$template->setVariable("contenido",$formulario->get());