<?php
inicializar($formulario,  dirname(__FILE__)."/formulario.html");


if(!isset($_GET["id"])){     
        $formulario->setVariable("action_form", "scanycar_opcion/agregar.php");
        if(isset($_SESSION["campos"]))
            $formulario->setVariable("opcion", $_SESSION["campos"]["opcion"]);
       
       $formulario->setVariable("mostrar_boton", "none");
        
        $opciones=$db->consulta("SELECT * FROM scanycar_opciones WHERE opcion_eliminado=0  AND id_idioma=".$_SESSION["idioma_gestor"]." ORDER BY nombre_opcion ASC");
        if(count($opciones)){
            foreach ($opciones as $opcion){
                        if(isset($_SESSION["campos"]["padre"]) && $opcion["id_opcion"]==$_SESSION["campos"]["padre"])
                            $formulario->setVariable("opcion_selected", "selected");
                        $formulario->setVariable("opcion_id", $opcion["id_opcion"]);
                        $formulario->setVariable("opcion_nombre", $opcion["nombre_opcion"]);
                        $formulario->parse("sel_opciones");
            }
        }
        
       
    
    
}else{
    $formulario->setVariable("action_form", "scanycar_opcion/editar.php");
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
