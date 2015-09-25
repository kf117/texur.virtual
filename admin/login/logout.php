<?php
session_start();
unset($_SESSION["usuario_gestor"]);
unset($_SESSION["idioma_gestor"]);
header("Location:../index.php");
?>
