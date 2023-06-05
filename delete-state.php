<?php

require("db.php");

$stmt = $pdo->prepare("delete from states where id = :id");
$stmt->bindParam("id", $_POST["id"]);
$stmt->execute();
echo "<script>alert('State deleted successfully'); window.location.href='/states.php'</script>";

?>