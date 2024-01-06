<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tenet";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT id FROM admin WHERE name=? AND password=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $user;
            echo "success";
        } else {
            echo "error";
        }
    }

    $conn->close();
?>
