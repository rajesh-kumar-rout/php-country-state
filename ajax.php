<?php 

if($_GET["action"] == "get_states_by_country") {
    require("db.php");
    $stmt = $pdo->prepare("select * from states where country_id = :country_id");
    $stmt->bindParam("country_id", $_GET["country_id"]);
    $stmt->execute();
    $states = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($states);
    die;
}

if($_GET["action"] == "get_cities_by_state") {
    require("db.php");
    $stmt = $pdo->prepare("select * from cities where state_id = :state_id");
    $stmt->bindParam("state_id", $_GET["state_id"]);
    $stmt->execute();
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cities);
    die;
}