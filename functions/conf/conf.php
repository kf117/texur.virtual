<?php
class conf{
	function getRoot(){
		return dirname(dirname(dirname(__FILE__)));
	}
	
	function getHead(){
		return dirname(dirname(dirname(__FILE__)))."/head";
	}
	
	function getInc(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/functions/inc/";
	}
	
	function getFun(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/functions/";
	}
	
	function getMydb(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/functions/inc/mydb.inc.php";
	}
	
	function getData(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/data/";
	}
    
	function getDataImagenes(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/data/img_cont/";
	}
    
        function getDataArchivos(){
		return /*$_SERVER["DOCUMENT_ROOT"]*/dirname(dirname(dirname(__FILE__)))."/data/arch_cont/";
	}
    
}
?>