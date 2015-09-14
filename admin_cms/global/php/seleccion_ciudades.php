<?php
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/util.inc.php");
include(dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php");
$db = new mydb();
inicializar($lst_ciudades,dirname(dirname(__FILE__))."/tpl/ciudades.html");
$ciudades = $db->consulta("SELECT * FROM ciudad WHERE prov_id=".$_GET["prov_id"]);
if(count($ciudades))
{
    foreach($ciudades as $ciudad){
       $lst_ciudades->setVariable("ciudad_id", $ciudad["ciud_id"]);
       $lst_ciudades->setVariable("ciudad_nombre", htmlentities($ciudad["ciud_nombre"])) ;
       $lst_ciudades->setVariable("id_provincia", $ciudad["prov_id"]) ;
       $lst_ciudades->parse("blq_ciudades");
        }
}
$lst_ciudades->show();
?>
