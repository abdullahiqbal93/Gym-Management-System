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

    // Initialize variables for height and weight
    $height = $weight = '';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve height and weight from the form
        $height = $_POST['height'];
        $weight = $_POST['weight'];

        // Calculate BMI
        if (!empty($height) && !empty($weight)) {
            // Convert height from centimeters to meters
            $heightInMeters = $height / 100;
            // Calculate BMI
            $bmi = $weight / ($heightInMeters * $heightInMeters);
            // Round BMI to 2 decimal places
            $bmi = round($bmi, 2);

            // Save BMI record to database
            $insertQuery = "INSERT INTO bmi_table (member_id, height, weight, bmi) VALUES ('$memberID', '$height', '$weight', '$bmi')";
            mysqli_query($con, $insertQuery);
        }
    }

    // Check if delete button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_bmi'])) {
        $bmiID = $_POST['bmi_id'];
        $deleteQuery = "DELETE FROM bmi_table WHERE bmi_id = '$bmiID'";
        if (mysqli_query($con, $deleteQuery)) {
            // Deletion successful
            header("Location: ".$_SERVER['PHP_SELF']); // Redirect to refresh the page
            exit();
        } else {
            // Error occurred while deleting
            echo "Error: " . mysqli_error($con);
        }
    }

    // Retrieve historical BMI records for the user
    $bmiHistoryQuery = "SELECT * FROM bmi_table WHERE member_id = '$memberID' ORDER BY bmi_id DESC LIMIT 5";
    $bmiHistoryResult = mysqli_query($con, $bmiHistoryQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/member_dashboard.css">

    <style>
        .bmi-calculator {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .bmi-calculator .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .bmi-calculator .result {
            text-align: center;
            margin-top: 20px;
        }

        .bmi-history table {
            width: 100%;
            border-collapse: collapse;
        }

        .bmi-history th,
        .bmi-history td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .bmi-history th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
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
                    <a href="">Payments</a>
                </li>
                <li>
                    <a href="schedule.php">Schedule</a>
                </li>
                <li class="active">
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
            <div class="bmi-calculator">
                <div class="heading">
                    <h3>BMI Calculator</h3>
                </div>
                <div class="form">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="height">Height (in cm):</label>
                            <input type="number" class="form-control" id="height" name="height" value="<?php echo $height; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight (in kg):</label>
                            <input type="number" class="form-control" id="weight" name="weight" value="<?php echo $weight; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Calculate BMI</button>
                    </form>
                </div>
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($bmi)) : ?>
                    <div class="result">
                        <h4>Your BMI: <?php echo $bmi; ?></h4>
                        <p>
                            <?php
                            // Interpretation of BMI
                            if ($bmi < 18.5) {
                                echo "Underweight - You may need to increase your calorie intake with nutrient-rich foods such as lean proteins, healthy fats, and complex carbohydrates.";
                                echo "Examples of foods to consume: Chicken breast, fish, tofu, lentils, quinoa, avocado.";
                                echo "Recommended protein intake: Approximately 1.2 to 1.5 grams of protein per kilogram of body weight.";
                            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                                echo "Normal weight - Maintain a balanced diet with a variety of fruits, vegetables, lean proteins, and whole grains.";
                                echo "Examples of foods to consume: Broccoli, spinach, berries, whole grain bread, chicken breast.";
                                echo "Recommended protein intake: Approximately 0.8 to 1.0 grams of protein per kilogram of body weight.";
                            } elseif ($bmi >= 24.9 && $bmi < 29.9) {
                                echo "Overweight - Focus on portion control and incorporate more physical activity into your daily routine.";
                                echo "Examples of foods to consume: Leafy greens, lean meats, nuts, seeds, whole grains.";
                                echo "Recommended protein intake: Approximately 1.0 to 1.2 grams of protein per kilogram of body weight.";
                            } else {
                                echo "Obese - Consult a healthcare professional for personalized nutrition and exercise recommendations.";
                                echo "Examples of foods to consume: Vegetables, fruits, lean proteins, whole grains, healthy fats in moderation.";
                                echo "Recommended protein intake: Approximately 1.0 to 1.2 grams of protein per kilogram of body weight.";
                            }
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($bmiHistoryResult && mysqli_num_rows($bmiHistoryResult) > 0) : ?>
                <div class="bmi-history">
                    <h3>Recent BMI History</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Height (cm)</th>
                                <th>Weight (kg)</th>
                                <th>BMI</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($bmiHistoryResult)) : ?>
                                <tr>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['height']; ?></td>
                                    <td><?php echo $row['weight']; ?></td>
                                    <td><?php echo $row['bmi']; ?></td>
                                    <td>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="bmi_id" value="<?php echo $row['bmi_id']; ?>">
                                            <button type="submit" name="delete_bmi" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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
