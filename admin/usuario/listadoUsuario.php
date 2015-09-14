<?php
inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nick"]=$_POST["nick"];
$_SESSION["busqueda"]["tipo_usuario"]=$_POST["tipo_usuario"];
}
if(isset($_SESSION["busqueda"])){
$post_dni=$_SESSION["busqueda"]["nick"];
$post_tipo_usuario=$_SESSION["busqueda"]["tipo_usuario"];

}
/////////////
////***************ARMO EL FORMULARIO DE BUSQUEDA; MARCA, MODELO, PROVEEDOR, UBICACION... ETC****************************////

///////////////////*************************************************************************************************/////////
/////////////////////////CARGO LOS PARAMETROS DE POST EN EL FORMULARIO QUE VIENEN DE LA BUSQUEDA
// Y ARMO EL CRITERIO DE BUSQUEDA PARA LA CONSULTA/////////////////////////////

if(isset($post_dni) && trim($post_dni)!=""){//die();
    $listado->setVariable("nick",$post_dni);
    $criterio_busqueda.=" AND us_apellido LIKE '%{$post_dni}%'";
}

$perfiles = $db->consulta("SELECT * FROM perfil");

if(count($perfiles))
{
    foreach ($perfiles as $p){
        if(isset($post_tipo_usuario) && $post_tipo_usuario== $p["perfil_id"])
            $listado->setVariable("selected_perfil", "selected") ;
        $listado->setVariable("perfil_id", $p["perfil_id"]) ;
        $listado->setVariable("perfil_n_s", $p["perfil_nombre"]) ;
        $listado->parse("perfiles");
    }    
}
if(isset($post_tipo_usuario) && $post_tipo_usuario!=0){
    $criterio_busqueda.=" AND u.perfil_id={$post_tipo_usuario} ";
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM usuario u LEFT JOIN perfil p ON p.perfil_id=u.perfil_id WHERE u.us_eliminado=0 $criterio_busqueda AND u.us_id!={$_SESSION["usuario_gestor"]["us_id"]} ORDER BY u.us_nick ";
//$rs=$db->consulta($qry);
//die(print_r($rs));
/////////////PAGINADOR//////////////////////////////////
include_once (dirname(dirname(__FILE__))).'/functions/inc/paginator.class.php';
$pages = new Paginator;  
$cantidad_mostrar=15;
$pages->items_per_page=$cantidad_mostrar;
$_GET["ipp"]=$cantidad_mostrar;
$resultados=paginar($db,$pages,$qry,$listado);
/////////////PAGINADOR//////////////////////////////////
if(count($resultados)){
    foreach ($resultados as $rs){
        $listado->setVariable("nickname",$rs["us_nick"]);
        $listado->setVariable("apellido",$rs["us_apellido"]);
        $listado->setVariable("nombre",$rs["us_nombre"]);
        $listado->setVariable("telefono",$rs["us_telefono"]);
        $listado->setVariable("domicilio",$rs["us_direccion"]);
       
        $listado->setVariable("tipo_de_usuario_lis",$rs["perfil_nombre"]);
        
        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["us_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["us_id"]);
        $listado->setVariable("acc_ed",$_GET["acc"]);
        }
        $listado->parse("resultados");
    }
}
$listado->setVariable("paginado",$pages->display_pages());  

$template->setVariable("contenido",$listado->get());
?>
