<?php

class menu_gestor{
//variables de mapeo
var $mu_id;
var $mu_id_padre;
var $mu_id_dependiente;
var $mu_accion;
var $mu_javascripts;
var $mu_url;
var $mu_orden;
var $mu_nombre_opcion;
//variables de clase
var $campos;
var $db;

///////////////////////
function menu_gestor($id=0){
$this->db = new mydb();
$this->tabla = 'menu_gestor';
$this->campos = 'mu_id,mu_id_padre,mu_id_dependiente,mu_accion,mu_javascripts,mu_url,mu_orden,mu_nombre_opcion';

if($id){
$this->get($id);
}

}
////////////////////


////////////////////
function add(){ $values = "$this->mu_id,$this->mu_id_padre,$this->mu_id_dependiente,'$this->mu_accion','$this->mu_javascripts','$this->mu_url',$this->mu_orden,'$this->mu_nombre_opcion'";
$this->mu_id = $this->db->add($values,$this->campos,$this->tabla); return $this->mu_id; }
//////////////////////




///////////////////


function del(){
$GLOBALS["db"]->del("mu_id = $this->mu_id",$this->tabla);
}

//////////////////////////




/////////////////////////
function get($id = 0){
    if($id){
    $rs = $GLOBALS["db"]->consulta("SELECT *        FROM $this->tabla
       WHERE mu_id = $id");
    $this->mu_id = $rs[0]["mu_id"];
    $this->mu_id_padre = $rs[0]["mu_id_padre"];
    $this->mu_id_dependiente = $rs[0]["mu_id_dependiente"];
    $this->mu_accion = $rs[0]["mu_accion"];
    $this->mu_javascripts = $rs[0]["mu_javascripts"];
    $this->mu_url = $rs[0]["mu_url"];
    $this->mu_orden = $rs[0]["mu_orden"];
    $this->mu_nombre_opcion = $rs[0]["mu_nombre_opcion"];
}
}



//////////////////////




///////////////////////////
function setmu_id($par=0){
if(!$par){
$this->mu_id = -1;
}else{
$this->mu_id = (int)$par;
}
}




///////////////////////
function setmu_id_padre($par=0){
if(!$par){
$this->mu_id_padre = 0;
}else{
$this->mu_id_padre = (int)$par;
}
}



////////////////////

///////////////////////
function setmu_id_dependiente($par=0){
if(!$par){
$this->mu_id_dependiente = 0;
}else{
$this->mu_id_dependiente = (int)$par;
}
}



////////////////////

///////////////////////
function setmu_accion($par=''){
if(!$par){
$this->mu_accion = '';
}else{
$this->mu_accion = (string)$par;
}
}



////////////////////

///////////////////////
function setmu_javascripts($par=''){
if(!$par){
$this->mu_javascripts = '';
}else{
$this->mu_javascripts = (string)$par;
}
}



////////////////////

///////////////////////
function setmu_url($par=''){
if(!$par){
$this->mu_url = '';
}else{
$this->mu_url = (string)$par;
}
}



////////////////////

///////////////////////
function setmu_orden($par=0){
if(!$par){
$this->mu_orden = 0;
}else{
$this->mu_orden = (int)$par;
}
}



////////////////////

///////////////////////
function setmu_nombre_opcion($par=''){
if(!$par){
$this->mu_nombre_opcion = '';
}else{
$this->mu_nombre_opcion = (string)$par;
}
}


/*function subMenu($perfil,$opcion=0,$dep,&$tpl){//die(" a".$opcion);
	if($opcion!=0){
	$rs=$GLOBALS["db"]->consulta("SELECT * FROM menu_gestor mg inner join menu_perfiles mp on mp.mu_id=mg.mu_id WHERE mg.mu_id_padre=$opcion AND mp.pf_id=$perfil");
		//die(print_r($rs));
		if(count($rs))
		foreach ($rs as $r){
			
			$tpl->setVariable("opcion",$r["mu_nombre_opcion"]);
			$tpl->setVariable("url_opcion",$r["mu_url"]);
			$tpl->parse("opciones_padres");
		}
	}
}*/



function armarMenu($perfil,$opcion=0,$dep,$tpl){
    $accion="";
	if($opcion==0){
		
		$rs=$GLOBALS["db"]->consulta("SELECT * FROM menu_gestor mg inner join menu_perfiles mp on mp.mu_id=mg.mu_id WHERE mg.mu_id_padre=0 AND mp.pf_id=$perfil");
		//die(print_r($rs));
		foreach ($rs as $r){
			
			$tpl->setVariable("opcion",$r["mu_nombre_opcion"]);
			$tpl->setVariable("url_opcion",$r["mu_url"]);
			$tpl->parse("opciones_padres");
		}
		//$tpl->parse("menu");
	}else{			
			$arbol_genealogico="";//OBTENGO TODOS LOS ANTEPASADOS DE LA OPCION MARCADA HASTA QUE LLEGUE A EL
			$copia_opcion=$opcion;//porque se modifica en el for asi no la pierdo
			while($opcion!=0){
				
				$rs=$GLOBALS["db"]->consulta("SELECT * FROM menu_gestor mg inner 
                                        join menu_perfiles mp on mp.mu_id=mg.mu_id WHERE mg.mu_id=$opcion AND mp.pf_id=$perfil");
				//die(print_r($rs));
				$arbol_genealogico.=" ".$rs[0]["mu_id_padre"]; 
				$opcion=$rs[0]["mu_id_padre"];
			
			}
			/////////////////////MUESTRO LAS OPCIONES QUE SON ANTEPASADOS////////////(OSEA PADRES, QUE APARECEN ARRIBA -.-)
			$array_auxiliar=explode(" ",$copia_opcion.$arbol_genealogico);//die(print_r($array_auxiliar));
			$js="";
			$accion="";
			for($i=sizeof($array_auxiliar)-1;$i>=0;$i--){
			$rs=$GLOBALS["db"]->consulta("SELECT * FROM menu_gestor mg inner join menu_perfiles mp on mp.mu_id=mg.mu_id 
                            WHERE mg.mu_id_padre=".$array_auxiliar[$i]." AND mp.pf_id=$perfil");
		//die(print_r($rs));
				foreach ($rs as $r){
                                    if($i==sizeof($array_auxiliar)-1){
					if($copia_opcion==$r["mu_id"]){
						$js=$r["mu_javascripts"];
						$accion=$r["mu_accion"];
                                               
					}
                                        if($array_auxiliar[$i-1]==$r["mu_id"])
                                        $tpl->setVariable("opcion_activa","active");
					$tpl->setVariable("opcion",$r["mu_nombre_opcion"]);
					$tpl->setVariable("url_opcion",$r["mu_url"]);
					$tpl->parse("opciones_padres");
                                    }else{
                                        if($copia_opcion==$r["mu_id"]){
						$js=$r["mu_javascripts"];
						$accion=$r["mu_accion"];
                                               
					}
                                        if($array_auxiliar[$i-1]==$r["mu_id"])
                                        $tpl->setVariable("opcion_activahijo","active");
					$tpl->setVariable("opcionhijo",$r["mu_nombre_opcion"]);
					$tpl->setVariable("url_opcionhijo",$r["mu_url"]);
					$tpl->parse("opcioneshijo");
                                    }
				}
                                if($i!=sizeof($array_auxiliar)-1)
				$tpl->parse("submenu");
			}
			/*if($accion){
			include_once($accion);
			$tpl->setVariable("contenido",$tpl_contenedor->get());
			}*/
			$jss=explode("|",$js);
			foreach ($jss as $j=>$value){
				$tpl->setVariable("javascript",$value);
				$tpl->parse("bloque_javascript");
			}
		
	}
       
        return $accion;
}

////////////////////
}

?>