<?php
$first_name = $name = $email = $password = $confirm_password = "";
$first_name_err = $name_err = $email_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter your first name.";
    } elseif(!preg_match('/^[a-zA-Z]+$/', trim($_POST["first_name"]))){
        $first_name_err = "First name can only contain letters.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } elseif(!preg_match('/^[a-zA-Z]+$/', trim($_POST["name"]))){
        $name_err = "Nname can only contain letters.";
    } else{
        $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif(!preg_match('/^[a-zA-Z0-9_@.]+$/', trim($_POST["email"]))){
        $email_err = "Email is not valid.";
    } else{
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already used.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($name_err)){

        $sql = "INSERT INTO Users (email, password, first_name, name) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_password, $param_first_name, $param_name);

            $param_first_name = $first_name;
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>
    <form class="p-4 p-md-5 border rounded-3 bg-light" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <div class="form-floating mb-3">
            <input type="text" name="first_name" value="<?php echo $first_name; ?>" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" id="floatingInput" placeholder="James">
            <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
            <label for="floatingInput">First name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="name" value="<?php echo $name; ?>" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="floatingInput" placeholder="Dean">
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
            <label for="floatingInput">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="floatingInput" placeholder="name@example.com">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="floatingPassword" placeholder="Password">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password)) ? 'is-invalid' : ''; ?>" id="floatingPassword" placeholder="Password">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            <label for="floatingPassword">Confirm password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Create account</button>
        <hr class="my-4">
        <small class="text-muted">Already have an account? <a href="../../pages/account/login.php">Login</a></small>
    </form>