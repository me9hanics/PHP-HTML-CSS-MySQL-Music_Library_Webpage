<?php
session_start();
require_once "config.php";

if(isset($_GET["link"]))
{










header('Location: https://'.$_GET["link"]);
}
else{
    header('Location: /index.php');
}
exit();
?>