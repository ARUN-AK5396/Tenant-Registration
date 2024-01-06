<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'tenet';

    $connection = mysqli_connect($host, $user, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $tenantId = $_GET['tenantId'];
    $sql = "SELECT * FROM tenant_data WHERE id = $tenantId";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $tenantDetails = mysqli_fetch_assoc($result);
        header('Content-Type: application/json');
        echo json_encode($tenantDetails);
    } else {
        echo "No tenant found for the provided ID.";
    }

    mysqli_close($connection);
?>
