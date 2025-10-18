<?php
header('Content-Type: text/plain'); // Important for AJAX

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust path

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // ✅ Validation
    if (empty($name)) {
        echo "Name is required!";
        exit;
    }

    if (empty($email)) {
        echo "Email is required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    if (empty($subject)) {
        echo "Subject is required!";
        exit;
    }

    if (empty($message)) {
        echo "Message is required!";
        exit;
    }

    // ✅ PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kuldeepsapariya821@gmail.com';
        $mail->Password   = 'vdye ipmr wtxg rohj';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('kuldeepsapariya821@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <strong>Name:</strong> $name <br>
            <strong>Email:</strong> $email <br>
            <strong>Message:</strong> <br>" . nl2br($message);

        if ($mail->send()) {
            echo "OK"; // ✅ success keyword
        } else {
            echo "Failed to send message.";
        }

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
