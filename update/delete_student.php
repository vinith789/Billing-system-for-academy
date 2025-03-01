<?php
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    $sql = "DELETE FROM students WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Student Deleted Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
