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
    $muvesznev = mysqli_real_escape_string($link, $_POST['muvesznev']);
    $szarmazas = mysqli_real_escape_string($link, $_POST['szarmazas']);
    $leszamolas=-1;

    $szerzoQuery="SELECT * from szerzo";
    $result=mysqli_query($link, $szerzoQuery) or die(mysqli_error($link));
    while ( $row = $result->fetch_object() ){
        if($muvesznev == $row->muvesznev){
            $leszamolas=0;
            unset($_POST['create']);
            header('Location: /hazi/index.php?uzenet=Ez%20a%20zenesz%20mar%20a%20listaban%20van');
        }
        elseif(isset($_POST['create'])){
            $leszamolas=1;
        }
    }
    if($leszamolas>0){
        $createQuery = sprintf("INSERT INTO szerzo(muvesznev, szarmazas) VALUES ('%s','%s')",
            $muvesznev,
            $szarmazas,
        );
        mysqli_query($link, $createQuery) or die(mysqli_error($link)); //lehetett volna irni

        $created = true;
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

                <h1>Szerzők</h1>  
                <?php if ($created): ?>   
                <p>
                    <span class="badge badge-success">Sikeres hozzáadás</span><!--Ezt ki lehetne venni, helyette uzenet-->
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
                    $querySelect = "SELECT idszerzo, muvesznev, szarmazas, count(iras.szerzo_idszerzo) as x FROM szerzo LEFT OUTER JOIN iras ON idszerzo=iras.szerzo_idszerzo GROUP BY idszerzo ORDER BY x DESC; "; //order by count(iras.szerzo_idszerzo) DESC LIMIT 10
                    if ($search) {
                        $querySelect = $querySelect . sprintf(" WHERE LOWER(muvesznev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
                    }
                    $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
                ?>
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Szerző</th>      
                                <th>szarmazas</th>    
                                <th>Számok száma adatbázisban</th>
                            </tr> 
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                            <tr>
                                <td><?=$row['muvesznev']?></td>
                                <td><?=$row['szarmazas']?></td>
                                <td><?=$row['x']?></td>
                                <td>
                                    <!--<a class="btn btn-success btn-sm" href="edit-book.php?bookid=<?//=$row['id']?>">
                                        <i class="fa fa-edit"></i> Szerkesztés
                                    </a>-->
                                </td>

                            </tr>                
                        <?php endwhile; ?> 
                        </tbody>
                    </table>
            </div>
            <form method="post" action="">
                    <div class="card">
                        <div class="card-header">
                            Szerző feltöltése
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="muvesznev">Művésznév</label>
                                <input required class="form-control" name="muvesznev" id="muvesznev" type="text"  /> <!--talan legyen mind required class--> 
                            </div>
                            <div class="form-group">
                                <label for="szarmazas">Származas</label>
                                <input class="form-control" name="szarmazas" id="szarmazas" type="text"  />
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
