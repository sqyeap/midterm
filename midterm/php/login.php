<?php

if (isset($_POST['submit'])) {
    include 'dbconnect.php';
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sqllogin = "SELECT * FROM tbl_tutors WHERE tutor_email = '$email' AND tutor_password = '$pass'";
    $stmt = $conn->prepare($sqllogin);
    $stmt->execute();
    $number_of_rows = $stmt->rowCount();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    if ($number_of_rows > 0) {
        session_start();
        $_SESSION['session_id'] = session_id();
        $_SESSION['tutor_name'] = $name;
        $_SESSION['tutor_email'] = $email;
        echo "<script>alert('Login Successful');</script>";
        echo "<script>window.location.replace('index.php');</script>";
    } else {
        echo "<script>alert('Login Failed');</script>";
        echo "<script>window.location.replace('login.php');</script>";
    }
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
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/login.js" defer></script>
    <title>Login Page</title>
</head>

<body onload="loadCookies()">
    <header class="w3-header p1">
        <h1 class="p1" style="font-size: 40px;">MyTutor</h1>
        <p style="font-size: 20px;">Login Page</p>
    </header>

    <div style="display: flex; justify-content: center;">
        <div class="w3-container w3-card w3-padding-32 w3-margin" style="width: 600px; margin: auto; text-align: left;">
            <form name="loginForm" action="login.php" method="POST">
                <p>
                    <label><b>Email</b></label>
                    <input type="email" id="idemail" name="email" class="w3-input w3-round w3-border" placeholder="Your Email" required>
                </p>
                <p>
                    <label><b>Password</b></label>
                    <input type="password" id="idpass" name="password" class="w3-input w3-round w3-border" placeholder="Password" required>
                </p>
                <p>
                    <input type="checkbox" id="idremember" name="rememberme" class="w3-check w3-round" onclick="rememberMe()">
                    <label style="font-family: Georgia; font-size: 14px;">Remember Me</label>
                </p>
                <p class="w3-center">
                    <input type="submit" id="submit" name="submit" class="button" value="Login">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <input type="reset" class="button">
                    <hr style="height: 1px; background-color: darkgrey; border: none;">
                    <p class="w3-center">
                        Do not have an account?
                        <span><a href="register.php">Register Here</a> for Free</span>
                    </p>
                    <p class="w3-center">
                        Forgot your password?
                        <span><a href="#">Click Here</a></span>
                    </p>
                </p>
            </form>
        </div>
    </div>
    
    <footer class="w3-bottom">
        <p>&copy; 2022 MyTutor</p>
    </footer>
    
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null,null,href="");
        }
    </script>
</body>

</html>
