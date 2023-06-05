<?php

require("db.php");

$stmt = $pdo->prepare("delete from countries where id = :id");
$stmt->bindParam("id", $_POST["id"]);
$stmt->execute();
echo "<script>alert('Country deleted successfully'); window.location.href='/countries.php'</script>";

?>