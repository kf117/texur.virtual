<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("accion","politica_privacidad/guardar.php");

$terminos=$db->consulta("SELECT * FROM politica_privacidad WHERE idioma_id=".$_SESSION["idioma_gestor"]);

$formulario->setVariable("texto",  addslashes($terminos[0]["texto"]));

if(isset($_GET["msg"]))
{
    switch ($_GET["msg"]){
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> Los cambios han sido cargados exitosamente.") ; 
        break;
        
    };
}


$template->setVariable("contenido",$formulario->get());