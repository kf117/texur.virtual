<?php
inicializar($formulario,  dirname(__FILE__)."/formulario_opcion.html");

$lista = $db->consulta("SELECT * FROM lista_opcion WHERE lista_eliminado=0 AND lista_id=".$_GET["lista_id"]);
$formulario->setVariable("lista_titulo", $lista[0]["lista_nombre"]);
$formulario->setVariable("lista_id", $lista[0]["lista_id"]);
if(!isset($_GET["id"])){     
        $formulario->setVariable("action_form", "tutorial_lista/agregar_opcion.php");
        if(isset($_SESSION["campos"]))
            $formulario->setVariable("opcion", $_SESSION["campos"]["opcion"]);
       
       $formulario->setVariable("mostrar_boton", "none");
        
        $opciones=$db->consulta("SELECT * FROM lista_opcion WHERE lista_eliminado=0 AND id_idioma=".$_SESSION["idioma_gestor"]." AND lista_id!=".$_GET["lista_id"]." ORDER BY lista_nombre ASC");
        if(count($opciones)){
            foreach ($opciones as $opcion){
                        if(isset($_SESSION["campos"]["lista_sgte"]) && $opcion["lista_id"]==$_SESSION["campos"]["lista_sgte"])
                            $formulario->setVariable("opcion_selected", "selected");
                        $formulario->setVariable("opcion_id", $opcion["lista_id"]);
                        $formulario->setVariable("opcion_nombre", $opcion["lista_nombre"]);
                        $formulario->parse("sel_opciones");
            }
        }
        
       
    
    
}else{
    $formulario->setVariable("action_form", "tutorial_lista/editar_opcion.php");
    include_once dirname(__FILE__).'/modificar_opcion.php';
}  
                  
if(isset($_GET["msg"]))
    switch ($_GET["msg"]){
        case 1:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> La opci&oacute;n ha sido cargada correctamente.") ; 
            break;
        case 2:
            $formulario->setVariable("mensaje_error","<b>Error:</b> Debe cargar el nombre de la opci&oacute;n.") ; 
            break;
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> La opci&oacute;n ha sido modificada correctamente.") ; 
            break;
        case 4:
            $formulario->setVariable("mensaje_error","<b>Error:</b> La imagen debe ser jpg, png o gif.") ; 
            break;
    }                   
$formulario->setVariable("acc",$_GET["acc"]);
$template->setVariable("contenido",$formulario->get());
?>
