<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["name"]); ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../../pages/account/account.php">Account</a></li>
        <?php
        $doctor = Doctor::getByUserId($link, $_SESSION["id"]);
        if($doctor !== null){
            echo("<li><a class='dropdown-item' href='../../pages/dashboard/main.php'>Dashboard</a></li>\n");
        }
        ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="../../pages/account/logout.php">Logout</a></li>
    </ul>
</li>