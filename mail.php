<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Sertakan file PHPMailer
require 'vendor/autoload.php'; // Jika menggunakan Composer
// require 'path/to/PHPMailer/src/PHPMailer.php'; // Jika manual
// require 'path/to/PHPMailer/src/Exception.php'; // Jika manual
// require 'path/to/PHPMailer/src/SMTP.php'; // Jika manual

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $checkbox = isset($_POST['checkbox']) ? 'Yes' : 'No';

    // Validasi input (opsional)
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Pengaturan server email (SMTP)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ganti dengan SMTP provider Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'luthfidika31@gmail.com'; // Ganti dengan email Anda
        $mail->Password = 'jvrorrspeegnkizq'; // Ganti dengan password email Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Gunakan TLS atau SSL
        $mail->Port = 465; // Port SSL: 465, TLS: 587

        // Pengaturan email pengirim dan penerima
        $mail->setFrom($email, $name);
        $mail->addAddress('luthfidika31@gmail.com', 'Your Name'); // Ganti dengan email penerima

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'New Consultation Request';
        $mail->Body = "
            <h3>New message from contact form:</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
            <p><strong>Consent Given:</strong> $checkbox</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message\nConsent Given: $checkbox";

        // Kirim email
        $mail->send();
        echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href = 'contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
