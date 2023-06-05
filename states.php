<?php

require("db.php");
$stmt = $pdo->prepare("select states.id, states.name, (select countries.name from countries where countries.id = states.country_id) as country from states order by name asc");
$stmt->execute();
$states = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require("header.php") ?>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="fw-bold text-primary">States</div>
            <a href="/create-state.php" class="btn btn-primary btn-sm">Create New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 700px">
                    <thead>
                        <tr>
                            <td scope="col">Id</td>
                            <td scope="col">Name</td>
                            <td scope="col">Country</td>
                            <td scope="col">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($states as $state): ?>
                            <tr>
                                <td><?= $state["id"] ?></td>
                                <td><?= $state["name"] ?></td>
                                <td><?= $state["country"] ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="/edit-state.php?id=<?= $state["id"] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="/delete-state.php?id=<?= $state["id"] ?>" method="post">
                                            <input type="hidden" name="id" value="<?= $state["id"] ?>">
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
