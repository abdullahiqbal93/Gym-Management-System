<?php
include '../../connection.php';
session_start();

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['member_id'])) {
    header("Location: ../../login.php");
    exit();
}

$memberID = $_SESSION['member_id'];
$packageID = $_POST['package_id'];
$cardNumber = $_POST['card_number'];
$expiryDate = $_POST['expiry_date'];
$cvc = $_POST['cvc'];

// Insert card details into the database
$insertCardQuery = "INSERT INTO card_details (member_id, card_number, expiry_date, cvc) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($insertCardQuery);
$stmt->bind_param("isss", $memberID, $cardNumber, $expiryDate, $cvc);
$stmt->execute();
$stmt->close();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    // Start transaction
    mysqli_begin_transaction($con);

    // Fetch package price from the database
    $packageQuery = "SELECT price FROM package WHERE package_id = ?";
    $stmt = $con->prepare($packageQuery);
    $stmt->bind_param("i", $packageID);
    $stmt->execute();
    $stmt->bind_result($package_amount); // Change $price to $package_amount
    $stmt->fetch();
    $stmt->close();

    // Simulate a payment processing (replace with actual payment gateway integration)
    $paymentSuccessful = true; // This should be the response from your payment processor

    if ($paymentSuccessful) {
        // Insert payment into the database
        $paymentQuery = "INSERT INTO payment (member_id, package_id, amount, payment_date, fee_month, payment_status) VALUES (?, ?, ?, CURDATE(), NULL, 'pending')";
        $stmt = $con->prepare($paymentQuery);
        $stmt->bind_param("iii", $memberID, $packageID, $package_amount); // Add $package_amount to bind
        $stmt->execute();
        $stmt->close();

        // Insert booking into the database
        $bookingQuery = "INSERT INTO booking (member_id, package_id, booking_date, payment_status, approval_status, approval_date, expiry_date) VALUES (?, ?, CURDATE(), 'pending', 'pending', NULL, NULL)";
        $stmt = $con->prepare($bookingQuery);
        $stmt->bind_param("ii", $memberID, $packageID);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        mysqli_commit($con);

        $_SESSION['message'] = 'Payment successful and package selected!';
    } else {
        throw new Exception('Payment failed: Your payment processor returned an error.');
    }
} catch (Exception $e) {
    // Rollback transaction in case of error
    mysqli_rollback($con);

    $_SESSION['error'] = $e->getMessage();
} finally {
    // Close the database connection
    $con->close();
}

header("Location: ../../member_dashboard.php");
exit();
?>
