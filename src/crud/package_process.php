<?php
include '../../connection.php';
// Inserting data
try {
    if (isset($_POST["register"])) {
        $name = $_POST['name'];
        $description = $_POST['desc'];
        $price = $_POST['price'];
        $duration = $_POST['duration'];

        // Check if email already exists
        $checkQuery = "SELECT COUNT(*) as count FROM package WHERE name = '$name'";
        $checkResult = mysqli_query($con, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        if ($row['count'] > 0) {
            echo "<script>alert('Name already exists. Please use a different Package Name.'); window.location.href='../admin/package.php';</script>";
            exit();
        }
        
        // Perform input validation here if necessary

        $query = "INSERT INTO package (name, description, price, duration) 
                  VALUES ('$name', '$description', '$price', '$duration')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Package added successfully!'); window.location.href='../admin/package.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during package addition. Please try again later.');</script>";
        }
    }
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
}

// Deleting Data
if (isset($_GET["action"]) && isset($_GET["ID"])) {
    if($_GET["action"] == "delete"){
    $package_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM package WHERE package_id='$package_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Package deleted successfully!'); window.location.href='../admin/package.php';</script>";
    }
}
}

// Update Data
if (isset($_POST['packageID'])) {
    $packageID = $_POST['packageID'];
    $name = $_POST['name'];
    $description = $_POST['desc'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];


    // Update payment query
    $updateQuery = "UPDATE package SET package_id = '$packageID', name = '$name', description = '$description', price = '$price' , duration = '$duration' WHERE package_id = '$packageID'";

    // Execute update query
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Package updated successfully!'); window.location.href='../admin/package.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
} else {
    echo "No data received for update.";
}
?>
