<?php
session_start(); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include '../../connection.php';

    $email = $_POST['email'];
    $password = $_POST['password'];


    $admin_sql = "SELECT * FROM admin WHERE username = '$email' AND password = '$password'";
    $admin_result = mysqli_query($con, $admin_sql);

    if ($admin_result && mysqli_num_rows($admin_result) > 0) {
        // If admin exists
        $_SESSION['authenticated'] = true;
        $_SESSION['admin'] = true;
        header("Location: ../../dashboard.php");
        exit();

    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: ../../login.php");
    
    }

    $member_sql = "SELECT * FROM member WHERE email = '$email' AND password = '$password'";
    $member_result = $con->query($member_sql);



    if ($member_result && mysqli_num_rows($member_result) > 0) {

        $record = $member_result->fetch_assoc();
        $mem_id = $record['member_id'];

        $_SESSION['authenticated'] = true;
        $_SESSION['admin'] = false;
        $_SESSION['member_id'] = $mem_id;
        header("Location: ../../member_dashboard.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: ../../login.php");
        exit();
    }



}
$con->close();
?>