<?php

require("db.php");

if(isset($_POST["name"])) {
    require("db.php");
    $stmt = $pdo->prepare("select * from states where name = :name and country_id = :country_id limit 1");
    $stmt->bindParam("name", $_POST["name"]);
    $stmt->bindParam("country_id", $_POST["country_id"]);
    $stmt->execute();
    $state = $stmt->fetch(PDO::FETCH_ASSOC);
    if($state) {
        echo "<script>alert('State already exists')</script>";
    } else {
        $stmt = $pdo->prepare("insert into states (name, country_id) values (:name, :country_id)");
        $stmt->bindParam("name", $_POST["name"]);
        $stmt->bindParam("country_id", $_POST["country_id"]);
        $stmt->execute();
        echo "<script>alert('State added successfully')</script>";
    }
}

$stmt = $pdo->prepare("select * from countries");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require("header.php") ?>
    <form class="card mx-auto" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Add New State</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="country_id" class="form-label">Country</label>
                <select required name="country_id" id="country_id" class="form-control form-select">
                    <option value="">Choose a country</option>
                    <?php foreach($countries as $country): ?>
                        <option value="<?= $country["id"] ?>"><?= $country["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
<?php require("footer.php") ?>
