
<?php

require("db.php");

$stmt = $pdo->prepare("select * from countries");
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["state_id"])) {
    foreach ($_POST["names"] as $city) {
        $stmt = $pdo->prepare("select * from cities where name = :name and state_id = :state_id limit 1");
        $stmt->bindParam("name", $city);
        $stmt->bindParam("state_id", $_POST["state_id"]);
        $stmt->execute();

        if(!$stmt->fetch()) {
            $stmt = $pdo->prepare("insert into cities (name, state_id) values (:name, :state_id)");
            $stmt->bindParam("name", $city);
            $stmt->bindParam("state_id", $_POST["state_id"]);
            $stmt->execute();
        }
    }
    echo "<script>alert('City added successfully')</script>";
}

?>

<?php 
    $page_title = "Create City";
    require("header.php") 
?>
    <form class="card mx-auto" method="post" style="max-width: 600px;">
        <div class="card-header fw-bold text-primary">Add New City</div>
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
                <label for="state_id" class="form-label">State</label>
                <select required name="state_id" id="state_id" class="form-control form-select"></select>
            </div>

            <div class="name-container mb-3">
                <label for="name" class="form-label mb-0">Name</label>
                <div class="d-flex gap-2 mt-3">
                    <input type="text" class="form-control" name="names[]">
                    <button type="button" id="btnAddCity" class="btn btn-sm btn-success">Add</button>
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

            event.target.closest(".name-container").appendChild(nameItem)
        }
        
        function removeNameItem(event) {
            event.target.closest(".name-item").remove()
        }
    </script>
<?php require("footer.php") ?>
