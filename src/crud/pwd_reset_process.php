<?php
session_start(); 

if (isset($_POST['change'])) {
    include '../../connection.php';

    // Retrieve form data
    $email = $_POST['email'];
    $member_id = $_POST['id'];
    $full_name = $_POST['name'];
    $dob = $_POST['dob'];
    $new_password = $_POST['password'];

    // Check if the provided details match a user in the database
    $query = "SELECT * FROM member WHERE email = '$email' AND member_id = '$member_id' AND full_name = '$full_name' AND dob = '$dob'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $update_query = "UPDATE member SET password = '$new_password' WHERE email = '$email'";
        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Password Updated successfully'); window.location.href='../../login.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error Updating password'); window.history.back();</script>";
            exit();
        }
    } else {
        // User details does not match
        echo "<script>alert('Invalid Details'); window.history.back();</script>";
        exit();
    }


} else {
    header("Location: ../../login.php");
    mysqli_close($con);
    exit();
    
}
?>
