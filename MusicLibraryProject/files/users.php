<?php
session_start();
require_once "config.php";

if(isset($_SESSION["email"])){

}
else{
    header('Location: /hazi/index.php?uzenet=Jelentkezz%20be');
}


?>




<html lang="hu">

    <head>
        <link rel="stylesheet" type = "text/css" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="keret">   
            <?php include 'menu.html'; ?>

            <div class="container main-content">

                <h1>Felhasználók</h1>  
                <?php
                    $querySelect = "SELECT userid, vezeteknev, keresztnev, email FROM felhasznalo";
                    $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
                    echo('<h2>'.'Az adataid:'.'<br>'.'Email:'.$_SESSION["email"].'<br>'.'Nev:'.$_SESSION["vnev"].' '.$_SESSION["knev"]);
                ?>
                    <a class="btn btn-success btn-sm" href="useredit.php"><i class="fa fa-edit"></i> Szerkesztés
                    </a>

                    <table class="table table-striped table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Vezetéknév</th>      
                                <th>Keresztnév</th>
                                <th>Email</th>    
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                            <tr>
                                <td><?=$row['vezeteknev']?></td>
                                <td><?=$row['keresztnev']?></td>
                                <td><?=$row['email']?></td>
                                <td>
                                    
                                </td>

                            </tr>                
                        <?php endwhile; ?> 
                        </tbody>
                    </table>
            </div>
           
        </div> 
        <?php exit() ?>
    </body>
</html>