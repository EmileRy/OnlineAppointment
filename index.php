<?php
include("components/navbar/main.php");
?>
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Welcome to LatvijasDoctor</h1>
            <p class="col-lg-10 fs-4">LatvijasDoctor allows you to book medical appointment online. Many doctors already joined the platform so you can easily find different types of doctors.</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <?php
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                include("components/login/main.php");
            } else {
                include("components/find-doctor-form/main.php");
            }
            ?>
        </div>
    </div>
    <?php include("components/featured-doctors/main.php") ?>

<?php
include("components/footer/main.php");