<?php

inicializar($listado,  dirname(__FILE__)."/inscriptos.html");
$criterio_busqueda="";
$listado->setVariable("acc_form",$_GET["acc"]);

if(isset($_POST["acc"])){//si se hizo click en buscar actualizo los parametros para el buscador
$_SESSION["busqueda"]["nombre"]=$_POST["nombre"];
$_SESSION["busqueda"]["curso"]=$_POST["curso"];
$_SESSION["busqueda"]["email"]=$_POST["email"];
$_SESSION["busqueda"]["apellido"]=$_POST["apellido"];
$_SESSION["busqueda"]["estado"]=$_POST["estado"];
}
if(isset($_SESSION["busqueda"])){
$post_nombre=$_SESSION["busqueda"]["nombre"];
$post_curso=$_SESSION["busqueda"]["curso"];
$post_email=$_SESSION["busqueda"]["email"];
$post_apellido=$_SESSION["busqueda"]["apellido"];
$post_estado=$_SESSION["busqueda"]["estado"];
}

if(isset($post_nombre) && trim($post_nombre)!=''){
    $criterio_busqueda.=" AND usw_nombre LIKE '%".addslashes($post_nombre)."%' ";
	$listado->setVariable("nombre",  htmlspecialchars($post_nombre));
}

if(isset($post_apellido) && trim($post_apellido)!=''){
    $criterio_busqueda.=" AND usw_apellido LIKE '%".addslashes($post_apellido)."%' ";
	$listado->setVariable("apellido",  htmlspecialchars($post_apellido));
}

if(isset($post_email) && trim($post_email)!=''){
    $criterio_busqueda.=" AND usw_email LIKE '%".addslashes($post_email)."%' ";
	$listado->setVariable("email",  htmlspecialchars($post_email));
}
if(isset($post_estado) && trim($post_estado)!=''){
    $criterio_busqueda.=" AND validado=".($post_estado)." ";
	$listado->setVariable("validado_".$post_estado, "selected");
}

if(isset($post_curso) && trim($post_curso)!=''){
    $criterio_busqueda.=" AND ic.curso_id=".($post_curso)." ";
	
}


$cursos=$db->consulta("SELECT * FROM curso WHERE curso_eliminado=0 ");
    if(count($cursos))
        foreach ($cursos as $curso){
            if(isset($post_curso) && $post_curso==$curso["curso_id"] )
                $listado->setVariable("curso_selected","selected") ; 
            $listado->setVariable("curso_id",$curso["curso_id"]) ; 
            $listado->setVariable("curso_nombre",$curso["curso_nombre"]) ; 
            $listado->parse("cursos") ; 
        }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM inscripto_curso ic LEFT JOIN curso c ON (ic.curso_id=c.curso_id) LEFT JOIN usuario_sitio us ON (ic.usw_id=us.usw_id)"
        . "WHERE  inscripto_eliminado=0  $criterio_busqueda"
        . " ORDER BY validado ASC,fecha_inscripcion DESC ";
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
        $listado->setVariable("nombre_lis",$rs["usw_apellido"].", ".$rs["usw_nombre"]);
        $listado->setVariable("email_lis",$rs["usw_email"]);
        $listado->setVariable("fecha_lis",convertirFecha($rs["fecha_inscripcion"]));
        $listado->setVariable("curso_lis",$rs["curso_nombre"]);
        $listado->setVariable("validado_lis_".$rs["validado"],"selected");
        if($rs["validado"]==1)
            $listado->setVariable("alerta_color","alert-success");
        else
        $listado->setVariable("alerta_color","alert-danger");
        
        $listado->setVariable("id_inscripto",$rs["inscripto_id"]);
        
        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $listado->setVariable("id_eliminar",$rs["inscripto_id"]);
        $listado->setVariable("acc",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $listado->setVariable("id_editar",$rs["inscripto_id"]);
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
