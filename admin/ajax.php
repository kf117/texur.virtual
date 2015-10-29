<?php
session_start();
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/util.inc.php");
include(dirname(dirname(__FILE__))."/functions/inc/seguridad.php");
$db=new mydb();
$db->rawData("SET NAMES 'utf8'");
switch($_GET["func"]){
    case "cambiarEstado":
        $valido_upd="";
        if($_GET["val"]==3)
            $valido_upd=",usw_fecha_valido='".date("Y-m-d H:i:s")."'";
        else
            $valido_upd=",usw_fecha_valido='0000-00-00 00:00:00'";
        echo '
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <b>Exito:</b> Se ha actualizado el estado del usuario correctamente
                    </div>
                ';
        $db->rawData("UPDATE usuario_sitio SET estado_id=".$_GET["val"]." $valido_upd WHERE usw_id=".$_GET["us"]);
        break;
        
    case "cambiarEstadoInscripto":
        
        
        echo '
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <b>Exito:</b> Se ha actualizado la inscripci&oacute;n al curso correctamente
                    </div>
                ';
        $db->rawData("UPDATE inscripto_curso SET validado=".$_GET["val"]."  WHERE inscripto_eliminado=0 AND inscripto_id=".$_GET["ins"]);
        break;    
    case "cambiarEstadoPedido":
        
        
        echo '
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <b>Exito:</b> Se ha actualizado el estado del pedido correctamente
                    </div>
                ';
        $db->rawData("UPDATE pedido SET pedido_procesado=".$_GET["val"]."  WHERE pedido_eliminado=0 AND pedido_id=".$_GET["ped"]);
        break; 
    case "detallePedido":
        $salida="";
        $info=$db->consulta("SELECT * FROM pedido p  LEFT JOIN usuario_sitio us ON (p.usw_id=us.usw_id) LEFT JOIN direccion_envio de ON (de.usw_id=us.usw_id) LEFT JOIN paises pa ON (pa.id=de.pais_id)"
        . "WHERE  pedido_eliminado=0 AND pedido_id=".$_GET["ped"]);
        $info=$info[0];
        
        $productos=$db->consulta("SELECT * FROM pedido_producto pp LEFT JOIN producto p ON (pp.prod_id=p.prod_id) WHERE pedido_id=".$_GET["ped"]);
        
        $uax_extra;
        if(trim($info["dire_extra"])!="")
        $uax_extra="(".$info["dire_extra"].")";
        
        $salida="<b>Datos del Usuario</b><br>"
                . "".$info["usw_apellido"].", ".$info["usw_nombre"]." <br>"
                . "".$info["usw_email"]." <br>"
                . "".$info["usw_scanycar"]." <br>"
                ."<b>Datos para envio</b><br>"
                . "".$info["dire_direccion"]." ".$uax_extra." <br>"
                . "".$info["dire_ciudad"].", ".$info["dire_provincia"]." (".$info["dire_cp"].") <br>"
                . "".$info["nombre"]." <br>"
                . "".$info["dire_telefono"]." ".$info["dire_movil"]." <br><br>"
                ."<b>Datos del Pedido #".$info["pedido_id"]." ".  convertirFechaHora($info["pedido_fecha"])."</b><br>"
                . "<table class='table table-striped'>
                <thead>
                        <tr>
                          <th></th>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          
                        </tr>
                      </thead>
                      <tbody>";
        
        foreach ($productos as $prod){
            $img;
            if(file_exists((dirname(dirname(__FILE__)))."/img/producto/".$prod["prod_foto"]) && $prod["prod_foto"]!="")
        	$img='<img src="../img/producto/'.$prod["prod_foto"].'" width="50"  class="img-responsive img-circle">';
            else
        	$img='<i class="fa fa-shopping-cart fa-3x"></i>';
            
                    $salida.="<tr>
                          <td>$img</td>
                          <td>".$prod["prod_nombre"]."</td>
                          <td>".$prod["cantidad"]."</td>
                          
                        </tr>";
        }
                        
        $salida.="</tbody>
                </table>";
        
        
        
        echo $salida;
        break;
    case "cambiarEstadoReclamo":
        
        
        echo '
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <b>Exito:</b> Se ha actualizado el estado del reclamo correctamente
                    </div>
                ';
        $db->rawData("UPDATE reclamo SET reclamo_procesado=".$_GET["val"]."  WHERE reclamo_eliminado=0 AND reclamo_id=".$_GET["rec"]);
        break;     
    case "detalleReclamo":
        $salida="";
        $info=$db->consulta("SELECT * FROM reclamo rec LEFT JOIN pedido p ON (rec.pedido_id=p.pedido_id)  LEFT JOIN usuario_sitio us ON (p.usw_id=us.usw_id) LEFT JOIN direccion_envio de ON (de.usw_id=us.usw_id) LEFT JOIN paises pa ON (pa.id=de.pais_id)"
        . "WHERE  reclamo_eliminado=0 AND reclamo_id=".$_GET["rec"]);
        $info=$info[0];
        
        $productos=$db->consulta("SELECT * FROM pedido_producto pp LEFT JOIN producto p ON (pp.prod_id=p.prod_id) WHERE pedido_id=".$info["pedido_id"]);
        
        $uax_extra;
        if(trim($info["dire_extra"])!="")
        $uax_extra="(".$info["dire_extra"].")";
        
        $salida="<b>Datos del Usuario</b><br>"
                . "".$info["usw_apellido"].", ".$info["usw_nombre"]." <br>"
                . "".$info["usw_email"]." <br>"
                . "".$info["usw_scanycar"]." <br>"
                ."<b>Datos para envio</b><br>"
                . "".$info["dire_direccion"]." ".$uax_extra." <br>"
                . "".$info["dire_ciudad"].", ".$info["dire_provincia"]." (".$info["dire_cp"].") <br>"
                . "".$info["nombre"]." <br>"
                . "".$info["dire_telefono"]." ".$info["dire_movil"]." <br><br>"
                ."<b>Datos del Pedido #".$info["pedido_id"]." ".  convertirFechaHora($info["pedido_fecha"])."</b><br>"
                . "<table class='table table-striped'>
                <thead>
                        <tr>
                          <th></th>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          
                        </tr>
                      </thead>
                      <tbody>"
                ;
        
        foreach ($productos as $prod){
            $img;
            if(file_exists((dirname(dirname(__FILE__)))."/img/producto/".$prod["prod_foto"]) && $prod["prod_foto"]!="")
        	$img='<img src="../img/producto/'.$prod["prod_foto"].'" width="50"  class="img-responsive img-circle">';
            else
        	$img='<i class="fa fa-shopping-cart fa-3x"></i>';
            
                    $salida.="<tr>
                          <td>$img</td>
                          <td>".$prod["prod_nombre"]."</td>
                          <td>".$prod["cantidad"]."</td>
                          
                        </tr>";
        }
                        
        $salida.="</tbody>
                </table>"
                ."<b>Datos del Reclamo #".$info["reclamo_id"]." ".  convertirFechaHora($info["reclamo_fecha"])."</b><br><br>"
                ."Mensaje: ".$info["reclamo_texto"]."<br>";
        
        
        
        echo $salida;
        break;    
}

