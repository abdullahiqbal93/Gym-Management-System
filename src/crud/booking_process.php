<?php
include '../../connection.php';
// Inserting data
try {
    if (isset($_POST["register"])) {
        // Retrieve other form data
        $member_id = $_POST['member_id'];
        $package = $_POST['package'];
        $b_date = $_POST['booking_date'];
        $a_status = $_POST['approval_status'];
        $a_date = $_POST['approval_date'];
        $e_date = $_POST['expiry_date'];
        // Perform input validation here if necessary

        $query = "INSERT INTO booking (member_id, package_id, booking_date , approval_status) 
                  VALUES ('$member_id', '$package', '$b_date' , '$a_status')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Booking added successfully!'); window.location.href='../admin/booking.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during booking addition. Please try again later.');</script>";
        }
    }
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
}

// Deleting Data
if (isset($_GET["action"]) && isset($_GET["ID"])) {
    if($_GET["action"] == "delete"){
    $booking_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM booking WHERE booking_id='$booking_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='../admin/booking.php';</script>";
    }
}
}

// Update Data
if (isset($_POST['bookingID'])) {
    $bookingID = $_POST['bookingID'];
    $member_id = $_POST['member_id'];
    $package = $_POST['package'];
    $b_date = !empty($_POST['booking_date']) ? $_POST['booking_date'] : date('Y-m-d');
    $a_status = $_POST['approval_status'];
    $a_date = $_POST['approval_date'];
    $e_date = $_POST['expiry_date'];


    // Update payment query
    $updateQuery = "UPDATE booking SET member_id = '$member_id', package_id = '$package' , booking_date = '$b_date' , approval_status = '$a_status' , approval_date = '$a_date' , expiry_date = '$e_date'  WHERE booking_id = '$bookingID'";

    // Execute update query
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='../admin/booking.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
} else {
    echo "No data received for update.";
}
?>
