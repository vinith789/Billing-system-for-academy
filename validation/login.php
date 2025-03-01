<?php
session_start();

// If user is already logged in, redirect to index.php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ./index.php");
    exit;
}

$error = ""; // To show errors if login fails

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hardcoded credentials
    $valid_email = "brightfuture@gmail.com";
    $valid_password = "1230";

    if ($email === $valid_email && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: ./index.php");
        exit;
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>