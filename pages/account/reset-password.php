<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../index.php");
    exit;
}
?>
    <div class="container col-xl-10 col-xxl-6 px-4 py-5">
        <?php
        include("../../components/update-password/main.php");
        ?>
    </div>

<?php
include("../../components/footer/main.php");