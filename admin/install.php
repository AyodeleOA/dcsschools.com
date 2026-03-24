<?php
require_once __DIR__ . '/db.php';

$pdo = db();
$count = (int)$pdo->query('SELECT COUNT(*) AS c FROM admins')->fetch()['c'];
if ($count > 0) {
  redirect_to('admin/login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = isset($_POST['username']) ? trim($_POST['username']) : '';
  $p = isset($_POST['password']) ? trim($_POST['password']) : '';
  if ($u !== '' && $p !== '') {
    $hash = password_hash($p, PASSWORD_DEFAULT);
    $st = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
    $st->execute([$u, $hash]);
    redirect_to('admin/login.php');
  }
}
?><!doctype html><html><head><meta charset="utf-8"><title>Install Admin</title><link rel="stylesheet" href="<?php echo base_path(); ?>/assets/css/admin.css"></head><body><div class="auth-wrap"><div class="brand"><img class="brand-logo" src="<?php echo base_path(); ?>/assets/images/logo.png" alt="Anapeace Logo"><span class="brand-name">ANAPEACE BRITISH ACADEMY</span></div><h1>Create Admin</h1><form method="post"><label>Username<input name="username" required></label><label>Password<input name="password" type="password" required></label><button type="submit">Create</button></form></div></body></html>
