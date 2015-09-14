<?php
session_start();
unset($_SESSION["usuario_gestor"]);
header("Location:../index.php");
?>
