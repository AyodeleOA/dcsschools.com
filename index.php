<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/admin/db.php';

$pdo = db();

// Ensure default admin exists
try {
    $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
    $stmt->execute(array('admin@gmail.com'));
    if (!$stmt->fetch()) {
        $hash = password_hash('Password123', PASSWORD_DEFAULT);
        $ins = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
        $ins->execute(array('admin@gmail.com', $hash));
    }
} catch (Exception $e) {
    // ignore failure
}

// Normalize requested URL
$uri = isset($_GET['route']) ? '/' . trim($_GET['route'], '/') : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}

if ($uri === '' || $uri === null) {
    $uri = '/';
}

$uri = rtrim($uri, '/');

// Admin direct PHP handling
$rel = ltrim($uri, '/');

if ($rel === 'admin' || $rel === 'admin/index') {
    require __DIR__ . '/admin/index.php';
    exit;
}

if (strpos($rel, 'admin/') === 0) {
    $suffix = substr($rel, strlen('admin/'));
    $php = 'admin/' . $suffix;

    if (substr($php, -1) === '/') {
        $php .= 'index.php';
    } elseif (substr($php, -4) !== '.php') {
        $php .= '.php';
    }

    if (is_file(__DIR__ . '/' . $php)) {
        require __DIR__ . '/' . $php;
        exit;
    }
}

// Direct handlers under pages/
if (strpos($rel, 'pages/') === 0 && substr($rel, -4) === '.php') {
    if (is_file(__DIR__ . '/' . $rel)) {
        require __DIR__ . '/' . $rel;
        exit;
    }
}

// Route definitions
$routes = array(
    '/' => array('type' => 'php', 'path' => 'pages/homepage.php'),
    '/home' => array('type' => 'php', 'path' => 'pages/homepage.php'),
    '/admin' => array('type' => 'php', 'path' => 'admin/index.php'),
    '/admin/login' => array('type' => 'php', 'path' => 'admin/login.php'),
    '/admin/install' => array('type' => 'php', 'path' => 'admin/install.php'),
    '/admin/logout' => array('type' => 'php', 'path' => 'admin/logout.php'),
    '/admin/gallery' => array('type' => 'php', 'path' => 'admin/gallery.php'),
    '/admin/academics' => array('type' => 'php', 'path' => 'admin/academics.php'),
    '/admin/settings' => array('type' => 'php', 'path' => 'admin/settings.php'),
    '/admin/faqs' => array('type' => 'php', 'path' => 'admin/faqs.php'),
    '/admin/contacts' => array('type' => 'php', 'path' => 'admin/contacts.php'),
    '/contact' => array('type' => 'php', 'path' => 'pages/contact.php'),
    '/about.php' => array('type' => 'php', 'path' => 'pages/about.php'),
    '/academics' => array('type' => 'php', 'path' => 'pages/academics.php'),
);

$route = isset($routes[$uri]) ? $routes[$uri] : null;

if ($route && $route['type'] === 'php') {
    require __DIR__ . '/' . $route['path'];
    exit;
}

$page = $route ? $route['path'] : (isset($_GET['page']) ? $_GET['page'] : 'pages/homepage.php');

if (!is_file(__DIR__ . '/' . $page)) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

if (substr($page, -4) === '.php') {
    require __DIR__ . '/' . $page;
} else {
    readfile(__DIR__ . '/' . $page);
}
