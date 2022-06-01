<?php
session_start();
require_once "config.php";

if(isset($_POST["regemail"])&&isset($_POST["regjelszo"])&&isset($_POST["vnev"])&&isset($_POST["knev"]))
{
$Querys = "SELECT * FROM felhasznalo";
$Results = $link->query($Querys);

$usersor=-1;
$reguzenet="Sikeres regisztracio";

    while ( $row = $Results->fetch_object() ) {
        if($_POST["regemail"]===$row->email){
            $usersor=$row->userid;
        }
    }

    /*if($usersor>-1 && $userjelszo==$_POST['jelszo']){
        $Querys = "SELECT * FROM felhasznalo";//SQL INSERT
        $Results = $link->query($Querys);
    }*/
    if($usersor>-1){
        $reguzenet="Ez az email már létezik";
    }
    else{
        $keresztnev = mysqli_real_escape_string($link, $_POST['knev']);
        $vezeteknev = mysqli_real_escape_string($link, $_POST['vnev']);
        $regemail = mysqli_real_escape_string($link, $_POST['regemail']);
        $regjelszo = mysqli_real_escape_string($link, $_POST['regjelszo']);

        $insQuery = sprintf("INSERT INTO felhasznalo(vezeteknev, keresztnev, email, jelszo) VALUES ('%s','%s','%s','%s')",
        $vezeteknev,
        $keresztnev,
        $regemail,
        $regjelszo
        );
        mysqli_query($link, $insQuery) or die(mysqli_error($link));
    }
}
header('Location: /hazi/index.php?uzenet='.$reguzenet);
exit();
?>
