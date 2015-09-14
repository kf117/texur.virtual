<?php

 $anio=date("Y");
        $anio_pasado=$anio-1;
        $anio_que_viene=$anio+1;
       
        $moto_certif=  explode("-", $rs["moto_certificado"]);
         die(print_r($moto_certif));
        if($rs["moto_certificado"]>=$anio."-04-01"){
        $listado->setVariable("venta","venta-verde");// tiene este año y el que viene para venderse 
        $listado->setVariable("texto_tooltip","Se puede vender patentada en $anio y $anio_que_viene");
        }
        
        //if( $rs["moto_id"]==30 && $rs["moto_certificado"]>=$anio_pasado."-04-01")die($anio_pasado." pasado   llega  cert ".$rs["moto_certificado"]."   $anio ");
        
        if( ($rs["moto_certificado"]>=$anio_pasado."-04-01" && $rs["moto_certificado"]<$anio."-04-01")
               ){
        $listado->setVariable("venta","venta-amarillo");    // se tiene que vender este año 
        $listado->setVariable("texto_tooltip","Se puede vender patentada en $anio");
        }
        if( ($rs["moto_certificado"]>=$anio_pasado."-04-01" && $rs["moto_certificado"]<$anio."-04-01") 
               
                && date("Y-m-d")>=$anio."-12-01")
        {$listado->setVariable("venta","venta-anaranjado");    // se tiene que vender este mes
        $listado->setVariable("texto_tooltip","Se tiene que vender este mes");
        }
        if($rs["moto_certificado"]<$anio_pasado."-04-01"){
            $anio_patentado=  explode("-", $rs["moto_certificado"]);
        $listado->setVariable("venta","venta-rojo");    // se paso de fecha de modelo 
        $listado->setVariable("texto_tooltip","Se tiene que vender patentada ".$anio_patentado[0]);
        }
        
        if($rs["moto_certificado"]=="0000-00-00"){     
        $listado->setVariable("venta","venta-azul");    // se paso de fecha de modelo 
        $listado->setVariable("texto_tooltip","No se puede vender moto sin certificado");
        }
?>
