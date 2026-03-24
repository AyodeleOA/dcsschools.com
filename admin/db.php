<?php
require __DIR__ . '/config.php';

function db() {
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
    } catch (PDOException $e) {
        // Database may not exist - create it
        $hostDsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';

        $tmp = new PDO($hostDsn, DB_USER, DB_PASS, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));

        $tmp->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');

        $pdo = new PDO($dsn, DB_USER, DB_PASS, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
    }

    ensure_schema($pdo);
    return $pdo;
}

function ensure_schema($pdo) {

    $pdo->exec('CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(64) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS gallery_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image_path VARCHAR(255) NOT NULL,
        title VARCHAR(128) NOT NULL,
        event_date DATE NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS academic_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(128) NOT NULL,
        description TEXT NOT NULL,
        image_path_1 VARCHAR(255) NULL,
        image_path_2 VARCHAR(255) NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    try {
        $pdo->exec('ALTER TABLE academic_cards ADD COLUMN image_path_1 VARCHAR(255) NULL');
    } catch (Exception $e) {}
    try {
        $pdo->exec('ALTER TABLE academic_cards ADD COLUMN image_path_2 VARCHAR(255) NULL');
    } catch (Exception $e) {}

    $pdo->exec('CREATE TABLE IF NOT EXISTS settings (
        id INT PRIMARY KEY,
        email VARCHAR(128) NULL,
        phone VARCHAR(64) NULL,
        address VARCHAR(255) NULL
    )');

    $pdo->exec("INSERT IGNORE INTO settings (id, email, phone, address) VALUES (1, NULL, NULL, NULL)");

    $pdo->exec('CREATE TABLE IF NOT EXISTS social_links (
        id INT AUTO_INCREMENT PRIMARY KEY,
        platform VARCHAR(32) NOT NULL,
        url VARCHAR(255) NOT NULL
    )');

    try {
        $pdo->exec('ALTER TABLE social_links ADD COLUMN icon_path VARCHAR(255) NULL');
    } catch (Exception $e) {
        // ignore error (column exists)
    }

    $pdo->exec('CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question VARCHAR(225) NOT NULL,
        answer TEXT NOT NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS enrollments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(255) NOT NULL,
        gender VARCHAR(32) NOT NULL,
        dob DATE NOT NULL,
        intended_class VARCHAR(64) NOT NULL,
        parent_name VARCHAR(255) NOT NULL,
        phone VARCHAR(64) NOT NULL,
        email VARCHAR(128) NOT NULL,
        relationship VARCHAR(64) NOT NULL,
        address TEXT NULL,
        status VARCHAR(32) DEFAULT \'pending\',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(128) NOT NULL,
        email VARCHAR(128) NOT NULL,
        phone VARCHAR(64) NOT NULL,
        message TEXT NOT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');
}
