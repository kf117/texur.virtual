<?php

$producto=$db->consulta("SELECT * FROM producto p LEFT JOIN categoria_producto cp ON (p.catp_id=cp.catp_id)"
        . " WHERE prod_eliminado=0 AND p.idioma_id=".$_SESSION["idioma_gestor"]." AND prod_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($producto[0]["prod_nombre"]));
$formulario->setVariable("descripcion",($producto[0]["prod_descripcion"]));
$formulario->setVariable("palabras_clave",($producto[0]["prod_keywords"]));
$formulario->setVariable("selected_".$producto[0]["prod_destacado"],"selected");
$formulario->setVariable("selected_p_".$producto[0]["prod_publicado"],"selected");

$categorias=$db->consulta("SELECT * FROM categoria_producto "
            . "WHERE catp_eliminado=0 AND idioma_id=".$_SESSION["idioma_gestor"]);    
        if(count($categorias))
            foreach($categorias as $cat){
                if( $producto[0]["catp_id"]==$cat["catp_id"])
                    $formulario->setVariable("selected_categoria","selected");
                $formulario->setVariable("cat_id",$cat["catp_id"]);
                $formulario->setVariable("cat_nombre",$cat["catp_nombre"]);
                $formulario->parse("categorias");
            }


if(file_exists(dirname(dirname(dirname(__FILE__)))."/img/producto/".$producto[0]["prod_foto"]) && $producto[0]["prod_foto"]!="")
	$formulario->setVariable("imagen","../img/producto/".$producto[0]["prod_foto"]);
	