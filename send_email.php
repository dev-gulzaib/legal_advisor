<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Initialize form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$formType = ''; // 'appointment' or 'contact'
$subject = '';
$body = '';

// Detect form type
if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['service'])) {
    // Appointment form
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    $service_name = match ($service) {
        '1' => 'Legal Onboarding',
        '2' => 'Online Consultation',
        '3' => 'Consultation at Office',
        default => 'Unknown Service'
    };

    $formType = 'appointment';
    $subject = 'New Appointment Request - Legal Advisers Inc.';

    $body = <<<HTML
        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; max-width: 600px; margin: auto;">
            <div style="background-color: #ffffff; padding: 25px; border-radius: 6px;">
                <h2 style="color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                    New Appointment Request
                </h2>
                <p style="color: #555;"><strong>Name:</strong> <span style="color: #333;">{$name}</span></p>
                <p style="color: #555;"><strong>Email:</strong> <span style="color: #333;">{$email}</span></p>
                <p style="color: #555;"><strong>Date:</strong> <span style="color: #333;">{$date}</span></p>
                <p style="color: #555;"><strong>Time:</strong> <span style="color: #333;">{$time}</span></p>
                <p style="color: #555;"><strong>Service:</strong> <span style="color: #333;">{$service_name}</span></p>
            </div>
            <div style="text-align: center; margin-top: 25px; color: #aaa; font-size: 12px;">
                Operated by Legal Advisers Inc.
            </div>
        </div>
    HTML;

} elseif (isset($_POST['location']) && isset($_POST['message'])) {
    // Contact form
    $location = $_POST['location'];
    $message = nl2br(htmlspecialchars($_POST['message']));

    $formType = 'contact';
    $subject = 'New Contact Message - Legal Advisers Inc.';

    $body = <<<HTML
        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; max-width: 600px; margin: auto;">
            <div style="background-color: #ffffff; padding: 25px; border-radius: 6px;">
                <h2 style="color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                    New Contact Message
                </h2>
                <p style="color: #555;"><strong>Name:</strong> <span style="color: #333;">{$name}</span></p>
                <p style="color: #555;"><strong>Email:</strong> <span style="color: #333;">{$email}</span></p>
                <p style="color: #555;"><strong>Location:</strong> <span style="color: #333;">{$location}</span></p>
                <p style="color: #555;"><strong>Message:</strong></p>
                <p style="color: #333;">{$message}</p>
            </div>
            <div style="text-align: center; margin-top: 25px; color: #aaa; font-size: 12px;">
                Operated by Legal Advisers Inc.
            </div>
        </div>
    HTML;

} else {
    // Invalid form
    die("Invalid form submission.");
}

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'mail.legaladvisersinc.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@legaladvisersinc.com';
    $mail->Password = ',UVLEr6U1Mdm9V%B';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('info@legaladvisersinc.com', 'Legal Advisers Inc.');
    $mail->addAddress('info@legaladvisersinc.com');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();

    // Redirect based on form type
    if ($formType === 'appointment') {
        header("Location: {$_SERVER['HTTP_REFERER']}?appointment=success#appointment");
    } elseif ($formType === 'contact') {
        header("Location: {$_SERVER['HTTP_REFERER']}?contact=success#contact");
    }
    exit();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
