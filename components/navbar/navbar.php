<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php"><span style="color: #EC7063;">Latvijas</span>Doctor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../pages/doctor/list.php">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../pages/account/account.php">Account</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php
                if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                    include ("login-buttons.php");
                } else {
                    include ("user-info.php");
                }
                ?>
            </ul>
        </div>
    </div>
</nav>