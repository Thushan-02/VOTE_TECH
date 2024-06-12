<?php
include 'db.php';

session_start();

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST['full_name'], $_POST['house_no'], $_POST['nic_no'], $_POST['mobile_no'], $_POST['dob'], $_POST['civil_status'], $_POST['gender']) &&
        !empty($_POST['full_name']) && !empty($_POST['house_no']) && !empty($_POST['nic_no']) && !empty($_POST['mobile_no']) && !empty($_POST['dob']) && !empty($_POST['civil_status']) && !empty($_POST['gender']) && isset($_FILES['nic_picture']) && $_FILES['nic_picture']['error'] === UPLOAD_ERR_OK) {

        $full_name = validate_input($_POST['full_name']);
        $house_no = validate_input($_POST['house_no']);
        $nic_no = validate_input($_POST['nic_no']);
        $mobile_no = validate_input($_POST['mobile_no']);
        $dob = validate_input($_POST['dob']);
        $civil_status = validate_input($_POST['civil_status']);
        $gender = validate_input($_POST['gender']);

        // Handle file upload for NIC Picture
        $nic_picture = $_FILES['nic_picture'];
        $target_dir = "nic_pictures/";
        $target_file = $target_dir . basename($nic_picture["name"]);
        $upload_ok = 1;
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a valid image type
        $valid_types = array("jpg", "jpeg", "png");
        if (!in_array($image_type, $valid_types)) {
            die("Sorry, only JPG, JPEG & PNG files are allowed.");
        }

        // Check if file upload is successful
        if ($upload_ok && move_uploaded_file($nic_picture["tmp_name"], $target_file)) {
            // Insert data into database
            $sql = "INSERT INTO members_registration (full_name, house_no, nic_no, mobile_no, dob, civil_status, gender, nic_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssss", $full_name, $house_no, $nic_no, $mobile_no, $dob, $civil_status, $gender, $target_file);

                if ($stmt->execute()) {
                    echo "Registration successful!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        die("Please fill all the fields.");
    }
}
?>
