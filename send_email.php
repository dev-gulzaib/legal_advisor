<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];
$service = $_POST['service'];

// Convert service number to readable name
$service_name = match ($service) {
    '1' => 'Legal Onboarding',
    '2' => 'Online Consultation',
    '3' => 'Consultation at Office',
    default => 'Unknown Service'
};

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'mail.legaladvisersinc.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@legaladvisersinc.com';
    $mail->Password = ',UVLEr6U1Mdm9V%B';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Sender and recipient
    $mail->setFrom('info@legaladvisersinc.com', 'Legal Advisers Inc.');
    $mail->addAddress('info@legaladvisersinc.com');
    $mail->addReplyTo($email, $name);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'New Appointment Request - Legal Advisers Inc.';

    $mail->Body = <<<HTML
        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; max-width: 600px; margin: auto;">
            <div style="background-color: #ffffff; padding: 25px; border-radius: 6px;">
                <h2 style="box-sizing:border-box; font-family:-apple-system, BlinkMacSystemFont,'Segoe UI', Roboto, Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
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

    $mail->send();
    // echo 'Thank you! Your appointment request has been sent.';
    header("Location: {$_SERVER['HTTP_REFERER']}?appointment=success#appointment");
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>