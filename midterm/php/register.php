<?php

if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    // addslashes()
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_pass = sha1($_POST['password']);
    $user_tel = $_POST['phone'];
    $user_address = $_POST['address'];

    $sqlregister = "INSERT INTO `tbl_users`(`user_name`, `user_email`, `user_pass`, `user_tel`, `user_address`) VALUES ('$user_name', '$user_email', '$user_pass', '$user_tel', '$user_address')";
    
    try {
        $conn->exec($sqlregister);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $last_id = $conn->lastInsertId();
            uploadImage($last_id);
            echo "<script>alert('Registration successful.')</script>";
            echo "<script>window.location.replace('login.php')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed.')</script>";
        echo "<script>window.location.replace('register.php')</script>";
    }
}

function uploadImage($filename) {
    $target_dir = "../res/profilepics/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/register.css">
    <script src="../js/register.js"></script>
    <title>Registration Page</title>
</head>

<body>
    <header class="w3-header p1" style="padding: 16px;">
        <h1 class="p1" style="font-size: 40px;">MyTutor</h1>
        <p style="font-size: 20px;">Registration Page</p>
    </header>

    <div class="navibar w3-bar">
        <a href="login.php" class="w3-bar-item w3-button w3-right" style="font-weight: bold;">Login</a>
    </div>
    
    <br>
    
    <div style="display: flex; justify-content: center;">
        <div class="w3-container w3-card w3-padding-32 w3-margin" style="width: 800px; margin: auto; text-align: left;">
            <form name="registrationForm" action="register.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?');">
                <div class="w3-container">
                    <h3 class="w3-center" style="text-decoration: underline;"><b>New User Registration</b></h3>
                </div>
                <p>
                    <div class="w3-container w3-padding w3-center">
                        <img src="../assets/default_pic.png" id="defaultPic" class="w3-image w3-margin" 
                             style="height: 180px; max-width: 180px; border-radius: 90px; border: 5px solid; border-color: #ba55d3;">
                        <input type="file" id="fileToUpload" name="fileToUpload" onchange="previewFile()">
                    </div>
                </p>
                <p>
                    <div class="w3-col w3-left" style="width: 100px;">
                        <label>Name:</label>
                    </div>
                    <div class="w3-rest">
                        <input type="text" name="name" class="w3-input w3-round w3-border" maxlength="100" placeholder="Your Name" required>
                    </div>
                </p>
                <p>
                    <div class="w3-col w3-left" style="width: 100px;">
                        <label>Email:</label>
                    </div>
                    <div class="w3-rest">
                        <input type="email" name="email" class="w3-input w3-round w3-border" maxlength="50" placeholder="Email Address" required>
                    </div>
                </p>
                <p>
                    <div class="w3-col w3-left" style="width: 100px;">
                        <label>Password:</label>
                    </div>
                    <div class="w3-rest">
                        <input type="password" name="password" class="w3-input w3-round w3-border" maxlength="40" placeholder="Password" required>
                    </div>
                </p>
                <p>
                    <div class="w3-col w3-left" style="width: 100px;">
                        <label>Phone No.:</label>
                    </div>
                    <div class="w3-rest">
                        <input type="tel" name="phone" class="w3-input w3-round w3-border" maxlength="20" placeholder="Phone Number" required>
                    </div>
                </p>
                <p>
                    <div class="w3-col w3-left" style="width: 100px;">
                        <label>Address:</label>
                    </div>
                    <div class="w3-rest">
                        <textarea name="address" class="w3-input w3-round w3-border" rows="4" width="100%" maxlength="500" placeholder="Home Address" required></textarea>
                    </div>
                </p>
                <br>
                <p class="w3-center">
                    <input type="submit" name="submit" class="button" value="Register">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <input type="reset" class="button" onclick="resetDefaultPic()">
                </p>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2022 MyTutor</p>
    </footer>

</body>

</html>