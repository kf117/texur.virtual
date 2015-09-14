<?php
inicializar($formulario,  dirname(__FILE__)."/formulario.html");


if(!isset($_GET["id"])){     
        $formulario->setVariable("action_form", "tutorial_lista/agregar.php");
        if(isset($_SESSION["campos"])){
            $formulario->setVariable("titulo", $_SESSION["campos"]["titulo"]);
            if(isset($_SESSION["campos"]["principal"])){
                $formulario->setVariable("principal", "checked");
            }
        }
        
       
        
       
    
    
}else{
    $formulario->setVariable("action_form", "tutorial_lista/editar.php");
    include_once dirname(__FILE__).'/modificar_lista.php';
}  
                  
if(isset($_GET["msg"]))
    switch ($_GET["msg"]){
        case 1:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> La lista ha sido cargada correctamente.") ; 
            break;
        case 2:
            $formulario->setVariable("mensaje_error","<b>Error:</b> Debe cargar el t&iacute;tulo de la lista.") ; 
            break;
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> La lista ha sido modificada correctamente.") ; 
            break;
        
    }                   
$formulario->setVariable("acc",$_GET["acc"]);
$template->setVariable("contenido",$formulario->get());
?>
