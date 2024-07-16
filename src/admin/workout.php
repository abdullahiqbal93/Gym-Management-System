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
    <link rel="stylesheet" href="../../css/dashboard.css">

    <style>
        /* Styles for the modal */
        .modal-dialog {
            max-width: 80%;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-title {
            color: #343a40;
        }

        .modal-body {
            background-color: #f8f9fa;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #495057;
        }
    </style>
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

                <li>
                    <a href="../../dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="#memberSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Members</a>
                    <ul class="collapse list-unstyled" id="memberSubmenu">
                        <li>
                            <a href="member_details.php">Member Details</a>
                        </li>
                        <li>
                            <a href="payment.php">Payments</a>
                        </li>
                        <li>
                            <a href="booking.php">Bookings</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="equipment.php">Equipments</a>
                </li>
                <li>
                    <a href="package.php">Packages</a>
                </li>
                <li>
                    <a href="trainer.php">Trainers</a>
                </li>
                <li class="active">
                    <a href="#exerciseSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Exercises</a>
                    <ul class="collapse list-unstyled" id="exerciseSubmenu">
                        <li class="active">
                            <a href="workout.php">Workouts</a>
                        </li>
                        <li>
                            <a href="package_workout.php">Package Workouts</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" class="download" onclick="logout()">Logout</a>
                </li>
                <li>
                    <a href="../../index.php" class="article">Back to website</a>
                </li>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <div class="heading">
                        <span><img width="40" height="40" src="https://img.icons8.com/color/48/overview-pages-1.png"
                                alt="overview-pages-1" /> WORKOUTS</span>
                    </div>
                </div>
            </nav>
            <div class="heading">
                        <h3>Search Workouts</h3>
                        <input type="text" id="workoutSearch" class="form-control" placeholder="Search workouts..." onkeyup="filterWorkouts()">
                    </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addWorkoutModal">
                Add Workout
            </button>
            <br><br>
            <div class="tbl">
    <?php
    include '../../connection.php';
    $selectQuery = "SELECT * FROM workout ORDER BY workout_id DESC";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered' style='width: 100%;'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>
<th style='width: 10%;'>Package ID</th>
<th style='width: 20%;'>Name</th>
<th style='width: 50%;'>Description</th>
<th style='width: 20%;'>Actions</th>
</tr>";
        echo "</thead>";
        echo "<tbody id='workoutTableBody'>"; // Added id attribute here
        while ($record = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$record['workout_id']}</td>";
            echo "<td>{$record['name']}</td>";
            echo "<td>{$record['description']}</td>";
            echo "<td><a href='#' class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editWorkoutModal' data-workoutid='{$record['workout_id']}'>Edit</a>  ";
            echo "<a href='../crud/workout_process.php?action=delete&ID={$record['workout_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";

            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p class='text-center'>No records found.</p>";
    }
    ?>
</div>


            <!-- Modal -->
            <div class="modal fade" id="addWorkoutModal" tabindex="-1" role="dialog"
                aria-labelledby="addWorkoutModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addWorkoutModalLabel">Add Workout</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new workout -->
                            <form id="addWorkoutForm" action="../crud/workout_process.php" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Workout Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" name="desc" rows="3"></textarea>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="register">Add Workout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit Workout Modal -->
            <div class="modal fade" id="editWorkoutModal" tabindex="-1" role="dialog"
                aria-labelledby="editWorkoutModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editWorkoutModalLabel">Edit Workout Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for editing workout -->
                            <form action="../crud/workout_process.php" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="workoutID" value="<?php echo $record['workout_id']; ?>">
                                    <label for="name">Workout Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="<?php echo $record['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" name="desc"
                                        rows="3"><?php echo $record['description']; ?>"</textarea>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="edit_register">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
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
        <script src="../../js/dashboard.js"></script>

        <script>

function filterWorkouts() {
    const searchInput = document.getElementById('workoutSearch').value.toLowerCase();
    const workoutTableBody = document.getElementById('workoutTableBody');
    const rows = workoutTableBody.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const workoutNameCell = rows[i].getElementsByTagName('td')[1]; // Adjusted index to match the 'Name' column
        const workoutName = workoutNameCell.textContent.toLowerCase();
        
        if (workoutName.includes(searchInput)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

                function toggleDetails(button) {
                    const detailsRow = button.closest('tr').nextElementSibling;
                    $(detailsRow).toggle();
                }

            function logout() {
                window.location.href = '../logout.php';
            }

            $(document).ready(function () {
                $('.edit-btn').click(function () {
                    var workoutID = $(this).data('workoutid');
                    // AJAX request to fetch equipment data
                    $.ajax({
                        url: '../crud/update_workout.php',
                        type: 'POST',
                        data: { workoutID: workoutID },
                        success: function (response) {
                            $('#editWorkoutModal').html(response);
                        }
                    });
                });
            });
        </script>




</body>

</html>