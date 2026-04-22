<?php
    session_start();
    $errors = [];
    $success = "";

    // Keep field values on error
    $name     = "";
    $email    = "";
    $username = "";
    $gender   = "";
    $dd       = "";
    $mm       = "";
    $yyyy     = "";

    if(isset($_POST['submit'])){
        $name     = trim($_POST['name']);
        $email    = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $gender   = isset($_POST['gender']) ? $_POST['gender'] : "";
        $dd       = trim($_POST['dd']);
        $mm       = trim($_POST['mm']);
        $yyyy     = trim($_POST['yyyy']);

        // Name: must not be empty
        if($name == ""){
            $errors['name'] = "Name is required.";
        }

        // Email: valid format
        if($email == ""){
            $errors['email'] = "Email is required.";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email format is invalid.";
        }

        // Username: alphanumeric, period, dash, underscore; at least 2 chars
        if($username == ""){
            $errors['username'] = "User Name is required.";
        }elseif(!preg_match('/^[a-zA-Z0-9._-]+$/', $username)){
            $errors['username'] = "User Name can only contain alphanumeric characters, period, dash or underscore.";
        }elseif(strlen($username) < 2){
            $errors['username'] = "User Name must contain at least 2 characters.";
        }

        // Password: at least 8 chars and one special character
        if($password == ""){
            $errors['password'] = "Password is required.";
        }elseif(strlen($password) < 8){
            $errors['password'] = "Password must not be less than 8 characters.";
        }elseif(!preg_match('/[@#$%]/', $password)){
            $errors['password'] = "Password must contain at least one special character (@, #, $, %).";
        }

        // Confirm Password: must match password
        if($confirmPassword == ""){
            $errors['confirm_password'] = "Please confirm your password.";
        }elseif($confirmPassword != $password){
            $errors['confirm_password'] = "Confirm Password does not match Password.";
        }

        // Gender: must be selected
        if($gender == ""){
            $errors['gender'] = "Please select a gender.";
        }

        // Date of Birth: dd/mm/yyyy validation
        if($dd == "" || $mm == "" || $yyyy == ""){
            $errors['dob'] = "Date of Birth is required (dd/mm/yyyy).";
        }elseif(!checkdate((int)$mm, (int)$dd, (int)$yyyy)){
            $errors['dob'] = "Date of Birth is not a valid date.";
        }

        if(empty($errors)){
            $success = "Registration successful! Welcome, " . htmlspecialchars($name) . "!";
            // Reset fields on success
            $name = $email = $username = $gender = $dd = $mm = $yyyy = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration</title>
</head>
<body>

    <fieldset style="width:400px;">
        <legend><strong>REGISTRATION</strong></legend>

        <?php if($success != ""): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post" action="registration.php" enctype="multipart/form-data">

            Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"/> <br>
            <?php if(isset($errors['name'])): ?>
                <span style="color:red;"><?php echo $errors['name']; ?></span><br>
            <?php endif; ?>
            <br>

            Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"/> <br>
            <?php if(isset($errors['email'])): ?>
                <span style="color:red;"><?php echo $errors['email']; ?></span><br>
            <?php endif; ?>
            <br>

            User Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"/> <br>
            <?php if(isset($errors['username'])): ?>
                <span style="color:red;"><?php echo $errors['username']; ?></span><br>
            <?php endif; ?>
            <br>

            Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" name="password" value=""/> <br>
            <?php if(isset($errors['password'])): ?>
                <span style="color:red;"><?php echo $errors['password']; ?></span><br>
            <?php endif; ?>
            <br>

            Confirm Password : <input type="password" name="confirm_password" value=""/> <br>
            <?php if(isset($errors['confirm_password'])): ?>
                <span style="color:red;"><?php echo $errors['confirm_password']; ?></span><br>
            <?php endif; ?>
            <br>

            <fieldset>
                <legend>Gender</legend>
                <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>/> Male
                <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>/> Female
                <input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked"; ?>/> Other
            </fieldset>
            <?php if(isset($errors['gender'])): ?>
                <span style="color:red;"><?php echo $errors['gender']; ?></span>
            <?php endif; ?>
            <br>

            <fieldset>
                <legend>Date of Birth</legend>
                <input type="text" name="dd" value="<?php echo htmlspecialchars($dd); ?>" size="3" maxlength="2" placeholder="dd"/> /
                <input type="text" name="mm" value="<?php echo htmlspecialchars($mm); ?>" size="3" maxlength="2" placeholder="mm"/> /
                <input type="text" name="yyyy" value="<?php echo htmlspecialchars($yyyy); ?>" size="5" maxlength="4" placeholder="yyyy"/>
                &nbsp;<em>(dd/mm/yyyy)</em>
            </fieldset>
            <?php if(isset($errors['dob'])): ?>
                <span style="color:red;"><?php echo $errors['dob']; ?></span>
            <?php endif; ?>
            <br>

            <hr>
            <input type="submit" name="submit" value="Submit"/>
            <input type="reset" name="reset" value="Reset"/>

        </form>
    </fieldset>

</body>
</html>
