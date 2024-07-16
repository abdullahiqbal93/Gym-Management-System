<?php
session_start(); 

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../../login.php");
    exit();
}

// Include database connection
include '../../connection.php';

// Retrieve logged-in user's ID from session
$memberID = $_SESSION['member_id'];

// Retrieve user details from the database using the stored ID
$selectQuery = "SELECT * FROM member WHERE member_id = '$memberID'";
$result = mysqli_query($con, $selectQuery);

// Check if user details are fetched successfully
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user's details
    $record = mysqli_fetch_assoc($result);

    // Query to get booking status
    $bookingQuery = "SELECT approval_status FROM booking WHERE member_id = '$memberID' ORDER BY booking_id DESC LIMIT 1";
    $bookingResult = mysqli_query($con, $bookingQuery);

    // Check if booking exists and its approval status
    $approvalPending = false;
    $packageSelected = false;
    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $bookingData = mysqli_fetch_assoc($bookingResult);
        if ($bookingData['approval_status'] === 'pending') {
            $approvalPending = true;
        } elseif ($bookingData['approval_status'] === 'approved') {
            $packageSelected = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/member_dashboard.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>FITNESS CLUB</h3>
            </div>
            <div class="prfl">
                <img src="<?php echo $record['photo']; ?>" alt="prfl" />
                <span><?php echo $record['full_name']; ?></span>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="../../member_dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="profile.php">Profile</a>
                </li>
                <li class="active">
                    <a href="">Payments</a>
                </li>
                <li>
                    <a href="schedule.php">Schedule</a>
                </li>
                <li>
                    <a href="bmi.php">BMI</a>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" class="download" onclick="logout()">Logout</a>
                </li>
                <li>
                    <a href="../../inde.php" class="article">Back to Website</a>
                </li>
            </ul>
        </nav>

        <div id="content" class="container-fluid">
            <?php if (!$packageSelected || $approvalPending): ?>
                <div class="alert alert-warning" role="alert">
                    <?php if ($approvalPending): ?>
                        Your package selection is currently pending approval. You cannot access the payment details until your package is approved.
                    <?php else: ?>
                        You must select a package to access the payment details.
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="payments">
                    <div class="heading">
                        <h3>Payment History</h3>
                    </div>

                    <!-- Membership Payments Table -->
                    <h4>Membership Payments</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Fee Month</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to retrieve membership payments for the logged-in user
                            $membershipQuery = "SELECT 
                                payment_id, 
                                amount, 
                                payment_date,
                                fee_month,
                                payment_status
                            FROM 
                                payment 
                            WHERE 
                                member_id = $memberID";

                            $membershipResult = mysqli_query($con, $membershipQuery);
                            if ($membershipResult && mysqli_num_rows($membershipResult) > 0) {
                                while ($record = mysqli_fetch_assoc($membershipResult)) {

                                    $statusClass = '';
                                    switch ($record['payment_status']) {
                                        case 'approved':
                                            $statusClass = 'text-success';
                                            break;
                                        case 'pending':
                                            $statusClass = 'text-warning';
                                            break;
                                        case 'declined':
                                            $statusClass = 'text-danger';
                                            break;
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $record['payment_date'] . "</td>";
                                    echo "<td>" . $record['amount'] . "</td>";
                                    echo "<td>" . $record['fee_month'] . "</td>";
                                    echo "<td class='$statusClass'>" . $record['payment_status'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No membership payments found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Package Payments Table -->
                    <h4>Package Payments</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to retrieve package payments for the logged-in user
                            $packageQuery = "SELECT 
                                p.payment_id, 
                                p.package_id, 
                                p.amount, 
                                p.payment_date,
                                p.payment_status,
                                pkg.name AS package_name
                            FROM 
                                payment p
                            LEFT JOIN 
                                package pkg ON p.package_id = pkg.package_id
                            WHERE 
                                p.member_id = $memberID";
                            
                            $packageResult = mysqli_query($con, $packageQuery);
                            if ($packageResult && mysqli_num_rows($packageResult) > 0) {
                                while ($record = mysqli_fetch_assoc($packageResult)) {

                                    $statusClass = '';
                                    switch ($record['payment_status']) {
                                        case 'approved':
                                            $statusClass = 'text-success';
                                            break;
                                        case 'pending':
                                            $statusClass = 'text-warning';
                                            break;
                                        case 'declined':
                                            $statusClass = 'text-danger';
                                            break;
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $record['package_name'] . "</td>";
                                    echo "<td>" . $record['payment_date'] . "</td>";
                                    echo "<td>" . $record['amount'] . "</td>";
                                    echo "<td class='$statusClass'>" . $record['payment_status'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No package payments found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <!-- Custom Script -->
        <script src="../../js/dashboard.js"></script>

        <script>
            function logout() {
                window.location.href = '../../src/logout.php';
            }
        </script>
    </div>
</body>

</html>

<?php
} else {
    // If user details are not found, display an error message
    echo "User details not found.";
}
?>
