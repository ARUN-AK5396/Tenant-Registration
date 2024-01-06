<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tenet';

$connection = mysqli_connect($host, $user, $password, $database);

if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
}

ini_set('post_max_size', '20M');
ini_set('upload_max_filesize', '20M');

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$fees = $_POST['fees'];
$appointment = $_POST['appointment'];

$created_at = date("Y-m-d");
$target_dir = './Images/';

$check_query = "SELECT * FROM `tenant_data` WHERE `email`='$email' OR `mobile`='$mobile'";
$check_result = mysqli_query($connection, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo '<script>alert("Email or mobile number already exists in the database. Please use a different email or mobile number.");</script>';
} else {
    // Loop through each uploaded file only if email or mobile doesn't exist
    $image_paths = array();
    foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
        $target_filename = $name . '_' . date("YmdHis") . '_' . $key . '_' . basename($_FILES['image']['name'][$key]);
        $target_path = $target_dir . $target_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $target_path)) {
            $username = explode(' ', $name)[0];
            $folder_name = $username . '_' . date("Y-m-d");
            $user_folder_path = $target_dir . $folder_name;

            if (!is_dir($user_folder_path)) {
                mkdir($user_folder_path);
            }

            $new_target_path = $user_folder_path . '/' . basename($_FILES['image']['name'][$key]);
            rename($target_path, $new_target_path);

            $target_filename = $folder_name . '/' . basename($_FILES['image']['name'][$key]);
            $image_paths[] = $target_filename;
        } else {
            echo "Image upload failed.";
            echo "Error: " . $_FILES['image']['error'][$key];
        }
    }

    // If images were uploaded, store their paths in the database
    if (!empty($image_paths)) {
        // Concatenate the image paths into a comma-separated string
        $image_path = implode(',', $image_paths);

        $query = "INSERT INTO `tenant_data` (`name`, `email`, `mobile`, `address`, `photo`, `Gender`, `amount`, `appoinment`, `flag`, `created_at`)
            VALUES ('$name','$email','$mobile','$address','$image_path','$gender','$fees','$appointment','1','$created_at')";

        $result = mysqli_query($connection, $query);

        if($result){
            echo "Data inserted successfully";
            echo '<script>alert("Data inserted Successfully");</script>';
        } else {
            echo 'Error: ' . mysqli_error($connection);
            echo '<script>alert("Something went wrong!! Try again");</script>';
        }
    } else {
        echo '<script>alert("No images were uploaded.");</script>';
    }
}

mysqli_close($connection);
?>
