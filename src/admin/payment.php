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
                        <li>
                            <a href="member_details.php">Member Details</a>
                        </li>
                        <li class="active">
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
                                alt="overview-pages-1" /> PAYMENTS</span>
                    </div>
                </div>
            </nav>

            <div class="heading">
                        <h3>Search Payment</h3>
                        <input type="text" id="paymentSearch" class="form-control" placeholder="Enter Member ID....." onkeyup="filterPayments()">
                    </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addPaymentModal">
                Add Payment
            </button>
            <br><br>

            <div class="tbl">
                <?php
                $monthNames = [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December'
                ];

                // Add current year as an option
                $monthNames[date('Y')] = 'Current Year';


                include '../../connection.php';
                $selectQuery = "SELECT * FROM payment ORDER BY payment_id DESC";
                $result = mysqli_query($con, $selectQuery);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-bordered' style='width: 100%;'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>
            <th style='width: 5%;'>Payment ID</th>
            <th style='width: 5%;'>Member ID</th>
            <th style='width: 15%;'>Amount</th>
            <th style='width: 15%;'>Payment Date</th>
            <th style='width: 15%;'>Status</th>
            <th style='width: 20%;'>Actions</th>
          </tr>";
                    echo "</thead>";
                    echo "<tbody id='paymentTableBody'>";
                    while ($record = mysqli_fetch_assoc($result)) {
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
                        echo "<td>{$record['payment_id']}</td>";
                        echo "<td>{$record['member_id']}</td>";
                        echo "<td>{$record['amount']}</td>";
                        echo "<td>{$record['payment_date']}</td>";
                        echo "<td class='$statusClass'>{$record['payment_status']}</td>";
                        echo "<td><a href='#' class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editPaymentModal' data-paymentid='{$record['payment_id']}'>Edit</a>  ";
                        echo "<a href='../crud/payment_process.php?action=delete&ID={$record['payment_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";

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
            <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog"
                aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new payment -->
                            <form id="addPaymentForm" action="../crud/payment_process.php" method="post"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="member_id">Member ID</label>
                                            <input type="text" class="form-control" name="member_id" id="member_id"
                                                required>
                                        </div>

                                        <div class="form-group package-type">
                                            <label for="package">Package Type</label>
                                            <select class="form-control" name="package" id="package"
                                                onchange="updateAmount()">
                                                <option value="">Please Select</option>
                                                <?php
                                                include '../../connection.php';
                                                $sql = "SELECT package_id, name, price FROM package";
                                                $result = $con->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row["package_id"] . "' data-price='" . $row["price"] . "'>" . $row["name"] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No Packages found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="pending">Please Select</option>
                                                <option value="approved">Approved</option>
                                                <option value="pending">Pending</option>
                                                <option value="declined">Declined</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="payment_date">Payment Date</label>
                                            <input type="date" class="form-control" name="payment_date"
                                                id="payment_date" required>
                                        </div>

                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="register">Add
                                        Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit Member Modal -->
            <div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog"
                aria-labelledby="editPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Form for editing payment -->
                        <form action="../crud/payment_process.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="paymentID" value="<?php echo $record['payment_id']; ?>">
                                <label for="member_id">Member ID</label>
                                <input type="text" class="form-control" name="member_id" required
                                    value="<?php echo $record['member_id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="amount" required
                                    value="<?php echo $record['amount']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="payment_date">Payment Date</label>
                                <input type="date" class="form-control" name="payment_date" required
                                    value="<?php echo $record['payment_date']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="approved" <?php echo ($record['payment_status'] == 'approved') ? 'selected' : ''; ?>>
                                        Approved</option>
                                    <option value="pending" <?php echo ($record['payment_status'] == 'pending') ? 'selected' : ''; ?>>Pending
                                    </option>
                                    <option value="declined" <?php echo ($record['payment_status'] == 'declined') ? 'selected' : ''; ?>>
                                        Declined</option>
                                </select>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="edit_register">Save Changes</button>
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

function filterPayments() {
    const searchInput = document.getElementById('paymentSearch').value.toLowerCase();
    const paymentTableBody = document.getElementById('paymentTableBody');
    const rows = paymentTableBody.getElementsByTagName('tr');
    
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

            function updateAmount() {
                var packageSelect = document.getElementById("package");
                var amountInput = document.getElementById("amount");
                var selectedOption = packageSelect.options[packageSelect.selectedIndex];
                var price = selectedOption.getAttribute("data-price");
                amountInput.value = price;
            }

            $(document).ready(function () {
                $('.edit-btn').click(function () {
                    var paymentID = $(this).data('paymentid');
                    // AJAX request to fetch equipment data
                    $.ajax({
                        url: '../crud/update_payment.php',
                        type: 'POST',
                        data: { paymentID: paymentID },
                        success: function (response) {
                            $('#editPaymentModal').html(response);
                        }
                    });
                });
            });




        </script>





</body>

</html>