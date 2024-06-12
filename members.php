<?php
session_start();
include 'db.php';

// Assuming house_no is stored in session upon login
$house_no = $_SESSION['house_no']; 

$sql = "SELECT * FROM members_registration WHERE house_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $house_no);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid shadow mb-2 bg-body rounded pb-2">
                <a class="navbar-brand d-flex justify-content-between align-items-center" href="#"><img src="Assets/Vote Tech.png" width="40" height="40" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse pe-5" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-lg-0 d-flex justify-content-between align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Services</li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Feedback</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="admin-signup.html">Sign Up</a></li>
                                <li><a class="dropdown-item" href="admin-login.html">Log In</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="btn-primary px-4 py-1 rounded" type="submit" href="admin-login.html" target="_blank">Get Started</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="members">
        <div class="logo-1">
            <img src="Assets/Vote Tech.png" alt="" width="120px" height="auto">
        </div>
        <div class="house-no">
            <p><b>House No:</b></p>
            <p id="house_no"><b><?= htmlspecialchars($house_no); ?></b></p>
        </div>
        <div class="details">
            <div class="container">
                <div class="row px-4">
                    <div class="col-sm-3">
                        <p><b>NIC</b></p>
                    </div>
                    <div class="col-sm-3">
                        <p><b>Name</b></p>
                    </div>
                    <div class="col-sm-3">
                        <p><b>DOB</b></p>
                    </div>
                </div>

                <?php foreach ($members as $member): ?>
                    <div class="row px-4">
                        <div class="col">
                            <p id="NIC"><?= htmlspecialchars($member['nic_no']); ?></p>
                        </div>
                        <div class="col">
                            <p id="name"><?= htmlspecialchars($member['full_name']); ?></p>
                        </div>
                        <div class="col">
                            <p id="dob"><?= htmlspecialchars($member['dob']); ?></p>
                        </div>
                        <div class="col">
                            <button class="btn-green">Apply</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="items-2">
            <div class="contact-us">
                <h5>Contact Us</h5>
                <div class="items-3">
                    <i class="fa-solid fa-location-dot"></i>
                    <p>VoteTech Headquarters, Colombo, Sri Lanka</p>
                </div>
                <div class="items-3">
                    <i class="fa-solid fa-phone"></i>
                    <p>+94 11 123 4567</p>
                </div>
                <div class="items-3">
                    <i class="fa-solid fa-envelope"></i>
                    <p>info@votetech.lk</p>
                </div>
            </div>
            <div class="quick-links">
                <h5>Quick Links</h5>
                <div class="items-3">
                    <p><a href="index.html" target="_parent">About Us</a></p>
                </div>
                <div class="items-3">
                    <p><a href="index.html">Feedback</a></p>
                </div>
                <div class="items-3">
                    <p><a href="admin-login.html" target="_blank">Account</a></p>
                </div>
                <div class="items-3">
                    <p><a href="#faq"></a></p>
                </div>
            </div>
            <div class="connect">
                <h5>Connect with Us</h5>
                <div class="items-3">
                    <i class="fa-brands fa-facebook"></i>
                    <p>Facebook</p>
                </div>
                <div class="items-3">
                    <i class="fa-brands fa-instagram"></i>
                    <p>Instagram</p>
                </div>
                <div class="items-3">
                    <i class="fa-brands fa-whatsapp"></i>
                    <p>Whatsapp</p>
                </div>
                <div class="items-3">
                    <i class="fa-brands fa-x-twitter"></i>
                    <p>X</p>
                </div>
            </div>
        </div>
        <p>Copyright © 2024 VoteTech. All Rights Reserved.</p>
    </footer>
    <script src="./bootstrap_assets/js/bootstrap.min.js"></script>
</body>

</html>
