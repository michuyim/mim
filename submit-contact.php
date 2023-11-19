<?php

// Check if the request is coming from a POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject');
    $message = filter_input(INPUT_POST, 'message');

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Respond with an error message
        http_response_code(400);
        echo "Please fill all the fields.";
        exit;
    }

    // If email validation fails
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format";
        exit;
    }

    // Process the data
    // For example, sending an email
    $to = 'contact@michuyim.uk'; // Replace with your email address
    $email_subject = "New message from $name: $subject";
    $email_body = "You have received a new message from your website contact form." . "Here are the details: Name: $name; Email: $email; Subject: $subject; Message: $message";

    $headers = "From: noreply@colibri.foundation"; // Replace with your domain
    $headers .= "Reply-To: $email";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully.";
    } else {
        http_response_code(500);
        echo "Message could not be sent.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
