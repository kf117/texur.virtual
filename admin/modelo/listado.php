<?php

inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
$_SESSION["busqueda"]["marca"]=$_POST["marca"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];
$post_marca=$_SESSION["busqueda"]["marca"];
}



 if(isset($post_marca) && trim($post_marca)!="")   {
    $criterio_busqueda.=" AND marca_id=$post_marca ";
}

$marcas=$db->consulta("SELECT * FROM marca WHERE marca_eliminado=0");
    if(count($marcas)){
        foreach ($marcas as $marca){
           if(isset($post_marca) && $marca["marca_id"]==$post_marca)
               $listado->setVariable("selected_marca","selected");
           $listado->setVariable("marca_nombre",$marca["marca_nombre"]); 
           $listado->setVariable("marca_id",$marca["marca_id"]); 
           $listado->parse("marcas");
        }
    }

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND modelo_nombre LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM modelo WHERE modelo_eliminado=0 $criterio_busqueda ORDER BY modelo_nombre ";
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
        $listado->setVariable("modelo",$rs["modelo_nombre"]);

        $marca_lis=$db->consulta("SELECT * FROM marca WHERE marca_id=".$rs["marca_id"]);
        $listado->setVariable("marca_lis",$marca_lis[0]["marca_nombre"]);
        
        if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/modelo/".$rs["modelo_foto"]) && $rs["modelo_foto"]!="")
        	$listado->setVariable("modelo_foto",$rs["modelo_foto"]);
        else
        	$listado->setVariable("no_aviable","");

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["modelo_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["modelo_id"]);
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
