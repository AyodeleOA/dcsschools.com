<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$pdo = db();
if ((int)$pdo->query('SELECT COUNT(*) AS c FROM admins')->fetch()['c'] === 0) {
  redirect_to('admin/install.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = isset($_POST['username']) ? trim($_POST['username']) : '';
  $p = isset($_POST['password']) ? trim($_POST['password']) : '';
  $st = $pdo->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
  $st->execute([$u]);
  $row = $st->fetch();
  if ($row && password_verify($p, $row['password_hash'])) {
    $_SESSION['admin_id'] = (int)$row['id'];
    redirect_to('dcsschools.com/admin/index.php');
  } else {
    $error = 'Invalid credentials';
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://dcsschools.com/assets/css/admin.css">
</head>

<body>
  <div class="auth-wrap">
    <!-- <div class="brand"><img style="width:200px" class="brand-logo" src="<?php echo base_path(); ?>/assets/images/logo.png" alt="Divine Confidence Logo"><span class="brand-name" style="color:black">DIVINE CONFIDENCE</span></div> -->
    <h1>Divine Confidence Admin Login</h1><?php if ($error) {
                          echo '<div class="error">' . $error . '</div>';
                        } ?><form method="post"><label>Username<input name="username" required></label><label>Password<input name="password" type="password" required></label><button type="submit">Login</button></form>
  </div>
</body>

</html>