<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Success</title>
</head>
<body>
    <h2>Login Successful!</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="login.php">Logout</a>
</body>
</html>
