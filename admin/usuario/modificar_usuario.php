<?php


session_start();
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/seguridad.php");
include(dirname(dirname(__FILE__))."/entidades/usuario.class.php");


$db = new mydb();
$usuario = new usuario();

if(trim($_POST["nombre"]) != '' && trim($_POST["apellido"]) != '' )
{

 if(md5($_POST["passwordact"]) == $_SESSION["usuario_gestor"]["us_pass"])
 {
     
        $usuario->setus_id($_SESSION["usuario_gestor"]["us_id"]);
        $usuario->setperfil_id($_SESSION["usuario_gestor"]["perfil_id"]);
        $usuario->setus_apellido(addslashes($_POST["apellido"]));
        $usuario->setus_direccion(addslashes($_POST["domicilio"]));
        $usuario->setus_email(addslashes($_POST["email"]));
        $usuario->setus_nick(addslashes($_POST["nickname"]));
        $usuario->setus_nombre(addslashes($_POST["nombre"]));
        $usuario->setus_telefono(addslashes($_POST["telefono"]));
       
        
     
     if(($_POST["password"])== ($_POST["repassword"]) && trim($_POST["repassword"])=="")
    {
        
        $usuario->setus_pass($_SESSION["usuario_gestor"]["us_pass"]);
        $_SESSION["usuario_gestor"]["us_nombre"] = $_POST["nombre"];
        $_SESSION["usuario_gestor"]["us_apellido"] = $_POST["apellido"];
        $_SESSION["usuario_gestor"]["us_telefono"] = $_POST["telefono"];
        $_SESSION["usuario_gestor"]["us_direccion"] = $_POST["domicilio"];
        $_SESSION["usuario_gestor"]["us_email"] = $_POST["email"];
        
        $usuario->upd();
        header("Location:/admin/index.php?acc=".$_POST["acc"]."&msg=3"); 
    } 
    else if(($_POST["password"])== ($_POST["repassword"]) && trim($_POST["repassword"])!="")
    {
        
        $usuario->setus_pass(md5($_POST["repassword"]));
        $_SESSION["usuario_gestor"]["us_nombre"] = $_POST["nombre"];
        $_SESSION["usuario_gestor"]["us_pass"] = md5($_POST["repassword"]);
        $_SESSION["usuario_gestor"]["us_apellido"] = $_POST["apellido"];
        $_SESSION["usuario_gestor"]["us_telefono"] = $_POST["telefono"];
        $_SESSION["usuario_gestor"]["us_direccion"] = $_POST["domicilio"];
        $_SESSION["usuario_gestor"]["us_email"] = $_POST["email"];
        
        $usuario->upd();
        header("Location:/admin/index.php?acc=".$_POST["acc"]."&msg=3"); 
    }
    else {
        header("Location:/admin/index.php?acc=".$_POST["acc"]."&msg=1"); 
        //mensaje de error de passw distintas
        
        }
 }
 else
 {
      header("Location:/admin/index.php?acc=".$_POST["acc"]."&msg=2"); 
     //mensaje de error clave actual es distinta
      
 }
 
}
else
{
      header("Location:/admin/index.php?acc=".$_POST["acc"]."&msg=4"); 
}
 
  
?>
