<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "worksmart");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL insert query
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Registration successful!";
            // Optionally, redirect to login page
            // header("Location: login.php");
            // exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
