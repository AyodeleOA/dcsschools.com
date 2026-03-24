<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
    exit;
}

// Get form data (PHP 7.2 compatible)
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate required fields
if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo json_encode(array('success' => false, 'message' => 'All fields are required'));
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array('success' => false, 'message' => 'Invalid email format'));
    exit;
}

// Sanitize inputs
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Pure cURL Mailjet implementation (PHP 7.2 compatible)
function sendMailjetEmail($apiKey, $apiSecret, $toEmails, $subject, $htmlContent, $textContent = '') {
    $url = 'https://api.mailjet.com/v3.1/send';
    
    // Prepare recipients array
    $recipients = array();
    foreach ($toEmails as $emailAddr) {
        $recipients[] = array('Email' => $emailAddr);
    }
    
    // Prepare the email data
    $emailData = array(
        'Messages' => array(
            array(
                'From' => array(
                    'Email' => 'sales@casdnet.com',
                    'Name' => 'CDN Store Contact Form'
                ),
                'To' => $recipients,
                'Subject' => $subject,
                'TextPart' => !empty($textContent) ? $textContent : strip_tags($htmlContent),
                'HTMLPart' => $htmlContent,
                'CustomID' => 'ContactFormSubmission' . time()
            )
        )
    );
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($emailData),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($apiKey . ':' . $apiSecret)
        ),
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_USERAGENT => 'CDN-ContactForm/1.0'
    ));
    
    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    
    curl_close($ch);
    
    // Handle cURL errors
    if ($response === false || !empty($curlError)) {
        error_log('cURL Error: ' . $curlError);
        return false;
    }
    
    // Parse response
    $responseData = json_decode($response, true);
    
    // Check if request was successful
    if ($httpCode >= 200 && $httpCode < 300) {
        // Log successful response for debugging
        error_log('Mailjet Success: ' . $response);
        return true;
    } else {
        // Log error response for debugging
        error_log('Mailjet Error (HTTP ' . $httpCode . '): ' . $response);
        return false;
    }
}

// Mailjet API credentials
$apiKey = '6c030f6245529ed5a4de82dad1804019';
$apiSecret = '19ccf157aea4db7b9431ecc51d02dd8f';

// Email configuration
$toEmails = array('fasanyafemi@gmail.com', 'operations@casdnet.com');
$subject = 'New Contact Form Submission - CDN Store';

// Create email body
$emailBody = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f4f4f4; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-top: 5px; padding: 8px; background-color: #f9f9f9; border-radius: 4px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>New Contact Form Submission</h2>
            <p>CDN Website</p>
        </div>
        <div class='content'>
            <div class='field'>
                <div class='label'>Name:</div>
                <div class='value'>{$name}</div>
            </div>
            <div class='field'>
                <div class='label'>Email:</div>
                <div class='value'>{$email}</div>
            </div>
            <div class='field'>
                <div class='label'>Phone Number:</div>
                <div class='value'>{$phone}</div>
            </div>
            <div class='field'>
                <div class='label'>Message:</div>
                <div class='value'>{$message}</div>
            </div>
            <div class='field'>
                <div class='label'>Submitted:</div>
                <div class='value'>" . date('Y-m-d H:i:s') . "</div>
            </div>
        </div>
    </div>
</body>
</html>
";

// Send email using pure cURL implementation
if (sendMailjetEmail($apiKey, $apiSecret, $toEmails, $subject, $emailBody)) {
    echo json_encode(array('success' => true, 'message' => 'Message sent successfully! We will get back to you soon.'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Failed to send message. Please try again later.'));
}
?>