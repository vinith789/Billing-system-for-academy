<?php
include '../db/config.php';
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Generate Unique ID (BFA + random char + 3-digit counter)
$last_id_query = $conn->query("SELECT student_id FROM students ORDER BY id DESC LIMIT 1");
$last_id = $last_id_query->fetch_assoc()['student_id'] ?? "BFAa000";
$next_id = "BFA" . chr(rand(97, 122)) . str_pad(substr($last_id, -3) + 1, 3, "0", STR_PAD_LEFT);

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$course = $_POST['course'];
$amount = $_POST['amount'];

$conn->query("INSERT INTO students (student_id, first_name, last_name, course, total_amount, balance_amount) VALUES ('$next_id', '$firstName', '$lastName', '$course', '$amount', '$amount')");

echo "Student Registered Successfully! ID: $next_id";
?>
