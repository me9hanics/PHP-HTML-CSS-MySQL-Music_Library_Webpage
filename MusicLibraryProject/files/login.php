<?php
session_start();
require_once "config.php";

if(isset($_POST["email"])&&isset($_POST["jelszo"]))
{
$Querys = "SELECT * FROM felhasznalo";
$Results = $link->query($Querys);

$userjelszo = "";
$uservnev = "";
$userknev= "";
$usersor=-1;
$loguzenet = "sikertelen belépés";

    while ( $row = $Results->fetch_object() ) {

    if($_POST["email"]===$row->email){
        $usersor=$row->userid;
        $userjelszo=$row->jelszo;
        $uservnev=$row->vezeteknev; 
        $userknev=$row->keresztnev;
    }

    }

    if($usersor>-1 && $userjelszo==$_POST['jelszo']){
        $_SESSION["email"]=$_POST["email"];
        $_SESSION["vnev"]=$uservnev;
        $_SESSION["knev"]=$userknev;
        $loguzenet = "Sikeres login";
    }
    
}
header('Location: /hazi/index.php?uzenet='.$loguzenet);
exit();
?>