<?php
inicializar($listado,  dirname(__FILE__)."/listado.html");
if(isset($_GET["del"]) && is_numeric($_GET["del"])){
     $db->rawData("UPDATE scanycar_opciones SET id_opcion_padre=0 WHERE id_opcion_padre=".$_GET["del"]);
     $db->rawData("UPDATE scanycar_opciones SET opcion_eliminado={$_SESSION["usuario_gestor"]["us_id"]} WHERE id_opcion=".$_GET["del"]);
      $_GET["msg"]=3;
}

$criterio_busqueda="";


if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador

$_SESSION["busqueda"]["opcion"]=$_POST["opcion"];
$_SESSION["busqueda"]["padre"]=$_POST["padre"];


}
if(isset($_SESSION["busqueda"])){
$post_opcion=$_SESSION["busqueda"]["opcion"];
$post_padre=$_SESSION["busqueda"]["padre"];

}


if(isset($post_opcion) && trim($post_opcion)!=""){//die();   
    $criterio_busqueda.=" AND nombre_opcion LIKE '%{$post_opcion}%'";
    $listado->setVariable("opcion", $post_opcion);
}
if(isset($post_padre) && ($post_padre)!=""){//die();   
    $criterio_busqueda.=" AND id_opcion_padre={$post_padre}";
}



$listado->setVariable("selected_null", "selected");

if(isset($post_padre) && ($post_padre)=="0")
$listado->setVariable("selected_0", "selected");


$opciones_busqueda=$db->consulta("SELECT * FROM scanycar_opciones WHERE opcion_eliminado=0 ORDER BY nombre_opcion ASC");
if(count($opciones_busqueda)){
    foreach ($opciones_busqueda as $opb){
            if(isset($post_padre) && ($post_padre)==$opb["id_opcion"])
                $listado->setVariable("opb_selected", "selected");
            $listado->setVariable("opb_id", $opb["id_opcion"]);
            $listado->setVariable("opb_nombre", $opb["nombre_opcion"]);
            $listado->parse("sel_opb");
        }
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM scanycar_opciones 
    WHERE opcion_eliminado=0 AND id_idioma=".$_SESSION["idioma_gestor"]." $criterio_busqueda ";


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
        
        $listado->setVariable("opcion_lis",  $mod["nombre_opcion"]);
        if($mod["id_opcion_padre"]){
            $nombre_padre=$db->consulta("SELECT * FROM scanycar_opciones  WHERE id_opcion=".$mod["id_opcion_padre"]);
            $listado->setVariable("opcion_previa_lis",  $nombre_padre[0]["nombre_opcion"]);
        }else{
            $listado->setVariable("opcion_previa_lis",  "Pantalla Inicial");
        }
        if(isset($_GET["page"]))
         $listado->setVariable("pagelist",$_GET["page"]);
        else $listado->setVariable("pagelist",1);
        if($_SESSION["accion_activa"]["acc_eliminar"]){
            $listado->setVariable("idelim",$mod["id_opcion"]);
            $listado->setVariable("accelim",$_GET["acc"]);
            }
        
        if($_SESSION["accion_activa"]["acc_editar"]){
            $listado->setVariable("idlist",$mod["id_opcion"]); 
            $listado->setVariable("acclist",$_GET["acc"]);
            }
         $listado->parse("resultados");   
    }
}

switch ($_GET["msg"]){
    
    case 3:
        $listado->setVariable("mensaje_exito","<b>Exito:</b> La opci&oacute;n ha sido eliminada correctamente.") ; 
        break;
   
                    }

$listado->setVariable("paginado",$pages->display_pages());  

$template->setVariable("contenido",$listado->get());
?>
