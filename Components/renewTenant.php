<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tenet';

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$oldEmail = $_REQUEST['old-email'];
$oldMobile = $_REQUEST['old-mobile'];
$oldDate = $_REQUEST['old-date'];

// Check if the email and mobile number exist in the database for the same tenant
$query = "SELECT id FROM tenant_data WHERE email = ? AND mobile = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ss", $oldEmail, $oldMobile);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($tenantId);
    $stmt->fetch();

    // Update the data for the tenant with the provided email and mobile
    $flag = 1; // Set flag to 1
    $appointment = $oldDate; // Set appointment date from form

    $updateQuery = "UPDATE tenant_data SET flag = ?, appoinment = ? WHERE id = ?";
    $updateStmt = $connection->prepare($updateQuery);
    $updateStmt->bind_param("isi", $flag, $appointment, $tenantId);

    if ($updateStmt->execute()) {
        echo "Data updated successfully";
        // echo '<script>alert("Data Updated Successfully");</script>';
    } else {
        echo "Error updating data: " . $updateStmt->error;
    }
} else {
    echo "Data not available for the provided email and mobile number.";
}

$connection->close();
?>
