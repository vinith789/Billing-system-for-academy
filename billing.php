<?php
include './db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];

    $result = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");

    if ($result->num_rows == 0) {
        echo "<p style='color:red; font-size:20px;'>Error: Student not found!</p>";
        exit;
    }

    $student = $result->fetch_assoc();
    $new_paid = $student['paid_amount'] + $amount;
    $new_balance = $student['total_amount'] - $new_paid;

    $conn->query("INSERT INTO payments (student_id, paid_amount) VALUES ('$student_id', $amount)");

    $update = "UPDATE students SET paid_amount=$new_paid, balance_amount=$new_balance WHERE student_id='$student_id'";
    if ($conn->query($update) === TRUE) {

        // Set header to output an image
        header('Content-Type: image/png');

        // Create a high-resolution image (Full HD)
        $width = 1920;
        $height = 1040;
        $image = imagecreatetruecolor($width, $height);

        // Define Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 0, 0, 255);
        $red = imagecolorallocate($image, 255, 0, 0);

        // Fill background with white
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Load and Insert High-Resolution Logo
        // $logoPath = './image/logo.jpeg';
        // if (file_exists($logoPath)) {
        //     $logo = @imagecreatefromjpeg($logoPath) ?: @imagecreatefrompng($logoPath);
        //     if ($logo) {
        //         $logoWidth = imagesx($logo);
        //         $logoHeight = imagesy($logo);
        //         $newLogoWidth = 250;
        //         $newLogoHeight = ($logoHeight / $logoWidth) * $newLogoWidth;
        //         imagecopyresampled($image, $logo, 50, 20, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
        //         imagedestroy($logo);
        //     }
        // }

        // Font Path
        $fontPath = './Montserrat-VariableFont_wght.ttf';
        if (!file_exists($fontPath)) {
            die("Error: Font file not found at $fontPath");
        }

        // Date of Payment
        $date = date("d-m-Y");

        // Add Text Content
        imagettftext($image, 50, 0, 600, 150, $black, $fontPath, "Bright Future Academy");
        imagettftext($image, 40, 0, 700, 250, $black, $fontPath, "Academy Billing Receipt");
        imagettftext($image, 25, 0, 100, 350, $black, $fontPath, "Date of Payment: $date");

        imagettftext($image, 30, 0, 100, 420, $black, $fontPath, "Student ID: $student_id");
        imagettftext($image, 30, 0, 100, 490, $black, $fontPath, "Name: " . $student['first_name'] . " " . $student['last_name']);
        imagettftext($image, 30, 0, 100, 560, $black, $fontPath, "Course: " . $student['course']);
        imagettftext($image, 30, 0, 100, 630, $black, $fontPath, "Total Amount: ₹" . $student['total_amount']);
        imagettftext($image, 30, 0, 100, 700, $black, $fontPath, "Paid Amount: ₹$new_paid");
        imagettftext($image, 35, 0, 100, 770, $blue, $fontPath, "Last Payment: ₹$amount");

        // Make Balance Amount Bold and Red
        imagettftext($image, 35, 0, 100, 840, $red, $fontPath, "Balance Amount: ₹$new_balance");

        // Academy Contact Details
        imagettftext($image, 25, 0, 100, 900, $black, $fontPath, "Contact: +91 90873 15789 | Email: bfa.academy@gmail.com");

        // Authorized Signature
        imagettftext($image, 30, 0, 1520, 950, $black, $fontPath, "Approved By");
        imagettftext($image, 30, 0, 1550, 1000 ,$black, $fontPath, "VINITH R");

        // imageline($image, 1500, 1010, 1850, 1010, $black); // Signature Line

        // Save Image
        $filePath = "./uploads/invoice_$student_id.png";
        if (!is_dir("./uploads")) {
            mkdir("./uploads", 0777, true);
        }
        imagepng($image, $filePath);
        imagedestroy($image);

        // Display Output
        echo "<p style='color:green; font-size:22px;'>Payment Successful!</p>";
        echo "<img src='$filePath' width='600'> <br>";
        echo "<a href='$filePath' download='Invoice_$student_id.png'><button class='btn btn-primary '>Download Invoice</button></a>";
    } else {
        echo "<p style='color:red; font-size:20px;'>Error updating record: " . $conn->error . "</p>";
    }
}
?>
