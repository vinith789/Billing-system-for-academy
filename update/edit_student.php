<?php
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $sql = "UPDATE students SET first_name='$first_name', last_name='$last_name' WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Student Updated Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
