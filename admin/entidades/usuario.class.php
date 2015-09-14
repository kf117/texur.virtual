<?php

class usuario{
//variables de mapeo
var $us_id;
var $us_nombre;
var $us_apellido;
var $us_telefono;
var $us_direccion;
var $us_email;
var $us_nick;
var $us_pass;
var $perfil_id;
//variables de clase
var $usuario;
var $campos;
var $db;

///////////////////////
function usuario($id=0){
$this->db = new mydb();
$this->tabla = 'usuario';
$this->campos = 'us_nombre,us_apellido,us_telefono,us_direccion,us_email,us_nick,us_pass,perfil_id';

if($id){
$this->get($id);
}

}
//////////////////// 


////////////////////
function add(){ $values = "'$this->us_nombre','$this->us_apellido','$this->us_telefono','$this->us_direccion','$this->us_email'
        ,'$this->us_nick','$this->us_pass',$this->perfil_id";
$this->us_id = $this->db->add($values,$this->campos,$this->tabla); return $this->us_id; }
////////////////////// 




///////////////////


function del(){
$GLOBALS["db"]->del("us_id = $this->us_id",$this->tabla);
} 

//////////////////////////




/////////////////////////
function get($id = 0){
   	if($id){
   	$rs = $GLOBALS["db"]->consulta("SELECT *        FROM $this->tabla 
       WHERE us_id = $id");
   	 $this->us_id = $rs[0]["us_id"];
   	 $this->us_nombre = $rs[0]["us_nombre"];
   	 $this->us_apellido = $rs[0]["us_apellido"];
   	 $this->us_telefono = $rs[0]["us_telefono"];
   	 $this->us_direccion = $rs[0]["us_direccion"];
   	 $this->us_email = $rs[0]["us_email"];
   	 $this->us_nick = $rs[0]["us_nick"];
   	 $this->us_pass = $rs[0]["us_pass"];
   	 $this->perfil_id = $rs[0]["perfil_id"];
         
}
}



//////////////////////




///////////////////////////
function setus_id($par=0){
if(!$par){
$this->us_id = -1;
}else{
$this->us_id = (int)$par;
}
}




///////////////////////
function setus_nombre($par=''){
if(!$par){
$this->us_nombre = '';
}else{
$this->us_nombre = (string)$par;
}
}



////////////////////

///////////////////////
function setus_apellido($par=''){
if(!$par){
$this->us_apellido = '';
}else{
$this->us_apellido = (string)$par;
}
}



///////////////////////
function setus_telefono($par=''){
if(!$par){
$this->us_telefono = '';
}else{
$this->us_telefono = (string)$par;
}
}



////////////////////

///////////////////////
function setus_direccion($par=''){
if(!$par){
$this->us_direccion = '';
}else{
$this->us_direccion = (string)$par;
}
}



////////////////////

///////////////////////
function setus_email($par=''){
if(!$par){
$this->us_email = '';
}else{
$this->us_email = (string)$par;
}
}



////////////////////

///////////////////////
function setus_nick($par=''){
if(!$par){
$this->us_nick = '';
}else{
$this->us_nick = (string)$par;
}
}



////////////////////

///////////////////////
function setus_pass($par=''){
if(!$par){
$this->us_pass = '';
}else{
$this->us_pass = (string)$par;
}
}



////////////////////

///////////////////////
function setperfil_id($par=0){
if(!$par){
$this->perfil_id = 0;
}else{
$this->perfil_id = (int)$par;
}
}



////////////////////

function upd(){
if($this->us_id){
    
$values = "us_nombre='$this->us_nombre',us_apellido='$this->us_apellido',
        us_telefono='$this->us_telefono',us_direccion='$this->us_direccion',us_email='$this->us_email',
        us_nick='$this->us_nick',us_pass='$this->us_pass', perfil_id= '$this->perfil_id'";

$this->db->update("us_id=$this->us_id",$values,$this->tabla); 
}
}
}

?>