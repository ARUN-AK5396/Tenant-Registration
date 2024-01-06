<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tenet';

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$tenantId = $_REQUEST['editTenantId'];
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$mobile = $_REQUEST['mobile'];
$address = $_REQUEST['address'];
$fees = $_REQUEST['fees'];
$gender = $_REQUEST['gender'];
$appointment = $_REQUEST['appointment'];
$flag = 1;

// Fetch the 'created_at' and 'name' columns from the database based on the tenantId
$query = "SELECT created_at, name FROM tenant_data WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $tenantId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($created_at, $username);
    $stmt->fetch();

    $target_dir = './Images/';
    $user_folder_path = $target_dir . $username . '_' . $created_at;

    if (!is_dir($user_folder_path)) {
        mkdir($user_folder_path);
    } else {
        // Move previous images to a 'Delete' folder within the user's folder
        $delete_folder_path = $user_folder_path . '/Delete';
        if (!is_dir($delete_folder_path)) {
            mkdir($delete_folder_path);
        }

        $existing_images = glob($user_folder_path . '/*'); // Fetch existing images
        foreach ($existing_images as $existing_image) {
            $image_name = basename($existing_image);
            rename($existing_image, $delete_folder_path . '/' . $image_name);
        }
    }

    // Loop through each uploaded file
    $image_paths = array();
    foreach ($_FILES['edit-image']['tmp_name'] as $key => $tmp_name) {
        $extension = strtolower(pathinfo($_FILES['edit-image']['name'][$key], PATHINFO_EXTENSION));
        $target_filename = $name . '_' . date("YmdHis") . '_' . $tenantId . '_' . $key . '.' . $extension;
        $target_path = $user_folder_path . '/' . $target_filename;

        // Upload the new image
        if (move_uploaded_file($tmp_name, $target_path)) {
            $image_paths[] = $username . '_' . $created_at . '/' . $target_filename;
        } else {
            echo "Image upload failed.";
            echo "Error: " . $_FILES['edit-image']['error'][$key];
        }
    }

    // Concatenate the image paths into a comma-separated string
    $image_path = implode(',', $image_paths);

    $stmt = $connection->prepare("UPDATE tenant_data SET name=?, email=?, mobile=?, address=?, photo=?, Gender=?, amount=?, appoinment=?, flag=? WHERE id=?");

    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param("ssssssssii", $name, $email, $mobile, $address, $image_path, $gender, $fees, $appointment, $flag, $tenantId);

    if ($stmt->execute()) {
        echo "Data updated successfully";
        echo '<script>alert("Data Updated Successfully");</script>';
    } else {
        echo "Error updating data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No data found for the provided tenant ID.";
}

$connection->close();
?>
