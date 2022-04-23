<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
    <div class="row">
        <div class="col-lg-4">
            <div class="card" style="margin-bottom: 20px;">
                <img src="../../assets/images/user.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["name"]); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
                    <small class="text-muted"><a href="../../pages/account/reset-password.php">Reset my password</a></small>
                </div>
            </div>
            <div class="d-grid gap-2" style="margin-bottom: 20px;">
                <a class="btn btn-outline-primary" type="button" href="../../pages/account/logout.php">Logout</a>
            </div>
            <?php
            $doctor = Doctor::getByUserId($link, $_SESSION["id"]);
            if($doctor !== null){
                include ("account/doctor-dashboard-link.php");
            } else {
                include ("account/doctor-appliment.php");
            }
            ?>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcomming-tab" data-bs-toggle="pill" data-bs-target="#upcomming" type="button" role="tab" aria-controls="upcomming" aria-selected="true">Upcomming appointments</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-tab" data-bs-toggle="pill" data-bs-target="#past" type="button" role="tab" aria-controls="past" aria-selected="false">Past appointments</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="upcomming" role="tabpanel" aria-labelledby="pills-home-tab">
                            <?php include("account/appointments-upcomming.php"); ?>
                        </div>
                        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <?php include("account/appointments-past.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");