<?php
include '../db/config.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Student not found"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
