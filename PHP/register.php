<?php
session_start();
include('db_connect.php');
if (isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}
if (isset($_POST['register'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {

        $email = $conn->real_escape_string($email);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            //Password hashing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $email, $hashed_password);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Registration successful! Please log in.";
                    $stmt->close();
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Error: " . $conn->error;
                }
                $stmt->close();
            } else {
                $error = "Prepare failed: " . $conn->error;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
    <link rel="shortcut icon" href="../IBP-2/pictures/list_icon.png">
    <title>Sign-up</title>
</head>
<body class="standard">
    <h1>Let's organize your Day!</h1>
    <div class="auth-container">
        <h2>Sign up</h2>
        <?php
        if (isset($error)) {
            echo "<p style='color: red;'>" . htmlspecialchars($error) . "</p>";
        }
        if (isset($_SESSION['message'])) {
            echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <form action="register.php" method="POST" onsubmit="return validateLoginForm()">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Sign up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
    <script src="./login.js"></script>
</body>
</html>
