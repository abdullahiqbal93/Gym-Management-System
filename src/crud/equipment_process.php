<?php
include '../../connection.php';

// Inserting data
try {
    if (isset($_POST["register"])) {
        // Retrieve other form data
        $name = $_POST['name'];
        $quantity = $_POST['qty'];
        $description = $_POST['desc'];
        $unit_price = $_POST['price'];
        
        // File upload handling
        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
            $targetDirectory = "../../image/equipments/";
            $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                $photo = $targetFile;
            } else {
                // Handle file upload error
                echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='../admin/equipment.php';</script>";
                exit;
            }
        } else {
            // Handle case when no file was uploaded
            echo "<script>alert('No file was uploaded.'); window.location.href='../admin/equipment.php';</script>";
            exit;
        }

        $query = "INSERT INTO equipment (name, quantity, description, unit_price, photo) 
                  VALUES ('$name', '$quantity', '$description', '$unit_price', '$photo')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Equipment added successfully!'); window.location.href='../admin/equipment.php';</script>";
        } else {
            error_log("MySQL Error: " . mysqli_error($con));
            echo "<script>alert('An error occurred during equipment addition. Please try again later.');</script>";
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
    $equipment_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM equipment WHERE equipment_id='$equipment_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Equipment Deleted successfully!'); window.location.href='../admin/equipment.php';</script>";
    }
}
}

// Update data
if (isset($_POST['equipmentID'])) {
    $equipmentID = $_POST['equipmentID'];
    $name = $_POST['name'];
    $quantity = $_POST['qty'];
    $description = $_POST['desc'];
    $unit_price = $_POST['price'];

    // Check if a new photo was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
        // File upload handling for new photo
        $targetDirectory = "../../image/equipments/";
        $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
            $photo = $targetFile;
        } else {
            // Handle file upload error
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='../admin/equipment.php';</script>";
            exit;
        }
    } else {
        // No new photo provided, retain the existing photo path
        $photo = $_POST['photo'];
    }
    
    // Update query with proper handling of photo
    $updateQuery = "UPDATE equipment SET name = '$name', quantity = '$quantity', description = '$description', unit_price = '$unit_price'";
    if (isset($photo)) {
        // Append photo update to query if a new photo was provided
        $updateQuery .= ", photo = '$photo'";
    }
    $updateQuery .= " WHERE equipment_id = '$equipmentID'";

    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Equipment updated successfully!'); window.location.href='../admin/equipment.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
}
?>
