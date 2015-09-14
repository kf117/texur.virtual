<?php
inicializar($formulario,  dirname(__FILE__)."/formularioAgregarUsuario.html");


if(!isset($_GET["id"])){
    if(isset($_GET["sess"]) && $_GET["sess"]==0 && isset($_SESSION["campos"]))
        unset($_SESSION["campos"]);
    
    $formulario->setVariable("titulo_gestor","Agregar Profesor");
if(isset($_SESSION["campos"])){
$formulario->setVariable("apellido",  htmlspecialchars($_SESSION["campos"]["apellido"])) ;
$formulario->setVariable("nombre",htmlspecialchars($_SESSION["campos"]["nombre"])) ;
$formulario->setVariable("email",htmlspecialchars($_SESSION["campos"]["email"])) ;
$formulario->setVariable("telefono",htmlspecialchars($_SESSION["campos"]["telefono"])) ;
$formulario->setVariable("domicilio",htmlspecialchars($_SESSION["campos"]["domicilio"])) ;
$formulario->setVariable("nick",htmlspecialchars($_SESSION["campos"]["nick"]) );
$formulario->setVariable("contrasenia",$_SESSION["campos"]["contrasenia"]) ;
$formulario->setVariable("recontrasenia",$_SESSION["campos"]["recontrasenia"]) ;
}

$perfiles = $db->consulta("SELECT * FROM perfil");

if(count($perfiles))
{
    foreach ($perfiles as $p){
        if(isset($_SESSION["campos"]) && $_SESSION["campos"]["perfil"]== $p["perfil_id"])
            $formulario->setVariable("selected_perfil", "selected") ;
        $formulario->setVariable("perfil_id", $p["perfil_id"]) ;
        $formulario->setVariable("perfil", $p["perfil_nombre"]) ;
        $formulario->parse("perfiles");
    }    
}
if(isset($_GET["msg"]))
switch ($_GET["msg"]){
    case 1:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Las contraseñas no coinsiden, o estan vacías.") ; 
        break;
    case 2:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Faltan cargar campos obligatorios.") ; 
        break;
    case 3:
        $formulario->setVariable("mensaje_error","<b>Error:</b> Ya existe ese usuario.") ; 
        break;
 }
 $formulario->setVariable("accion","../usuario/agregar_usuario.php") ;    

}else{
    $formulario->setVariable("titulo_gestor","Editar Profesor");
    include(dirname(__FILE__)."/editarUsuario.php");  
}

$formulario->setVariable("acc",$_GET["acc"]) ;

$template->setVariable("contenido",$formulario->get());
?>
