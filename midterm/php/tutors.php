<?php

session_start();

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login.');</script>";
    echo "<script>window.location.replace('login.php');</script>";
}

include_once('dbconnect.php');

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

$sqltutors = "SELECT * FROM tbl_tutors";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutors = $sqltutors . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/index.js" defer></script>
    <title>Main Page</title>
</head>

<body>
    <div style="display: flex; margin: auto; padding-right: 10px;">
        <div id="mySidebar" class="w3-sidebar w3-bar-block" style="display: none;">
            <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">&times;</button>
            <a href="main.php" class="w3-bar-item w3-button">Dashboard</a>
            <a href="index.php" class="w3-bar-item w3-button">Courses</a>
            <a href="tutors.php" class="w3-bar-item w3-button">Tutors</a>
            <a href="#" class="w3-bar-item w3-button">Subscriptions</a>
            <a href="#" class="w3-bar-item w3-button">Profile</a>
            <a href="login.php" class="w3-bar-item w3-button">Logout</a>
        </div>
        
        <button class="w3-button w3-xlarge" onclick="w3_open()">&#9776;</button>
        <span class="p1">MyTutor</span>
    </div>
    
    <div class="p2">
        <span>Tutors</span>
    </div>

    <div class="searchbox">
        <input type="text" placeholder="Search here">
        <a href="##" class="icon">
            <i class="fa fa-search"></i>
        </a>
    </div>

    <div class="w3-grid-template">
        <?php
            $i = 0;
            foreach ($rows as $tutors) {
                $i++;
                $ttid = $tutors['tutor_id'];
                $ttname = truncate($tutors['tutor_name'], 27);
                $ttdesc = truncate($tutors['tutor_description'], 105);
                $ttemail = $tutors['tutor_email'];
                $ttphone = $tutors['tutor_phone'];

                echo "<div class='w3-card w3-round' style='margin:7px'>
                     <div style='text-align: center; height: 40px; padding: 10px;'>
                     <span><b>$ttname</b></span></div>";
                echo "<a href='tutordetails.php?ttid=$ttid' style='text-decoration: none;'> 
                     <img class='w3-image' src=../assets/tutors/$ttid.jpg" 
                     . " onerror=this.onerror=null;this.src='../assets/default_pic.png'"
                     . " style='width:100%;height:250px'></a><hr>";
                echo "<div class='w3-container'><p>Description: $ttdesc<br>Email: $ttemail<br>Phone No.: $ttphone<br></div>
                     <div style='display: flex; padding: 5px 70px;'>
                     <input type='button' class='button w3-round w3-block' onClick='addCart($ttid)' value='Tutor Details'>
                     </p></div></div>";
            }
        ?>
    </div>

    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "index.php?pageno=' . $page . '" style=
                "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>

    <footer>
        <p>&copy; MyTutor 2022</p>
    </footer>
</body>

</html>