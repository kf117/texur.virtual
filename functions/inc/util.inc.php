<?php
	$path = dirname(dirname(dirname(__FILE__)));

    /*path de cache de Sigma*/
   define('HEAD_CACHE_PATH', $path . "/functions/tpl/cache");
    define('HEAD_CACHEFULL_PATH', $path . "/functions/tpl/fullcache");

	require_once($path."/functions/tpl/PEAR.php");
	require_once($path."/functions/tpl/Html_Render.class.php");

    /**
     * inicializa la libreria de template y devuelve el objecto
     *
     * @access public
     */
	function inicializar(&$template,$archivo="",$cache = HEAD_CACHE_PATH) {

        if(!class_exists("Html_Render")) {
            die(dirname(__FILE__) . "/Html_Render.class.php");
            require_once(dirname(__FILE__) . "/Html_Render.class.php");
        }
        /*$cache = '';*/
        /* instancio, el root no lo seteo, pero si le seteo la cache*/
    	$template= new Html_Render('',$cache);

        /* forma de manejo de errores*/
        //$template->setErrorHandling(PEAR_ERROR_CALLBACK,array('Errorhandler','handle'));

		if($template->loadTemplatefile($archivo) != 1) {
            trigger_error("No se encontro el archivo de plantilla {$archivo}",E_USER_WARNING);
        }

	 }
	
	function convertirFechaHora($fecha,$disc_fecha="/",$disc_hora=" "){
		$aDate = explode(" ",$fecha);
		$aFecha = explode("-",$aDate[0]);
		
		return $aFecha[2].$disc_fecha.$aFecha[1].$disc_fecha.$aFecha[0].$disc_hora.$aDate[1];
	}
	
    /**
	  *transforma una cadena del formato 18-07-2005 (DD-MM-AAAA)y lo trans. en 2005-07-18, si no es pasado el parametro retorna la fecha actual 
	  */
	 function dateEsToInt($par = ""){
	 	if($par){
	 		list($day,$month,$year) = sscanf($par,'%2s-%2s-%4s');
	 		return date('Y-m-d', mktime(0,0,0,$month,$day,$year));
	 	}else{
	 		return date('Y-m-d');	 		
	 	}
	 } 	
    
	function convertirFecha($fecha,$disc_fecha="/"){
		$aDate = explode(" ",$fecha);
		$aFecha = explode("-",$aDate[0]);
		
		return $aFecha[2].$disc_fecha.$aFecha[1].$disc_fecha.$aFecha[0];
	}
	
	function obtenerExtension($file){
		$aFile = explode(".",$file);
		return array_pop($aFile);
	}
    
    function separarFecha($fecha = ''){
        $splitFecha = explode(" ",$fecha);
        
        $horas = $splitFecha[1];
        $splitHoras = explode(":",$horas);
        $hora = $splitHoras[0] . ":" . $splitHoras[1];
        
        $arrayFecha = array(0 => $splitFecha[0],
                            1 => $hora);
        return $arrayFecha;                        
    }
    
   function tiempoLectura($texto){
		$spc=0.045; //segundos por caracter
		
		$tiempo = $spc * strlen($texto);
		$hora = floor($tiempo/3600);
			
		if ($hora<=0) $hora='';
			
		else $hora = $hora."h ";
			
		$mins = floor($tiempo/60)-(floor($tiempo/3600)*60).":";
		$segs = (integer) ($tiempo%60);
			
		if (strlen($segs)<=1) $segs = "0$segs";
			
		$segs = "$segs";
		$tiempo = "$hora$mins$segs";
			
		return $tiempo;
	}		
		
    function contarPalabras($texto = ''){
        $splitTexto = explode(" ",$texto);

        return count($splitTexto);
    }
        
    
	function cortarParrafo($texto,$indice,$cantCar) {
		$result = array();
			
		if(strlen($texto) < $cantCar) {
			$result[0] = 0;
			$result[1] = 0;
			$result[2] = $texto;
		}	
		else {
			$pos = $cantCar + $indice;
			$posAux = $pos;
				
			while(($texto[$posAux] != "\n") && ($posAux < strlen($texto))) $posAux++;
				
			$textCut = substr($texto,$indice,($posAux-$indice));
				
			$result[0] = $posAux;
			$result[1] = $posAux - $pos;
			$result[2] = $textCut;
		}
		
		return $result;
	}
    
    
    /*ARMA UN BANNER DE ACUERDO A UNA ZONA*/
	function armar_banner($id_zona=0,$trasp=0,$sec_id=0,$reg_id=0,$hzo_id=0){
        include_once(conf::getInc()."/campanias.inc.php");
        $oCampania = new campanias();
        $banner = $oCampania->listarBannersHome($id_zona,$sec_id,$reg_id,$hzo_id);      
        $hora=date('H');
        
        if(count($banner))
        {
        foreach ($banner as $cam)
        {
        	if ($cam['cam_hora_f']==$cam['cam_hora_i']) {$campania=$cam; break;}
        	
        	if ($hora >=$cam['cam_hora_i'] and $hora < $cam['cam_hora_f']  ) $campania=$cam;
        	
        }
        }
        if($campania["cam_id"]){
            /*INCREMENTO LA LAS IMPRESIONES DE LA CAMPANIA*/
            $oCampania->updImpresiones($campania["cam_id"]);
            /*ACTUALIZA LA TABLA DE ESTADISTICAS*/
          //  $oCampania->updEstadisticas($campania["cam_id"],1,getIP());
            
            $html = "";
            $file = "../data/img_cont/img_banners/".$campania["cam_archivo"];
    		$img = explode(".",$campania["cam_archivo"]);
    	 	$target = ($campania["cam_target"] == "p") ? "_self" : "_blank";
            
            $name = $id_zona.$campania["cam_id"];
            
            if($trasp==1) $transparent = 'swf_'.$name.'.addParam("wmode", "transparent");';
            
            if(is_file($file)){  
                $datosFile = getimagesize($file);
                switch($img[1]){
        	  		case "swf":/*FLASH*/
                        
                        $html .= '<div id="swf_'.$name.'"></div>
                        <script type="text/javascript">
                            <!--
                            var swf_'.$name.' = new SWFObject("../global/swf/cont_banner.swf", "swf_'.$name.'", "'.$datosFile[0].'", "'.$datosFile[1].'", "7", "");
                                swf_'.$name.'.addVariable("url", "'.$campania['cam_url_link'].'");
                                swf_'.$name.'.addVariable("camp", "'.$campania['cam_id'].'");
                                swf_'.$name.'.addVariable("ban", "'.$campania['cam_id'].'");
                                swf_'.$name.'.addVariable("targ", "'.$target.'");
                                '.$transparent.'
                                swf_'.$name.'.addParam("showmenu", "false");
                                swf_'.$name.'.addParam("scale", "noscale");
                                swf_'.$name.'.addParam("salign", "lt");
                                swf_'.$name.'.addParam("quality", "high");
                                swf_'.$name.'.write("swf_'.$name.'");
                            -->
                        </script>';
                        break;
        	   		default:/*OTRO...*/
        		  		if($campania['cam_url_link'])  $add_href = "<a href='../home/cont_click.php?url=".$campania['cam_url_link']."&idcamp=".$campania['cam_id']."' target='".$target."'>";
                        
                        $html .= $add_href .' 
                            <img src="'.$file.'" width="'.$datosFile[0].'" height="'.$datosFile[1].'" alt=""></a>';
        		  		break; 
        	  	} // switch  
            }
        }
	  	return $html;
		
	 }
     
     /*ARMA UN BANNER DE ACUERDO A UNA ZONA*/
	function armar_banner_old($id_zona=0,$sec_id=0,$reg_id=0,$hzo_id=0){
        include_once(conf::getInc()."/campanias.inc.php");
        $oCampania = new campanias();
        $banner = $oCampania->listarBannersHome($id_zona,$sec_id,$reg_id,$hzo_id);        
        if($campania["cam_id"]){
            /*INCREMENTO LA LAS IMPRESIONES DE LA CAMPANIA*/
            $oCampania->updImpresiones($campania["cam_id"]);
            /*ACTUALIZA LA TABLA DE ESTADISTICAS*/
            $oCampania->updEstadisticas($campania["cam_id"],1,getIP());
            
            $html = "";
            $file = "../data/img_cont/img_banners/".$campania["cam_archivo"];
    		$img = explode(".",$campania["cam_archivo"]);
    	 	$target = ($campania["cam_target"] == "p") ? "_parent" : "_blank";
            if(is_file($file)){  
                $datosFile = getimagesize($file);
                switch($img[1]){
        	  		case "swf":/*FLASH*/
                        $html .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$datosFile[0].'px" height="'.$datosFile[1].'px" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">
                                	<param name="movie" value="../global/swf/cont_banner.swf"/>
                                	<param name="scale" value="noscale"/>
                                	<param name="salign" value="lt"/>
                                	<param name="quality" value="high"/>
                                    <param name="bgcolor" value="#ffffff">
                                    <param name="FlashVars" value="url='.$campania['cam_url_link'].'&camp='.$campania['cam_id'].'&ban='.$campania['cam_id'].'&targ='.$target.'"/>
                                	<param name="allowScriptAccess" value="sameDomain"/>
                                	<param name="menu" value="false"/>
                                    <embed src="../global/swf/cont_banner.swf" bgcolor="#ffffff" quality="high" scale="noscale" salign="lt" menu="false" width="'.$datosFile[0].'px" height="'.$datosFile[1].'px" align="middle" quality="high" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="url='.$campania['cam_url_link'].'&camp='.$campania['cam_id'].'&ban='.$campania['cam_id'].'&targ='.$target.'"/>
                                </object>';
                        
                        
        				break;
        	   		default:/*OTRO...*/
        		  		if($campania['cam_url_link'])  $add_href = "<a href='../home/cont_click.php?url=".$campania['cam_url_link']."&idcamp=".$campania['cam_id']."' target='$target'>";
                        
                        $html .= $add_href .' 
                            <img src="'.$file.'" width="'.$datosFile[0].'" height="'.$datosFile[1].'" alt=""></a>';
        		  		break; 
        	  	} // switch  
            }
        }
	  	return $html;
		
	 }
    
     /*LEO LA TABLA DE PARAMETROS*/
     function obtenerParametros(){
        $qry = "SELECT *
                FROM parametros";
        
        $rs = $GLOBALS["db"]->consulta($qry);
        return $rs[0];
    }
     
     
	 
	 //da formato a la fecha

	function dar_fecha($fecha,$op=0){
		  setlocale(LC_ALL, 'es_ES.ISO8859-1');
		DEFINE('_ISO','charset=iso-8859-1');
		DEFINE('_DATE_FORMAT','l, F de Y');
		switch ($op){
			case 0://devuelve la fecha en un formato para mostrar en la home
				list($year,$month,$day,$hh,$mm,$ss) = sscanf($fecha,'%4s-%2s-%2s %2s:%2s:%2s');
				$date = strftime('%e de %B de %Y' , mktime($hh,$mm,$ss,$month,$day,$year));
				return $date;
			break;

			case 1://Devuelve el numero del dia de la fecha pasada por par{ametro
				list($year,$month,$day) = sscanf($fecha,'%4s-%2s-%2s');
				$numero_dia = strftime('%w', mktime(0,0,0,$month,$day,$year));
				return $numero_dia;
			break;

			case 2://Devuelve el nombre del dia de la fecha pasada por par�metro
                list($year,$month,$day) = sscanf($fecha,'%4s-%2s-%2s');
                $nombre_dia = strftime('%A', mktime(0,0,0,$month,$day,$year));
				return $nombre_dia;
			break;


		}
	}
	
	/*function getLastDay($anio,$mes){
		if($mes == 12){
			$anio++;
			$mes = "01";	
		}else{
			$mes++;	
		}
		return strftime("%d",mktime(0, 0, 0,$mes, 0, $anio));
	}
	
	//Determina si un a�o es bisiesto
	function anioBisiesto($anio){
      return (($anio%4 == 0) && ($anio%100 != 0)) || ($anio%400 == 0) ? true : false;      
   	}; */
	
	//Incrementa la fecha en X cantidad de meses teniendo en cuenta que si la fecha final cae 31/02 � 30/02 � 
	//29/02(y no es a�o bisiesto) devuelve 28/02.
	/*function incrementDate($date, $months){
		list($anio,$mes,$dia) = explode("-",$date);
		$cont = $mes;
		$dias = 0;
		for($i=0; $i<$months; $i++){
			$dias += getLastDay($anio,$cont);
			$cont++;
			if($cont == 13){
				$cont = 1;
				$anio++;
			}
		}
		$fecha_new = date('Y-m-d',strtotime('+' . ($dias-1) . ' days',strtotime($date . " 00:00:00")));
		list($anio_n,$mes_n,$dia_n) = explode("-",$fecha_new);
		if(($dia == 29 or $dia == 30 or $dia == 31) and ($dia_n = 01 or $dia_n = 02 or $dia_n = 03 ) and (($mes + $months)%12  == 2 )){
			if(anioBisiesto($anio_n))	$fecha_fin = $anio_n."-02-29"; else	$fecha_fin = $anio_n."-02-28";
			return $fecha_fin;
		}
		else	return $fecha_new; 
	}*/
		
    //leo la ip de un equipo
	function getIP() {
	    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    elseif (isset($_SERVER['HTTP_VIA'])) {
	       $ip = $_SERVER['HTTP_VIA'];
	    }
	    elseif (isset($_SERVER['REMOTE_ADDR'])) {
	       $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    else {
	       $ip = "unknown";
	    }
	   
	    return $ip;
	}
	 
     
    //-------------------------------------------------------------------- 
    /*function limpiarArchivos($id_reg,$path,$formatos){
     //$id_reg: id del registro al cual le hago el upload del file
     //$path: path en donde alojo los archivos de ese registro
     //$formatos: todos los formatos permitidos
        foreach($formatos as $form){
            $file = $id_reg . $form;
            if(is_file($path . $file))  unlink($path . $file);
        }
     }*/
     //--------------------------------------------------------------------
     //DEVUELVE EL TAMANIO MAXIMO en Mb PERMITIDO PARA UN ARCHIVO
     function tamMaxFile(){
        $tamMax = ini_get('post_max_size')+1-1;//Mb
        return $tamMax;
     }
    
    
    
    /*Cambia caracteres con acentos o &Ntilde; por caracteres especiales*/
    function convertirCaracteres($texto){
        $arrayCaracteres = array(0 => array("�","�a"),
                                 1 => array("�","�e"),
                                 2 => array("�","�i"),
                                 3 => array("�","�o"),
                                 4 => array("�","�u"),
                                 5 => array("�","�A"),
                                 6 => array("�","�E"),
                                 7 => array("�","�I"),
                                 8 => array("�","�O"),
                                 9 => array("�","�U"),
                                 10 => array("�","�N"),
                                 11 => array("�","�n"));
        for($i = 0; $i<12; $i++ )
            $texto = str_replace($arrayCaracteres[$i][0],$arrayCaracteres[$i][1],$texto);
        return $texto;
    }
    
    
    //---------------------------------------------
    function getPerfilXZona($id_z = 0,$id_p = 0){
        $qry = "SELECT sysmp_publicar as publicar,sysmp_secciones as secciones,sysmp_regiones as regiones
                FROM sys_menu_perfil
                WHERE sysm_id_menu = $id_z AND sysp_id_perfil = $id_p";
        
        $rs = $GLOBALS["db"]->consulta($qry);
        return $rs[0];
    }
    
    	
	function genRand($long = 32){
	 	return substr(md5(uniqid(rand(),true)),0,$long);
	}
	
		
	
	
	function cargarRSS($ruta_fichero){//funciona para php5
		
		$contenido = "";
		$oDOM = new DOMDocument();
		if($da = fopen($ruta_fichero,"r")){
			while ($aux= fgets($da,1024)){
				$contenido.=$aux;
			}
		fclose($da);
		}else{
			echo "Error: no se ha podido leer el archivo <strong>$ruta_fichero</strong>";
		} 		
		$tagnames = array ("title","link","description");	
		if (!$oDOM->loadXML($contenido)) {
			echo "Ha ocurrido un error al procesar el documento<strong> \"$ruta_fichero\"</strong> a XML <br>";
			exit;
		}else{			
			$raiz = $oDOM->documentElement;//obtiene el elemento raiz del archivo			
			$tam=sizeof($tagnames);
			for($i=0; $i<$tam; $i++){
				$nodo = $raiz->getElementsByTagName($tagnames[$i]);
				$j=0;
				foreach ($nodo as $etiqueta){
					$matriz[$j][$tagnames[$i]]=$etiqueta->textContent;//muestro el contenido de cada nodo
					//$matriz[$j][$tagnames[$i]]=$etiqueta->firstChild->data;//Para el standard W3C
					$j++;
				}
			}
			//die(print_r($matriz));
			return $matriz;
		}
	}
    

	  /*Cambia caracteres con acentos o &Ntilde; por caracteres especiales*/
    function convertirCaracteres_inv($texto){
        $arrayCaracteres = array(0 => array("�a","�"),
                                 1 => array("�e","�"),
                                 2 => array("�i","�"),
                                 3 => array("�o","�"),
                                 4 => array("�u","�"),
                                 5 => array("�A","�"),
                                 6 => array("�E","�"),
                                 7 => array("�I","�"),
                                 8 => array("�O","�"),
                                 9 => array("�U","�"),
                                 10 => array("�N","�"),
                                 11 => array("�n","�"));
        for($i = 0; $i<12; $i++ )
            $texto = str_replace($arrayCaracteres[$i][0],$arrayCaracteres[$i][1],$texto);
        return $texto;
    }
    
    function limpiarcadenatitulo($titulo2){
			$text_entities = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','"','�','/',' ','?','�','!','�','&','%','\\','.',':',',',';','�','\'','B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z','A','E','I','O','U');
			$html_entities = array('a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','n','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','n','','','-','-','','','','','','','','','','','','','','b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z','a','e','i','o','u');
			$titulo2 = str_replace($text_entities,$html_entities,$titulo2);

	    return $titulo2;
	}
	
	
	function quitarComillas($texto){
		
		ereg_replace("'","",$texto);
		ereg_replace('"',"",$texto);
		
		return $texto;
		
	}
        function paginar($db,$pages,$qry,$tpl_lst){
            
            $qry_count=  ereg_replace("SELECT", "SELECT COUNT(", $qry);
            $qry_count= ereg_replace("FROM", ") as cant FROM", $qry_count);
            
            //$qry_count="SELECT COUNT(*) as cant FROM ($qry)  tabla";
            $rg=$db->consulta($qry_count);
            //die(print_r($rg));
            $pages->items_total = $rg[0]["cant"];//count($rg);   
            
            $pages->mid_range = 3;   
            $pages->paginate(); 
            $tpl_lst->setVariable("encontrados", $pages->items_total);
            //die(strpos( $pages->limit, "+" )." a");
            if( strpos( $pages->limit, "-" ) === false )
            $rs=$db->consulta($qry." ".$pages->limit);
            return $rs;
        }
        
        
function armarMenu($db,$template,$perfil_id,$acc,$idioma_id){
    $acciones_grales=$db->consulta("SELECT acc.*,ap.* FROM acciones acc INNER JOIN accion_perfil ap ON ap.acc_id=acc.acc_id 
        WHERE acc.acc_id_accion=0 and ap.perfil_id=$perfil_id ORDER BY acc.acc_orden");///acciones principales que se ven siempre.
    $accion_activa;//variable donde voy a guardar la accion activa.
    
    $idiomas=$db->consulta("SELECT * FROM idioma");
    
    foreach ($idiomas as $idioma){
        if($idioma_id!=$idioma["idioma_id"]){
            $template->setVariable("idioma_selected","selected");
            $template->setVariable("idioma_id",$idioma["idioma_id"]);
            $template->setVariable("idioma_nombre",$idioma["idioma_nombre"]);
            $template->setVariable("idioma_img",$idioma["idioma_bandera"]);
            $template->parse("idiomas_sets");
        }else{
            $template->setVariable("idioma_used",$idioma["idioma_nombre"]);
            $template->setVariable("idioma_used_img",$idioma["idioma_bandera"]);
        }
    }
    
    
    if(count($acciones_grales))
    foreach ($acciones_grales as $ag){
        
        if($ag["acc_ver"]==0){
               $template->setVariable("ver_sub_acciones","none");
               $template->setVariable("ver_acciones","none");
        }
        
        if($acc==$ag["acc_id"]){// Si es la que se hizo click la marco como activa.
        $template->setVariable("accion_activa","active");
        $accion_activa=$ag;
        }
        $template->setVariable("url_accion","http://".$_SERVER["HTTP_HOST"]."/admin/".$ag["acc_url"]);
        $template->setVariable("accion_nombre",$ag["acc_nombre"]);
        $template->setVariable("accion_icono",$ag["acc_icono"]);
        $acciones_hijos=$db->consulta("SELECT acc.*,ap.* FROM acciones acc INNER JOIN accion_perfil ap ON ap.acc_id=acc.acc_id 
        WHERE acc.acc_id_accion=".$ag["acc_id"]." and ap.perfil_id=$perfil_id ORDER BY acc.acc_orden");
        $template->setVariable("id_acc",$ag["acc_id"]);
        if(count($acciones_hijos)){
            $template->setVariable("url_accion","javascript:;");
            $template->setVariable("tiene_hijo",'data-toggle="collapse"');
            
            $flag=0;
            
            foreach($acciones_hijos as $ah){
               if($acc==$ah["acc_id"]){
                $template->setVariable("accion_activa","active");
                $template->setVariable("accionh_activa","color:white;background-color:#000;");
                $template->setVariable("collapse","in");
                $accion_activa=$ah;
               }
               if($ah["acc_ver"]==0){
               
               $template->setVariable("ver_acciones_h","none");
                }
               if($flag==0)
               if($acc==$ah["acc_id"] || $acc==$ag["acc_id"] ){
                $flag=1;
                $template->setVariable("ver_sub_acciones","block");// Si tiene hijos los muestro.
                }else{
                    $template->setVariable("ver_sub_acciones","none");// Si no tiene hijos escondo el bloque.
                }
                
                
               $template->setVariable("url_accionh","http://".$_SERVER["HTTP_HOST"]."/admin/".$ah["acc_url"]);
               $template->setVariable("accionh_nombre",$ah["acc_nombre"]);
               $template->setVariable("accionh_icono",$ah["acc_icono"]);
               $template->parse("accionesh");
            }
            
        }else{
            $template->setVariable("ver_acciones_h","none");
        }
        
        $template->parse("acciones");
    }
    
    if($acc>0 && trim($accion_activa["acc_archivo"])!="" ){
        $_SESSION["accion_activa"]=$accion_activa;
        include(dirname(dirname(dirname(__FILE__)))."/admin/".$accion_activa["acc_archivo"]);
        
    }else{ 
        inicializar($bienvenida,  dirname(dirname(dirname(__FILE__)))."/admin/interfaces/mensaje_bienvenida.html");
        $bienvenida->setVariable("nom_us",$_SESSION["usuario_gestor"]["us_nombre"]." ".$_SESSION["usuario_gestor"]["us_apellido"]);
        $template->setVariable("contenido",$bienvenida->get());
    }
    
}
function borrar_sesiones(){
    $aux=$_SESSION["usuario_gestor"];
    $aux2=$_SESSION["idioma_gestor"];
     session_unset();
    $_SESSION["usuario_gestor"]=$aux;
    $_SESSION["idioma_gestor"]=$aux2;
  
}
function verificarrDireccionCorreo($direccion)
{
   $sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($sintaxis,$direccion))
      return true;
   else
     return false;
}
        
?>
