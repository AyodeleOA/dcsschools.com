<?php
require_once __DIR__ . '/../admin/db.php';
try { $pdo = db(); } catch (Throwable $e) { $pdo = null; }
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Sanitize inputs
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Email configuration
$to = 'fasanyafemi@gmail.com';
$subject = 'New Contact Form Submission - CDN Store';
$headers = [
    'From: noreply@casdnet.com',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
    'MIME-Version: 1.0',
    'Content-Type: text/html; charset=UTF-8'
];

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
        .value { margin-top: 5px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>New Contact Form Submission</h2>
            <p>CDN Store Website</p>
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

if ($pdo) {
  try {
    $st = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)');
    $st->execute([$name, $email, $phone, $message]);
  } catch (Throwable $e) {}
}

$sent = mail($to, $subject, $emailBody, implode("\r\n", $headers));
if ($sent) {
  echo json_encode(['success' => true, 'message' => 'Message sent successfully! We will get back to you soon.']);
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again later.']);
}
?>
