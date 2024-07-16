<?php
include '../../connection.php';

// Inserting data
try {
    if (isset($_POST["register"])) {
        $package = $_POST['package'];
        $workout = $_POST['workout'];
        $sets = $_POST['sets'];
        $reps = $_POST['reps'];

        $query = "INSERT INTO package_workout (package_id, workout_id, sets, reps) 
                  VALUES ('$package', '$workout' , $sets , $reps)";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Package Workout added successfully!'); window.location.href='../admin/package_workout.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during package workout addition. Please try again later.');</script>";
        }
    }
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
}

// Deleting Data
if (isset($_GET["action"]) && isset($_GET["workout_id"]) && isset($_GET["package_id"])) {
    if ($_GET["action"] == "delete") {
        $workout_id = $_GET["workout_id"];
        $package_id = $_GET["package_id"];
        
        $deleteQuery = "DELETE FROM package_workout WHERE workout_id ='$workout_id' AND package_id ='$package_id'";
        $deleteResult = mysqli_query($con, $deleteQuery);
        
        if (!$deleteResult) {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "An error occurred during deletion. Please try again later.";
        } else {
            echo "<script>alert('Package Workout deleted successfully!'); window.location.href='../admin/package_workout.php';</script>";
        }
    }
}

?>
