
<?php

require("db.php");

$stmt = $pdo->prepare("select * from countries");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from states where id = :state_id limit 1");
$stmt->bindParam("state_id", $_GET["state_id"]);
$stmt->execute();
$state = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from states where country_id = :country_id");
$stmt->bindParam("country_id", $state["country_id"]);
$stmt->execute();
$states = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from cities where state_id = :state_id");
$stmt->bindParam("state_id", $state["id"]);
$stmt->execute();
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["state_id"])) {
    $stmt = $pdo->prepare("DELETE FROM cities WHERE state_id = :state_id");
    $stmt->bindParam("state_id", $_POST["state_id"]);
    $stmt->execute();

    foreach ($_POST["names"] as $city) {
        $stmt = $pdo->prepare("INSERT INTO cities (name, state_id) VALUES (:name, :state_id)");
        $stmt->bindParam("name", $city);
        $stmt->bindParam("state_id", $_POST["state_id"]);
        $stmt->execute();
    }
    header('Location: /cities.php');
    die();
}

?>

<?php require("header.php") ?>
    <form class="card mx-auto" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Manage Cities</div>

        <div class="card-body">
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
                <label for="state_id" class="form-label">State</label>
                <select required name="state_id" id="state_id" class="form-control form-select">
                    <option value="">Choose a country</option>
                    <?php foreach($states as $loop_state): ?>
                        <option <?= $loop_state["id"] == $state["id"] ? "selected" : "" ?> value="<?= $loop_state["id"] ?>"><?= $loop_state["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="name-container mb-3">
                <label for="name" class="form-label mb-0">Name</label>
                <div class="name-items">
                    <?php if(count($cities) == 0): ?>
                        <div class="name-item d-flex gap-2 mt-3">
                            <input type="text" class="form-control" name="names[]">
                            <button type="button" id="btnAddCity" class="btn btn-sm btn-success">Add</button>
                        </div>
                    <?php endif; ?>

                    <?php for($i=0;$i<count($cities);$i++): ?>
                        <div class="name-item d-flex gap-2 mt-3">
                            <input type="text" class="form-control" value="<?= $cities[$i]["name"] ?>" name="names[]">
                            <?php if($i == 0): ?>
                                <button type="button" id="btnAddCity" class="btn btn-sm btn-success">Add</button>
                            <?php else: ?>
                                <button type="button" onclick="removeNameItem(event)" class="btn btn-sm btn-danger">Remove</button>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <button class="btn btn-primary">Save</button>
        </div>
    </form>

    <script>
        document.querySelector("#country_id").onchange = async (event) => {
            const response = await fetch(`/ajax.php?action=get_states_by_country&&country_id=${event.target.value}`)
            const states = await response.json()
            
            document.querySelector("#state_id").innerHTML = `
                <option>Choose a state</option>
                ${states.map(state => `<option value="${state.id}">${state.name}</option>`).join("")}
            `
        }

        document.querySelector("#state_id").onchange = async event => {
            const response = await fetch(`/ajax.php?action=get_cities_by_state&&state_id=${event.target.value}`)
            const cities = await response.json()
            
            document.querySelector(".name-items").innerHTML = ''

            cities.forEach((city, index) => {
                let nameItem = document.createElement("div")
                nameItem.classList.add("name-item")
                nameItem.classList.add("d-flex")
                nameItem.classList.add("gap-2")
                nameItem.classList.add("mt-3")
                nameItem.innerHTML = `
                    <input type="text" class="form-control" value="${city.name}" name="names[]">
                    ${index == 0 ? `<button type="button" id="btnAddCity" class="btn btn-sm btn-success">Add</button>` :
                    `<button type="button" onclick="removeNameItem(event)" class="btn btn-sm btn-danger">Remove</button>`}
                `
                document.querySelector(".name-items").appendChild(nameItem)
            })
        }

        document.querySelector("#btnAddCity").onclick = event => {
            const nameItem = document.createElement("div")
            nameItem.classList.add("name-item")
            nameItem.classList.add("d-flex")
            nameItem.classList.add("gap-2")
            nameItem.classList.add("mt-3")
            nameItem.innerHTML = `
                <input type="text" class="form-control" name="names[]">
                <button type="button" onclick="removeNameItem(event)" class="btn btn-sm btn-danger">Remove</button>
            `
            event.target.closest(".name-items").appendChild(nameItem)
        }
        
        function removeNameItem(event) {
            event.target.closest(".name-item").remove()
        }
    </script>
<?php require("footer.php") ?>
