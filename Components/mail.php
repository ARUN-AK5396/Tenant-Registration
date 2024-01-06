<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tenet";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    $sql = "SELECT * FROM `tenant_data` WHERE DATE(`appoinment`) = '$tomorrow' ORDER BY `appoinment` ASC";
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {

        $timeSlots = [
            "11:00 AM - 11:45 AM",
            "12:00 PM - 12:45 PM",
            "1:45 PM - 2:30 PM",
            "2:45 PM - 3:30 PM",
            "3:45 PM - 4:30 PM"
        ];

        $slotIndex = 0;

        while ($row = $result->fetch_assoc()) {
            if ($slotIndex >= count($timeSlots)) {
                $nextDate = date('Y-m-d', strtotime('+1 day', strtotime($tomorrow)));
                $tenantId = $row['id'];
                $updateSql = "UPDATE `tenant_data` SET `appoinment` = '$nextDate' WHERE `id` = '$tenantId'";
                $connection->query($updateSql);
    
                $userEmail = $row['email'];
                $userName = $row['name'];
                try {
                    $mail = new PHPMailer(true);

                    // SMTP Configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'thedeveloper.arun@gmail.com'; 
                    $mail->Password = 'cwxhnvjzjslobmel'; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom('thedeveloper.arun@gmail.com', 'Tenant Registration');
                    $mail->addAddress($userEmail);

                    // Email content
                    // $mail->isHTML(false);
                    // $mail->Subject = "Hello $userName, your appointment rescheduled";
                    // $mail->Body = "Hello $userName,\n\nYour appointment scheduled for tomorrow is rescheduled to $nextDate due to a full schedule. We apologize for the inconvenience.\n\nBest regards,\n Tenant Registration";
    
                    // // Send email
                    // $mail->send();
                    echo "Email sent to $userEmail regarding their appointment on $appointmentDate.<br>";
                } catch (Exception $e) {
                    echo "Email sending failed. Error: {$mail->ErrorInfo}<br>";
                }
        
            } else {
                $tenantId = $row['id'];
                $appointmentTime = $timeSlots[$slotIndex];
                $updateSql = "UPDATE `tenant_data` SET `appointment_time` = '$appointmentTime' WHERE `id` = '$tenantId'";
                $connection->query($updateSql);

                $userEmail = $row['email'];
                $userName = $row['name'];
                $appointmentDate = date('Y-m-d', strtotime($row['appoinment']));

                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'thedeveloper.arun@gmail.com'; 
                    $mail->Password = 'cwxhnvjzjslobmel';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;


                    $mail->setFrom('thedeveloper.arun@gmail.com', 'Tenant Registration');
                    $mail->addAddress($userEmail);

                    $mail->isHTML(false);
                    $mail->Subject = "Hello $userName, your scheduled appointment";
                    $mail->Body = "Hello $userName,\n\nYour appointment is scheduled for $appointmentDate at $appointmentTime. We look forward to seeing you.\n\nBest regards,\n Tenant Registration";

                    // Send email
                    $mail->send();
                    echo "Email sent to $userEmail regarding their appointment on $appointmentDate at $appointmentTime.<br>";
                } catch (Exception $e) {
                    echo "Email sending failed. Error: {$mail->ErrorInfo}<br>";
                }
                $slotIndex++;
            }
        }
        } else {
            echo "No appointments scheduled for tomorrow.<br>";
    }

    $connection->close();
?>
