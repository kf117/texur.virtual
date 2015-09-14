<?php
//motos vendidas casuales
//SELECT * FROM `moto` WHERE est_moto_id=4 AND moto_eliminado=0
include(dirname(dirname(__FILE__))."/functions/inc/util.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
include(dirname(dirname(__FILE__))."/entidades/cliente.class.php");
include(dirname(dirname(__FILE__))."/entidades/casual.class.php");
include(dirname(dirname(__FILE__))."/entidades/conyugue.class.php");
include(dirname(dirname(__FILE__))."/entidades/venta.class.php");

$db=new mydb();
$cony=new conyugue();
$cony->setcony_dni("888888888");
$cony->setcony_eliminado(0);
$cony->setcony_nombre("8888888");
$cony->settipo_dni_id(1);
$id_cony=$cony->add();

$casual= new casual();
$casual->setcasual_eliminado(0);
$casual->setcasual_fecha_nacimiento('0000-00-00');
$casual->setcasual_lugar_nacimiento("888888888");
$casual->setest_civil_id(1);
$casual->setcasual_profesion("8888888888");
$casual->setconyugue_id($id_cony);
$id_casual=$casual->add();

$cliente=new cliente();
$cliente->setcasual_id($id_casual);
$cliente->setcli_apellido("888888888");
$cliente->setcli_cp("888");
$cliente->setcli_cuil("888888");
$cliente->settipo_dni_id(1);
$cliente->setrevendedor_id(0);
$cliente->setciud_id(123);
$cliente->setcli_dni("8888888");
$cliente->setcli_domicilio("88888888");
$cliente->setcli_eliminado(0);
$cliente->setcli_email("hola8888@hotmail.com");
$id_cliente=$cliente->add();

$ventas_casuales=$db->consulta("SELECT * FROM `moto` WHERE est_moto_id=4 AND moto_eliminado=0 AND suc_id<10");
foreach ($ventas_casuales as $vc){
    
    $venta = new venta();
    
    $venta->setcli_id($id_cliente);
    $venta->setest_venta_id(4);
    $venta->setmoto_id($vc["moto_id"]);
    $venta->setsuc_id($vc["suc_id"]);
    $venta->setus_id(2);
    $venta->setus_id_modifica(0);
    $venta->setventa_descripcion("");
    $venta->setventa_eliminado(0);
    $venta->setventa_fecha(date("Y-m-d"));
    $venta->setventa_fecha_entrega(date("Y-m-d H:i:s"));
    $venta->setventa_monto_adicional();
    $venta->setventa_nro_factura();
    $venta->setventa_numero();
    $venta->setventa_precio($vc["moto_precio_venta"]);
    $id_venta=$venta->add();
            
            
    $pago_fecha=date("Y-m-d");
    $db->rawData("INSERT INTO pago (pago_monto,forma_id,venta_id,cant_cuotas,us_id,pago_cheque,pago_nro_cheque,pago_fecha) 
            VALUES ({$vc["moto_precio_venta"]},1,$id_venta,1 ,2,0,'','$pago_fecha')");
}

// motos vendidas a revendedor  
//  SELECT * FROM `moto` WHERE est_moto_id=4 AND suc_id>=10 AND moto_eliminado=0

$ventas_a_reventas=$db->consulta("SELECT * FROM moto m INNER JOIN sucursal s ON s.suc_id=m.suc_id WHERE m.est_moto_id=4 AND m.suc_id>=10 AND m.moto_eliminado=0");
foreach ($ventas_a_reventas as $vcr){
    
    $venta1 = new venta();
    
    $venta1->setcli_id($vcr["cli_id"]);
    $venta1->setest_venta_id(4);
    $venta1->setmoto_id($vcr["moto_id"]);
    $venta1->setsuc_id($vcr["suc_id"]);
    $venta1->setus_id(2);
    $venta1->setus_id_modifica(0);
    $venta1->setventa_descripcion("");
    $venta1->setventa_eliminado(0);
    $venta1->setventa_fecha(date("Y-m-d"));
    $venta1->setventa_fecha_entrega(date("Y-m-d H:i:s"));
    $venta1->setventa_monto_adicional();
    $venta1->setventa_nro_factura();
    $venta1->setventa_numero();
    $venta1->setventa_precio($vcr["moto_precio_venta"]);
    $id_venta=$venta1->add();
            
            
    $pago_fecha=date("Y-m-d");
    $db->rawData("INSERT INTO pago (pago_monto,forma_id,venta_id,cant_cuotas,us_id,pago_cheque,pago_nro_cheque,pago_fecha) 
            VALUES ({$vcr["moto_precio_venta"]},1,$id_venta,1 ,2,0,'','$pago_fecha')");
}


//motos que tiene un revendedor
//SELECT * FROM  `moto` WHERE est_moto_id =1 AND suc_id >=10 AND moto_eliminado =0
$conseciones=$db->consulta("SELECT * FROM moto m INNER JOIN sucursal s ON s.suc_id=m.suc_id WHERE m.est_moto_id=1 AND m.suc_id>=10 AND m.moto_eliminado=0");
foreach ($conseciones as $ccs){
    
    $venta = new venta();
    
    $venta->setcli_id($ccs["cli_id"]);
    $venta->setest_venta_id(4);
    $venta->setmoto_id($ccs["moto_id"]);
    $venta->setsuc_id($ccs["suc_id"]);
    $venta->setus_id(2);
    $venta->setus_id_modifica(0);
    $venta->setventa_descripcion("");
    $venta->setventa_eliminado(0);
    $venta->setventa_fecha(date("Y-m-d"));
    $venta->setventa_fecha_entrega(date("Y-m-d H:i:s"));
    $venta->setventa_monto_adicional();
    $venta->setventa_nro_factura();
    $venta->setventa_numero();
    $venta->setventa_precio($ccs["moto_precio_venta"]);
    $venta->add();
            
            
    $pago_fecha=date("Y-m-d");
   
}
?>
