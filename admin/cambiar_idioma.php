<?php
session_start();
$_SESSION["idioma_gestor"]=$_GET["id"];
header("Location:index.php");
die();
