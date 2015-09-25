<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("max_size",ini_get('upload_max_filesize'));

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    $formulario->setVariable("accion","usuario_web/editar.php");
    include_once(dirname(__FILE__)."/mostrar.php");
}else{
	if(isset($_SESSION["campos"])){
            $formulario->setVariable("nombre",htmlspecialchars($_SESSION["campos"]["nombre"]));
            $formulario->setVariable("apellido",htmlspecialchars($_SESSION["campos"]["apellido"]));
            $formulario->setVariable("scanycar",htmlspecialchars($_SESSION["campos"]["scanycar"]));
            $formulario->setVariable("email",htmlspecialchars($_SESSION["campos"]["email"]));
            $formulario->setVariable("password",htmlspecialchars($_SESSION["campos"]["password"]));
            $formulario->setVariable("direccion",htmlspecialchars($_SESSION["campos"]["direccion"]));
            $formulario->setVariable("extra",htmlspecialchars($_SESSION["campos"]["extra"]));
            $formulario->setVariable("provincia",htmlspecialchars($_SESSION["campos"]["provincia"]));
            $formulario->setVariable("ciudad",htmlspecialchars($_SESSION["campos"]["ciudad"]));
            $formulario->setVariable("cp",htmlspecialchars($_SESSION["campos"]["cp"]));
            $formulario->setVariable("telefono",htmlspecialchars($_SESSION["campos"]["telefono"]));
            $formulario->setVariable("movil",htmlspecialchars($_SESSION["campos"]["movil"]));
        }
        
        $paises=$db->consulta("SELECT * FROM paises");
        foreach($paises as $pais){
            if(isset($_SESSION["campos"]["pais"]) && $_SESSION["campos"]["pais"]==$pais["id"])
            $formulario->setVariable("selected_pais","selected");
            $formulario->setVariable("pais_id",$pais["id"]);
            $formulario->setVariable("pais_nombre",$pais["nombre"]);
            $formulario->parse("paises");
        }
        
        $estados=$db->consulta("SELECT * FROM usuario_sitio_estado WHERE estado_eliminado=0");
        foreach($estados as $estado){
            if(isset($_SESSION["campos"]["estado"]) && $_SESSION["campos"]["estado"]==$estado["estado_id"])
            $formulario->setVariable("selected_estado","selected");
            $formulario->setVariable("estado_id",$estado["estado_id"]);
            $formulario->setVariable("estado_nombre",$estado["estado_nombre"]);
            $formulario->parse("estados");
        }
    $formulario->setVariable("accion","usuario_web/guardar.php");
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