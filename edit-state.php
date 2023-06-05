<?php

require("db.php");

if(isset($_POST["country_id"])) {
    $stmt = $pdo->prepare("select * from states where name = :name and country_id = :country_id and id != :id limit 1");
    $stmt->bindParam("name", $_POST["name"]);
    $stmt->bindParam("country_id", $_POST["country_id"]);
    $stmt->bindParam("id", $_POST["id"]);
    $stmt->execute();

    if($stmt->fetch()) {
        echo "<script>alert('State already exists')</script>";
    } else {
        $stmt = $pdo->prepare("update states set name = :name, country_id = :country_id where id = :id");
        $stmt->bindParam("name", $_POST["name"]);
        $stmt->bindParam("country_id", $_POST["country_id"]);
        $stmt->bindParam("id", $_POST["id"]);
        $stmt->execute();
        echo "<script>alert('State updated successfully')</script>";
    }
}

$stmt = $pdo->prepare("select * from countries");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from states where id = :id limit 1");
$stmt->bindParam("id", $_GET["id"]);
$stmt->execute();
$state = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php require("header.php") ?>
    <form class="card mx-auto" action="" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Edit State</div>
        <div class="card-body">
            <input type="hidden" name="id" id="id" value="<?= $state["id"] ?>">

            <div class="mb-3">
                <label for="country_id" class="form-label">Country</label>

                <select required name="country_id" id="country_id" class="form-control form-select">
                    <option value="">Choose a country</option>
                    <?php foreach($countries as $country): ?>
                        <option <?= $country["id"] == $state["country_id"] ? "selected" : "" ?> value="<?= $country["id"] ?>"><?= $country["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $state["name"] ?>">
            </div>

            <button class="btn btn-primary">Update</button>
        </div>
    </form>
<?php require("footer.php") ?>
