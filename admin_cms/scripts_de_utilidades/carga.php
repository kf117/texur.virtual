<?php
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
$db = new mydb();
   $sql = "INSERT INTO moto (moto_descripcion, modelo_id, color_id, moto_chasis, moto_motor, cilin_id, suc_id, moto_precio_lista
      , moto_precio_venta, clasif_id, prove_id, est_moto_id, marca_id, moto_eliminado) ".
     "VALUES ('asdasdasd', '1', '1', '123123123', '5345345345', '1', '1', '9000', '444444', '1', '1','1','1','0')";
   
   for ($i=1; $i < 10000;$i++){
  $db->rawData($sql);
   }
   die("listo");
?>
