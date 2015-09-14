<?php
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
$db = new mydb();
inicializar($lst_modelos,dirname(dirname(__FILE__))."/tpl/modelos.html");
$modelos = $db->consulta("SELECT * FROM modelo WHERE marca_id=".$_GET["marca_id"]." AND modelo_eliminado=0 ");
if(count($modelos))
{
    foreach($modelos as $modelo){
       $lst_modelos->setVariable("modelo_id", $modelo["modelo_id"]);
       $lst_modelos->setVariable("modelo_nombre", htmlentities($modelo["modelo_nombre"])) ;
       //$lst_modelos->setVariable("id_marca", $modelo["prov_id"]) ;
       $lst_modelos->parse("blq_modelos");
        }
}
$lst_modelos->show();
?>
