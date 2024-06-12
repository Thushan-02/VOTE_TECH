<?php
include 'db.php';

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validate_input($_POST['username']);
    $gn_division = validate_input($_POST['gn_division']);
    $mobile = validate_input($_POST['mobile']);
    $secreteriat_division = validate_input($_POST['secreteriat_division']);
    $email = validate_input($_POST['email']);
    $password = validate_input($_POST['password']);
    $gn_code = validate_input($_POST['gn_code']);

    // Simple validation
    if (empty($username) || empty($gn_division) || empty($mobile) || empty($secreteriat_division) || empty($email) || empty($password) || empty($gn_code)) {
        die("Please fill all the fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO gn_signup (username, gn_division, mobile, secreteriat_division, email, password, gn_code) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $username, $gn_division, $mobile, $secreteriat_division, $email, $hashed_password, $gn_code);

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
