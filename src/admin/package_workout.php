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
                        <li>
                            <a href="workout.php">Workouts</a>
                        </li>
                        <li class="active">
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
                                alt="overview-pages-1" /> PACKAGE WORKOUTS</span>
                    </div>
                </div>
            </nav>

            <div class="heading">
                        <h3>Search Package Workouts</h3>
                        <input type="text" id="packageSearch" class="form-control" placeholder="Enter Package Name....." onkeyup="filterPackages()">
                    </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                data-target="#addPackageWorkoutModal">
                Add Package Workout
            </button>
            <br><br>

            <div class="tbl">
                <?php
                include '../../connection.php';
                $selectQuery = "SELECT p.package_id, p.name AS package_name, 
                                w.workout_id, w.name AS workout_name, 
                                pw.sets, pw.reps
                                FROM package_workout pw
                                INNER JOIN package p ON pw.package_id = p.package_id
                                INNER JOIN workout w ON pw.workout_id = w.workout_id";

                $result = mysqli_query($con, $selectQuery);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-bordered' style='width: 100%;'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>
            <th style='width: 10%;'>Package ID</th>
            <th style='width: 25%;'>Package Name</th>
            <th style='width: 10%;'>Workout ID</th>
            <th style='width: 25%;'>Workout Name</th>
            <th style='width: 5%;'>Sets</th>
            <th style='width: 5%;'>Reps</th>
            <th style='width: 5%;'>Actions</th>
        </tr>";
                    echo "</thead>";
                    echo "<tbody id='packageTableBody'>";
                    while ($record = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$record['package_id']}</td>";
                        echo "<td>{$record['package_name']}</td>";
                        echo "<td>{$record['workout_id']}</td>";
                        echo "<td>{$record['workout_name']}</td>";
                        echo "<td>{$record['sets']}</td>";
                        echo "<td>{$record['reps']}</td>";
                        echo "<td><a href='../crud/package_workout_process.php?action=delete&workout_id={$record['workout_id']}&package_id={$record['package_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
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
            <div class="modal fade" id="addPackageWorkoutModal" tabindex="-1" role="dialog"
                aria-labelledby="addPackageWorkoutModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPackageWorkoutModalLabel">Add Package Workout</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new workout -->
                            <form id="addPackageWorkoutForm" action="../crud/package_workout_process.php" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="package">Package Type</label>
                                    <select class="form-control" name="package" id="package" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        include '../../connection.php';
                                        $sql = "SELECT package_id, name, price FROM package";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["package_id"] . "'>" . $row["name"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Packages found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="workout">Workout Name</label>
                                    <select class="form-control" name="workout" id="workout" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        include '../../connection.php';
                                        $sql = "SELECT workout_id, name FROM workout";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["workout_id"] . "'>" . $row["name"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Workouts found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sets">Sets</label>
                                    <input type="number" name="sets" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="reps">Reps</label>
                                    <input type="number" name="reps" id="" class="form-control">
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="register">Add</button>
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
            <script src="../../js/dashboard.js"></script>

            <script>

function filterPackages() {
    const searchInput = document.getElementById('packageSearch').value.toLowerCase();
    const packageTableBody = document.getElementById('packageTableBody');
    const rows = packageTableBody.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const fullNameCell = rows[i].getElementsByTagName('td')[1]; // Adjusted index to match the 'Full Name' column
        const fullName = fullNameCell.textContent.toLowerCase();
        
        if (fullName.includes(searchInput)) {
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
            </script>



</body>

</html>