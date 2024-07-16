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
                <li class="active">
                    <a href="trainer.php">Trainers</a>
                </li>
                <li>
                    <a href="#exerciseSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Exercises</a>
                    <ul class="collapse list-unstyled" id="exerciseSubmenu">
                        <li>
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
                    <a href="../../inde.php" class="article">Back to website</a>
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
                                alt="overview-pages-1" /> Trainers</span>
                    </div>
                </div>
            </nav>

            <div class="heading">
                        <h3>Search Trainer</h3>
                        <input type="text" id="trainerSearch" class="form-control" placeholder="Enter Trainer Name....." onkeyup="filterTrainers()">
                    </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addTrainerModal">
                Add Trainer
            </button>
            <br><br>

            <div class="tbl">
                <?php include '../../connection.php';
                $selectQuery = "SELECT * FROM trainer ORDER BY trainer_id DESC";
                $result = mysqli_query($con, $selectQuery);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-bordered' style='width: 100%;'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>
                    <th style='width: 1%;'>Trainer ID</th>
                    <th style='width: 8%;'>Name</th>
                    <th style='width: 20%;'>Specialization</th>
                    <th style='width: 12%;'>Conatct No</th>  
                    <th style='width: 10%;'>Email</th>
                    <th style='width: 10%;'>Salary</th>
                    <th style='width: 15%;'>Photo</th>
                    <th style='width: 20%;'>Actions</th>
                </tr>";
                    echo "</thead>";
                    echo "<tbody id='trainerTableBody'>";
                    while ($record = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$record['trainer_id']}</td>";
                        echo "<td>{$record['full_name']}</td>";
                        echo "<td>{$record['specialization']}</td>";
                        echo "<td>{$record['contact_no']}</td>";
                        echo "<td>{$record['email']}</td>";
                        echo "<td>" . number_format($record['salary'], 2) . "</td>";
                        echo "<td>{$record['photo']}</td>";
                        echo "<td><a href='#' class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editTrainerModal' data-trainerid='{$record['trainer_id']}'>Edit</a>  ";
                        echo "<a href='../crud/trainer_process.php?action=delete&ID={$record['trainer_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";

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
            <div class="modal fade" id="addTrainerModal" tabindex="-1" role="dialog"
                aria-labelledby="addTrainerModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTrainerModalLabel">Trainer Registration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new equipment -->
                            <form action="../crud/trainer_process.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Trainer Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="specialization">Specialization</label>
                                            <input type="text" class="form-control" name="specialization" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact">Contact No</label>
                                            <input type="text" class="form-control" name="contact" id="" required>
                                        </div>



                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="" required>
                                        </div>

                                        <div class="form-group">

                                            <label for="salary">Salary</label>
                                            <input type="text" name="salary" id="" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="photo" style="display:block;">Upload Photo</label>
                                            <input type="file" name="photo" id="">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit trainer Modal -->
            <div class="modal fade" id="editTrainerModal" tabindex="-1" role="dialog"
                aria-labelledby="editTrainerModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTrainerModalLabel">Edit Trainer Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for editing trainer -->
                            <form action="../crud/trainer_process.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Trainer Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="specialization">Specialization</label>
                                            <input type="text" class="form-control" name="specialization" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact">Contact No</label>
                                            <input type="text" class="form-control" name="contact" id="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="" required>
                                        </div>

                                        <div class="form-group">

                                            <label for="salary">Salary</label>
                                            <input type="text" name="salary" id="" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="photo" style="display:block;">Upload Photo</label>
                                            <input type="file" name="photo" id="">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary edit"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary edit" name="edit_register">Save
                                        Changes</button>
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

            <!-- SweetAlert CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

            <!-- SweetAlert JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



            <script>

function filterTrainers() {
    const searchInput = document.getElementById('trainerSearch').value.toLowerCase();
    const trainerTableBody = document.getElementById('trainerTableBody');
    const rows = trainerTableBody.getElementsByTagName('tr');
    
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

                $(document).ready(function () {
                    $('.edit-btn').click(function () {
                        var trainerID = $(this).data('trainerid');
                        // AJAX request to fetch equipment data
                        $.ajax({
                            url: '../crud/update_trainer.php',
                            type: 'POST',
                            data: { trainerID: trainerID },
                            success: function (response) {
                                $('#editTrainerModal').html(response);
                            }
                        });
                    });
                });
            </script>


</body>

</html>