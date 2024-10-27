<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dual Design Registration Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <a href="index.html" class="back-arrow">&#8592;</a> <!-- Panah Kembali -->
            <img src="images/slide/logowmk.png" class="logo img-fluid" alt="Kind Heart Charity">
            <h1>Welcome</h1>
            <p>Anda baru saja membuka pintu menuju pengetahuan dan keterampilan baru. <br>Mari kita eksplorasi bersama dan capai potensi Anda!</p>
            <a href="login1.html">
                <button class="login-btn">Login</button>
            </a>
        </div>

        <div class="registration-section">
            <h2 id="form-title">Apply as an Employee</h2>
                <input type="text" name="first_name" id="first_name" required>
            
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required>
            
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>
            
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="Admin">Admin</option>
                    <option value="Mitra">Mitra</option>
                    <option value="Peserta">Peserta</option>
                </select>
            
                <button type="submit" class="register-btn">Registrasi</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php
// Sertakan file koneksi
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
        exit();
    }

    // Check for existing email
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
        $stmt->close();
        exit();
    }

    $stmt->close();

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL insert query
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='login1.html';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>
