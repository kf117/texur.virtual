<?php
session_start();
$_SESSION["idioma_gestor"]=$_GET["id"];
echo "<script>window.location = 'index.php'</script>";
