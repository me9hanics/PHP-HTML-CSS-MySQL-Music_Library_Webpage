<?php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'test');
define('DB_PASSWORD', 'testing');
define('DB_NAME', 'hazidb');


$link= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());

}//Lehetseges lett volna defineok nelkul is csatlakozni, de igy szerintem atlathatobb, best practice
?>
