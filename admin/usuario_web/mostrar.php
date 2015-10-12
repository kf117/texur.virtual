<?php

$usuario=$db->consulta("SELECT * FROM usuario_sitio WHERE usw_eliminado=0 AND usw_id=".$_GET["id"]);

$formulario->setVariable("id",$_GET["id"]);
$formulario->setVariable("nombre",htmlspecialchars($usuario[0]["usw_nombre"]));
$formulario->setVariable("apellido",htmlspecialchars($usuario[0]["usw_apellido"]));
$formulario->setVariable("scanycar",htmlspecialchars($usuario[0]["usw_scanycar"]));
$formulario->setVariable("email",htmlspecialchars($usuario[0]["usw_email"]));
	
$formulario->setVariable("edit_pass","(solo ingrese un password si lo desea modificar)");
$estados=$db->consulta("SELECT * FROM usuario_sitio_estado WHERE estado_eliminado=0");
foreach($estados as $estado){
    if($usuario[0]["estado_id"]==$estado["estado_id"])
        $formulario->setVariable("selected_estado","selected");
    $formulario->setVariable("estado_id",$estado["estado_id"]);
    $formulario->setVariable("estado_nombre",$estado["estado_nombre"]);
    $formulario->parse("estados");
}

$direccion=$db->consulta("SELECT * FROM direccion_envio WHERE dire_eliminado=0 AND usw_id=".$_GET["id"]);

$formulario->setVariable("direccion",htmlspecialchars($direccion[0]["dire_direccion"]));
$formulario->setVariable("extra",htmlspecialchars($direccion[0]["dire_extra"]));
$formulario->setVariable("provincia",htmlspecialchars($direccion[0]["dire_provincia"]));
$formulario->setVariable("ciudad",htmlspecialchars($direccion[0]["dire_ciudad"]));
$formulario->setVariable("cp",htmlspecialchars($direccion[0]["dire_cp"]));
$formulario->setVariable("telefono",htmlspecialchars($direccion[0]["dire_telefono"]));
$formulario->setVariable("movil",htmlspecialchars($direccion[0]["dire_movil"]));

$paises=$db->consulta("SELECT * FROM paises");
        foreach($paises as $pais){
            if($direccion[0]["pais_id"]==$pais["id"])
                $formulario->setVariable("selected_pais","selected");
            $formulario->setVariable("pais_id",$pais["id"]);
            $formulario->setVariable("pais_nombre",$pais["nombre"]);
            $formulario->parse("paises");
        }