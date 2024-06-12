<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $house_no = htmlspecialchars($_POST['house_no']);
    $password = htmlspecialchars($_POST['password']);

    // Validate input (you may add more validation as needed)
    if (empty($house_no) || empty($password)) {
        die("Please fill all the fields.");
    }

    // Check if the house number exists in the database
    $sql = "SELECT * FROM house_registration WHERE house_no = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $house_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a new session
                $_SESSION['house_no'] = $house_no;

                // Redirect to a dashboard or profile page
                header("Location: user-index.html");
                exit();
            } else {
                // Incorrect password
                echo "Incorrect password.";
            }
        } else {
            // House number not found
            echo "House number not found.";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
