<?php
try {
    $dsn = "mysql:host=localhost;dbname=Store_LB1";
    $user = "root";
    $pass = "";
    $dbh = new PDO($dsn, $user, $pass);

} catch (PDOException $ex) {
    echo $ex->GetMessage();
}