<?php
include '../../connection.php';

if (isset($_GET['preview'])) {
    header('Content-Type: application/json');

    $selectQuery = "SELECT * FROM member";
    $result = mysqli_query($con, $selectQuery);

    $members = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($record = mysqli_fetch_assoc($result)) {
            $members[] = $record;
        }
    }

    echo json_encode($members);
    exit;
} else {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="member_report.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Member ID', 'Full Name', 'DOB', 'Gender', 'Contact No', 'Email', 'DOJ']);

    $selectQuery = "SELECT * FROM member";
    $result = mysqli_query($con, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($record = mysqli_fetch_assoc($result)) {
            fputcsv($output, $record);
        }
    }
    fclose($output);
    exit;
}
?>
