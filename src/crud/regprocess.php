<?php
include '../../connection.php';


// Inserting data
try {
    if (isset($_POST["register"])) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $doj = $_POST['doj'];

        if ($_POST["password"]== null) {
            $password = 1234;
        }else{
            $password = $_POST['password']; 
        }

        // Check if email already exists
        $checkQuery = "SELECT COUNT(*) as count FROM member WHERE email = '$email'";
        $checkResult = mysqli_query($con, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        if ($row['count'] > 0) {
            echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
            exit(); // Stop further execution
        }

        // Prepare and execute the SQL query
        $query = "INSERT INTO member (full_name, dob, gender, contact_no, email, password, doj) 
                  VALUES ('$name', '$dob', '$gender', '$contact', '$email', '$password', '$doj')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Member registered successfully!'); window.location.href='../admin/member_details.php';</script>";
        } else {
            // Check if the error is due to duplicate entry
            if (mysqli_errno($con) == 1062) { // Error number for duplicate entry
                echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
            } else {
                // Log and display other errors
                error_log("MySQL Error: " . mysqli_error($con));
                echo "<script>alert('An error occurred during registration. Please try again later.'); window.history.back();</script>";
            }
        }
    }else if(isset($_POST["submit"])){
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $doj = date('Y-m-d');
        $mem_type = "NULL";

           // Check if email already exists
           $checkQuery = "SELECT COUNT(*) as count FROM member WHERE email = '$email'";
           $checkResult = mysqli_query($con, $checkQuery);
           $row = mysqli_fetch_assoc($checkResult);
           if ($row['count'] > 0) {
               echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
               exit(); // Stop further execution
           }
   
           // Prepare and execute the SQL query
           $query = "INSERT INTO member (full_name, dob, gender, contact_no, email, password, doj ) 
                     VALUES ('$name', '$dob', '$gender', '$contact', '$email', '$password', '$doj')";
   
           if (mysqli_query($con, $query)) {
               echo "<script>alert('Member registered successfully!'); window.location.href='../../login.php';</script>";
           } else {
               // Check if the error is due to duplicate entry
               if (mysqli_errno($con) == 1062) { // Error number for duplicate entry
                   echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
               } else {
                   // Log and display other errors
                   error_log("MySQL Error: " . mysqli_error($con));
                   echo "<script>alert('An error occurred during registration. Please try again later.'); window.location.href='../../login.php';</script>";
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
    if ($_GET["action"] == "delete"){
    $member_id = $_GET["ID"];
    $deleteQuery = "DELETE FROM member WHERE member_id='$member_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during deletion. Please try again later.";
    } else {
        echo "<script>alert('Record Deleted successfully!'); window.location.href='../admin/member_details.php';</script>";
    }
}
}


// Update Data
if (isset($_POST['memberID'])) {
    $memberID = $_POST['memberID'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $doj = $_POST['doj'];
    $password = $_POST['password'];

    $updateQuery = "UPDATE member SET full_name = '$name', dob = '$dob', gender = '$gender', contact_no = '$contact', email = '$email', password = '$password', doj = '$doj' WHERE member_id = '$memberID'";

    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Member updated successfully!'); window.location.href='../admin/member_details.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($con));
        echo "An error occurred during update. Please try again later.";
    }
}


?>