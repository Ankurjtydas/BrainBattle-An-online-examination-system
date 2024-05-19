<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (isset($_SESSION["loggedin"])) {
    header("Location: ../index.php");
    exit;
}

date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "_dbconnect.php";
    $email = htmlspecialchars($_POST["email"]);
    $sql = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        header("Location: ../emailVerify.php");
        $otp = rand(100000, 999999);

        // storing details till otp is expired
        $_SESSION["temp_user"] = array(
            "email" => $email,
            "otp" => $otp,
            "otp_expiry" => date('Y-m-d H:i:s', strtotime('+5 minutes')),
        );
        $_SESSION["forgot"] = true;

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
            $mail->Body = '<h2 style="display:inline;">The OTP to reset password is : <h1 style="display:inline;">' . $otp . '</h1></h2>';
            $mail->AltBody = 'The OTP to reset password is ' . $otp;

            $mail->send();
            // echo 'Message has been sent';
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: ../index.php?success=false&alert=$mail->ErrorInfo");
            exit;
        }
    } else {
        $alert = "This email is not register.";
        header("Location: ../index.php?success=false&alert=$alert");
        exit;
    }
}else {
    header("Location: ../index.php");
}
?>