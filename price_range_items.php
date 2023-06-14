<?php
include("connect.php");
$minPrice = $_GET['minPrice'];
$maxPrice = $_GET['maxPrice'];

try {
    $sqlSelect = "SELECT * FROM items, category, vendors WHERE items.price BETWEEN :minPrice AND :maxPrice AND items.FID_Category = category.ID_Category AND items.FID_Vendor = vendors.ID_Vendors";
    $stmt = $dbh->prepare($sqlSelect);
    $stmt->bindParam(':minPrice', $minPrice);
    $stmt->bindParam(':maxPrice', $maxPrice);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/json');
    
    echo json_encode($result);
} catch (PDOException $ex) {
    echo $ex->GetMessage();
}