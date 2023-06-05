
<?php

if(isset($_POST["name"])) {
    require("db.php");

    $stmt = $pdo->prepare("select * from countries where name = :name limit 1");
    $stmt->bindParam("name", $_POST["name"]);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user) {
        echo "<script>alert('Country already exists')</script>";
    } else {
        $stmt = $pdo->prepare("insert into countries (name) values (:name)");
        $stmt->bindParam("name", $_POST["name"]);
        $stmt->execute();
        echo "<script>alert('Country added successfully')</script>";
    }
}

?>

<?php require("header.php") ?>
    <form class="card mx-auto" action="/create-country.php" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Add New Country</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
<?php require("footer.php") ?>
