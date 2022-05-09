<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../account/login.php");
    exit;
}

$doctor = Doctor::getByUserId($link, $_SESSION["id"]);
if($doctor != null){
    header("location: ./dashboard.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["type_id"]) && isset($_POST["identification_number"]) && isset($_POST["address"])){
    $doctor = new Doctor($_SESSION["id"], $_POST["type_id"], $_POST["address"], $_POST["identification_number"]);
    $doctor->save($link);
    header("location: ./main.php");
    exit;
}
?>
    <div class="container col-xl-10 col-xxl-6 px-4 py-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">What type of doctor are you?</label>
                <select class="form-select" name="type_id" required>
                    <?php
                    $types = Type::getAll($link);
                    foreach($types as $type){
                        echo("<option value='" . $type->id . "'>" . $type->name . "</option>\n");
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">What is your identification number? <span style="color: gray;">(numbers only)</span></label>
                <input class="form-control" name="identification_number" minlength="3" placeholder="123XXXXXX" pattern="[0-9]+" required>
            </div>
            <div class="mb-3">
                <label class="form-label">What is your professional address?</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Create my Doctor dashboard</button>
        </form>
    </div>

<?php
include("../../components/footer/main.php");