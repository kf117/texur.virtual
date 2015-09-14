<?php

inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];

}



    

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND marca_nombre LIKE '%".$post_nombre."%' ";
	$listado->setVariable("nombre",$post_nombre);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM marca  WHERE marca_eliminado=0 $criterio_busqueda ORDER BY marca_nombre ";
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
        $listado->setVariable("marca",$rs["marca_nombre"]);

        if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/marca/".$rs["marca_foto"]) && $rs["marca_foto"]!="")
        	$listado->setVariable("marca_foto",$rs["marca_foto"]);
        else
        	$listado->setVariable("no_aviable","");

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["marca_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["marca_id"]);
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
