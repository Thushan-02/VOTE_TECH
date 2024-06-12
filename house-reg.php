<?php
include 'db.php';

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $house_no = validate_input($_POST['full_name']);
    $chief_occupant = validate_input($_POST['name_of_chief_occupant']);
    $mobile_no = validate_input($_POST['mobile_no']);
    $address = validate_input($_POST['address']);
    $password = validate_input($_POST['H_password']);
    $confirm_password = validate_input($_POST['c_password']);
    $gn_code = validate_input($_POST['GN_code']);

    // Check if all fields are filled
    if (empty($house_no) || empty($chief_occupant) || empty($mobile_no) || empty($address) || empty($password) || empty($confirm_password) || empty($gn_code)) {
        die("Please fill all the fields.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    if ($_FILES['bill']['error'] === UPLOAD_ERR_OK) {
        $bill = $_FILES['bill'];
        $target_dir = "bill_images/";
        $target_file = $target_dir . basename($bill["name"]);
        $upload_ok = 1;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a valid image type (e.g., jpg, jpeg, png)
        $valid_types = array("jpg", "jpeg", "png");
        if (!in_array($file_type, $valid_types)) {
            die("Sorry, only JPG, JPEG & PNG files are allowed.");
        }

        // Check if file upload is successful
        if ($upload_ok && move_uploaded_file($bill["tmp_name"], $target_file)) {
            // File upload successful
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        die("Error uploading file.");
    }

    // Insert data into database
    $sql = "INSERT INTO house_registration (house_no, chief_occupant, mobile_no, address, password, gn_code, bill_image) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $house_no, $chief_occupant, $mobile_no, $address, $hashed_password, $gn_code, $target_file);

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
}
?>
