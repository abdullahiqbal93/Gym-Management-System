<?php
session_start();
include '../../connection.php';

$memberID = $_SESSION['member_id'];

if (isset($_POST["register"])) {
    // Retrieve form data
    $fullName = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $contactNo = $_POST['contact'];
    $password = $_POST['password'];

    // Check if a file is uploaded
    if ($_FILES['edit_photo']['size'] > 0) {
        $targetDirectory = "../../image/members/";
        $targetFile = $targetDirectory . basename($_FILES["edit_photo"]["name"]);

        // Check if file was uploaded successfully
        if (move_uploaded_file($_FILES["edit_photo"]["tmp_name"], $targetFile)) {
            $photo = $targetFile;   // File upload successful, update photo path
        } else {
            // File upload failed, display error
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        // No new file uploaded, check if the "photo" key is set in $_POST
        $photo = isset($_POST['photo']) ? $_POST['photo'] : ''; // Set $photo to empty string if "photo" key is not set
    }

    // Construct the update query
    $updateQuery = "UPDATE member SET full_name = '$fullName', gender = '$gender', dob = '$dob', contact_no = '$contactNo', password = '$password'";

    // Append photo update if a new photo was uploaded
    if (isset($photo) && $photo !== '') {
        $updateQuery .= ", photo = '$photo'";
    }

    $updateQuery .= " WHERE member_id = '$memberID'";

    // Execute the update query
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='../member/profile.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
}
?>
