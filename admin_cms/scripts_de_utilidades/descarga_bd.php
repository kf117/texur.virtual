
<?php
if(is_file($_SERVER["DOCUMENT_ROOT"]."/archivos_backup/backup01-06-2013.sql")){

// conexion a mysql
$hostname_conexion = "localhost";
$database_conexion = "test";
$username_conexion = "root";
$password_conexion = "";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 

// seleccionamos la base de datos
mysql_select_db($database_conexion, $conexion);

// obtenemos el archivo enviado por post
//consulta=$_FILES['file'];

// leemos el contenido del archivo
$consultasql = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/archivos_backup/backup01-06-2013.sql");
//$conssql = explode(";", $consultasql);
//$consultsql=$conssql[5];


// ejecutamos la consulta
//$query_Recordset1 = $consultsql;
$query_Recordset1 = $consultasql;
mysql_query($query_Recordset1, $conexion) or die(mysql_error());

}

// PARA PRUEBAS:
//print_r($consulta);
//echo $consultasql;
//echo $consulta['tmp_name'];
//echo $consultsql;

?>
