<?php
// Change this to your real email address
$receiving_email_address = "ebenhaj2005@gmail.com";

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

// Sanitize inputs
$name    = strip_tags(trim($_POST["name"] ?? ""));
$email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$subject = strip_tags(trim($_POST["subject"] ?? "New Contact Form Message"));
$message = strip_tags(trim($_POST["message"] ?? ""));

// Validate required fields
if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill in all required fields correctly.";
    exit;
}

// Email content
$email_content = "From: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Email headers
$email_headers = "From: $name <$email>\r\n";
$email_headers .= "Reply-To: $email\r\n";
$email_headers .= "Content-Type: text/plain; charset=UTF-8";

// Send email
if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Your message has been sent. Thank you!";
} else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
}
