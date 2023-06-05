<?php

require("db.php");

if(isset($_POST["name"])) {
    $stmt = $pdo->prepare("select * from countries where name = :name and id != :id limit 1");
    $stmt->bindParam("name", $_POST["name"]);
    $stmt->bindParam("id", $_POST["id"]);
    $stmt->execute();

    if($stmt->fetch()) {
        echo "<script>alert('Country already exists')</script>";
    } else {
        $stmt = $pdo->prepare("update countries set name = :name where id = :id");
        $stmt->bindParam("name", $_POST["name"]);
        $stmt->bindParam("id", $_POST["id"]);
        $stmt->execute();
        echo "<script>alert('Country updated successfully')</script>";
    }
}

$stmt = $pdo->prepare("select * from countries where id = :id");
$stmt->bindParam("id", $_GET["id"]);
$stmt->execute();
$country = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php require("header.php") ?>
    <form class="card mx-auto" action="" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Edit Country</div>
        <div class="card-body">
            <input type="hidden" name="id" id="id" value="<?= $country["id"] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $country["name"] ?>">
            </div>
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
<?php require("footer.php") ?>
