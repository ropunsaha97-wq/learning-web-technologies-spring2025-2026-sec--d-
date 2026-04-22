<?php
    session_start();
    $errors = [];
    $username = "";

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // A. Username: alphanumeric, period, dash, underscore only
        if(!preg_match('/^[a-zA-Z0-9._-]+$/', $username)){
            $errors['username'] = "User Name can only contain alphanumeric characters, period, dash or underscore.";
        }
        // B. Username must be at least 2 characters
        elseif(strlen($username) < 2){
            $errors['username'] = "User Name must contain at least 2 characters.";
        }

        // C. Password must not be less than 8 characters
        if(strlen($password) < 8){
            $errors['password'] = "Password must not be less than 8 characters.";
        }
        // D. Password must contain at least one special character (@, #, $, %)
        elseif(!preg_match('/[@#$%]/', $password)){
            $errors['password'] = "Password must contain at least one special character (@, #, $, %).";
        }

        if(empty($errors)){
            // Remember Me cookie
            if(isset($_POST['remember'])){
                setcookie('username', $username, time()+604800, '/');
            }
            $_SESSION['username'] = $username;
            header('location: loginSuccess.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>

    <fieldset style="width:350px;">
        <legend><strong>LOGIN</strong></legend>

        <form method="post" action="login.php" enctype="multipart/form-data">

            User Name : <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"/> <br>
            <?php if(isset($errors['username'])): ?>
                <span style="color:red;"><?php echo $errors['username']; ?></span><br>
            <?php endif; ?>

            Password &nbsp;: <input type="password" name="password" value=""/> <br>
            <?php if(isset($errors['password'])): ?>
                <span style="color:red;"><?php echo $errors['password']; ?></span><br>
            <?php endif; ?>

            <hr>
            <input type="checkbox" name="remember"/> Remember Me <br><br>

            <input type="submit" name="submit" value="Submit"/>
            <a href="forgotPassword.php">Forgot Password?</a>

        </form>
    </fieldset>

</body>
</html>
