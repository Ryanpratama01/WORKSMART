<?php
$conn = mysqli_connect("localhost", "root", "","login");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Securely prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $user_role = $user['user_role'];

        // Redirect based on the user role
        if ($user_role == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($user_role == 'Mitra') {
            header("Location: partner_dashboard.php");
        } elseif ($user_role == 'Peserta') {
            header("Location: Peserta_dashboard.php");
        }
    } else {
        echo "Invalid email or password.";
    }
    $stmt->close();
}
$conn->close();
?>
