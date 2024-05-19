<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

if (!isset($_SESSION["register"]) || isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: ../emailVerify.php");
    // echo "resend";
    $otp = rand(100000, 999999);
    $tempUser = $_SESSION["temp_user"];
    $first_name = $tempUser["first_name"];
    $last_name = $tempUser["last_name"];
    $email = $tempUser["email"];
    $password = $tempUser["password"];
    $_SESSION["temp_user"]["otp"] = $otp;
    $_SESSION["temp_user"]["otp_expiry"] = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $_SESSION["register"] = true;

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
        $mail->addAddress($email, $email);     //Add a recipient
        $mail->addAddress($email);               //Name is optional
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
        exit;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: ../index.php?success=false&alert=$mail->ErrorInfo");
        exit;
    }
}else{
    header("Location: ..index.php");
}
?>