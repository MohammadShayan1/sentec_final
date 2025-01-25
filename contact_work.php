<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Admin email (recipient)
    $admin_email = 'admin@example.com'; // Replace with your email

    // Subject and message for the admin
    $admin_subject = "New Contact Form Submission";
    $admin_message = "You have received a new message from your website contact form.\n\n";
    $admin_message .= "Name: $fullname\n";
    $admin_message .= "Email: $email\n";
    $admin_message .= "Phone: $phone\n";
    $admin_message .= "Message:\n$message";

    // Headers for admin email
    $admin_headers = "From: no-reply@example.com\r\n";
    $admin_headers .= "Reply-To: $email\r\n";
    $admin_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email to the admin
    $admin_sent = mail($admin_email, $admin_subject, $admin_message, $admin_headers);

    // Send email to user (thank you message)
    $user_subject = "Thank You for Contacting Us";
    $user_message = "Hello $fullname,\n\nThank you for reaching out to us. We have received your message and will get back to you shortly.\n\n";
    $user_message .= "Your message:\n$message\n\nBest regards,\nThe Team";

    // Headers for user email
    $user_headers = "From: no-reply@example.com\r\n";
    $user_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email to the user
    $user_sent = mail($email, $user_subject, $user_message, $user_headers);

    // Check if both emails were sent successfully
    if ($admin_sent && $user_sent) {
        echo "Thank you for contacting us. We will get back to you shortly.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
}
?>
