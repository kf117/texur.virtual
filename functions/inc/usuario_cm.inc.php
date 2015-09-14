<?php

class usuarios_cm{
//variables de mapeo
var $us_cm_id;
var $us_cm_usuario;
var $us_cm_clave_sin_md5;
var $us_cm_clave_md5;
var $us_cm_nombre;
var $us_cm_mail;
var $pf_id;
//variables de clase

var $campos;
var $db;

///////////////////////
function usuarios_cm($id=0){
$this->db = new mydb();
$this->tabla = 'usuarios_cm';
$this->campos = 'us_cm_id,us_cm_usuario,us_cm_clave_sin_md5,us_cm_clave_md5,us_cm_nombre,us_cm_mail,pf_id';

if($id){
$this->get($id);
}

}
////////////////////


////////////////////
function add(){ $values = "$this->us_cm_id,'$this->us_cm_usuario','$this->us_cm_clave_sin_md5','$this->us_cm_clave_md5','$this->us_cm_nombre','$this->us_cm_mail',$this->pf_id";
$this->us_cm_id = $this->db->add($values,$this->campos,$this->tabla); return $this->us_cm_id; }
//////////////////////




///////////////////


function del(){
$GLOBALS["db"]->del("us_cm_id = $this->us_cm_id",$this->tabla);
}

//////////////////////////




/////////////////////////
function get($id = 0){
    if($id){
    $rs = $GLOBALS["db"]->consulta("SELECT *        FROM $this->tabla
       WHERE us_cm_id = $id");
    $this->us_cm_id = $rs[0]["us_cm_id"];
    $this->us_cm_usuario = $rs[0]["us_cm_usuario"];
    $this->us_cm_clave_sin_md5 = $rs[0]["us_cm_clave_sin_md5"];
    $this->us_cm_clave_md5 = $rs[0]["us_cm_clave_md5"];
    $this->us_cm_nombre = $rs[0]["us_cm_nombre"];
    $this->us_cm_mail = $rs[0]["us_cm_mail"];
    $this->pf_id = $rs[0]["pf_id"];
}
}



//////////////////////




///////////////////////////
function setus_cm_id($par=0){
if(!$par){
$this->us_cm_id = -1;
}else{
$this->us_cm_id = (int)$par;
}
}




///////////////////////
function setus_cm_usuario($par=''){
if(!$par){
$this->us_cm_usuario = '';
}else{
$this->us_cm_usuario = (string)$par;
}
}



////////////////////

///////////////////////
function setus_cm_clave_sin_md5($par=''){
if(!$par){
$this->us_cm_clave_sin_md5 = '';
}else{
$this->us_cm_clave_sin_md5 = (string)$par;
}
}



////////////////////

///////////////////////
function setus_cm_clave_md5($par=''){
if(!$par){
$this->us_cm_clave_md5 = '';
}else{
$this->us_cm_clave_md5 = (string)$par;
}
}



////////////////////

///////////////////////
function setus_cm_nombre($par=''){
if(!$par){
$this->us_cm_nombre = '';
}else{
$this->us_cm_nombre = (string)$par;
}
}



////////////////////

///////////////////////
function setus_cm_mail($par=''){
if(!$par){
$this->us_cm_mail = '';
}else{
$this->us_cm_mail = (string)$par;
}
}



////////////////////

///////////////////////
function setpf_id($par=0){
if(!$par){
$this->pf_id = 0;
}else{
$this->pf_id = (int)$par;
}
}



////////////////////

function validarUsuario($clave,$usuario){
	
	$rs=$GLOBALS["db"]->consulta("SELECT * FROM usuarios_cm WHERE us_cm_usuario='$usuario' AND us_cm_clave_sin_md5='$clave'");
	return $rs;
}




}


?>