<?php

require("db.php");

$stmt = $pdo->prepare("select states.id, states.name, countries.name as country from states inner join countries on countries.id = states.country_id order by countries.name asc");
$stmt->execute();
$states = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php 
    $page_title = "States";
    require("header.php") 
?>
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
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">Action</th>
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
