<?php
session_start();
$conn = new mysqli("localhost", "your_db_username", "your_db_password", "your_database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm-password"]);
    
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "Email already registered!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $_SESSION["user_id"] = $stmt->insert_id;
                $_SESSION["user_name"] = $name;
                header("Location: explore ease.html");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>

