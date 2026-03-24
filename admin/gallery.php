<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
  $title = isset($_POST['title']) ? trim($_POST['title']) : '';
  $path = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $name = uniqid('g_', true) . '.' . strtolower($ext);
    $dir = __DIR__ . '/../assets/upload';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    @chmod($dir, 0775);
    if (!is_writable($dir)) { @chmod($dir, 0777); }
    if (!is_writable($dir)) { $error = 'Upload directory is not writable: ' . htmlspecialchars($dir); }
    $dest = $dir . '/' . $name;
    if ($error === '' && is_uploaded_file($_FILES['image']['tmp_name']) && move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
      @chmod($dest, 0664);
      $path = 'assets/upload/' . $name;
    } else {
      $error = 'Failed to upload image. Please check permissions for assets/upload.';
    }
  }
  if ($path !== '' && $title !== '') {
    $st = $pdo->prepare('INSERT INTO gallery_items (image_path, title) VALUES (?, ?)');
    $st->execute([$path, $title]);
    set_flash('Gallery item added');
    redirect_to('dcsschools.com/admin/gallery.php');
  }
}

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $st = $pdo->prepare('SELECT image_path FROM gallery_items WHERE id = ?');
  $st->execute([$id]);
  $row = $st->fetch();
  if ($row) {
    $pdo->prepare('DELETE FROM gallery_items WHERE id = ?')->execute([$id]);
    $file = __DIR__ . '/../' . $row['image_path'];
    if (is_file($file)) @unlink($file);
  }
  set_flash('Gallery item deleted');
  redirect_to('dcsschools.com/admin/gallery.php');
}

$items = $pdo->query('SELECT * FROM gallery_items ORDER BY id DESC')->fetchAll();
$page_title = 'Manage Gallery';
ob_start();
?>
<section class="panel"><h2>Add Item</h2><?php if($error){echo '<div class="error">'.htmlspecialchars($error).'</div>'; } ?><form method="post" enctype="multipart/form-data"><input type="hidden" name="action" value="add"><label>Title<input name="title" required></label><label>Image<input name="image" type="file" accept="image/*" required></label><button type="submit">Add</button></form></section>
<section class="panel"><h2>Items</h2><div class="grid">
<?php foreach($items as $it){ echo '<div class="card"><img src="https://dcsschools.com/'.htmlspecialchars($it['image_path']).'" alt=""><div class="card-body"><div class="card-title">'.htmlspecialchars($it['title']).'</div><a class="btn-danger" href="https://dcsschools.com/admin/gallery.php?delete='.$it['id'].'">Delete</a></div></div>'; } ?>
</div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
