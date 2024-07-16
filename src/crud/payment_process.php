<?php
include '../../connection.php';

// Inserting data
try {
    if (isset($_POST["register"])) {
        // Retrieve other form data
        $member_id = $_POST['member_id'];
        $package = $_POST['package'];
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];
        $payment_status = $_POST['status'];
       
        
        // Perform input validation here if necessary

        $query = "INSERT INTO payment (member_id, amount, package_id,  payment_date , payment_status) 
                  VALUES ('$member_id', '$amount', '$package' , '$payment_date' , '$payment_status')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Payment added successfully!'); window.location.href='../admin/payment.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during payment addition. Please try again later.');</script>";
        }
    }
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
}

// Deleting Data
if (isset($_GET["action"]) && isset($_GET["ID"])) {
    if ($_GET["action"] == "delete"){
    $payment_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM payment WHERE payment_id='$payment_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Payment deleted successfully!'); window.location.href='../admin/payment.php';</script>";
    }
}
}

// Update Data
if (isset($_POST['paymentID'])) {
    $paymentID = $_POST['paymentID'];
    $member_id = $_POST['member_id'];
    $package = $_POST['package'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['status'];


    // Update payment query
    $updateQuery = "UPDATE payment SET member_id = '$member_id', amount = '$amount', package_id = '$package' , payment_date = '$payment_date', payment_status = '$payment_status' WHERE payment_id = '$paymentID'";

    // Execute update query
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Payment updated successfully!'); window.location.href='../admin/payment.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
} else {
    echo "No data received for update.";
}
?>
