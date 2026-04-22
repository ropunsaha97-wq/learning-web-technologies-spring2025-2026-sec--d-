<?php
    session_start();
    $errors = [];
    $success = "";

    if(isset($_POST['submit'])){
        if($_FILES['picture']['error'] == 0){
            $fileName    = $_FILES['picture']['name'];
            $fileSize    = $_FILES['picture']['size'];
            $fileTmpPath = $_FILES['picture']['tmp_name'];

            // Get file extension
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // A. Picture format must be jpeg, jpg, or png
            $allowedExts = ['jpeg', 'jpg', 'png'];
            if(!in_array($fileExt, $allowedExts)){
                $errors['picture'] = "Picture format must be jpeg, jpg, or png only.";
            }

            // B. Picture size should not be more than 4MB
            $maxSize = 4 * 1024 * 1024; // 4MB in bytes
            if($fileSize > $maxSize){
                $errors['picture'] = "Picture size should not be more than 4MB.";
            }

            if(empty($errors)){
                // Move uploaded file to uploads folder
                if(!is_dir('uploads')){
                    mkdir('uploads', 0755, true);
                }
                $destPath = 'uploads/' . basename($fileName);
                if(move_uploaded_file($fileTmpPath, $destPath)){
                    $success = "Profile picture uploaded successfully!";
                }else{
                    $errors['picture'] = "Failed to upload the picture. Please try again.";
                }
            }
        }else{
            $errors['picture'] = "Please choose a picture to upload.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Picture</title>
</head>
<body>

    <fieldset style="width:300px;">
        <legend><strong>PROFILE PICTURE</strong></legend>

        <?php if($success != ""): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Default profile image placeholder -->
        <img src="https://via.placeholder.com/100x100?text=Photo" alt="Profile Picture" width="100" height="100"/> <br><br>

        <form method="post" action="profilePicture.php" enctype="multipart/form-data">

            <input type="file" name="picture"/> <br>
            <?php if(isset($errors['picture'])): ?>
                <span style="color:red;"><?php echo $errors['picture']; ?></span><br>
            <?php endif; ?>

            <hr>
            <input type="submit" name="submit" value="Submit"/>

        </form>
    </fieldset>

</body>
</html>
