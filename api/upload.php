// Load and Insert Student Image (or Default Image)
            // $studentImagePath = "./students/$student_id.jpg"; // Assuming student images are stored as student_id.jpg
            // if (!file_exists($studentImagePath)) {
            //     $studentImagePath = "./image/default-avatar.png"; // Use a default image if no student image exists
            // }
            // if (file_exists($studentImagePath)) {
            //     $studentImage = @imagecreatefromjpeg($studentImagePath) ?: @imagecreatefrompng($studentImagePath);
            //     if ($studentImage) {
            //         imagecopyresampled($image, $studentImage, 350, 10, 0, 0, 100, 100, imagesx($studentImage), imagesy($studentImage));
            //         imagedestroy($studentImage);
            //     }
            // }