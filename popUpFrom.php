<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';


// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    // $subject = $_POST['subject'];
    // $message = $_POST['message'];
    // $projectTitle = $_POST['projectTitle'];
    // $title = $projectTitle ?: "General Enquiry";


    $template = file_get_contents('./enquirymailtemplate.php');
    $template = str_replace(['{{name}}', '{{email}}', '{{whatsapp}}',  ], [$name, $email, $whatsapp, ], $template);
   
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->isMail();

        // Recipient and sender settings
        $mail->setFrom('mhd.binyamin@acodez.co.in');
        // $mail->addAddress('hilifesales@gmail.com');
        $mail->addCC('archana.p@acodez.co.in');
        // $mail->addBCC('ads@acodez.in');

        $title = $projectTitle ?: "General";

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Enquiry - ' . $title;
        $mail->Body    = $template;
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n Phone: $whatsapp";

        // Send email
        if ($mail->send()) {
            header("Location: thankyou.html");
            exit();
            // echo 'Message sent successfully!';
        } else {
            echo 'Message could not be sent.';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request method.';
}
