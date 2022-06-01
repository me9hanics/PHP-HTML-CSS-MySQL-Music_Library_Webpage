<?php
session_start();
require_once "config.php";

if(isset($_SESSION["email"]))
{
unset($_SESSION["email"]);
}
if(isset($_SESSION["vnev"])){
    unset($_SESSION["vnev"]);
}
if(isset($_SESSION["knev"])){
    unset($_SESSION["knev"]);
}        
    
header('Location: /hazi/index.php');
exit();
?>