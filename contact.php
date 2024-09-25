<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    
    // Here, you could store the message in the database or send an email
    // For demonstration, we just echo the details
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "Message: $message <br>";
}
?>
