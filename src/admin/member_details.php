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
                <li class="active">
                    <a href="#memberSubmenu" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Members</a>
                    <ul class="collapse list-unstyled" id="memberSubmenu">
                        <li class="active">
                            <a href="member_details.php">Member Details</a>
                        </li>
                        <li>
                            <a href="payment.php">Payments</a>
                        </li>
                        <li>
                            <a href="booking.php">Bookings</a>
                        </li>
                        <li>
                            <a href="package_workout.php">Schedule</a>
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
                                alt="overview-pages-1" /> MEMBERS</span>
                    </div>
                </div>
            </nav>

            <div class="heading">
                        <h3>Search Member</h3>
                        <input type="text" id="memberSearch" class="form-control" placeholder="Enter Member Name....." onkeyup="filterMembers()">
                    </div>


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addMemberModal">
                Add Member
            </button>

            <button type="button" class="btn btn-secondary mt-3 ml-2" onclick="generateReport()">
    Generate Report
</button>
<br><br>


            <div class="tbl">
                <?php include '../../connection.php';
                $selectQuery = "SELECT * FROM member ORDER BY member_id DESC";
                $result = mysqli_query($con, $selectQuery);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-bordered' style='width: 100%;'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>
                        <th style='width: 6%;'>Member ID</th>
                        <th style='width: 8%;'>Full Name</th>
                        <th style='width: 10%;'>DOB</th>
                        <th style='width: 5%;'>Gender</th>
                        <th style='width: 10%;'>Contact No</th>
                        <th style='width: 10%;'>Email</th>
                        <th style='width: 10%;'>DOJ</th>
                        <th style='width: 20%;'>Actions</th>
                    </tr>";
                    echo "</thead>";
                    echo "<tbody id='memberTableBody'>";
                    while ($record = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$record['member_id']}</td>";
                        echo "<td>{$record['full_name']}</td>";
                        echo "<td>{$record['dob']}</td>";
                        echo "<td>{$record['gender']}</td>";
                        echo "<td>{$record['contact_no']}</td>";
                        echo "<td>{$record['email']}</td>";
                        echo "<td>{$record['doj']}</td>";
                        echo "<td><a href='#' class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editMemberModal' data-memberid='{$record['member_id']}'>Edit</a>  ";
                        echo "<a href='../crud/regprocess.php?action=delete&ID={$record['member_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";

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
            <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog"
                aria-labelledby="addMemberModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMemberModalLabel">Member Registration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new member -->
                            <form action="../crud/regprocess.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name Of Participant</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Please Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="dob">Date of birth</label>
                                            <input type="date" class="form-control" name="dob">
                                        </div>

                                        <div class="form-group">
                                            <label for="contactNo">Contact No</label>
                                            <input type="text" class="form-control" name="contact" required maxlength="10">
                                        </div>

                                        <div class="form-group">
                                            <label for="doj">Date of Join</label>
                                            <input type="date" class="form-control" name="doj"
                                                value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password">
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


            <!-- Edit Member Modal -->
            <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog"
                aria-labelledby="editMemberModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMemberModalLabel">Edit Member Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for editing member -->
                            <form action="../crud/regprocess.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_name">Full Name Of Participant</label>
                                            <input type="text" class="form-control edit" name="edit_name"
                                                placeholder="Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_gender">Gender</label>
                                            <select class="form-control edit" name="edit_gender" required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_dob">Date of birth</label>
                                            <input type="date" class="form-control edit" name="edit_dob">
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_doj">Date of Join</label>
                                            <input type="date" class="form-control edit" name="edit_doj">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_email">Email:</label>
                                            <input type="email" class="form-control edit" name="edit_email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_password">Password</label>
                                            <input type="password" class="form-control edit" name="edit_password"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_contact">Contact No</label>
                                            <input type="text" class="form-control edit" name="edit_contact" required>
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

            <!-- Preview Report Modal -->
<div class="modal fade" id="previewReportModal" tabindex="-1" aria-labelledby="previewReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewReportModalLabel">Report Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="previewTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Member ID</th>
                                <th>Full Name</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>DOJ</th>
                            </tr>
                        </thead>
                        <tbody id="previewTableBody">
                            <!-- Data will be appended here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadReport()">Download Report</button>
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

function filterMembers() {
    const searchInput = document.getElementById('memberSearch').value.toLowerCase();
    const memberTableBody = document.getElementById('memberTableBody');
    const rows = memberTableBody.getElementsByTagName('tr');
    
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
                        var memberID = $(this).data('memberid');
                        // AJAX request to fetch member data
                        $.ajax({
                            url: '../crud/update_members.php',
                            type: 'POST',
                            data: { memberID: memberID },
                            success: function (response) {
                                $('#editMemberModal').html(response);
                            }
                        });
                    });
                });


                function generateReport() {
    // Fetch the report data
    fetch('../crud/generate_report.php?preview=true')
        .then(response => response.json())
        .then(data => {
            // Populate the table body with the data
            const tableBody = document.getElementById('previewTableBody');
            tableBody.innerHTML = ''; // Clear existing data

            data.forEach(member => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${member.member_id}</td>
                    <td>${member.full_name}</td>
                    <td>${member.dob}</td>
                    <td>${member.gender}</td>
                    <td>${member.contact_no}</td>
                    <td>${member.email}</td>
                    <td>${member.doj}</td>
                `;

                tableBody.appendChild(row);
            });

            // Show the modal
            $('#previewReportModal').modal('show');
        })
        .catch(error => console.error('Error fetching report data:', error));
}

function downloadReport() {
    window.location.href = '../crud/generate_report.php';
}


            </script>


</body>

</html>