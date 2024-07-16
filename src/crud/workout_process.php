<?php
include '../../connection.php';
// Inserting data
try {
    if (isset($_POST["register"])) {
        $name = $_POST['name'];
        $description = $_POST['desc'];

        // Check if email already exists
        $checkQuery = "SELECT COUNT(*) as count FROM workout WHERE name = '$name'";
        $checkResult = mysqli_query($con, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        if ($row['count'] > 0) {
            echo "<script>alert('Name already exists. Please use a different Workout Name.'); window.location.href='../admin/workout.php';</script>";
            exit();
        }
        
        // Perform input validation here if necessary

        $query = "INSERT INTO workout (name, description) 
                  VALUES ('$name', '$description')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Workout added successfully!'); window.location.href='../admin/workout.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during workout addition. Please try again later.');</script>";
        }
    }
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
}

// Deleting Data
if (isset($_GET["action"]) && isset($_GET["ID"])) {
    if ($_GET["action"] == "delete"){
    $workout_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM workout WHERE workout_id='$workout_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Workout deleted successfully!'); window.location.href='../admin/workout.php';</script>";
    }
}
}

// Update Data
if (isset($_POST['workoutID'])) {
    $workoutID = $_POST['workoutID'];
    $name = $_POST['name'];
    $description = $_POST['desc'];


    // Update payment query
    $updateQuery = "UPDATE workout SET workout_id = '$workoutID', name = '$name', description = '$description'  WHERE workout_id = '$workoutID'";

    // Execute update query
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Workout updated successfully!'); window.location.href='../admin/workout.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
} else {
    echo "No data received for update.";
}
?>
