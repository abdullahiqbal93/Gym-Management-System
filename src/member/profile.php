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
                <li class="active">
                    <a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="payment.php">Payments</a>
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

            <div class="profile">
                <div class="heading">
                    <h3>Edit Profile</h3>
                </div>

                <!-- Form for editing profile -->
                <form action="../crud/update_profile.php" method="post" enctype="multipart/form-data">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="profile-photo">
                                        <img src="<?php echo $record['photo']; ?>" alt="prfl" id="profile-photo">
                                        <input type="file" id="photo" name="edit_photo">
                                        <span class="edit-icon" onclick="document.getElementById('photo').click();">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="name">Full Name</label></td>
                                <td><input type="text" class="form-control" name="name" required value="<?php echo $record['full_name']; ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="gender">Gender</label></td>
                                <td>
                                    <select class="form-control" name="gender" required>
                                        <option value="male" <?php echo ($record['gender'] == 'male') ? 'selected' : ''; ?>>Male
                                        </option>
                                        <option value="female" <?php echo ($record['gender'] == 'female') ? 'selected' : ''; ?>>
                                            Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="dob">Date of birth</label></td>
                                <td><input type="date" class="form-control" name="dob" value="<?php echo $record['dob']; ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="contactNo">Contact No</label></td>
                                <td><input type="text" class="form-control" name="contact" required value="<?php echo $record['contact_no']; ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="password">Password</label></td>
                                <td><input type="password" class="form-control" name="password" required value="<?php echo $record['password']; ?>"></td>
                            </tr>
                            <!-- <tr>
                                <td><label for="membership_type">Membership Type</label></td>
                                <td>
                                    <select class="form-control" name="membership_type" required>
                                        <option value="monthly" <?php echo ($record['membership_type'] == 'monthly') ? 'selected' : ''; ?>>Monthly
                                        </option>
                                        <option value="yearly" <?php echo ($record['membership_type'] == 'yearly') ? 'selected' : ''; ?>>
                                            Yearly</option>
                                    </select>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary" name="register">Apply</button>
                </form>
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
            document.getElementById('profile-photo').addEventListener('click', function () {
                document.getElementById('photo').click();
            });

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
