<?php

session_start();

// Database connection parameters
$host = "localhost";
$databaseUserName = "sithmini";
$databasePassword = "bk1234";
$database = "BKDB";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $databaseUserName, $databasePassword, $database);

    // Check connection
    if ($conn->connect_error) {
        // Log connection error
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE UserName = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['Password']) {
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['UserName'];

            // Redirect user to dashboard or another page
            error_log("[NOTERROR] Redirection Reached !");
            header("Location: men.html");
            exit();
        } else {
            $errorMessage = "Incorrect password";
            error_log($errorMessage);
            echo "<script>console.log('$errorMessage');</script>";
            echo $errorMessage;
        }
    } else {
        $errorMessage = "User not found";
        error_log($errorMessage);
        echo "<script>console.log('$errorMessage');</script>";
        echo $errorMessage;
    }
    // Close the database connection
    $conn->close();
}
?>
