<?php
    session_start();
    $errors = [];
    $success = "";

    if(isset($_POST['submit'])){
        $currentPassword  = $_POST['current_password'];
        $newPassword      = $_POST['new_password'];
        $retypePassword   = $_POST['retype_password'];

        // A. New Password should not be same as Current Password
        if($newPassword == $currentPassword){
            $errors['new_password'] = "New Password should not be the same as the Current Password.";
        }

        // B. New Password must match with the Retyped Password
        if($newPassword != $retypePassword){
            $errors['retype_password'] = "New Password must match with the Retyped Password.";
        }

        if(empty($errors)){
            $success = "Password changed successfully!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
</head>
<body>

    <fieldset style="width:350px;">
        <legend><strong>CHANGE PASSWORD</strong></legend>

        <?php if($success != ""): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post" action="changePassword.php" enctype="multipart/form-data">

            Current Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" name="current_password" value=""/> <br><br>

            <span style="color:red;">New Password</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" name="new_password" value=""/> <br>
            <?php if(isset($errors['new_password'])): ?>
                <span style="color:red;"><?php echo $errors['new_password']; ?></span><br>
            <?php endif; ?>
            <br>

            <span style="color:red;">Retype New Password</span> : <input type="password" name="retype_password" value=""/> <br>
            <?php if(isset($errors['retype_password'])): ?>
                <span style="color:red;"><?php echo $errors['retype_password']; ?></span><br>
            <?php endif; ?>

            <hr>
            <input type="submit" name="submit" value="Submit"/>

        </form>
    </fieldset>

</body>
</html>
