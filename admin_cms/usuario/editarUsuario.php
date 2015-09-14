<?php
include(dirname(dirname(__FILE__))."/entidades/usuario.class.php");

    
$usuario=new usuario($_GET["id"]);
$formulario->setVariable("apellido",  htmlspecialchars($usuario->us_apellido)) ;
$formulario->setVariable("nombre",htmlspecialchars($usuario->us_nombre) );
$formulario->setVariable("email",htmlspecialchars($usuario->us_email) );
$formulario->setVariable("telefono",htmlspecialchars($usuario->us_telefono) );
$formulario->setVariable("domicilio",htmlspecialchars($usuario->us_direccion)) ;
$formulario->setVariable("nick",htmlspecialchars($usuario->us_nick)) ;
$formulario->setVariable("id",$usuario->us_id) ;

$perfiles = $db->consulta("SELECT * FROM perfil");

if(count($perfiles))
{
    foreach ($perfiles as $p){
        if($usuario->perfil_id== $p["perfil_id"])
            $formulario->setVariable("selected_perfil", "selected") ;
        $formulario->setVariable("perfil_id", $p["perfil_id"]) ;
        $formulario->setVariable("perfil", $p["perfil_nombre"]) ;
        $formulario->parse("perfiles");
    }    
}
if(isset($_GET["msg"]))
switch ($_GET["msg"]){
    case 6:
        $formulario->setVariable("mensaje_exito","<b>Exito:</b> Se ha editado el profesor de manera exitosa.") ; 
        break;
     case 1:
        $formulario->setVariable("mensaje_exito","<b>Exito:</b> Se ha agregado el profesor de manera exitosa.") ; 
        break;
    case 2:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Faltan cargar campos obligatorios.") ; 
        break;
    case 5:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Las contraseñas no coinciden, o estan vacías.") ; 
        break;
    case 3:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Ya existe ese usuario.") ; 
        break;
 }
 $formulario->setVariable("accion","../usuario/editar_usuario.php") ;    



$formulario->setVariable("acc",$_GET["acc"]) ;

$template->setVariable("contenido",$formulario->get());
?>
