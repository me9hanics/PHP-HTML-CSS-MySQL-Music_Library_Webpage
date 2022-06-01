<?php
session_start();
//
?>


<!DOCTYPE html>
<html lang="hu">
    <head>
        
        <link rel="stylesheet" type = "text/css" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <title>
            Informatika 2 hazi feladat weboldal
        </title>
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="keret">
            <div id="fejlec">
                <h1>Zenefeltöltő oldal</h1>
                <?php
                    if(isset($_GET['uzenet']))
                    {
                        echo('<h2>'.$_GET['uzenet'].'</h2>'.'<br>');
                    }
                ?>
            </div>
            <div class="row">        
                <div class="col-md-8"> 
                
                <?php if(isset($_SESSION["email"]))
                    { ?>
                    <p> Üdv/Welcome</p>
                    <a class="btn btn-success btn-sm" href="logout.php"><i class="fa fa-edit"></i> Kijelentkezés
                    </a>
                    <?php include 'menu.html'; ?>
                   <?php } ?> 

                   <div class="cikk">
                       <h2>Üdvözöllek a weboldalamon!</h2>
                       <p> Ha a weboldalamon vagy, a szabályokat be kell tartani. Nincs spam, ne "trollkodj", ne adj meg hamis adatokat!
                        </p>
                        <div id = "kep">
                            <img src="media/smiley.png" width="300" title="Smiley" alt="Mosolyogj!"/>
                        </div>    
                    </div>
                </div>
                <div class="col-md-4"> 
                    Jobbszélső menü.
                    <div class="modul">
                        <?php //
                            if(isset($_SESSION["email"]))
                            {
                                echo '<h4>Szerbusz '.$_SESSION["email"].'<br>'.'Drága '.$_SESSION["vnev"].' '.$_SESSION["knev"].'</h4>';
                                //<a class="btn btn-success btn-sm" href="logout.php"><i class="fa fa-edit"></i> kijelentkezés </a>
                            }
                            else
                            {
                                ?>

                                <form action="login.php" method="post">
                                <input type="text" placeholder="Email cím" name="email"/>
                                <input type="password" placeholder="Jelszó" name="jelszo"/>
                                <button type="submit">Belépés</button>
                                </form>
                                <h4>Nincs fiókod?<br/>Regisztráció:</h4>
                                <form action="reg.php" method="post">
                                <input type="text" placeholder="Vezetéknév" name="vnev"/>
                                <input type="text" placeholder="Keresztnév" name="knev"/>
                                <input type="text" placeholder="Email" name="regemail"/>
                                <input type="password" placeholder="Jelszó" name="regjelszo"/>
                                <button type="submit">Regisztráció</button>
                                </form>

                                <?php
                                //

                            }
                            ?>
                    </div>
                </div>
            </div>    
            <br style="clear: both" />
        </div>
    </body>
</html>