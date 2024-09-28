<?php
include('includes/config.php');

if(isset($_GET['province_id'])) {
    $province_id = $_GET['province_id'];
    $sql = "SELECT id, name_th FROM thai_amphures WHERE province_id = :province_id ORDER BY name_th";
    $query = $dbh->prepare($sql);
    $query->bindParam(':province_id', $province_id, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}

if(isset($_GET['amphur_id'])) {
    $amphur_id = $_GET['amphur_id'];
    $sql = "SELECT id, name_th FROM thai_tambons WHERE amphure_id = :amphur_id ORDER BY name_th";
    $query = $dbh->prepare($sql);
    $query->bindParam(':amphur_id', $amphur_id, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}