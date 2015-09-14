<?php
inicializar($modificar,dirname(__FILE__)."/modificar_datos.html");


//  $id_usuario = $_SESSION["usuario_gestor"]["us_id"];


$modificar->setVariable("apellido",htmlspecialchars($_SESSION["usuario_gestor"]["us_apellido"]));
$modificar->setVariable("nombre",htmlspecialchars($_SESSION["usuario_gestor"]["us_nombre"])) ;
$modificar->setVariable("telefono",htmlspecialchars($_SESSION["usuario_gestor"]["us_telefono"])) ;
$modificar->setVariable("domicilio",htmlspecialchars($_SESSION["usuario_gestor"]["us_direccion"])) ;
$modificar->setVariable("email",htmlspecialchars($_SESSION["usuario_gestor"]["us_email"])) ;
$modificar->setVariable("nickname",htmlspecialchars($_SESSION["usuario_gestor"]["us_nick"])) ;

if($_SESSION["usuario_gestor"]["perfil_id"]==1)
    $modificar->setVariable("display","block") ;
else $modificar->setVariable("display","none") ;
$modificar->setVariable("accion","usuario/modificar_usuario.php") ;    
$modificar->setVariable("acc",$_GET["acc"]) ;

if(isset($_GET["msg"]))
{
    switch ($_GET["msg"]){
        case 1:
            $modificar->setVariable("mensaje_error","<b>Error:</b> La contrase&ntilde;as no coinciden.") ; 
        break;
        case 2:
            $modificar->setVariable("mensaje_error","<b>Error:</b> La contrase&ntilde;a actual no es correcta.") ; 
        break;
        case 3:
            $modificar->setVariable("mensaje_exito","<b>Exito:</b> Los cambios han sido guardados correctamente.") ; 
        break;
        case 4:
            $modificar->setVariable("mensaje_error","<b>Error:</b> Los campos obligatorios no pueden estar vacios.") ; 
        break;
        
    };
}

$template->setVariable("contenido",$modificar->get());
?>
