<?php
$exp_email = '[_a-z0-9\-]+(\.[_a-z0-9\-]+)*\@[_a-z0-9\-]+(\.[a-z]{1,4})+';
$email="asaddasda@adsdas.cm";
if(strpos($email," ")!==false)
        die("no");
    if( preg_match("/$exp_email/i",$email))
            die("valido") ;
?>