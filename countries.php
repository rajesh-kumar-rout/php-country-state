<?php

require("db.php");
$stmt = $pdo->prepare("select * from countries");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require("header.php") ?>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="fw-bold text-primary">Countries</div>
            <a href="/create-country.php" class="btn btn-primary btn-sm">Create New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 700px">
                    <thead>
                        <tr>
                            <td scope="col">Id</td>
                            <td scope="col">Name</td>
                            <td scope="col">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($countries as $country): ?>
                            <tr>
                                <td><?= $country["id"] ?></td>
                                <td><?= $country["name"] ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="/edit-country.php?id=<?= $country["id"] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="/delete-country.php?id=<?= $country["id"] ?>" method="post">
                                            <input type="hidden" name="id" value="<?= $country["id"] ?>">
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php require("footer.php") ?>
