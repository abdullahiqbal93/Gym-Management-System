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
        <link rel="stylesheet" href="../../css/member_dashboard.css">
        <style>
            .workout-details {
                display: none;
                margin-top: 10px;
            }

            .workout-details p {
                margin: 0;
            }
        </style>
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
                    <li>
                        <a href="payment.php">Payments</a>
                    </li>
                    <li class="active">
                        <a href="">Schedule</a>
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
                <div class="schedule">
                    <div class="heading">
                        <h3>Schedule Detail</h3>
                        <input type="text" id="workoutSearch" class="form-control" placeholder="Search workouts..." onkeyup="filterWorkouts()">
                    </div>
                    <div class="schedule-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Workout Name</th>
                                    <th>Sets</th>
                                    <th>Reps</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody id="workoutTableBody">
                                <?php
                                // Query to retrieve scheduled workouts for the logged-in member
                                $scheduleQuery = "SELECT w.name AS workout_name, pw.sets, pw.reps, w.description, w.video_url
                                                FROM member m
                                                JOIN booking b ON m.member_id = b.member_id
                                                JOIN package_workout pw ON b.package_id = pw.package_id
                                                JOIN workout w ON pw.workout_id = w.workout_id
                                                WHERE m.member_id = $memberID
                                                AND b.approval_status = 'approved'
                                                AND b.expiry_date > NOW()";
                                $scheduleResult = mysqli_query($con, $scheduleQuery);
                                if ($scheduleResult && mysqli_num_rows($scheduleResult) > 0) {
                                    while ($row = mysqli_fetch_assoc($scheduleResult)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['workout_name'] . "</td>";
                                        echo "<td>" . $row['sets'] . "</td>";
                                        echo "<td>" . $row['reps'] . "</td>";
                                        echo "<td><button class='btn btn-info btn-sm' onclick='toggleDetails(this)'>Details</button></td>";
                                        echo "</tr>";
                                        echo "<tr class='workout-details'>";
                                        echo "<td colspan='4'>
                                                <p><strong>Description:</strong> " . $row['description'] . "</p>
                                                <p><a href='" . $row['video_url'] . "' target='_blank' style='color:#007bff;'>Watch Tutorial</a></p>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No scheduled workouts found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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
            <script src="../../js/dashboard.js"></script>

            <script>
                function filterWorkouts() {
                    const searchInput = document.getElementById('workoutSearch').value.toLowerCase();
                    const workoutTableBody = document.getElementById('workoutTableBody');
                    const rows = workoutTableBody.getElementsByTagName('tr');
                    
                    for (let i = 0; i < rows.length; i += 2) {
                        const workoutNameCell = rows[i].getElementsByTagName('td')[0];
                        const workoutName = workoutNameCell.textContent.toLowerCase();
                        
                        if (workoutName.includes(searchInput)) {
                            rows[i].style.display = '';
                            rows[i + 1].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                            rows[i + 1].style.display = 'none';
                        }
                    }
                }

                function toggleDetails(button) {
                    const detailsRow = button.closest('tr').nextElementSibling;
                    $(detailsRow).toggle();
                }

                function logout() {
                    window.location.href = 'src/logout.php';
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
