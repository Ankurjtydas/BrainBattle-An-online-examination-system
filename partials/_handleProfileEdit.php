<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("Location: index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "_dbconnect.php";
    $new_first_name = htmlspecialchars($_POST["fname"]);
    $new_last_name = htmlspecialchars($_POST["lname"]);
    $new_email = htmlspecialchars($_POST["email"]);

    $alert = "No changes done.";

    if ($new_first_name !== $_SESSION["first_name"]) {
        $sql = "UPDATE `users` SET `first_name` = '$new_first_name' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        $_SESSION["first_name"] = $new_first_name;
        $alert = "Profile updated successfully.";
    }
    if ($new_last_name !== $_SESSION["last_name"]) {
        $sql = "UPDATE `users` SET `last_name` = '$new_last_name' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        $_SESSION["last_name"] = $new_last_name;
        $alert = "Profile updated successfully.";
    }
    if ($new_email !== $_SESSION["email"]) {
        header("Location: ../emailVerify.php");
        $otp = rand(100000, 999999);
        $_SESSION["temp_user"] = array(
            "email" => $new_email,
            "otp" => $otp,
            "otp_expiry" => date('Y-m-d H:i:s', strtotime('+5 minutes')),
        );
        $_SESSION["updation"] = true;

        // sending a mail with OTP to the email entered
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'stonystain5@gmail.com';                     //SMTP username
            $mail->Password = 'zoqkdrmjyaedvyve';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('brainbattle@gmail.com', 'BrainBattle');
            $mail->addAddress($new_email, $new_email);     //Add a recipient
            $mail->addAddress($new_email);               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email verification';
            $mail->Body = '<h2 style="display:inline;">The OTP for verification of your email is : <h1 style="display:inline;">' . $otp . '</h1></h2>';
            $mail->AltBody = 'The OTP for verification of your email is ' . $otp;

            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: ../index.php?success=false&alert=$mail->ErrorInfo");
            exit;
        }
        exit;
    }
    header("Location: ../profile.php?success=true&alert=$alert");
    exit;
}
header("Location: ../profile.php");
?>