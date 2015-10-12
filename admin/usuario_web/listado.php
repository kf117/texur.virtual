<?php

inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
$_SESSION["busqueda"]["apellido"]=$_POST["apellido"];
$_SESSION["busqueda"]["estado"]=$_POST["estado"];
$_SESSION["busqueda"]["scanycar"]=$_POST["scanycar"];
$_SESSION["busqueda"]["email"]=$_POST["email"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];
$post_apellido=$_SESSION["busqueda"]["apellido"];
$post_estado=$_SESSION["busqueda"]["estado"];
$post_scanycar=$_SESSION["busqueda"]["scanycar"];
$post_email=$_SESSION["busqueda"]["email"];
}



    

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND usw_nombre LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}
if(isset($post_apellido) && trim($post_apellido)!=''){
    $criterio_busqueda.=" AND usw_apellido LIKE '%".addslashes($post_apellido)."%' ";
	$listado->setVariable("apellido",  htmlspecialchars($post_apellido));
}
if(isset($post_scanycar) && trim($post_scanycar)!=''){
    $criterio_busqueda.=" AND usw_scanycar LIKE '%".addslashes($post_scanycar)."%' ";
	$listado->setVariable("scanycar",  htmlspecialchars($post_scanycar));
}

if(isset($post_email) && trim($post_email)!=''){
    $criterio_busqueda.=" AND usw_email LIKE '%".addslashes($post_email)."%' ";
	$listado->setVariable("email",  htmlspecialchars($post_email));
}

if(isset($post_estado) && ($post_estado)!=0){
    $criterio_busqueda.=" AND estado_id=".($post_estado)." ";
}

$estados=$db->consulta("SELECT * FROM usuario_sitio_estado WHERE estado_eliminado=0");
        foreach($estados as $estado){
            if(isset($post_estado) && $post_estado==$estado["estado_id"])
            $listado->setVariable("selected_estado","selected");
            $listado->setVariable("estado_id",$estado["estado_id"]);
            $listado->setVariable("estado_nombre",$estado["estado_nombre"]);
            $listado->parse("estados");
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM usuario_sitio  WHERE usw_eliminado=0 $criterio_busqueda ORDER BY usw_fecha_alta DESC ";
////
include_once (dirname(dirname(dirname(__FILE__)))).'/functions/inc/paginator.class.php';
$pages = new Paginator;  
$cantidad_mostrar=15;
$pages->items_per_page=$cantidad_mostrar;
$_GET["ipp"]=$cantidad_mostrar;
$resultados=paginar($db,$pages,$qry,$listado);
/////////////PAGINADOR//////////////////////////////////
if(count($resultados)){
    foreach ($resultados as $rs){
        $listado->setVariable("fecha_alta",$rs["usw_fecha_alta"]);
        $listado->setVariable("apellido_lis",$rs["usw_apellido"]);
        $listado->setVariable("nombre_lis",$rs["usw_nombre"]);
        $listado->setVariable("email_lis",$rs["usw_email"]);
        if($rs["usw_scanycar"]!="")
            $listado->setVariable("scanycar_lis",$rs["usw_scanycar"]);
        else
            $listado->setVariable("scanycar_lis","-");

        $listado->setVariable("id_usw",$rs["usw_id"]);
        foreach($estados as $estado){
            if($rs["estado_id"]==$estado["estado_id"])
            $listado->setVariable("selected_estado_lis","selected");
            $listado->setVariable("estado_id_lis",$estado["estado_id"]);
            $listado->setVariable("estado_nombre_lis",$estado["estado_nombre"]);
            $listado->parse("estados_lis");
        }
        
        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["usw_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["usw_id"]);
        $listado->setVariable("acc_ed",$_GET["acc"]);
        }
        $listado->parse("resultados");
    }
}else{
	$listado->setVariable("esta_vacio","No se han encontrado resultados");
}
$listado->setVariable("paginado",$pages->display_pages());  

if($_GET["msg"]==1)
$listado->setVariable("mensaje_exito","<b>Exito:</b> Se ha eliminado el registro correctamente."); 

$template->setVariable("contenido",$listado->get());
?>
