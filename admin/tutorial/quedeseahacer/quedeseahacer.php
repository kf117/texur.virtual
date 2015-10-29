<?php

inicializar($formulario,  dirname(__FILE__)."/formulario.html");
$formulario->setVariable("acc",$_GET["acc"]);
$formulario->setVariable("max_size",ini_get('upload_max_filesize'));

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    $formulario->setVariable("accion","tutorial/quedeseahacer/editar.php");
    $formulario->setVariable("titulo_formulario","Editar <i>\"Que desea hacer\"</i>");
    include_once(dirname(__FILE__)."/mostrar.php");
}else{
    $formulario->setVariable("titulo_formulario","Nuevo <i>\"Que desea hacer\"</i>");
	
    $formulario->setVariable("accion","tutorial/quedeseahacer/guardar.php");
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qry="SELECT * FROM que_desea_hacer WHERE qdh_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"].""
        . " ORDER BY qdh_titulo ";
////

$resultados=$db->consulta($qry);
/////////////PAGINADOR//////////////////////////////////
if(count($resultados)){
    foreach ($resultados as $rs){
        $formulario->setVariable("titulo",$rs["qdh_titulo"]);

       
        
        

        if($_SESSION["accion_activa"]["acc_eliminar"]){
        $formulario->setVariable("id_eliminar",$rs["qdh_id"]);
        $formulario->setVariable("acc_elim",$_GET["acc"]);
        }
        if($_SESSION["accion_activa"]["acc_editar"]){
        $formulario->setVariable("id_editar",$rs["qdh_id"]);
        $formulario->setVariable("acc_edit",$_GET["acc"]);
        }
        $formulario->parse("resultados");
    }
}else{
	$formulario->setVariable("esta_vacio","No se han encontrado resultados");
}


if(isset($_GET["msg"]))
{
    switch ($_GET["msg"]){
        case 1:
            $formulario->setVariable("mensaje_error","<b>Error:</b> Debe ingresar los campos requeridos.") ; 
        break;
        case 2:
            $formulario->setVariable("mensaje_error","<b>Error:</b> El formato de la imagen es incorrecto.") ; 
        break;
        case 3:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> El nuevo registro ha sido cargado exitosamente.") ; 
        break;
        case 4:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> El registro ha sido modificado correctamente.") ; 
        break;
        case 5:
            $formulario->setVariable("mensaje_error","<b>Error:</b> El tama&ntilde;o de la imagen es demasiado grande.") ; 
        break;
        case 6:
            $formulario->setVariable("mensaje_exito","<b>Exito:</b> El registro ha sido eliminado correctamente.") ; 
        break;
    };
}


$template->setVariable("contenido",$formulario->get());