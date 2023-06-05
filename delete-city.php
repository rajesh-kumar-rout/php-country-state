<?php

require("db.php");

$stmt = $pdo->prepare("delete from cities where id = :id");
$stmt->bindParam("id", $_POST["id"]);
$stmt->execute();
echo "<script>alert('City deleted successfully'); window.location.href='/cities.php'</script>";

?>