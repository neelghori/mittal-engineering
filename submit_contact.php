<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// --- Collect form data ---
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? 'Website Inquiry';
$message = $_POST['message'] ?? '';

if (empty($name) || empty($email) || empty($message)) {
    echo "Please fill all required fields.";
    exit;
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';       // Gmail SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yourgmail@gmail.com';  // 🔹 your Gmail address
    $mail->Password   = 'your-app-password';    // 🔹 16-digit App Password (NOT your Gmail password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('kanchavabrasscomponents@gmail.com', 'Mital Engineering'); // 🔹 destination email

    // Content
    $mail->isHTML(true);
    $mail->Subject = "New Message from $name - $subject";
    $mail->Body    = "
        <h3>New Contact Form Submission</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong><br>{$message}</p>
    ";

    // Send email
    $mail->send();
    echo "success";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
