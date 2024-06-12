<?php
include 'db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if all required fields are set and not empty
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : null;
    $nic = isset($_POST['nic']) ? $_POST['nic'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : null;

    // Debugging: Print out the values of the form fields
    // echo "Fullname: $fullname<br>";
    // echo "NIC: $nic<br>";
    // echo "Role: $role<br>";
    // echo "Feedback: $feedback<br>";

    // Validate the input
    if ($fullname && $nic && $role && $feedback) {

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO feedback (fullname, nic, role, feedback) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $nic, $role, $feedback);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>
