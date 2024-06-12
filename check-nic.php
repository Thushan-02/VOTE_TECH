<?php
include 'db.php';

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['nic_no']) && !empty($_GET['nic_no'])) {
        $nic_no = validate_input($_GET['nic_no']);
        
        $sql = "SELECT * FROM members_registration WHERE nic_no = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $nic_no);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // NIC found
                header("Location: nic-success.html");
            } else {
                // NIC not found
                header("Location: nic-fail.html");
            }
            
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Please enter a NIC number.";
    }
} else {
    echo "Invalid request method.";
}
?>
