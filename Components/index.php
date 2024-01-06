<?php
 session_start();

 // Check if the user is not logged in
 if (!isset($_SESSION['username'])) {
     // Redirect to the login page
     header("Location:../index.html"); // Assuming login.html is the login page file
     exit(); // Ensure script execution stops after redirection
 }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tenent Entry</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <style>
            body{
                display:flex;
            }
            ::-webkit-scrollbar {
            width: 10px;
            }
            ::-webkit-scrollbar-track {
            border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
            background: #0f77ff;
            border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
            background: transparent; 
            }
            .side_menu {
                position:fixed;
                height: auto;
                width: 20%;
                height:100%;
                background-color: #0f77ff;
                display: flex;
                border-top-right-radius: 27px;
                border-bottom-right-radius: 27px;
                box-shadow:0px 0px 15px 0px;
            }

            .nav_menu {
                margin: 50px;
                margin-top:80px
            }

            .navIcon{
                position: absolute;
                margin-top: 20px;
                margin-left:10px;
                font-size: 20px;
                color: #fff;
                transition: color 0.3s;
            }

            .nav_menu_item {
                padding: 20px;
                font-size: 17px;
                margin-left: 15px;
            }

            .container {
                width: 60%;
                border :2px #e0e0e0 solid;
                border-radius:27px;
                padding:30px;
                box-shadow: 0px 10px 10px 10px #ccc;
            }
            .edit_container{
                overflow:scroll;
                width: 60%;
                height:750px;
                border :2px #e0e0e0 solid;
                border-radius:27px;
                padding:30px;
                margin-left:20%;
                box-shadow: 0px 10px 10px 10px #ccc;
            }

            .tablinks {
                cursor: pointer;
                position: relative;
                margin-top:10px;
                margin-bottom:10px;
                border-top-left-radius: 28px;
                border-bottom-left-radius: 28px;
                width: 257px;
                color: #fff;
            }

            .tablinks::before {
                content: '';
                position: relative;
                top: 0;
                left: -15px;
                left:-35px;
                width: calc(100% + 30px);
                height: 100%;
                border-top-left-radius: 28px;
                border-bottom-left-radius: 28px;
                z-index: -1;
                transition: background-color 0.3s;
            }
            .tablinks:hover i {
                color: #0f77ff  !important;
            }
            .tablinks:hover .nav_menu_item {
                color: #0f77ff !important;
            }
            .tablinks:hover::before {
                background-color: #fff; 
            }
            .tablinks:hover {
                color: #0f77ff !important;
                background-color: #fff;
            }
            .tablinks.active::before,
            .tablinks.active:hover::before {
                background-color: #fff; 
            }
            .tablinks.active i,
            .tablinks.active:hover i {
                display:none
            }

            .tablinks.active .nav_menu_item,
            .tablinks.active:hover .nav_menu_item {
                color: #0f77ff !important;
                background-color:#fff;
                border-top-left-radius: 28px;
                border-bottom-left-radius: 28px;
            }
            .content_page{
                width:77%;
                margin-left:23%;
                margin-top:10px
            }
            input{
                margin-bottom:15px;
            }
            .form-check-input{
                margin-left:10px
            }
            .error-msg{
                display: none; 
                color: red;
            }
            .tabcontent{
                animation:fadeEffect 0.8s;
            }
            @keyframes fadeEffect {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            .tenant_details{
                width: 100%;
                margin-top:30px;
                margin-right:2%;
                border :2px #e0e0e0 solid;
                padding:30px;
                box-shadow: 0px 10px 10px 10px #ccc;
                border-radius:27px
            }
            td{
                padding:20px;
            }
            .table-striped{
                width:auto;
                overflow:scroll;
            }
            .top_bar{
                display:flex;
            }
            .form-select{
                width:auto;
                margin-left:60%;
                margin-bottom:50px
            }
            .filter{
                position:absolute;
                margin-top:-80px;
                margin-left:30%;
            }
            .form_field{
                height:80%
            }
            tbody{
                height:70%;
                overflow:scroll;
            }
            .mail{
                margin-left:400px;
                height:45px
            }
            .edit-button{
                margin-top:-35px
            }
            .avatar-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                align-items: center;
                justify-content: center;
            }

            .avatar-img {
                display: block;
            }

            .hidden-img {
                display: none;
            }
            .show-more-btn {
                cursor: pointer;
                color: blue;
                text-decoration: underline;
            }
            .send-qr{
                color:#fff;
                display:flex;
                margin-left:5px;
            }
            .logout-btn{
                position: absolute;
                display:flex;
                background-color: #0f77ff;
                border:none;
                margin:40px 0px 0px 250px;
            }
        </style>
        
    </head>
    <?php
    
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $databse = 'tenet';
    
        $connection = mysqli_connect($host,$user,$password,$databse);

       
    ?>
    <body>
            <div class="side_menu">
                <button class="logout-btn" onclick='logout()'><i class="log fa fa-sign-out" style="font-size:26px;color:#fff"></i></button>
                <div class="nav_menu">
                    <h3 style="color:white; margin-bottom:50px">Navigation Menu</h3>
                    <div class="icon tablinks" onclick="openTab(event, 'show-tenants')">
                        <i class="navIcon fa fa-address-book-o"></i>
                        <h4 class="nav_menu_item">Show all tenants</h4>
                    </div>
                    <div class="icon tablinks" onclick="openTab(event, 'create-tenant')">
                        <i class="navIcon fa fa-pencil"></i>
                        <h4 class="nav_menu_item">Create new Tenant</h4>
                    </div>
                    <div class="icon tablinks" onclick="openTab(event, 'update-tenant')">
                        <i class="navIcon material-icons" >update</i>
                        <h4 class="nav_menu_item">Renewal old Tenant</h4>
                    </div>
                    <div class="icon tablinks" style="display: none;" onclick="openTab(event, 'edit-tenant')">
                        <i class="navIcon fa fa-pencil"></i>
                        <h4 class="nav_menu_item">Edit Tenant</h4>
                    </div>
                </div>
            </div>

            <div class="content_page">

                <div class="tabcontent" id="create-tenant" style="display: none;">
                    <div class="container" > 
                        <h2 style="text-align:center">Fill the form to tenant entry </h2><br>
                        <form id="dataForm" onsubmit="submitData(event)" enctype="multipart/form-data">

                            <label class="form-label" for="name">Name : </label>
                            <input class="form-control" required type="text" name="name" id="name" >
                            <span id="nameError" class="error-msg" >Name is incorrect</span>
                            <label class="form-label" for="email">Email : </label>
                            <input class="form-control" required type="text" name="email" id="email" >
                            <span id="emailError" class="error-msg" >Email address is incorrect</span>
                            <label class="form-label" for="address">Address : </label>
                            <input class="form-control" type="text" required name="address" id="address" >
                            <span id="addressError" class="error-msg" >Address is incorrect</span>
                            <label class="form-label" for="mobile">Mobile : </label>
                            <input class="form-control" type="text" required name="mobile" id="mobile" >
                            <span id="mobileError" class="error-msg" >Mobile Number is incorrect   </span><br>
                            
                            <label >Gender : </label>
                            <input class="form-check-input"  type="radio" name="gender" id="male" value="Male" >
                            <label class="form-check-label" for="male">Male</label>
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female" >
                            <label class="form-check-label" for="female">Female</label> <br>

                            <label class="form-label" for="image">Image</label>
                            <input class="form-control" type="file" name="image[]" required accept=".jpg, .jpeg, .png, .jfif" id="imageInput" onchange="previewImage(event)" multiple>
                            <div style="position: relative;">
                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px; border-radius: 50px; margin-top: 10px;">
                                <button type="button" id="removeImageButton" onclick="removeImage()" style="position: absolute;background-color:#fff; top: 10px; right: 10px;border:none; display: none;">
                                    <i class="fa fa-trash-o" style="font-size:30px;color:red"></i>
                                </button>
                            </div>

                            <label class="form-label" for="fees">Fee : </label>
                            <input class="form-control" type="text" value="$10" name="fees" id="fees" aria-label="readonly input example" oninput="validateFees()" />
                            <span id="feesError" style="color: red;"></span><br>

                            <script>
                                function validateFees() {
                                    var feesInput = document.getElementById("fees");
                                    var feesError = document.getElementById("feesError");
                                    
                                    var feesValue = parseFloat(feesInput.value.replace('$', ''));

                                    if (isNaN(feesValue) || feesValue < 10) {
                                        feesError.textContent = "Fees must be a number greater than or equal to 10.";
                                    } else {
                                        feesError.textContent = "";
                                    }
                                }
                                function previewImage(event) {
                                    const imageFile = event.target.files[0];
                                    const imagePreview = document.getElementById('imagePreview');
                                    const removeImageButton = document.getElementById('removeImageButton');

                                    if (imageFile) {
                                        const reader = new FileReader();

                                        reader.onload = function () {
                                            imagePreview.src = reader.result;
                                            imagePreview.style.display = 'block';
                                            removeImageButton.style.display = 'block';
                                        };

                                        reader.readAsDataURL(imageFile);
                                    }
                                }
                                function removeImage() {
                                    const imageInput = document.getElementById('imageInput');
                                    const imagePreview = document.getElementById('imagePreview');
                                    const removeImageButton = document.getElementById('removeImageButton');

                                    imageInput.value = ''; // Clear the selected file
                                    imagePreview.src = '#'; // Clear the preview
                                    imagePreview.style.display = 'none'; // Hide the preview
                                    removeImageButton.style.display = 'none'; // Hide the remove button
                                }
                            </script>

                            <label class="form-label" for="appointment">Appointment date : </label>
                            <input class="form-control" type="date" name="appointment" required id="appointment" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="20000000">
                            <button type="submit" style="margin-left:40%; margin-bottom:30px" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="tabcontent" id="show-tenants" >
                    <div class="tenant_details">
                        <div class="top_bar">
                            <h2 style="text-align:center">Tenant Details</h2>
                            <form method="GET" id="filterForm">
                                <select class="form-select" name="tenantFilter" onchange="submitForm()">
                                    <option selected >Select the tenant fields</option>
                                    <option  value="1">Show the Upcoming tenants</option>
                                    <option value="0">Show the visited tenants</option>
                                </select>
                            </form>

                            <script>
                                function submitForm() {
                                    document.getElementById("filterForm").submit();
                                }

                                function sendAppointmentEmailsAlert() {
    
                                    var confirmation = confirm("Are you sure you want to send emails to all users with tomorrow's appointments?");
                                    
                                    if (confirmation) {
                                        sendAppointmentEmails();
                                        alert("Emails sent successfully!");
                                    } else {
                                        alert("Email sending cancelled.");
                                    }
                                }
                            </script>
                            <button onclick="sendAppointmentEmailsAlert()" class="mail btn btn-primary" style="font-size:18px;"><i class="fa fa-envelope" style="font-size:22px; padding-right:10px">  Send Emails </i></button>
                        </div>
        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">S.NO</th>
                                    <th style="width: 230px; text-align:center" scope="col">Name</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Image</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Email</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Address</th>
                                    <th style="width: 230px;text-align:center" scope="col">Mobile</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Gender</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Fees</th>
                                    <th style="width: 230px;text-align:center"  scope="col">Appointment Date</th>
                                    <th style="width: 300px;text-align:center"  scope="col"> Action</th>
                                    <th style="width: 300px;text-align:center"  scope="col"> QR Code</th>

                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                    include "phpqrcode/qrlib.php";

                                    use PHPMailer\PHPMailer\PHPMailer;
                                    use PHPMailer\PHPMailer\Exception;
                                    
                                    require 'phpmailer/src/Exception.php';
                                    require 'phpmailer/src/PHPMailer.php';
                                    require 'phpmailer/src/SMTP.php';


                                    $currentDate = date('Y-m-d H:i:s');

                                    $updateSql = "UPDATE `tenant_data` SET `flag` = 0 WHERE `appoinment` < '$currentDate'";
                                    $connection->query($updateSql);
                                    
                                    $filterValue = $_GET['tenantFilter'] ?? 1;
                                    if ($filterValue == 0) {
                                        $sql = "SELECT * FROM `tenant_data` WHERE `flag` = 0";
                                    } else {
                                        $sql = "SELECT * FROM `tenant_data` WHERE `flag` = 1";
                                    }
                                    
                                    $result = $connection->query($sql);

                                    $tomorrow = date('Y-m-d', strtotime('+1 day'));
                                    $serialNumber = 1;
                                    if ($result->num_rows > 0) {

                                        while ($row = $result->fetch_assoc()) {
                                            $tenantId = $row['id'];
                                            $imageNames = explode(',', $row['photo']);

                                            $tenantData = "Name: " . $row['name'] . "\nEmail: " . $row['email'] . "\nAddress: " . $row['address'] . "\nMobile: " . $row['mobile'] . "\nGender: " . $row['Gender'] . "\nFees: " . $row['amount'] . "\nAppointment Date: " . $row['appoinment'] ."\nAppoinment Time:".$row['appointment_time'];

                                        
                                            $PNG_TEMP_DIR = 'temp/';
                                            if (!file_exists($PNG_TEMP_DIR)) {
                                                mkdir($PNG_TEMP_DIR);
                                            }
                                    
                                            $filename = $PNG_TEMP_DIR . 'tenant_' . $tenantId . '.png';
                                            QRcode::png($tenantData, $filename);

                                            echo "<tr>
                                                <th scope='row' style='text-align:center;padding-top:50px'>" . $serialNumber . "</th>
                                                <td style='text-align:center;padding-top:50px'>" . $row['name'] . "</td>
                                                <td class='avatar-container' style='text-align:center'>";
                                                foreach($imageNames as $imageName){
                                                    echo "<img src='Images/" . $imageName . "' alt='Tenant Photo'class='avatar-img' style='width: 100px; height: 100px; border-radius: 50px'>";
                                                }
                                            echo"</td>
                                                <td style='text-align:center;padding-top:50px'>" . $row['email'] . "</td>
                                                <td style='text-align:center;padding-top:50px'>" . $row['address'] . "</td>
                                                <td style='text-align:center;padding-top:50px'>" ."+91". $row['mobile'] . "</td>
                                                <td style='text-align:center;padding-top:50px'>" . $row['Gender'] . "</td>
                                                <td style='text-align:center;padding-top:50px'>" . $row['amount'] . "</td>
                                                <td style='text-align:center;padding-top:50px'>" . $row['appoinment'] . " </td>
                                                <td style='text-align:center;padding-top:50px'>
                                                    <button class='edit-button btn btn-primary' onclick='openEditTab({$row['id']})'>Edit</button>
                                                    <button class='send-qr btn btn-info' onclick='sendEmailAndQR({$row['id']})'>SendQR</button>
                                                </td>
                                                <td colspan='10' style='text-align:center'>
                                                    <img src='" . $filename . "' alt='Tenant QR Code' style='width: 100px; height: 100px;'>
                                                </td>
                                        </tr>";
                                            $serialNumber++;
                                        }
                                        $result->data_seek(0);
                                    
                                    }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tabcontent" id="update-tenant" style="display: none;">
                    <div class="container" > 
                        <h2 style="text-align:center">Renewal Old Tenant Data</h2><br>
                        <form id="renewForm" onsubmit="submitRenewalData(event)">
                            <label class="form-label" for="old-email">Email : </label>
                            <input class="form-control" required type="text" name="old-email" id="old-email" >
                            <label class="form-label" for="old-mobile">Mobile : </label>
                            <input class="form-control" type="text" required name="old-mobile" id="old-mobile" >
                            <label class="form-label" for="old-date">Date : </label>
                            <input class="form-control" type="date" required name="old-date" id="old-date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" >
                            <button type="submit" style="margin-left:40%; margin-bottom:30px" class="btn btn-primary">Renew</button>
                        </form>
                    </div>
                </div>

                <div class="tabcontent" id="edit-tenant" style="display: none;">
                    <div class="edit_container" > 
                        <h2 style="text-align:center">Edit Tenant Details </h2><br>
                        <form id="dataEditForm" class='form_field' onsubmit="submitEditedData(event)" enctype="multipart/form-data">

                            <input type="hidden" id="editTenantId" name="editTenantId" value="">

                            <label class="form-label" for="edit-name">Name : </label>
                            <input class="form-control" type="text" name="edit-name" id="edit-name" >
                            <label class="form-label" for="edit-email">Email : </label>
                            <input class="form-control" type="text" name="edit-email" id="edit-email" >
                            <span id="edit-emailError" class="error-msg" >Email address is incorrect</span>
                            <label class="form-label" for="edit-address">Address : </label>
                            <input class="form-control" type="text" name="edit-address" id="edit-address" >
                            <span id="edit-addressError" class="error-msg" >Address is incorrect</span>
                            <label class="form-label" for="edit-mobile">Mobile : </label>
                            <input class="form-control" type="text" name="edit-mobile" id="edit-mobile" >
                            <span id="edit-mobileError" class="error-msg" >Mobile Number is incorrect   </span><br>
                            
                            <label >Gender : </label>
                            <input class="form-check-input"  type="radio" name="edit-gender" id="edit-male" value="Male" >
                            <label class="form-check-label" for="edit-male">Male</label>
                            <input class="form-check-input" type="radio" name="edit-gender" id="edit-female" value="Female" >
                            <label class="form-check-label" for="edit-female">Female</label> <br>

                            <label class="form-label" for="edit-image">Image : </label>
                            <div id="edit-image-container"></div>
                            <input class="form-control" type="file" name="edit-image[]" required accept=".jpg, .jpeg, .png, .jfif" onchange="previewImage(event)" id="edit-image" multiple>

                            <label class="form-label" for="edit-fees">Fee : </label>
                            <input class="form-control" type="text" name="edit-fees" id="edit-fees" aria-label="readonly input example" readonly/>

                            <label class="form-label" for="edit-appointment">Appointment date : </label>
                            <input class="form-control" type="date" name="edit-appointment" id="edit-appointment" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" />
                            <button type="submit" class="btn btn-primary" style="margin-left:40%; margin-bottom:30px">Update</button>
                        </form>
                    </div>
                </div>
                
            </div>
                
            <script>
                function openTab(evt, tabName) {
                    const tabcontent = document.getElementsByClassName('tabcontent');
                    for (let i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = 'none';
                    }

                    const tablinks = document.getElementsByClassName('tablinks');
                    for (let i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(' active', '');
                    }

                    document.getElementById(tabName).style.display = 'block';
                    evt.currentTarget.className += ' active';
                }
                function openEditTab(tenantId) {
                    document.getElementById('editTenantId').value = tenantId;

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var tenantData = JSON.parse(xhr.responseText);
                                console.log('Fetched tenant data:', tenantData);
                                populateEditForm(tenantData);
                                openTab(event, 'edit-tenant');
                            } else {
                                console.error('Error fetching tenant data:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.open('GET', `getTenantDetails.php?tenantId=${tenantId}`, true);
                    xhr.send();
                }
                function populateEditForm(tenantData) {
                    document.getElementById('edit-name').value = tenantData.name;
                    document.getElementById('edit-email').value = tenantData.email;
                    document.getElementById('edit-address').value = tenantData.address;
                    document.getElementById('edit-mobile').value = tenantData.mobile;
                    document.getElementById('edit-fees').value = tenantData.amount;
                    document.getElementById('edit-appointment').value = tenantData.appoinment;
                    // document.getElementById('edit-image').value = tenantData.photo;

                    if (tenantData.gender === 'Male') {
                        document.getElementById('edit-male').checked = true;
                    } else if (tenantData.gender === 'Female') {
                        document.getElementById('edit-female').checked = true;
                    } else {
                        document.getElementById('edit-male').checked = true; 
                    }

                    var imageContainer = document.getElementById('edit-image-container');

                    var imageNames = tenantData.photo.split(',');
                    imageContainer.innerHTML = '';

                    for (var i = 0; i < imageNames.length; i++) {
                        var imageTag = document.createElement('img');
                        var imagePath = './Images/' + imageNames[i];
                        
                        imageTag.src = imagePath;
                        imageTag.alt = 'Tenant Image';
                        imageTag.style.width = '100px'; 
                        imageTag.style.height = '100px'; 
                        imageTag.style.borderRadius = '50px';
                        
                        console.log(imagePath);
                        imageContainer.appendChild(imageTag);
                    }

                }

                function submitEditedData(event) {
                    event.preventDefault();

                    var name = document.getElementById('edit-name').value.trim();
                    var email = document.getElementById('edit-email').value.trim();
                    var mobile = document.getElementById('edit-mobile').value.trim();
                    var address = document.getElementById('edit-address').value.trim();
                    var fees = document.getElementById('edit-fees').value;
                    var gender = "";

                    var maleRadio = document.getElementById('edit-male');
                    var femaleRadio = document.getElementById('edit-female');

                    if (maleRadio.checked) {
                        gender = encodeURIComponent(maleRadio.value);
                    } else if (femaleRadio.checked) {
                        gender = encodeURIComponent(femaleRadio.value);
                    }
                    var appointment = document.getElementById('edit-appointment').value;
                    var formData = new FormData(); 

                    // Append form data to FormData object
                    formData.append('editTenantId', document.getElementById('editTenantId').value);
                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('mobile', mobile);
                    formData.append('address', address);
                    formData.append('fees', fees);
                    formData.append('gender', gender);
                    formData.append('appointment', appointment);


                    var fileInput = document.getElementById('edit-image');

                    for (var i = 0; i < fileInput.files.length; i++) {
                        formData.append('edit-image[]', fileInput.files[i]);
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                console.log(xhr.responseText);
                                // alert("Data inserted successfully");
                                document.getElementById('dataEditForm').reset();
                                openTab(event, 'show-tenants');
                            } else {
                                console.error('error', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.open('POST', 'dataUpdate.php', true);
                    xhr.send(formData);
                }


                function submitData(event) {
                    event.preventDefault();

                    var email = document.getElementById('email').value.trim();
                    var mobile = document.getElementById('mobile').value.trim();
                    var address = document.getElementById('address').value.trim();

                    var mobileRegex = /^\d{10}$/;
                    var addressRegex = /^[a-zA-Z0-9\s.,#]+$/;
                    var emailRegex = /^\S+@\S+\.\S+$/;
 
                    var isEmailValid = emailRegex.test(email);
                    var isAddressValid = addressRegex.test(address);
                    var isValidMobile = mobileRegex.test(mobile);

                    if (!isEmailValid) {
                        alert('Email address is incorrect.. Enter a valid email!!');
                        emailError.style.display = 'block';
                        return; 
                    }else{
                        emailError.style.display = 'none';
                    }

                    if(!isAddressValid){
                        alert("Please enter a valid address,It only contain letters,chracter and spaces!!");
                        addressError.style.display = 'block';
                        return;
                    }else{
                        addressError.style.display = 'none';
                    }

                    if (!isValidMobile) {
                        alert('Mobile number should contain only digits and have a maximum length of 10.');
                        mobileError.style.display = 'block';
                        return; 
                    }else{
                        mobileError.style.display = 'none';
                    }

                    var formData = new FormData(document.getElementById('dataForm'));

                    var fileInput = document.getElementById('imageInput');

                    for (var i = 0; i < fileInput.files.length; i++) {
                        formData.append('image[]', fileInput.files[i]);
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                console.log(xhr.responseText);
                                // Check the response from the server and display appropriate alerts
                                if (xhr.responseText.includes('Data inserted successfully')) {
                                    alert("Data inserted successfully!");
                                    document.getElementById('dataForm').reset();
                                } else {
                                    alert("Email address or mobile number already exist!! use different one..");
                                }
                            } else {
                                console.error('Error', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.open('POST', 'dataUpload.php', true);
                    xhr.send(formData);
                }
                function sendAppointmentEmails() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "mail.php", true);

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                            alert("Appointment emails sent successfully!");
                        }
                    };

                    xhr.send();
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var avatarContainers = document.querySelectorAll('.avatar-container');

                    avatarContainers.forEach(function (container) {
                        var avatarImages = container.querySelectorAll('.avatar-img');
                        var showMoreBtn = document.createElement('div');

                        var defaultImageCount = 1;
                        for (var i = defaultImageCount; i < avatarImages.length; i++) {
                            avatarImages[i].classList.add('hidden-img');
                        }

                        if (avatarImages.length > defaultImageCount) {
                            showMoreBtn.innerText = 'Show More';
                            showMoreBtn.classList.add('show-more-btn');
                            showMoreBtn.addEventListener('click', function () {
                                for (var i = defaultImageCount; i < avatarImages.length; i++) {
                                    avatarImages[i].classList.toggle('hidden-img');
                                }

                                var buttonText = showMoreBtn.innerText === 'Show More' ? 'Show Less' : 'Show More';
                                showMoreBtn.innerText = buttonText;
                            });

                            container.appendChild(showMoreBtn);
                        }
                    });
                });
                function sendEmailAndQR(tenantId) {
                    var popup = window.open('popup.html?tenantId=' + tenantId , 'emailPopup', 'width=400,height=300');
                }

                function submitRenewalData(event){
                    event.preventDefault();

                    let form = new FormData(document.getElementById('renewForm'));
                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4){
                            if(xhr.status == 200){
                                console.log(xhr.responseText);
                                if(xhr.responseText.includes('Data updated successfully')){
                                    alert("Data Updated successfully");
                                    openTab(event, 'show-tenants');
                                }else{
                                    alert("Email or Mobile not available ");
                                }
                            }else{
                                console.error('Error', xhr.status, xhr.statusText);
                            }
                        }
                    }
                    xhr.open('POST', 'renewTenant.php', true);
                    xhr.send(form);
                }
                var inactivityTime = 90000;
                    var logoutTimer;

                    function logout() {
                        window.location.href = './logout.php'; 
                    }

                    function displayRemainingTime(remainingTime) {
                        var timerElement = document.getElementById('timer');
                        
                        if (remainingTime <= 10 && remainingTime >= 0) {
                            timerElement.style.display = 'block';
                            timerElement.innerHTML = "Remaining time: " + remainingTime + " seconds";
                        } else {
                            timerElement.style.display = 'none';
                        }
                    }

                    function resetTimer() {
                        clearTimeout(logoutTimer);
                        var remainingTime = inactivityTime / 1000;

                        logoutTimer = setInterval(function() {
                            remainingTime--;
                            if (remainingTime <= 0) {
                                logout();
                            } else {
                                displayRemainingTime(remainingTime);
                            }
                        }, 1000);

                        document.addEventListener('mousemove', function() {
                            var timerElement = document.getElementById('timer');
                            timerElement.style.display = 'none';
                            resetTimer();
                        });

                        document.addEventListener('keypress', function() {
                            var timerElement = document.getElementById('timer');
                            timerElement.style.display = 'none';
                            resetTimer();
                        });
                    }

                    resetTimer();

            </script>
    </body>
</html>

