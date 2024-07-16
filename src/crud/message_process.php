<?php

session_start(); 

include '../../connection.php';

if (isset($_POST['send'])) {

    $member_id = $_SESSION['member_id'];
    $message = $_POST['msg'];
    $date = date("Y-m-d");

    // Insert message into member_msg_tbl
    $insertQuery = "INSERT INTO member_message_tbl (member_id, message, date) VALUES ('$member_id', '$message', '$date')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        echo "<script>alert('Message sent successfully!'); window.location.href='../../member_dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to send message');</script>";
    }
}else if(isset($_POST['ad_send'])){

    $member_id = $_POST['member'];
    $message = $_POST['msg'];
    $date = date("Y-m-d");

    // Insert message into member_msg_tbl
    $insertQuery = "INSERT INTO admin_message_tbl (member_id, message, date) VALUES ('$member_id', '$message', '$date')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        echo "<script>alert('Message sent successfully!'); window.location.href='../../dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to send message');window.location.href='../../dashboard.php';</script>";
    }
}

if(isset($_POST['an_send'])){
    $message = $_POST['an_msg'];
    $date = date("Y-m-d");

    // Insert message into announcement tbl
    $insertQuery = "INSERT INTO announcement (message, date) VALUES ('$message', '$date')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        echo "<script>alert('Announcement sent successfully!'); window.location.href='../../dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to send announcement');</script>";
    }
}




// Delete message
if (isset($_GET["action"]) && isset($_GET["ID"])) {
    if($_GET["action"] == "delete"){
    $msg_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM member_message_tbl WHERE msg_id='$msg_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Message deleted successfully!'); window.history.back();</script>";
        exit(); // Exit after deletion
    }
}
} else if(isset($_GET["action"]) && isset($_GET["MID"])){
    if($_GET["action"] == "delete"){
        $msg_id = $_GET["MID"];
        $deleteQuery = "DELETE FROM admin_message_tbl WHERE msg_id='$msg_id'";
        $deleteResult = mysqli_query($con, $deleteQuery);
        if (!$deleteResult) {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "An error occurred during deletion. Please try again later.";
        } else {
            echo "<script>alert('Message deleted successfully!'); window.history.back();</script>";
            exit(); // Exit after deletion
        }
}
}

// Delete announcement
if (isset($_GET["action"]) && isset($_GET["ANID"])) {
    if($_GET["action"] == "delete"){
    $an_id = $_GET["ANID"];
    $deleteQuery = "DELETE FROM announcement WHERE announcement_id='$an_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Announcement deleted successfully!');window.history.back();</script>";
        exit(); // Exit after deletion
    }
}
}

?>