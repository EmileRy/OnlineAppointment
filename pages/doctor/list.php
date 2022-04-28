<?php
include("../../components/navbar/main.php");

$type = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["type_id"])) {
    $doctors = Doctor::getAll($link, $_POST["type_id"]);
    $type = Type::getById($link, $_POST["type_id"]);
} else {
    $doctors = Doctor::getAll($link);
}

?>

    <div class="row">
        <div class="col-lg-4">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo($type == null ? "Doctor" : $type->name) ?>s</h5>
                    <p class="card-text">We found <span class="badge bg-secondary"><?php echo(sizeof($doctors)) ?></span> <?php echo($type == null ? "doctors" : strtolower($type->name) . (sizeof($doctors) > 1 ? "s" : "")) ?></p>
                </div>
            </div>
            <div class="list-group" style="margin-bottom: 20px;">
                <form method='post' action='<?php echo(htmlspecialchars($_SERVER["PHP_SELF"])) ?>'>
                    <button type='submit' class='list-group-item list-group-item-action <?php echo($type == null ? " active" : "") ?>'>All</button>
                </form>
                <?php
                $types = Type::getAll($link);
                foreach($types as $t){
                    echo("<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>\n");
                    echo("<input type='hidden' name='type_id' value='$t->id'>\n");
                    echo("<button type='submit' class='list-group-item list-group-item-action" . ($type != null && $type->id == $t->id ? " active" : "") . "'>" . $t->name . "s</button>\n");
                    echo("</form>\n");
                }
                ?>
            </div>
        </div>
        <div class="col">
            <div class="list-group">
                <?php
                foreach($doctors as $doctor){
                    $doctor_user = $doctor->getUser($link);
                    $doctor_type = $doctor->getType($link);

                    echo("<form method='post' action='../../pages/doctor/main.php'>\n");
                    echo("<input type='hidden' name='doctor_id' value='$doctor->id'>\n");
                    echo("<button type='submit' class='list-group-item list-group-item-action'>\n");
                    echo("<div class='d-flex w-100 justify-content-between'>\n");
                    echo("<h5 class='mb-1'>Dr. " . $doctor_user->first_name . " " . $doctor_user->name . "</h5>\n");
                    echo("<small><span class='badge bg-secondary'>Click to view</span></small>\n");
                    echo("</div>\n");
                    echo("<p class='mb-1'>" . $doctor->address . "</p>\n");
                    echo("<small>" . $doctor_type->name . "</small>\n");
                    echo("</button>\n");
                    echo("</form>\n");
                }
                ?>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");