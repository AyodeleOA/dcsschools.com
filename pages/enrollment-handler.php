<?php
require_once __DIR__ . '/../admin/db.php';
header('Content-Type: application/json');

$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve input
    $student_name = htmlspecialchars(trim($_POST['student_name'] ?? ''));
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
    $dob = htmlspecialchars(trim($_POST['dob'] ?? ''));
    $intended_class = htmlspecialchars(trim($_POST['intended_class'] ?? ''));
    $parent_name = htmlspecialchars(trim($_POST['parent_name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $relationship = htmlspecialchars(trim($_POST['relationship'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));

    // Basic Validation
    if (empty($student_name) || empty($gender) || empty($dob) || empty($intended_class) || empty($parent_name) || empty($phone) || empty($email) || empty($relationship)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO enrollments (student_name, gender, dob, intended_class, parent_name, phone, email, relationship, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_name, $gender, $dob, $intended_class, $parent_name, $phone, $email, $relationship, $address]);

        // Success
        echo json_encode(['success' => true, 'message' => 'Enrollment submitted successfully! We will contact you soon.']);
        exit;
    } catch (PDOException $e) {
        // Log error and return error
        error_log("Enrollment Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred. Please try again later.']);
        exit;
    }
} else {
    // Not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
?>