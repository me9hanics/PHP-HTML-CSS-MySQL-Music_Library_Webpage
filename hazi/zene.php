<?php
session_start();
require_once "config.php";

if(isset($_SESSION["email"])){

}
else{
    header('Location: /hazi/index.php?uzenet=Jelentkezz%20be');
}

$created = false;
if (isset($_POST['create'])) {
    $cim = mysqli_real_escape_string($link, $_POST['cim']);
    $szerzo = mysqli_real_escape_string($link, $_POST['szerzo']);
    $zsanra = mysqli_real_escape_string($link, $_POST['zsanra']);
    $nyelv = mysqli_real_escape_string($link, $_POST['nyelv']);
    $kiadas = mysqli_real_escape_string($link, $_POST['kiadas']);
    $zenelink = mysqli_real_escape_string($link, $_POST['zenelink']);


    $createQuery = sprintf("INSERT INTO zene(cim, zsanra, nyelv, kiadas, link) VALUES ('%s', '%s', '%s', '%s', '%s' )",
        $cim,
        $zsanra,
        $nyelv,
        $kiadas,
        $zenelink
    );
    $eredmeny1 = mysqli_query($link, $createQuery) or die(mysqli_error($link)); //lehetett volna irni mast is minden mysqli_query helyett pl. login fajl

    $zeneszamozas =-1;
    $zeneQuery = ("SELECT * from zene");
    $zeneeredmeny = mysqli_query($link, $zeneQuery) or die(mysqli_error($link));
    while($zenesorozas = $zeneeredmeny->fetch_object()){
    if($zenesorozas->cim==$cim){
        $zeneszamozas=$zenesorozas->idzene;
    }
    }
    //$zenesorozas=$zeneeredmeny->fetch_object();
    //$zeneszamozas = $zenesorozas->idzene;

    $counter=0;
    
    $checkQuery="SELECT * from szerzo";
    $checker = mysqli_query($link, $checkQuery) or die(mysqli_error($link));
    while($row = $checker->fetch_object()){
        if($szerzo==$row->muvesznev)
            $counter=$row->idszerzo;
    }

    if($counter>0){
        $queryA = sprintf("INSERT INTO iras (zene_idzene,szerzo_idszerzo ) VALUES ('%d', '%d')", $zeneszamozas, $counter);
        echo($queryA );
        $eredmenyA=mysqli_query($link, $queryA) or die(mysqli_error($link));
        $created = true;
    }
    
    else{
    $createQuery2=sprintf("INSERT INTO szerzo(muvesznev) VALUES (%s)",$szerzo);    
    $eredmeny2 = mysqli_query($link, $createQuery2) or die(mysqli_error($link));
    /*$szerzoszamozas = -1;
    
    $szerzoQuery="SELECT * from szerzo sz WHERE sz.idszerzo= (SELECT max(szerzoid) from szerzo)";
    $szerzoeredmeny = mysqli_query($link, $szerzoQuery) or die(mysqli_error($link));
    while($szerzosorozas = $szerzoeredmeny->fetch_object()){
    $szerzoszamozas = $szerzosorozas->idszerzo;
    }
    $queryB = sprintf("INSERT INTO iras (zene_idzene,szerzo_idszerzo ) VALUES ('%s', '%s')", $zeneszamozas, $szerzoszamozas);
    $eredmenyB = mysqli_query($link, $queryB) or die(mysqli_error($link));

    $created = true;*/
    }
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

                <h1>Zenék</h1>  <!--Ezt ki lehetne venni, helyette uzenet-->
                <?php if ($created): ?>   
                <p>
                    <span class="badge badge-success">Sikeres hozzáadás</span>
                </p>
                <?php endif; ?>
                
                <?php
                    $search = null;
                     if (isset($_POST['search'])) {
                         $search = $_POST['search'];
                    }
                ?> <!--Ezt ki lehetne venni-->

                <form class="form-inline" method="post">
                    <div class="card">
                        <div class="card-body">
                            Keresés: 
                            <input style="width:600px;margin-left:1em;" class="form-control" type="search" name="search" value="<?=$search?>">
                            <button class="btn btn-success" style="margin-left:1em;" type="submit" >Keress</button>
                        </div>
                    </div>
                </form> <!--Ezt ki lehetne venni-->
                
                <?php
                    $querySelect = "SELECT idzene, cim, zsanra, kiadas, link, nyelv, szerzo.muvesznev FROM zene LEFT OUTER JOIN iras ON zene.idzene=iras.zene_idzene LEFT OUTER JOIN szerzo ON iras.szerzo_idszerzo=szerzo.idszerzo";
                    if ($search) {
                        $querySelect = $querySelect . sprintf(" WHERE LOWER(cim) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
                    }
                    $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
                    //$queryIras = "SELECT * FROM iras";
                    
                ?>
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cím</th>
                                <th>Szerző</th>      
                                <th>Zsanra</th>   
                                <th>Nyelv</th>    
                                <th>Kiadás</th> <!--<th style="white-space:nowrap;">Kiadás időpontja</th>-->
                                <th>Zenelink</th>
                                <th>Hallgatas szama</th>
                            </tr> 
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_array($eredmeny)):
                        
                        ?>
                            <tr>
                                <td><?=$row['cim']?></td>
                                <td><?=$row['muvesznev']?></td>
                                <td><?=$row['zsanra']?></td>
                                <td><?=$row['nyelv']?></td>
                                <td><?=$row['kiadas']?></td>
                                <td><a href='./hallgatas.php?link=<?=$row['link']?>' target='_blank'><?=$row['link']?></a></td>
                                <td></td>

                            </tr>                
                        <?php endwhile; ?> 
                        </tbody>
                    </table>
            </div>
            <form method="post" action="">
                    <div class="card">
                        <div class="card-header">
                            Zene feltöltése
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="cim">Cím</label>
                                <input required class="form-control" name="cim" id="cim" type="text"  /> <!--talan legyen mind required class--> 
                            </div>
                            <div class="form-group">
                                <label for="szerzo">Szerző</label>
                                <input required class="form-control" name="szerzo" id="szerzo" type="text" />
                            </div>
                            <div class="form-group">
                                <label for="zsanra">Zsanra (genre)</label>
                                <input required class="form-control" name="zsanra" id="zsanra" type="text"  />
                            </div>
                            <div class="form-group">
                                <label for="nyelv">Nyelv</label>
                                <input required class="form-control" name="nyelv" id="nyelv" type="text"  />
                            </div>
                            <div class="form-group">
                                <label for="kiadas">Kiadás időpontja (abcd-ef-gh formátumban)</label>
                                <input required class="form-control" name="kiadas" id="kiadas" type="date" /> <!--Datum kell number helyett-->
                            </div>
                            <div class="form-group">
                                <label for="zenelink">Link(max 45 karakter)</label>
                                <input required class="form-control" name="zenelink" id="zenelink" type="text"  />
                            </div>
                        </div>
                        <div class="card-footer">
                            <input class="btn btn-success" name="create" type="submit" value="Feltöltés" />
                        </div>
                    </div>

                </form>
        </div> 
        <?php exit() ?>
    </body>
</html>
