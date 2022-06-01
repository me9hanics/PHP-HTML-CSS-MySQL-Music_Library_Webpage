<?php
session_start();
require_once "config.php";

if(isset($_SESSION["email"])){
    if(isset($_POST['delete'])){
        $deletequery = sprintf("DELETE FROM felhasznalo WHERE email = '%s'", 
        mysqli_real_escape_string($link, $_SESSION['email']));
        $del = mysqli_query($link, $deletequery) or die(mysqli_error($link));
        if(isset($_SESSION["email"])){
        unset($_SESSION["email"]);
        }
        if(isset($_SESSION["vnev"])){
            unset($_SESSION["vnev"]);
        }
        if(isset($_SESSION["knev"])){
            unset($_SESSION["knev"]);
        }
        header('Location: /hazi/index.php?uzenet=Jelentkezz%20be');
        return;        
    }
    if(isset($_POST["jelszo"])&&isset($_POST["vezeteknev"])&&isset($_POST["keresztnev"])&&isset($_POST["edit"])){
        $jelszo = mysqli_real_escape_string($link, $_POST["jelszo"]);
        $veznev = mysqli_real_escape_string($link, $_POST["vezeteknev"]);
        $kernev = mysqli_real_escape_string($link, $_POST["keresztnev"]);
        
        //Eredetileg at lehetett irni az emailt is, de rajottem, azzal mintha egy uj profilt csinalna az ember.

        //$Querys = "SELECT * FROM felhasznalo";
        //$Results = $link->query($Querys);
        
        //while ( $row = $Results->fetch_object() ) {
        //    if($_POST["email"]===$row->email){
        //        header('Location: /hazi/index.php?uzenet=Ilyen%20email%20mar%20van!');
        //    }   
        //}   
                $query = sprintf("UPDATE felhasznalo SET vezeteknev='%s', keresztnev='%s', jelszo ='%s' WHERE email='%s'",
                $veznev, $kernev, $jelszo, $_SESSION["email"]);
                $eredmenye = mysqli_query($link, $query) or die(mysqli_error($link));
                $_SESSION["vnev"]=$veznev;
                $_SESSION["knev"]=$kernev;
                echo("Sikeres adatvaltoztatas.");

    }

}
else{
    header('Location: /hazi/index.php?uzenet=Jelentkezz%20be');
}

?>


<html>
    <head>
        <link rel="stylesheet" type = "text/css" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php include 'menu.html'; ?>

        <div class="container main-content">
            <form method="post" action="">
                <div class="card">
                    <div class="card-header">
                        Adatok megváltoztatása. Minden adatot írj be!
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="vezeteknev">Vezetéknév</label>
                            <input required class="form-control" name="vezeteknev" id="vezeteknev" type="text"  /> 
                        </div>
                        <div class="form-group">
                            <label for="keresztnev">Keresztnév</label>
                            <input required class="form-control" name="keresztnev" id="keresztnev" type="text"  />
                        </div>
                        <div class="form-group">
                            <label for="jelszo">Uj jelszo</label>
                            <input required class="form-control" name="jelszo" id="jelszo" type="text"  />
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-success" name="edit" type="submit" value="Átírás" />
                    </div>
                    
                </div>
            </form>
            <form method="post" action=""> 
                <input class="btn btn-danger" name="delete" type="submit" value="Végleges törlés" />
            </form>

        </div>
        <?php exit() ?>
    </body>
</html>