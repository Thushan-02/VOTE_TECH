<?php
include 'db.php';

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validate_input($_POST['username']);
    $password = validate_input($_POST['password']);

    // Simple validation
    if (empty($username) || empty($password)) {
        die("Please fill all the fields.");
    }

    $sql = "SELECT password FROM gn_signup WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $stmt->bind_result($hashed_password);
            if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                echo "Login successful!";
                // Start session and redirect
                session_start();
                $_SESSION['username'] = $username;
                header("Location: admin-index.html"); 
            } else {
                echo "Invalid username or password.";
            }
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
