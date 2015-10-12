<?php
include(dirname(dirname(__FILE__))."/functions/inc/mydb.inc.php");
$db=new mydb();
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
}

