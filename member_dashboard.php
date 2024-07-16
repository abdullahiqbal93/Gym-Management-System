<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['member_id'])) {
    header("Location: ../../login.php");
    exit();
}

$memberID = $_SESSION['member_id'];

$selectQuery = "SELECT * FROM member WHERE member_id = '$memberID'";
$result = mysqli_query($con, $selectQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $record = mysqli_fetch_assoc($result);

    // Query to get booking status
    $bookingQuery = "SELECT approval_status FROM booking WHERE member_id = '$memberID' ORDER BY booking_id DESC LIMIT 1";
    $bookingResult = mysqli_query($con, $bookingQuery);

    // Get the booking status
    $bookingStatus = "Inactive";
    $approvalPending = false;
    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $bookingData = mysqli_fetch_assoc($bookingResult);
        if ($bookingData['approval_status'] === 'approved') {
            $bookingStatus = "Active";
        } elseif ($bookingData['approval_status'] === 'pending') {
            $approvalPending = true;
        }
    }

    $packageQuery = "SELECT p.name AS package_name FROM booking b
                    JOIN package p ON b.package_id = p.package_id
                    WHERE b.member_id = '$memberID' AND b.approval_status = 'approved'
                    ORDER BY b.booking_id DESC LIMIT 1";
    $packageResult = mysqli_query($con, $packageQuery);

    // Get the current package name
    $currentPackage = "No package";
    if ($packageResult && mysqli_num_rows($packageResult) > 0) {
        $packageData = mysqli_fetch_assoc($packageResult);
        $currentPackage = $packageData['package_name'];
    }

    // Show package modal only if status is inactive and not pending
    $showPackageModal = !$approvalPending && $bookingStatus === "Inactive";
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="./css/member_dashboard.css">
    </head>

    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>FITNESS CLUB</h3>
                </div>
                <div class="prfl">
                    <img src="<?php echo substr($record['photo'], 6); ?>" alt="prfl" />
                    <span>
                        <?php echo $record['full_name']; ?>
                    </span>
                </div>
                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="member_dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="src/member/profile.php">Profile</a>
                    </li>
                    <li>
                        <a href="src/member/payment.php">Payments</a>
                    </li>
                    <li>
                        <a href="src/member/schedule.php">Schedule</a>
                    </li>
                    <li>
                    <a href="src/member/bmi.php">BMI</a>
                </li>
                </ul>
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="#" class="download" onclick="logout()">Logout</a>
                    </li>
                    <li>
                        <a href="inde.php" class="article">Back to Website</a>
                    </li>
                </ul>
            </nav>

            <div id="content" class="container-fluid">
                <div class="main-header">
                    <span>Hello
                        <?php echo $record['full_name']; ?>!!!
                    </span>
                    <?php
                    $date = date("l j, F Y");
                    echo "<span>Today is $date</span>";
                    ?>
                </div>

                <div class="status-box">
                    <div class="card1">
                        <h5 class="card-title">Membership Status</h5>
                        <span>Active</span>
                    </div>
                    <div class="card2">
                        <h5 class="card-title">Booking Status</h5>
                        <span><?php echo $bookingStatus; ?></span>
                        <button class="btn btn-danger" onclick="showPackageModal()">
                <i class="fas fa-times"></i>
            </button>
                    </div>
                    <div class="card3">
                        <h5 class="card-title">Current Package</h5>
                        <span><?php echo $currentPackage; ?></span>
                    </div>
                </div>





                <div class="row">
                    <!-- Message Section -->
                    <div class="col-md-6">
                        <div class="messages-section">
                            <div class="projects-section-header">
                                <p>Messages</p>
                            </div>
                            <div class="messages">
                                <?php
                                $selectQuery = "SELECT * FROM admin_message_tbl WHERE member_id = $memberID ORDER BY date DESC";
                                $result = mysqli_query($con, $selectQuery);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($record = mysqli_fetch_assoc($result)) {
                                        echo "<div class='message-box'>
                                <div class='message-content'>
                                <div class='message-header'>
                                <div class='name'>Admin</div>
                                </div>
                                    <p class='message-line'>
                                    {$record['message']}
                                    </p>
                                    <p class='message-line time'>
                                    {$record['date']}
                                    </p>
                                    <div class='delete-icon'>
                                    <a href='src/crud/message_process.php?action=delete&MID={$record['msg_id']}' onclick='return confirm(\"Are you sure?\")'>
                                    <i class='fas fa-trash-alt'></i>
                                    </a>
                                    </div>
                                </div>
                            </div>";
                                    }
                                } else {
                                    echo "<p class='text-center'>No Messages found</p>";
                                }
                                ?>
                            </div>
                            <form action="./src/crud/message_process.php" method="post" enctype="multipart/form-data">
                                <div class="message-input">
                                    <textarea class="input-field" placeholder="Type your message..." name="msg" required></textarea>
                                    <button class="send-button" name="send">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="announcement-section">
                            <div class="projects-section-header">
                                <p>Announcements</p>
                            </div>
                            <div class="messages">
                                <?php
                                $selectQuery = "SELECT * FROM announcement ORDER BY date DESC";
                                $result = mysqli_query($con, $selectQuery);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($record = mysqli_fetch_assoc($result)) {
                                        echo "<div class='message-box'>
                                <div class='message-content'>
                                    <div class='message-header'>
                                        <div class='name'>Admin</div>
                                    </div>
                                    <p class='message-line'>
                                    {$record['message']}
                                    </p>
                                    <p class='message-line time'>
                                    {$record['date']}
                                    </p>
                                </div>
                            </div>";
                                    }
                                } else {
                                    echo "<p class='text-center'>No Announcement found.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Selection Modal -->
            <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="packageModalLabel">Select Package</h5>
                        </div>
                        <div class="modal-body">
                            <form id="payment-form" action="./src/member/package_selection.php" method="post">
                                <div class="form-group">
                                    <label for="package">Select Package:</label>
                                    <select class="form-control" id="package" name="package_id" required>
                                        <?php
                                        $packageQuery = "SELECT package_id, name, price FROM package";
                                        $packageResult = mysqli_query($con, $packageQuery);
                                        if ($packageResult && mysqli_num_rows($packageResult) > 0) {
                                            while ($package = mysqli_fetch_assoc($packageResult)) {
                                                echo "<option value='{$package['package_id']}' data-price='{$package['price']}'>{$package['name']} - \${$package['price']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                        <label for="card-number">Card Number</label>
                                        <input type="text" class="form-control" id="card-number" name="card_number" required maxlength="16">
                                    </div>
                                    <div class="form-group">
                                        <label for="expiry-date">Expiry Date (MM/YY)</label>
                                        <input type="month" class="form-control" id="expiry-date" name="expiry_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvc">CVC</label>
                                        <input type="text" class="form-control" id="cvc" name="cvc" required maxlength="3">
                                    </div>
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                                <button class="btn btn-secondary" onclick="logout()">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Approval Modal -->
            <div class="modal fade" id="pendingApprovalModal" tabindex="-1" role="dialog" aria-labelledby="pendingApprovalModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pendingApprovalModalLabel">Pending Approval</h5>
                        </div>
                        <div class="modal-body">
                            <p>Your package selection process is in pending. Please wait for the admin approval.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="logout()">Logout</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- jQuery -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <!-- Bootstrap JS -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <!-- Custom Script -->
            <script src="./js/dashboard.js"></script>

            <script>
                $(document).ready(function() {
                    if (<?php echo json_encode($showPackageModal); ?>) {
                        $('#packageModal').modal({ backdrop: 'static', keyboard: false });
                        $('#packageModal').modal('show');
                    }

                    if (<?php echo json_encode($approvalPending); ?>) {
                        $('#pendingApprovalModal').modal({ backdrop: 'static', keyboard: false });
                        $('#pendingApprovalModal').modal('show');
                    }
                });

                function logout() {
                    window.location.href = 'src/logout.php';
                }

                function showPackageModal() {
    // Check if a booking is active
    <?php if ($bookingStatus === "Active") : ?>
        // If active, show a confirmation message
        if (confirm("You have an active booking. Do you want to cancel it?")) {
            // If confirmed, redirect to the cancellation process page
            window.location.href = 'src/member/cancel_booking.php';
        }
    <?php else : ?>
        // If no active booking, show the package modal
        $('#packageModal').modal({ backdrop: 'static', keyboard: false });
        $('#packageModal').modal('show');
    <?php endif; ?>
}
            </script>
        </div>
    </body>

    </html>

    <?php
} else {
    echo "User details not found.";
}
?>
