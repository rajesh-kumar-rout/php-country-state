<?php

require("db.php");

$stmt = $pdo->prepare("
    SELECT 
        countries.id,
        countries.name
    FROM countries
");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

for($i=0; $i<count($countries);$i++) {
    $stmt = $pdo->prepare("
        SELECT 
            states.id,
            states.name
        FROM states
        WHERE states.country_id = :country_id
    ");
    $stmt->bindParam("country_id", $countries[$i]["id"]);
    $stmt->execute();
    $countries[$i]["states"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($j=0; $j < count($countries[$i]["states"]); $j++) { 
        $stmt = $pdo->prepare("
            SELECT 
                cities.id,
                cities.name
            FROM cities
            WHERE cities.state_id = :state_id
        ");
        $stmt->bindParam("state_id", $countries[$i]["states"][$j]["id"]);
        $stmt->execute();
        $countries[$i]["states"][$j]["cities"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<?php require("header.php") ?>
    <div class="card">
        <div class="card-header fw-bold text-primary">Cities</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 700px">
                    <thead>
                        <tr>
                            <th scope="col">Country</th>
                            <th scope="col">States</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($countries as $country): ?>
                            <tr>
                                <td><?= $country["name"] ?></td>
                                <td>
                                    <table class="table table-secondary table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="30%">Name</th>
                                                <th width="50%">Cities</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($country["states"] as $state): ?>
                                                <tr>
                                                    <td><?= $state["name"] ?></td>
                                                    <td>
                                                        <?php foreach($state["cities"] as $city): ?>
                                                            <p><?= $city["name"] ?></p>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td>
                                                        <a href="/edit-city.php?state_id=<?= $state["id"] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php require("footer.php") ?>
