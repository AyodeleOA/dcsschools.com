<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function base_path() {
  $b = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
  $b = preg_replace('#/admin$#', '', $b);
  return $b === '' ? '/' : $b;
}

function redirect_to($path) {
  $p = (isset($path[0]) && $path[0] === '/') ? $path : ('/' . $path);
  header('Location: ' . base_path() . $p);
  exit;
}

function set_flash($message, $type = 'success') {
  $_SESSION['flash'] = array('message' => $message, 'type' => $type);
}

function pop_flash() {
  if (!isset($_SESSION['flash'])) return null;
  $f = $_SESSION['flash'];
  unset($_SESSION['flash']);
  return $f;
}

function require_admin() {
  if (!isset($_SESSION['admin_id'])) {
    redirect_to('dcsschools.com/admin/login.php');
  }
}

function logout_admin() {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
}
