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
    $criterio_busqueda.=" AND curso_nombre LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM curso "
        . "WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." $criterio_busqueda"
        . " ORDER BY curso_nombre ";
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
        $listado->setVariable("titulo",$rs["curso_nombre"]);
        
        if($rs["curso_requiere_validacion"])
            $listado->setVariable("tipo","REQUIERE VALIDACI&Oacute;N");
        else 
            $listado->setVariable("tipo","NO REQUIERE VALIDACI&Oacute;N");
        
        if($rs["curso_publicado"])
            $listado->setVariable("publicada","SI");
        else 
            $listado->setVariable("publicada","NO");
        
        if($rs["curso_destacado"])
            $listado->setVariable("destacada","SI");
        else 
            $listado->setVariable("destacada","NO");

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["curso_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["curso_id"]);
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
