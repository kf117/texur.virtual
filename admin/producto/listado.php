<?php

inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
$_SESSION["busqueda"]["categoria"]=$_POST["categoria"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];
$post_categoria=$_SESSION["busqueda"]["categoria"];
}

$categorias=$db->consulta("SELECT * FROM categoria_producto "
            . "WHERE catp_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);    
        if(count($categorias))
            foreach($categorias as $cat){
                if(isset($post_categoria) && $post_categoria==$cat["catp_id"])
                    $listado->setVariable("selected_categoria","selected");
                $listado->setVariable("cat_id",$cat["catp_id"]);
                $listado->setVariable("cat_nombre",$cat["catp_nombre"]);
                $listado->parse("categorias");
            }


if(isset($post_categoria) && ($post_categoria)!=0)
    $criterio_busqueda.=" AND p.catp_id=".($post_categoria)." ";

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND p.prod_nombre LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM producto p LEFT JOIN categoria_producto cp ON (p.catp_id=cp.catp_id)  "
        . "WHERE prod_eliminado=0 AND p.idioma_id=".$_SESSION["idioma_gestor"]." $criterio_busqueda"
        . " ORDER BY p.prod_nombre ";

//die($qry);
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
        $listado->setVariable("titulo",$rs["prod_nombre"]);
        $listado->setVariable("categoria_ls",$rs["catp_nombre"]);
        if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/producto/".$rs["prod_foto"]) && $rs["prod_foto"]!="")
        	$listado->setVariable("producto_foto",$rs["prod_foto"]);
        else
        	$listado->setVariable("no_aviable","");
        
        if($rs["prod_publicado"])
            $listado->setVariable("publicada","SI");
        else 
            $listado->setVariable("publicada","NO");
        
        if($rs["prod_destacado"])
            $listado->setVariable("destacada","SI");
        else 
            $listado->setVariable("destacada","NO");

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["prod_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["prod_id"]);
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
