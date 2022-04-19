<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["name"]); ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../../pages/account/account.php">Profile</a>
        <a class="dropdown-item" href="../../pages/account/logout.php">Logout</a>
    </div>
</li>