<?php
session_start(); // Start the session

// Check if the user is authenticated as an admin
if (!isset($_SESSION['authenticated']) || !isset($_SESSION['admin']) || $_SESSION['authenticated'] !== true || $_SESSION['admin'] !== true) {
    // If not authenticated as an admin, redirect to login page
    header("Location: login.php");
    exit();
}
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
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
            </div>
            <ul class="list-unstyled components">
                <!-- <p>Hey Admin!</p> -->

                <li class="active">
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="#memberSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Members</a>
                    <ul class="collapse list-unstyled" id="memberSubmenu">
                        <li>
                            <a href="./src/admin/member_details.php">Member Details</a>
                        </li>
                        <li>
                            <a href="./src/admin/payment.php">Payments</a>
                        </li>
                        <li>
                            <a href="./src/admin/booking.php">Bookings</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="./src/admin/equipment.php">Equipments</a>
                </li>
                <li>
                    <a href="./src/admin/package.php">Packages</a>
                </li>
                <li>
                    <a href="./src/admin/trainer.php">Trainers</a>
                </li>
                <li>
                    <a href="#exerciseSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Exercises</a>
                    <ul class="collapse list-unstyled" id="exerciseSubmenu">
                        <li>
                            <a href="./src/admin/workout.php">Workouts</a>
                        </li>
                        <li>
                            <a href="./src/admin/package_workout.php">Package Workouts</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" class="download" onclick="logout()">Logout</a>
                </li>
                <li>
                    <a href="index.php" class="article">Back to Website</a>
                </li>
            </ul>
        </nav>



        <div id="content" class="container-fluid">

            <div class="row">
                <!-- Dashboard Card 1 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x"></i>
                            <h5 class="card-title">Total Members</h5>
                            <?php include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_members FROM member";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalMembers = $row['total_members'];
                            } else {
                                // Default value if query fails
                                $totalMembers = 0;
                            }


                            echo "<h3 class='amount'>$totalMembers</h3>"
                                ?>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Card 2 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-dumbbell fa-2x"></i>
                            <h5 class="card-title">Total Equipments</h5>
                            <?php
                            include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_equipments FROM equipment";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalEquipments = $row['total_equipments'];
                            } else {
                                // Default value if query fails
                                $totalEquipments = 0;
                            }

                            echo "<h3 class='amount'>$totalEquipments</h3>";
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Card 3 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-box-open fa-2x"></i>
                            <h5 class="card-title">Total Packages</h5>
                            <?php
                            include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_packages FROM package";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalPackages = $row['total_packages'];
                            } else {
                                // Default value if query fails
                                $totalPackages = 0;
                            }

                            echo "<h3 class='amount'>$totalPackages</h3>";
                            ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Dashboard Card 4 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-user-tie fa-2x"></i>
                            <h5 class="card-title">Total Trainers</h5>
                            <?php
                            include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_trainers FROM trainer";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalTrainers = $row['total_trainers'];
                            } else {
                                // Default value if query fails
                                $totalTrainers = 0;
                            }

                            echo "<h3 class='amount'>$totalTrainers</h3>";
                            ?>
                        </div>

                    </div>
                </div>

                <!-- Dashboard Card 5 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-dumbbell fa-2x"></i>
                            <h5 class="card-title">Total workouts</h5>
                            <?php
                            include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_workouts FROM workout";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalWorkouts = $row['total_workouts'];
                            } else {
                                // Default value if query fails
                                $totalWorkouts = 0;
                            }

                            echo "<h3 class='amount'>$totalWorkouts</h3>";
                            ?>
                        </div>

                    </div>
                </div>

                <!-- Dashboard Card 6 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                            <h5 class="card-title">Total bookings</h5>
                            <?php
                            include 'connection.php';
                            $countQuery = "SELECT COUNT(*) AS total_bookings FROM booking";
                            $countResult = mysqli_query($con, $countQuery);
                            if ($countResult) {
                                $row = mysqli_fetch_assoc($countResult);
                                $totalBookings = $row['total_bookings'];
                            } else {
                                // Default value if query fails
                                $totalBookings = 0;
                            }

                            echo "<h3 class='amount'>$totalBookings</h3>";
                            ?>
                        </div>

                    </div>
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
                            <?php include 'connection.php';

                            $selectQuery = "SELECT member_message_tbl.*, member.full_name FROM member_message_tbl JOIN member ON member_message_tbl.member_id = member.member_id  ORDER BY date DESC";
                            $result = mysqli_query($con, $selectQuery);

                            if ($result && mysqli_num_rows($result) > 0) {

                                while ($record = mysqli_fetch_assoc($result)) {

                                    echo "<div class='message-box'>
                                <div class='message-content'>
                                    <div class='message-header'>
                                        <div class='name'>{$record['full_name']}</div>
                                    </div>
                                    <p class='message-line'>
                                    {$record['message']}
                                    </p>
                                    <p class='message-line time'>
                                    {$record['date']}
                                    </p>
                                    <div class='delete-icon'>
                                    <a href='src/crud/message_process.php?action=delete&ID={$record['msg_id']}' onclick='return confirm(\"Are you sure?\")'>
                                    <i class='fas fa-trash-alt'></i>
                                    </a>
                                    </div>
                                </div>
                            </div>";
                                }
                            } else {
                                echo "<p class='text-center'>No records found.</p>";
                            }
                            ?>
                        </div>
                        <form action="src/crud/message_process.php" method="post" enctype="multipart/form-data">
                            <div class="message-input">
                                <div class="member-selection">
                                    <select class="select-member" name="member" required>
                                        <option value="">Select</option>
                                        <?php
                                        include 'connection.php';
                                        $sql = "SELECT member_id, full_name FROM member";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["member_id"] . "'>" . $row["full_name"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Members found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <textarea class="input-field" placeholder="Type your message..." name="msg"
                                    required></textarea>
                                <button class="send-button" name="ad_send">Send</button>
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
                            <?php include 'connection.php';

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
                                    <div class='delete-icon'>
                                    <a href='src/crud/message_process.php?action=delete&ANID={$record['announcement_id']}' onclick='return confirm(\"Are you sure?\")'>
                                    <i class='fas fa-trash-alt'></i>
                                    </a>
                                    </div>
                                </div>
                            </div>";
                                }
                            } else {
                                echo "<p class='text-center'>No Announcement found.</p>";
                            }
                            ?>
                        </div>
                        <form action="src/crud/message_process.php" method="post" enctype="multipart/form-data">
                            <div class="message-input">
                                <textarea class="input-field an-field" name="an_msg"
                                    placeholder="Type your announcement..."></textarea>
                                <button class="send-button" name="an_send">Send</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <!-- Custom Script -->
        <script src="./js/dashboard.js"></script>

        <script>
        function logout(){
        window.location.href='src/logout.php';
        }
        </script>

</body>

</html>