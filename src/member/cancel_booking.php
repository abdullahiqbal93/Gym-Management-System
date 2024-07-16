<?php
session_start();
include '../../connection.php';

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['member_id'])) {
    header("Location: ../../login.php");
    exit();
}

$memberID = $_SESSION['member_id'];

// Query to cancel the current booking
$updateQuery = "UPDATE booking SET approval_status = 'rejected' WHERE member_id = '$memberID' AND approval_status = 'approved'";
$updateResult = mysqli_query($con, $updateQuery);

if ($updateResult) {
    // If cancellation is successful, redirect back to the member dashboard
    header("Location: ../../member_dashboard.php");
    exit();
} else {
    // If cancellation fails, display an error message
    echo "Failed to cancel booking. Please try again later.";
}
?>
