<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "_dbconnect.php";
    $first_name = htmlspecialchars($_POST["fname"]);
    $last_name = htmlspecialchars($_POST["lname"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);

    if ($password === $cpassword) {
        if ($first_name != "" && $last_name != "" && $email != "" && $password != "" && $cpassword != "") {

            $sql = "select * from users where email='$email'";
            $result = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($result);
            if ($numRows > 0) {
                $alert = "This email is already register";
                header("Location: ../register.php?success=false&alert=$alert");
                exit;
            } else {
                $otp = rand(100000, 999999);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // storing details till otp is expired
                $_SESSION["temp_user"] = array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "password" => $hashed_password,
                    "otp" => $otp,
                    "otp_expiry" => date('Y-m-d H:i:s', strtotime('+5 minutes')),
                );
                $_SESSION["verification"] = true;

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
                    header("Location: ../emailVerify.php");
                    exit;
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    header("Location: ../index.php?success=false&alert=$mail->ErrorInfo");
                    exit;
                }

                // $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
                // $result = mysqli_query($conn, $sql);
                // if ($result == 1) {
                //     $alert = "You have register successfully. You can now login into you account.";
                //     header("Location: ../login.php?success=true&alert=$alert");
                //     exit;
                // }
            }
        } else {
            $alert = "Every field must be filled up.";
            header("Location: ../register.php?success=false&alert=$alert");
            exit;
        }
    } else {
        $alert = "Password fields doesn't match";
        header("Location: ../register.php?success=false&alert=$alert");
        exit;
    }
}
header("Location: ../index.php");
?>