<?php
include '../../connection.php';

// Inserting data
try {
    if (isset($_POST["register"])) {
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $salary = $_POST['salary'];
        
        // File upload handling
        $targetDirectory = "../../image/trainers/"; // Directory where uploaded files will be stored
        $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]); // Path of the uploaded file

        // Check if file was uploaded successfully
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
            $photo = $targetFile; // Store the path of the uploaded file in the database
            $query = "INSERT INTO trainer (full_name, specialization, contact_no, email, salary, photo) 
                      VALUES ('$name', '$specialization', '$contact', '$email', '$salary', '$photo')";
            if (mysqli_query($con, $query)) {
                echo "<script>alert('Trainer added successfully!'); window.location.href='../admin/trainer.php';</script>";
            } else {
                error_log("MySQL Error: " . mysqli_error($con));
                echo "<script>alert('An error occurred during trainer addition. Please try again later.');</script>";
            }
        } else {
            // File upload failed, log the specific error code
            $errorCode = $_FILES['photo']['error'];
            error_log("File upload error: " . $errorCode);
        
            // Display an error message based on the error code
            switch ($errorCode) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "<script>alert('The uploaded file exceeds the maximum file size.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<script>alert('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<script>alert('The uploaded file was only partially uploaded.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<script>alert('No file was uploaded.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "<script>alert('Missing a temporary folder.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "<script>alert('Failed to write file to disk.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "<script>alert('A PHP extension stopped the file upload.'); window.location.href='../admin/trainer.php';</script>";
                    break;
                default:
                    echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='../admin/trainer.php';</script>";
                    break;
            }
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
    $trainer_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM trainer WHERE trainer_id='$trainer_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Trainer Deleted successfully!'); window.location.href='../admin/trainer.php';</script>";
    }
}
}

// Update Data
if (isset($_POST['trainerID'])) {
    $trainerID = $_POST['trainerID'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];

    // File upload handling
    if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {

        $targetDirectory = "../../image/trainers/";
        $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

        // Check if file was uploaded successfully
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
            $photo = $targetFile;
        } else {
            // Handle file upload error
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='../admin/trainer.php';</script>";
            exit;
        }
    } else {
        $photo = $_POST['photo'];  // No new file uploaded, retain the existing photo path
    }
    

    $updateQuery = "UPDATE trainer SET full_name = '$name', specialization = '$specialization', contact_no = '$contact', email = '$email', salary = '$salary'";
    if (isset($photo)) {
        // Append photo update to query if a new photo was provided
        $updateQuery .= ", photo = '$photo'";
    }
    $updateQuery .= " WHERE trainer_id = '$trainerID'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Trainer updated successfully!'); window.location.href='../admin/trainer.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
}
?>
