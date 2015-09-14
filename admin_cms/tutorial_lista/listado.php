<?php
inicializar($listado,  dirname(__FILE__)."/listado.html");
if(isset($_GET["del"]) && is_numeric($_GET["del"])){
     $db->rawData("UPDATE opcion SET opcion_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE lista_id=".$_GET["del"]);
     $db->rawData("UPDATE lista_opcion SET lista_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE lista_id=".$_GET["del"]);
      $_GET["msg"]=3;
}

$criterio_busqueda="";

 $listado->setVariable("acc_form",$_GET["acc"]);
if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador

$_SESSION["busqueda"]["titulo"]=$_POST["titulo"];



}
if(isset($_SESSION["busqueda"])){
$post_titulo=$_SESSION["busqueda"]["titulo"];


}


if(isset($post_titulo) && trim($post_titulo)!=""){//die();   
    $criterio_busqueda.=" AND lista_nombre LIKE '%{$post_titulo}%'";
    $listado->setVariable("titulo", $post_titulo);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM lista_opcion 
    WHERE lista_eliminado=0 AND id_idioma=".$_SESSION["idioma_gestor"]." $criterio_busqueda ";


/////////////PAGINADOR//////////////////////////////////
include_once (dirname(dirname(dirname(__FILE__)))).'/functions/inc/paginator.class.php';
$pages = new Paginator;  
$cantidad_mostrar=15;
$pages->items_per_page=$cantidad_mostrar;
$_GET["ipp"]=$cantidad_mostrar;
$resultados=paginar($db,$pages,$qry,$listado);
/////////////PAGINADOR//////////////////////////////////

if(count($resultados)){
    foreach ($resultados as $mod){
        
        $listado->setVariable("titulo_lis",  $mod["lista_nombre"]);
        if($mod["lista_principal"]==1)
            $listado->setVariable("principal_lis","SI");
        else
        $listado->setVariable("principal_lis","NO");
        if(isset($_GET["page"]))
         $listado->setVariable("pagelist",$_GET["page"]);
        else $listado->setVariable("pagelist",1);
        if($_SESSION["accion_activa"]["acc_eliminar"]){
            $listado->setVariable("idelim",$mod["lista_id"]);
            $listado->setVariable("accelim",$_GET["acc"]);
            }
        
        if($_SESSION["accion_activa"]["acc_editar"]){
            $listado->setVariable("idlist",$mod["lista_id"]); 
            $listado->setVariable("acclist",$_GET["acc"]);
            }
         $listado->parse("resultados");   
    }
}

switch ($_GET["msg"]){
    
    case 3:
        $listado->setVariable("mensaje_exito","<b>Exito:</b> La lista ha sido eliminada correctamente.") ; 
        break;
   
                    }

$listado->setVariable("paginado",$pages->display_pages());  

$template->setVariable("contenido",$listado->get());
?>
