<?php

inicializar($listado,  dirname(__FILE__)."/listado.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
$_SESSION["busqueda"]["curso"]=$_POST["curso"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];
$post_curso=$_SESSION["busqueda"]["curso"];
}

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND ic_titulo LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}

if(isset($post_curso) && trim($post_curso)!=''){
    $criterio_busqueda.=" AND ic.curso_id=$post_curso";
}


$cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($post_curso) && $post_curso==$curso["curso_id"] )
                $listado->setVariable("curso_selected","selected") ; 
            $listado->setVariable("curso_id",$curso["curso_id"]) ; 
            $listado->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $listado->parse("cursos") ; 
        }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM imagen_curso ic LEFT JOIN curso c on (ic.curso_id=c.curso_id) "
        . "WHERE curso_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]." $criterio_busqueda"
        . " ORDER BY ic_titulo ";
////
include_once (dirname(dirname(dirname(dirname(__FILE__))))).'/functions/inc/paginator.class.php';
$pages = new Paginator;  
$cantidad_mostrar=15;
$pages->items_per_page=$cantidad_mostrar;
$_GET["ipp"]=$cantidad_mostrar;
$resultados=paginar($db,$pages,$qry,$listado);
/////////////PAGINADOR//////////////////////////////////
if(count($resultados)){
    foreach ($resultados as $rs){
        $listado->setVariable("curso_lis",$rs["curso_nombre"]);
        $listado->setVariable("titulo",$rs["ic_titulo"]);
        
        if(file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/img/curso/".$rs["ic_imagen"]) && $rs["ic_imagen"]!="")
        	$listado->setVariable("imagen_foto",$rs["ic_imagen"]);
        else
        	$listado->setVariable("no_aviable","");
        

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["ic_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["ic_id"]);
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
